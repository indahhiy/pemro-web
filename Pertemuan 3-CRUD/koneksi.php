<?php
$conn = mysqli_connect("localhost", "root", "", "crud_db");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
