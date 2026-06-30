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
    database: 'product_management'
});

db.connect((err) => {
    if (err) {
        console.error('Error connecting to database:', err);
        return;
    }
    console.log('Connected to MySQL database');
});

// =========================
// Helper Functions
// =========================
const sendSuccess = (res, message, data = {}) => {
    res.json({
        status: true,
        message: message,
        data: data
    });
};

const sendValidationError = (res, errors) => {
    res.status(400).json({
        status: false,
        message: 'Validasi gagal',
        errors: errors
    });
};

const sendServerError = (res, err) => {
    res.status(500).json({
        status: false,
        message: 'Terjadi kesalahan pada server',
        error: err.message
    });
};

// ====================================
// PRODUCT CATEGORIES ENDPOINTS
// ====================================

// GET /categories
// Menampilkan semua kategori
app.get('/categories', (req, res) => {
    const query = 'SELECT * FROM product_categories ORDER BY id DESC';

    db.query(query, (err, results) => {
        if (err) return sendServerError(res, err);

        sendSuccess(res, 'Kategori berhasil diambil', results);
    });
});


// GET /categories/:id
// Menampilkan satu kategori berdasarkan id
app.get('/categories/:id', (req, res) => {

    const id = req.params.id;

    const query = 'SELECT * FROM product_categories WHERE id = ?';

    db.query(query, [id], (err, results) => {
        if (err) return sendServerError(res, err);

        if (results.length === 0) {
            return res.status(404).json({
                status: false,
                message: 'Kategori tidak ditemukan'
            });
        }

        sendSuccess(res, 'Kategori berhasil ditemukan', results[0]);
    });
});


// POST /categories
// Menambah kategori
app.post('/categories', (req, res) => {

    const { category_name } = req.body;

    if (!category_name) {
        return sendValidationError(res, {
            category_name: 'Nama kategori wajib diisi'
        });
    }

    const query = 'INSERT INTO product_categories (category_name) VALUES (?)';

    db.query(query, [category_name], (err, result) => {
        if (err) return sendServerError(res, err);

        sendSuccess(res, 'Kategori berhasil ditambahkan', {
            id: result.insertId,
            category_name
        });
    });

});


// PUT /categories/:id
// Mengubah kategori
app.put('/categories/:id', (req, res) => {

    const id = req.params.id;
    const { category_name } = req.body;

    if (!category_name) {
        return sendValidationError(res, {
            category_name: 'Nama kategori wajib diisi'
        });
    }

    const query = `
        UPDATE product_categories
        SET category_name = ?
        WHERE id = ?
    `;

    db.query(query, [category_name, id], (err, result) => {

        if (err) return sendServerError(res, err);

        if (result.affectedRows === 0) {
            return res.status(404).json({
                status: false,
                message: 'Kategori tidak ditemukan'
            });
        }

        sendSuccess(res, 'Kategori berhasil diupdate');
    });

});


// DELETE /categories/:id
// Menghapus kategori
app.delete('/categories/:id', (req, res) => {

    const id = req.params.id;

    const query = 'DELETE FROM product_categories WHERE id = ?';

    db.query(query, [id], (err, result) => {

        if (err) return sendServerError(res, err);

        if (result.affectedRows === 0) {
            return res.status(404).json({
                status: false,
                message: 'Kategori tidak ditemukan'
            });
        }

        sendSuccess(res, 'Kategori berhasil dihapus');
    });

});


// =========================
// Start Server
// =========================
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});