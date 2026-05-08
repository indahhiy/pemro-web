<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi,
"SELECT * FROM mahasiswa WHERE id='$id'");

$d = mysqli_fetch_array($data);

if(isset($_POST['submit'])){

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    mysqli_query($koneksi,
    "UPDATE mahasiswa SET
    nim='$nim',
    nama='$nama',
    kelas='$kelas'
    WHERE id='$id'");

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Edit Mahasiswa</h2>

<form method="POST">

    NIM
    <input type="text" name="nim" value="<?php echo $d['nim']; ?>">

    Nama
    <input type="text" name="nama" value="<?php echo $d['nama']; ?>">

    Kelas
    <input type="text" name="kelas" value="<?php echo $d['kelas']; ?>">

    <button type="submit" name="submit">Update</button>

</form>

</div>

</body>
</html>