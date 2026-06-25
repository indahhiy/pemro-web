const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");

const app = express();
const PORT = 5000;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Koneksi database MySQL
const db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "sewa_alatPendakian",
  port: 3306,
});

// Cek koneksi database
db.connect((err) => {
  if (err) {
    console.log("Koneksi database gagal:", err.message);
    return;
  }

  console.log("Database MySQL berhasil terhubung");
});

// Endpoint awal
app.get("/", (req, res) => {
  res.json({
    status: true,
    message: "API Sewa Alat Pendakian berjalan",
  });
});

/*
  STRUKTUR DATA:
  id
  nama_penyewa
  no_hp
  nama_alat
  kategori_alat
  jumlah_sewa
  harga_per_hari
  lama_sewa
  tanggal_sewa
  tanggal_kembali
  status_sewa
*/

// =====================================================
// GET: Ambil semua data + search + pagination
// Contoh:
// http://localhost:5000/api/sewa-alat?page=1&limit=5&search=tas
// =====================================================
app.get("/api/sewa-alat", (req, res) => {
  let { page = 1, limit = 10, search = "" } = req.query;

  page = parseInt(page);
  limit = parseInt(limit);

  if (page < 1) page = 1;
  if (limit < 1) limit = 10;

  const offset = (page - 1) * limit;

  const searchQuery = `%${search}%`;

  const countSql = `
    SELECT COUNT(*) AS total
    FROM sewa_alat_pendakian_sucayyyy
    WHERE nama_penyewa LIKE ?
       OR nama_alat LIKE ?
       OR kategori_alat LIKE ?
       OR status_sewa LIKE ?
  `;

  db.query(
    countSql,
    [searchQuery, searchQuery, searchQuery, searchQuery],
    (err, countResult) => {
      if (err) {
        return res.status(500).json({
          status: false,
          message: "Terjadi kesalahan pada server",
        });
      }

      const total = countResult[0].total;
      const totalPages = Math.ceil(total / limit);

      const sql = `
        SELECT *,
        (jumlah_sewa * harga_per_hari * lama_sewa) AS total_harga
        FROM sewa_alat_pendakian_sucayyyy
        WHERE nama_penyewa LIKE ?
           OR nama_alat LIKE ?
           OR kategori_alat LIKE ?
           OR status_sewa LIKE ?
        ORDER BY id DESC
        LIMIT ? OFFSET ?
      `;

      db.query(
        sql,
        [searchQuery, searchQuery, searchQuery, searchQuery, limit, offset],
        (err, result) => {
          if (err) {
            return res.status(500).json({
              status: false,
              message: "Terjadi kesalahan pada server",
            });
          }

          res.status(200).json({
            status: true,
            message: "Data sewa alat pendakian berhasil diambil",
            data: result,
            pagination: {
              page: page,
              limit: limit,
              total: total,
              total_pages: totalPages,
            },
          });
        }
      );
    }
  );
});

// =====================================================
// GET: Ambil satu data berdasarkan ID
// Contoh: http://localhost:5000/api/sewa-alat/1
// =====================================================
app.get("/api/sewa-alat/:id", (req, res) => {
  const { id } = req.params;

  const sql = `
    SELECT *,
    (jumlah_sewa * harga_per_hari * lama_sewa) AS total_harga
    FROM sewa_alat_pendakian_sucayyyy
    WHERE id = ?
  `;

  db.query(sql, [id], (err, result) => {
    if (err) {
      return res.status(500).json({
        status: false,
        message: "Terjadi kesalahan pada server",
      });
    }

    if (result.length === 0) {
      return res.status(404).json({
        status: false,
        message: "Data tidak ditemukan",
      });
    }

    res.status(200).json({
      status: true,
      message: "Detail data sewa alat berhasil diambil",
      data: result[0],
    });
  });
});

// =====================================================
// POST: Tambah data sewa alat
// =====================================================
app.post("/api/sewa-alat", (req, res) => {
  const {
    nama_penyewa,
    no_hp,
    nama_alat,
    kategori_alat,
    jumlah_sewa,
    harga_per_hari,
    lama_sewa,
    tanggal_sewa,
    tanggal_kembali,
    status_sewa,
  } = req.body;

  const errors = {};

  if (!nama_penyewa) errors.nama_penyewa = ["Nama penyewa wajib diisi"];
  if (!no_hp) errors.no_hp = ["Nomor HP wajib diisi"];
  if (!nama_alat) errors.nama_alat = ["Nama alat wajib diisi"];
  if (!kategori_alat) errors.kategori_alat = ["Kategori alat wajib diisi"];
  if (!jumlah_sewa) errors.jumlah_sewa = ["Jumlah sewa wajib diisi"];
  if (!harga_per_hari) errors.harga_per_hari = ["Harga per hari wajib diisi"];
  if (!lama_sewa) errors.lama_sewa = ["Lama sewa wajib diisi"];
  if (!tanggal_sewa) errors.tanggal_sewa = ["Tanggal sewa wajib diisi"];
  if (!tanggal_kembali)
    errors.tanggal_kembali = ["Tanggal kembali wajib diisi"];
  if (!status_sewa) errors.status_sewa = ["Status sewa wajib diisi"];

  if (Object.keys(errors).length > 0) {
    return res.status(422).json({
      status: false,
      message: "Validasi gagal",
      errors: errors,
    });
  }

  const sql = `
    INSERT INTO sewa_alat_pendakian_sucayyyy
    (nama_penyewa, no_hp, nama_alat, kategori_alat, jumlah_sewa,
    harga_per_hari, lama_sewa, tanggal_sewa, tanggal_kembali, status_sewa)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  `;

  const values = [
    nama_penyewa,
    no_hp,
    nama_alat,
    kategori_alat,
    jumlah_sewa,
    harga_per_hari,
    lama_sewa,
    tanggal_sewa,
    tanggal_kembali,
    status_sewa,
  ];

  db.query(sql, values, (err, result) => {
    if (err) {
      return res.status(500).json({
        status: false,
        message: "Terjadi kesalahan pada server",
      });
    }

    res.status(201).json({
      status: true,
      message: "Data sewa alat berhasil disimpan",
      data: {
        id: result.insertId,
        ...req.body,
        total_harga: jumlah_sewa * harga_per_hari * lama_sewa,
      },
    });
  });
});

// =====================================================
// PUT: Ubah seluruh data berdasarkan ID
// =====================================================
app.put("/api/sewa-alat/:id", (req, res) => {
  const { id } = req.params;

  const {
    nama_penyewa,
    no_hp,
    nama_alat,
    kategori_alat,
    jumlah_sewa,
    harga_per_hari,
    lama_sewa,
    tanggal_sewa,
    tanggal_kembali,
    status_sewa,
  } = req.body;

  const errors = {};

  if (!nama_penyewa) errors.nama_penyewa = ["Nama penyewa wajib diisi"];
  if (!no_hp) errors.no_hp = ["Nomor HP wajib diisi"];
  if (!nama_alat) errors.nama_alat = ["Nama alat wajib diisi"];
  if (!kategori_alat) errors.kategori_alat = ["Kategori alat wajib diisi"];
  if (!jumlah_sewa) errors.jumlah_sewa = ["Jumlah sewa wajib diisi"];
  if (!harga_per_hari) errors.harga_per_hari = ["Harga per hari wajib diisi"];
  if (!lama_sewa) errors.lama_sewa = ["Lama sewa wajib diisi"];
  if (!tanggal_sewa) errors.tanggal_sewa = ["Tanggal sewa wajib diisi"];
  if (!tanggal_kembali)
    errors.tanggal_kembali = ["Tanggal kembali wajib diisi"];
  if (!status_sewa) errors.status_sewa = ["Status sewa wajib diisi"];

  if (Object.keys(errors).length > 0) {
    return res.status(422).json({
      status: false,
      message: "Validasi gagal",
      errors: errors,
    });
  }

  const checkSql = "SELECT id FROM sewa_alat_pendakian_sucayyyy WHERE id = ?";

  db.query(checkSql, [id], (err, checkResult) => {
    if (err) {
      return res.status(500).json({
        status: false,
        message: "Terjadi kesalahan pada server",
      });
    }

    if (checkResult.length === 0) {
      return res.status(404).json({
        status: false,
        message: "Data tidak ditemukan",
      });
    }

    const sql = `
      UPDATE sewa_alat_pendakian_sucayyyy
      SET nama_penyewa = ?, no_hp = ?, nama_alat = ?, kategori_alat = ?,
          jumlah_sewa = ?, harga_per_hari = ?, lama_sewa = ?,
          tanggal_sewa = ?, tanggal_kembali = ?, status_sewa = ?
      WHERE id = ?
    `;

    const values = [
      nama_penyewa,
      no_hp,
      nama_alat,
      kategori_alat,
      jumlah_sewa,
      harga_per_hari,
      lama_sewa,
      tanggal_sewa,
      tanggal_kembali,
      status_sewa,
      id,
    ];

    db.query(sql, values, (err) => {
      if (err) {
        return res.status(500).json({
          status: false,
          message: "Terjadi kesalahan pada server",
        });
      }

      res.status(200).json({
        status: true,
        message: "Data sewa alat berhasil diubah",
        data: {
          id: parseInt(id),
          ...req.body,
          total_harga: jumlah_sewa * harga_per_hari * lama_sewa,
        },
      });
    });
  });
});

// =====================================================
// PATCH: Ubah sebagian data berdasarkan ID
// =====================================================
app.patch("/api/sewa-alat/:id", (req, res) => {
  const { id } = req.params;
  const data = req.body;

  if (Object.keys(data).length === 0) {
    return res.status(422).json({
      status: false,
      message: "Validasi gagal",
      errors: {
        data: ["Data yang diubah wajib diisi"],
      },
    });
  }

  const allowedFields = [
    "nama_penyewa",
    "no_hp",
    "nama_alat",
    "kategori_alat",
    "jumlah_sewa",
    "harga_per_hari",
    "lama_sewa",
    "tanggal_sewa",
    "tanggal_kembali",
    "status_sewa",
  ];

  const fields = [];
  const values = [];

  for (const key in data) {
    if (allowedFields.includes(key)) {
      fields.push(`${key} = ?`);
      values.push(data[key]);
    }
  }

  if (fields.length === 0) {
    return res.status(422).json({
      status: false,
      message: "Validasi gagal",
      errors: {
        data: ["Kolom yang dikirim tidak valid"],
      },
    });
  }

  const checkSql = "SELECT * FROM sewa_alat_pendakian_sucayyyy WHERE id = ?";

  db.query(checkSql, [id], (err, checkResult) => {
    if (err) {
      return res.status(500).json({
        status: false,
        message: "Terjadi kesalahan pada server",
      });
    }

    if (checkResult.length === 0) {
      return res.status(404).json({
        status: false,
        message: "Data tidak ditemukan",
      });
    }

    values.push(id);

    const sql = `
      UPDATE sewa_alat_pendakian_sucayyyy
      SET ${fields.join(", ")}
      WHERE id = ?
    `;

    db.query(sql, values, (err) => {
      if (err) {
        return res.status(500).json({
          status: false,
          message: "Terjadi kesalahan pada server",
        });
      }

      res.status(200).json({
        status: true,
        message: "Data sewa alat berhasil diperbarui",
      });
    });
  });
});

// =====================================================
// DELETE: Hapus data berdasarkan ID
// =====================================================
app.delete("/api/sewa-alat/:id", (req, res) => {
  const { id } = req.params;

  const sql = "DELETE FROM sewa_alat_pendakian_sucayyyy WHERE id = ?";

  db.query(sql, [id], (err, result) => {
    if (err) {
      return res.status(500).json({
        status: false,
        message: "Terjadi kesalahan pada server",
      });
    }

    if (result.affectedRows === 0) {
      return res.status(404).json({
        status: false,
        message: "Data tidak ditemukan",
      });
    }

    res.status(200).json({
      status: true,
      message: "Data sewa alat berhasil dihapus",
    });
  });
});

// Jalankan server
app.listen(PORT, () => {
  console.log(`Server berjalan di http://localhost:${PORT}`);
});