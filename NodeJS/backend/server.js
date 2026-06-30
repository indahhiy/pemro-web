const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();

//Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({extended: true }));

// Database connerction
const db = mysql.createConnection({
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '',
    database: 'product_management'
});

db.connect((err) => {
    if (err) {
        console.error('Error connecting to database:',err);
        return;
    }
    console.log('Connected to MySql database');
});

//Helper funtions for responses
const sendSuccess = (res,message, data = {}) => {
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

const sendNotFound = (res) => {
    res.status(404).json({
        status: false,
        message: 'Data tidak ditemukan'
    });
};

const sendServerError = (res, err) => {
    console.error(err);
    res.status(500).json({
        status: false,
        message: ' Terjadi kesalahan pada server'
    });
};

//==============================================
// PRODUCT CATEGORIES ENDPOINTS
//==============================================

// GET /categories - menampilkan seluruh kategori
app.get('/categories', (req, res) => {
    const query = 'SELECT * FROM product_categories ORDER BY id DESC';
    db.query(query, (err, results) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Kategori Berhasil diambil', results);
    });
});

// POST /categories - menambahkan kategori baru
app.post('/categories', (req, res) => {
    const { name, description } = req.body;
    const errors = {};
    if (!name || name.toString().trim() === '') errors.name = 'Nama kategori wajib diisi';
    if (Object.keys(errors).length) return sendValidationError(res, errors);

    const query = 'INSERT INTO product_categories (name, description) VALUES (?, ?)';
    db.query(query, [name, description || null], (err, result) => {
        if (err) return sendServerError(res, err);
        const newId = result.insertId;
        db.query('SELECT * FROM product_categories WHERE id = ?', [newId], (err2, rows) => {
            if (err2) return sendServerError(res, err2);
            sendSuccess(res, 'Kategori berhasil ditambahkan', rows[0]);
        });
    });
});

// PUT /categories/:id - mengupdate kategori
app.put('/categories/:id', (req, res) => {
    const { id } = req.params;
    const { name, description } = req.body;
    const errors = {};
    if (!name || name.toString().trim() === '') errors.name = 'Nama kategori wajib diisi';
    if (Object.keys(errors).length) return sendValidationError(res, errors);

    db.query('SELECT * FROM product_categories WHERE id = ?', [id], (err, rows) => {
        if (err) return sendServerError(res, err);
        if (!rows.length) return sendNotFound(res);

        const query = 'UPDATE product_categories SET name = ?, description = ? WHERE id = ?';
        db.query(query, [name, description || null, id], (err2) => {
            if (err2) return sendServerError(res, err2);
            db.query('SELECT * FROM product_categories WHERE id = ?', [id], (err3, updatedRows) => {
                if (err3) return sendServerError(res, err3);
                sendSuccess(res, 'Kategori berhasil diupdate', updatedRows[0]);
            });
        });
    });
});

// DELETE /categories/:id - menghapus kategori
app.delete('/categories/:id', (req, res) => {
    const { id } = req.params;
    db.query('SELECT * FROM product_categories WHERE id = ?', [id], (err, rows) => {
        if (err) return sendServerError(res, err);
        if (!rows.length) return sendNotFound(res);

        db.query('DELETE FROM product_categories WHERE id = ?', [id], (err2) => {
            if (err2) return sendServerError(res, err2);
            sendSuccess(res, 'Kategori berhasil dihapus');
        });
    });
});

//Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});