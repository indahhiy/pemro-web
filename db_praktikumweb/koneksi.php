<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_praktikumweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>