<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpustakaan";

$con = mysqli_connect($host,$user,$pass,$db);

if(!$con){
    die("Koneksi gagal");
}
?>
