<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Data Mahasiswa Praktikum Web</h2>

<a href="tambah.php" class="btn btn-tambah">Tambah Data</a>

<table class="table">
    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $data = mysqli_query($koneksi, "SELECT * FROM mahasiswa");

    while($d = mysqli_fetch_array($data)){
    ?>

    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['nim']; ?></td>
        <td><?php echo $d['nama']; ?></td>
        <td><?php echo $d['kelas']; ?></td>

        <td>
            <a href="edit.php?id=<?php echo $d['id']; ?>" class="btn btn-edit">Edit</a>

            <a href="hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-hapus">Hapus</a>
        </td>
    </tr>

    <?php } ?>

</table>

</div>

</body>
</html>
