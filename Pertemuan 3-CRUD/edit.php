<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($conn, "UPDATE mahasiswa SET
    nama='$nama',
    jurusan='$jurusan'
    WHERE id='$id'");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>

<h2>Edit Data</h2>

<form method="POST">
    <input type="text" name="nama" value="<?php echo $d['nama']; ?>">
    <br><br>

    <input type="text" name="jurusan" value="<?php echo $d['jurusan']; ?>">
    <br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>