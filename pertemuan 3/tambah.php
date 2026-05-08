<?php
include 'koneksi.php';

if(isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "INSERT INTO siswa VALUES('', '$nama', '$kelas', '$alamat')");

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
</head>
<body>

    <h2>Tambah Data Siswa</h2>

    <form method="POST">

        <table>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama"></td>
            </tr>

            <tr>
                <td>Kelas</td>
                <td><input type="text" name="kelas"></td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td><textarea name="alamat"></textarea></td>
            </tr>

            <tr>
                <td></td>
                <td><button type="submit" name="simpan">Simpan</button></td>
            </tr>
        </table>

    </form>

</body>
</html>