const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
const app = express();

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const db = mysql.createConnection({
    host: 'localhost',
    port: '3306',
    user: 'root',
    password: '',
    database: 'laundry' 
});

db.connect((err) => {
    if (err) {
        console.error('Gagal nyambung database:', err);
        return;
    }
    console.log('Nyambung karo database Laundry');
});

const sendSuccess = (res, message, data = {}) => res.json({ status: true, message, data });
const sendServerError = (res, err) => res.status(500).json({ status: false, message: 'Server Error', error: err.message });

app.get('/laundry', (req, res) => {
    db.query('SELECT * FROM transaksi_laundry ORDER BY id DESC', (err, results) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Data diambil', results);
    });
});

app.post('/laundry', (req, res) => {
    const { nama_pelanggan, jenis_layanan, berat, total_harga } = req.body;
    const query = 'INSERT INTO transaksi_laundry (nama_pelanggan, jenis_layanan, berat, total_harga) VALUES (?, ?, ?, ?)';
    
    db.query(query, [nama_pelanggan, jenis_layanan, berat, total_harga], (err, results) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Berhasil disimpan!', { id: results.insertId });
    });
});

app.put('/laundry/:id', (req, res) => {
    const { nama_pelanggan, jenis_layanan, berat, total_harga } = req.body;
    const query = 'UPDATE transaksi_laundry SET nama_pelanggan=?, jenis_layanan=?, berat=?, total_harga=? WHERE id=?';
    
    db.query(query, [nama_pelanggan, jenis_layanan, berat, total_harga, req.params.id], (err) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Berhasil diupdate!');
    });
});

app.delete('/laundry/:id', (req, res) => {
    db.query('DELETE FROM transaksi_laundry WHERE id=?', [req.params.id], (err) => {
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'Berhasil dihapus!');
    });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server Laundry mlaku ning port ${PORT}`));