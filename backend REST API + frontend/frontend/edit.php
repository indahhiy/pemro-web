<?php

require "../backend/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($con,
"SELECT * FROM data_buku
WHERE id='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $kode_buku = $_POST['kode_buku'];
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    mysqli_query($con,"
    UPDATE data_buku
    SET
        kode_buku='$kode_buku',
        judul_buku='$judul_buku',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun_terbit='$tahun_terbit',
        stok='$stok'
    WHERE id='$id'
    ");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Buku</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Kode Buku</label>
            <input type="text"
                   name="kode_buku"
                   class="form-control"
                   value="<?= $data['kode_buku']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text"
                   name="judul_buku"
                   class="form-control"
                   value="<?= $data['judul_buku']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Penulis</label>
            <input type="text"
                   name="penulis"
                   class="form-control"
                   value="<?= $data['penulis']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Penerbit</label>
            <input type="text"
                   name="penerbit"
                   class="form-control"
                   value="<?= $data['penerbit']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number"
                   name="tahun_terbit"
                   class="form-control"
                   value="<?= $data['tahun_terbit']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   value="<?= $data['stok']; ?>"
                   required>
        </div>

        <button type="submit" name="update" class="btn btn-warning">
            Update
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>
