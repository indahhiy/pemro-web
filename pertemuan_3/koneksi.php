<?php
$host = "localhost";
$user = "root";   // default user XAMPP/Laragon
$pass = "";       // default kosong
$db   = "apotek_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
