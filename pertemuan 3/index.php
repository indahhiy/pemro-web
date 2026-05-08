<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP Simple</title>
</head>
<body>

    <h2>Data Siswa</h2>

    <a href="tambah.php">+ Tambah Data</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM siswa");

        while($d = mysqli_fetch_array($data)) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['nama']; ?></td>
            <td><?php echo $d['kelas']; ?></td>
            <td><?php echo $d['alamat']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $d['id']; ?>">Edit</a>
                |
                <a href="hapus.php?id=<?php echo $d['id']; ?>">Hapus</a>
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

</body>
</html>