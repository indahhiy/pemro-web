const express = require('express');
const mysql = require('mysql2'); // Atau 'mysql' sesuai yang Anda gunakan
const cors = require('cors');    // 1. Tambahkan import CORS

const app = express();

// 2. AKTIFKAN MIDDLEWARE (Wajib di atas kode Route/Endpoint)
app.use(cors());           // Mengizinkan frontend (port 5173) mengakses backend
app.use(express.json());   // Mengizinkan backend membaca data JSON dari body form frontend

// --- Konfigurasi Database Anda ---
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'product_management' // Sesuaikan dengan database Anda
});

// --- Fungsi Helper Anda ---
const sendServerError = (res, err) => {
    return res.status(500).json({ success: false, message: 'Server Error', error: err });
};

const sendSuccess = (res, message, result) => {
    return res.status(200).json({ success: true, message, result });
};


// ==================== ENDPOINT API KATEGORI ====================

// GET /categories - Menampilkan seluruh kategori
app.get('/categories', (req, res) => {
    const query = 'SELECT * FROM product_categories ORDER BY id DESC';
    db.query(query, (err, result) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Kategori berhasil diambil', result);
    });
});

// POST /categories - Menambahkan kategori baru
app.post('/categories', (req, res) => {
    const { category_name, description } = req.body; 

    if (!category_name) {
        return res.status(400).json({ success: false, message: 'Nama kategori wajib diisi' });
    }

    const query = 'INSERT INTO product_categories (category_name, description) VALUES (?, ?)';
    db.query(query, [category_name, description], (err, result) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Kategori berhasil ditambahkan', { id: result.insertId, category_name, description });
    });
});

// PUT /categories/:id - Mengubah kategori berdasarkan ID
app.put('/categories/:id', (req, res) => {
    const { id } = req.params;
    const { category_name, description } = req.body;

    if (!category_name) {
        return res.status(400).json({ success: false, message: 'Nama kategori wajib diisi' });
    }

    const query = 'UPDATE product_categories SET category_name = ?, description = ? WHERE id = ?';
    db.query(query, [category_name, description, id], (err, result) => {
        if (err) return sendServerError(res, err);
        if (result.affectedRows === 0) {
            return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
        }
        sendSuccess(res, 'Kategori berhasil diperbarui', { id, category_name, description });
    });
});

// DELETE /categories/:id - Menghapus kategori berdasarkan ID
app.delete('/categories/:id', (req, res) => {
    const { id } = req.params;

    const query = 'DELETE FROM product_categories WHERE id = ?';
    db.query(query, [id], (err, result) => {
        if (err) return sendServerError(res, err);
        if (result.affectedRows === 0) {
            return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
        }
        sendSuccess(res, 'Kategori berhasil dihapus', { id });
    });
});


// Jalankan Server Backend
const PORT = 5000; // Pastikan port ini sama dengan yang di api.js frontend
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});