<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $umur = $_POST['umur'];

    // Sanitize input
    $nama = mysqli_real_escape_string($conn, $nama);
    $nim = mysqli_real_escape_string($conn, $nim);
    $umur = (int)$umur;

    // Insert into database
    $sql = "INSERT INTO table1 (nama, nim, umur) VALUES ('$nama', '$nim', $umur)";

    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>