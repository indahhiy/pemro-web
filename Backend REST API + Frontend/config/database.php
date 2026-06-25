<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_karyawan";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die(json_encode([
        "status" => false,
        "message" => "Koneksi database gagal"
    ]));
}
