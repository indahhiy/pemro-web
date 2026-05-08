<?php

include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");

if(!$data){
    die("Query Error: " . mysqli_error($koneksi));
}

$d = mysqli_fetch_array($data);

if(isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "UPDATE siswa SET 
        nama='$nama',
        kelas='$kelas',
        alamat='$alamat'
        WHERE id='$id'");

    if($query){
        header("location:index.php");
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>

    <h2>Edit Data Siswa</h2>

    <form method="POST">

        <table>
            <tr>
                <td>Nama</td>
                <td>
                    <input type="text" name="nama"
                    value="<?php echo $d['nama']; ?>">
                </td>
            </tr>

            <tr>
                <td>Kelas</td>
                <td>
                    <input type="text" name="kelas"
                    value="<?php echo $d['kelas']; ?>">
                </td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td>
                    <textarea name="alamat"><?php echo $d['alamat']; ?></textarea>
                </td>
            </tr>

            <tr>
                <td></td>
                <td><button type="submit" name="update">Update</button></td>
            </tr>
        </table>

    </form>

</body>
</html>