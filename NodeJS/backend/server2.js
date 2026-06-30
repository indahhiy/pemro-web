const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();

//Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }))

//Database connection
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

//Helper Functions for responses
const sendSucces = (res, message, data = {}) => {
    res.json({
        status: true,
        message: message,
        data: data
    })
}

const sendValidationError = (res, errors) => {
    res.status(400).json({
        status: false,
        message: 'Validasi gagal',
        errors: errors
    })
}

______________________________
//PRODUCT CATEGOREIS ENDPOINTS
______________________________

//GET/categories = Menampilkan seluruh kategori
app.get('/categories', (req, res) => {
    const query = 'SELECT * FROM product_categories ORDER BY id DESC';
    db.query(query, (err, results) => {
        if (err) return sendServerError(res, err);
        sendSucces(res, 'Kategori berhasil diambil', results);
    });
});

//Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`)
});