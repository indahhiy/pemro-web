<?php

require "../backend/koneksi.php";

if(isset($_POST['simpan'])){

    $kode_buku = $_POST['kode_buku'];
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    mysqli_query($con,"
    INSERT INTO data_buku
    (
        kode_buku,
        judul_buku,
        penulis,
        penerbit,
        tahun_terbit,
        stok
    )
    VALUES
    (
        '$kode_buku',
        '$judul_buku',
        '$penulis',
        '$penerbit',
        '$tahun_terbit',
        '$stok'
    )
    ");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Tambah Buku</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">
            Simpan
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>
