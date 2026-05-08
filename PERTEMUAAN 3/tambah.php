<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    mysqli_query($koneksi,
    "INSERT INTO mahasiswa(nim, nama, kelas)
    VALUES('$nim', '$nama', '$kelas')");

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Tambah Mahasiswa</h2>

<form method="POST">

    NIM
    <input type="text" name="nim">

    Nama
    <input type="text" name="nama">

    Kelas
    <input type="text" name="kelas">

    <button type="submit" name="submit">Simpan</button>

</form>

</div>

</body>
</html>