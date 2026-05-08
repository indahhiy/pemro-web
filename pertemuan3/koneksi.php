<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pweb_db";
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>