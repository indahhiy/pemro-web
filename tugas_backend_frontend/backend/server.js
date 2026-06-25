const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Database connection
const db = mysql.createConnection({
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '',
    database: 'db_productsparepart'
});

db.connect((err) => {
    if (err) {
        console.error('Error connecting to database:', err);
        return;
    }
    console.log('Connected to MySQL database');
});

// ==========================================
// HELPER FUNCTIONS
// ==========================================

const sendSuccess = (res, message, data = {}) => {
    res.json({ status: true, message, data });
};

const sendValidationError = (res, errors) => {
    res.status(400).json({ status: false, message: 'Validasi gagal', errors });
};

const sendNotFound = (res) => {
    res.status(404).json({ status: false, message: 'Data tidak ditemukan' });
};

const sendServerError = (res, err) => {
    console.error(err);
    res.status(500).json({ status: false, message: 'Terjadi kesalahan pada server' });
};

// ==========================================
// CATEGORIES ENDPOINTS
// ==========================================

// GET /categories - Ambil semua kategori
app.get('/categories', (req, res) => {
    const query = 'SELECT * FROM product_categories ORDER BY id DESC';
    db.query(query, (err, results) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Kategori berhasil diambil', results);
    });
});

// ==========================================
// PRODUCTS ENDPOINTS
// ==========================================

// GET /products - Ambil semua produk (dengan nama kategori)
app.get('/products', (req, res) => {
    const query = `
        SELECT 
            p.id, p.code, p.name, p.description,
            p.price, p.stock, p.unit,
            p.created_at, p.updated_at,
            c.id AS category_id,
            c.name AS category_name
        FROM products p
        LEFT JOIN product_categories c ON p.category_id = c.id
        ORDER BY p.id DESC
    `;
    db.query(query, (err, results) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Produk berhasil diambil', results);
    });
});

// GET /products/:id - Ambil satu produk berdasarkan ID
app.get('/products/:id', (req, res) => {
    const { id } = req.params;
    const query = `
        SELECT 
            p.id, p.code, p.name, p.description,
            p.price, p.stock, p.unit,
            p.created_at, p.updated_at,
            c.id AS category_id,
            c.name AS category_name
        FROM products p
        LEFT JOIN product_categories c ON p.category_id = c.id
        WHERE p.id = ?
    `;
    db.query(query, [id], (err, results) => {
        if (err) return sendServerError(res, err);
        if (results.length === 0) return sendNotFound(res);
        sendSuccess(res, 'Produk berhasil diambil', results[0]);
    });
});

// POST /products - Tambah produk baru
app.post('/products', (req, res) => {
    const { category_id, name, code, description, price, stock, unit } = req.body;

    // Validasi field wajib
    const errors = {};
    if (!category_id) errors.category_id = 'Kategori wajib diisi';
    if (!name)        errors.name        = 'Nama produk wajib diisi';
    if (!code)        errors.code        = 'Kode produk wajib diisi';
    if (!price)       errors.price       = 'Harga wajib diisi';
    if (stock === undefined || stock === '') errors.stock = 'Stok wajib diisi';

    if (Object.keys(errors).length > 0) return sendValidationError(res, errors);

    const query = `
        INSERT INTO products (category_id, name, code, description, price, stock, unit)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    `;
    const values = [category_id, name, code, description || null, price, stock, unit || 'pcs'];

    db.query(query, values, (err, result) => {
        if (err) {
            // Tangani error kode produk duplikat
            if (err.code === 'ER_DUP_ENTRY') {
                return sendValidationError(res, { code: 'Kode produk sudah digunakan' });
            }
            return sendServerError(res, err);
        }
        // Ambil data produk yang baru dibuat untuk dikembalikan
        db.query('SELECT * FROM products WHERE id = ?', [result.insertId], (err2, rows) => {
            if (err2) return sendServerError(res, err2);
            sendSuccess(res, 'Produk berhasil ditambahkan', rows[0]);
        });
    });
});

// PUT /products/:id - Update produk
app.put('/products/:id', (req, res) => {
    const { id } = req.params;
    const { category_id, name, code, description, price, stock, unit } = req.body;

    // Validasi field wajib
    const errors = {};
    if (!category_id) errors.category_id = 'Kategori wajib diisi';
    if (!name)        errors.name        = 'Nama produk wajib diisi';
    if (!code)        errors.code        = 'Kode produk wajib diisi';
    if (!price)       errors.price       = 'Harga wajib diisi';
    if (stock === undefined || stock === '') errors.stock = 'Stok wajib diisi';

    if (Object.keys(errors).length > 0) return sendValidationError(res, errors);

    // Cek apakah produk ada
    db.query('SELECT id FROM products WHERE id = ?', [id], (err, rows) => {
        if (err) return sendServerError(res, err);
        if (rows.length === 0) return sendNotFound(res);

        const query = `
            UPDATE products 
            SET category_id=?, name=?, code=?, description=?, price=?, stock=?, unit=?
            WHERE id=?
        `;
        const values = [category_id, name, code, description || null, price, stock, unit || 'pcs', id];

        db.query(query, values, (err2) => {
            if (err2) {
                if (err2.code === 'ER_DUP_ENTRY') {
                    return sendValidationError(res, { code: 'Kode produk sudah digunakan' });
                }
                return sendServerError(res, err2);
            }
            db.query('SELECT * FROM products WHERE id = ?', [id], (err3, updated) => {
                if (err3) return sendServerError(res, err3);
                sendSuccess(res, 'Produk berhasil diperbarui', updated[0]);
            });
        });
    });
});

// DELETE /products/:id - Hapus produk
app.delete('/products/:id', (req, res) => {
    const { id } = req.params;

    // Cek apakah produk ada sebelum dihapus
    db.query('SELECT id, name FROM products WHERE id = ?', [id], (err, rows) => {
        if (err) return sendServerError(res, err);
        if (rows.length === 0) return sendNotFound(res);

        db.query('DELETE FROM products WHERE id = ?', [id], (err2) => {
            if (err2) return sendServerError(res, err2);
            sendSuccess(res, `Produk "${rows[0].name}" berhasil dihapus`);
        });
    });
});

// ==========================================
// START SERVER
// ==========================================

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});