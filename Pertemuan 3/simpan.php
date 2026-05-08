<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_mahasiswa";

// koneksi database
$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil data dari form
$nim      = $_POST['nim'];
$nama     = $_POST['nama'];
$jurusan  = $_POST['jurusan'];

// simpan ke database
$sql = "INSERT INTO mahasiswa (nim, nama, jurusan)
        VALUES ('$nim', '$nama', '$jurusan')";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>