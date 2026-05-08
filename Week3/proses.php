<?php
include "koneksi.php";

$nama = $_POST['nama'];
$email = $_POST['email'];

$sql = "INSERT INTO users (nama, email) VALUES ('$nama', '$email')";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil disimpan!";
    echo "<br><a href='index.php'>Kembali</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>