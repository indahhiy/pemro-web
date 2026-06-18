const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Database Connection
const db = mysql.createConnection({
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '',
    database: 'product_manajement'
});

// Koneksi ke Database
db.connect((err) => {
    if (err) {
        console.error('Database tidak dapat terkoneksi:', err);
        return;
    }

    console.log('Koneksi ke MySQL Database berhasil');
});

const sendSuccess = (res, message, data = {}) => {
    res.json({
        status: true,
        message: message,
        data: data
    })
};

const sendNotFound = (res, err)=> {
    res.status (404).json({
        status : false,
        message: 'data tidak ditemukan'
    });
};

const sendServerError = (res, err)=> {
    console.error(err);
    res.status (500).json({
        status : false,
        message: 'upss ada kesalahan pada server'
    });
};

//GET
app.get('/categories', (req, res) => {
    const query= 'SELECT * FROM product_categories ORDER BY id DESC';
    db.query(query, (err, results) =>{
        if (err) return sendServerError(res, err);
        sendSuccess(res, 'kategori berhasil di ambil', results);
    });
});

const sendValidationError = (res, errors) => {
    res.status (400).json({
        status: false,
        message: 'validasi gagal',
        errors: errors
    });
};

// Mulai Server
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Server berhasil running pada port ${PORT}`);
});

