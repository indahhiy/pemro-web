const express = require('express');
const mysql = require('mysql2'); 
const cors = require('cors');    

const app = express();

// AKTIFKAN MIDDLEWARE (Wajib di atas kode Route/Endpoint)
app.use(cors());           
app.use(express.json());   

// --- Konfigurasi Database Hotel Anda ---
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'db_hotel' // Sesuaikan dengan nama database Anda di phpMyAdmin
});

// Koneksi ke database
db.connect((err) => {
    if (err) {
        console.error('Koneksi database gagal: ' + err.stack);
        return;
    }
    console.log('Terhubung ke database MySQL.');
});

// --- Fungsi Helper Response ---
const sendServerError = (res, err) => {
    return res.status(500).json({ status: false, message: 'Server Error', error: err });
};

// Response sukses disesuaikan dengan format instruksi tugas (mengandung data status & pagination)
const sendSuccess = (res, message, result, pagination = null) => {
    const responseBody = { status: true, message, data: result };
    if (pagination) {
        responseBody.pagination = pagination;
    }
    return res.status(200).json(responseBody);
};


// ==================== ENDPOINT API HOTEL (ROOMS) ====================

// GET /rooms - Menampilkan seluruh kamar dengan Search & Pagination
app.get('/rooms', (req, res) => {
    // Ambil query params untuk pencarian dan pagination (Default: page=1, limit=5)
    const page = parseInt(req.query.page) || 1;
    const limit = parseInt(req.query.limit) || 5;
    const search = req.query.search || '';
    const offset = (page - 1) * limit;

    let queryStr = 'SELECT * FROM hotel_rooms';
    let countStr = 'SELECT COUNT(*) as total FROM hotel_rooms';
    let queryParams = [];

    // Logika Pencarian berdasarkan nomor kamar atau tipe kamar
    if (search !== '') {
        queryStr += ' WHERE room_number LIKE ? OR room_type LIKE ?';
        countStr += ' WHERE room_number LIKE ? OR room_type LIKE ?';
        queryParams.push(`%${search}%`, `%${search}%`);
    }

    // 1. Hitung total data terlebih dahulu untuk info pagination
    db.query(countStr, queryParams, (err, countResult) => {
        if (err) return sendServerError(res, err);

        const total = countResult[0].total;
        const total_pages = Math.ceil(total / limit);

        // 2. Gabungkan LIMIT dan OFFSET untuk mengambil data halaman tertentu
        let finalQuery = queryStr + ' ORDER BY id DESC LIMIT ? OFFSET ?';
        let finalParams = [...queryParams, limit, offset];

        db.query(finalQuery, finalParams, (err, roomsResult) => {
            if (err) return sendServerError(res, err);

            // Bungkus informasi pagination-nya sesuai instruksi laporan praktikum
            const paginationInfo = {
                page: page,
                limit: limit,
                total: total,
                total_pages: total_pages || 1
            };

            sendSuccess(res, 'Data kamar berhasil diambil', roomsResult, paginationInfo);
        });
    });
});

// GET /rooms/:id - Mengambil detail satu kamar berdasarkan ID
app.get('/rooms/:id', (req, res) => {
    const { id } = req.params;
    const query = 'SELECT * FROM hotel_rooms WHERE id = ?';

    db.query(query, [id], (err, result) => {
        if (err) return sendServerError(res, err);
        if (result.length === 0) {
            return res.status(404).json({ status: false, message: 'Data tidak ditemukan' });
        }
        sendSuccess(res, 'Detail kamar ditemukan', result[0]);
    });
});

// POST /rooms - Menambahkan kamar baru (dengan Validasi Gagal 422)
app.post('/rooms', (req, res) => {
    const { room_number, room_type, floor, status, price_per_night } = req.body; 

    // Logika Validasi Mahasiswa (Jika kolom utama kosong)
    let errors = {};
    if (!room_number) errors.room_number = ["Nomor kamar wajib diisi"];
    if (!room_type) errors.room_type = ["Tipe kamar wajib diisi"];

    // Mengembalikan status 422 jika validasi gagal sesuai kriteria PDF
    if (Object.keys(errors).length > 0) {
        return res.status(422).json({
            status: false,
            message: 'Validasi gagal',
            errors: errors
        });
    }

    const query = 'INSERT INTO hotel_rooms (room_number, room_type, floor, status, price_per_night) VALUES (?, ?, ?, ?, ?)';
    db.query(query, [room_number, room_type, floor, status || 'Available', price_per_night], (err, result) => {
        if (err) return sendServerError(res, err);
        
        // Response sukses status 210 / 201 Created
        return res.status(201).json({
            status: true,
            message: 'Data berhasil disimpan',
            data: { id: result.insertId, room_number, room_type, floor, status: status || 'Available', price_per_night }
        });
    });
});

// PUT /rooms/:id - Mengubah data kamar berdasarkan ID
app.put('/rooms/:id', (req, res) => {
    const { id } = req.params;
    const { room_number, room_type, floor, status, price_per_night } = req.body;

    // Proteksi validasi
    if (!room_number || !room_type) {
        return res.status(422).json({ status: false, message: 'Nomor kamar dan tipe kamar wajib diisi' });
    }

    const query = 'UPDATE hotel_rooms SET room_number = ?, room_type = ?, floor = ?, status = ?, price_per_night = ? WHERE id = ?';
    db.query(query, [room_number, room_type, floor, status, price_per_night, id], (err, result) => {
        if (err) return sendServerError(res, err);
        if (result.affectedRows === 0) {
            return res.status(404).json({ status: false, message: 'Data tidak ditemukan' });
        }
        sendSuccess(res, 'Data berhasil disimpan', { id: parseInt(id), room_number, room_type, floor, status, price_per_night });
    });
});

// DELETE /rooms/:id - Menghapus data kamar berdasarkan ID
app.delete('/rooms/:id', (req, res) => {
    const { id } = req.params;

    const query = 'DELETE FROM hotel_rooms WHERE id = ?';
    db.query(query, [id], (err, result) => {
        if (err) return sendServerError(res, err);
        if (result.affectedRows === 0) {
            return res.status(404).json({ status: false, message: 'Data tidak ditemukan' });
        }
        sendSuccess(res, 'Data berhasil dihapus', { id: parseInt(id) });
    });
});


// Jalankan Server Backend
const PORT = 5000; // Menggunakan Port 5000 sesuai kode contoh Anda
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});