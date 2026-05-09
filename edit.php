<?php 
include 'config.php'; 
$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id'");
$row = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Mahasiswa</title>
</head>
<body>

    <h2>Edit Data Mahasiswa</h2>

    <form method="post">
        NIM: <br>
        <input type="text" name="nim" value="<?= $row['nim']; ?>" required><br><br>

        Nama: <br>
        <input type="text" name="nama" value="<?= $row['nama']; ?>" required><br><br>

        Jurusan: <br>
        <input type="text" name="jurusan" value="<?= $row['jurusan']; ?>" required><br><br>

        Alamat: <br>
        <textarea name="alamat" required><?= $row['alamat']; ?></textarea><br><br>

        <button type="submit" name="update">Update</button>
    </form>

    <?php
    if (isset($_POST['update'])) {
        mysqli_query($conn, "UPDATE mahasiswa SET 
            nim='$_POST[nim]',
            nama='$_POST[nama]',
            jurusan='$_POST[jurusan]',
            alamat='$_POST[alamat]'
            WHERE id='$id'
        ");

        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php';</script>";
    }
    ?>

</body>
</html>