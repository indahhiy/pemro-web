<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Buku Perpustakaan</title>
</head>
<body>

<h2>Data Buku Perpustakaan</h2>

<a href="tambah.php">+ Tambah Buku</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Penerbit</th>
        <th>Tahun</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;

    while($d = mysqli_fetch_array($data)){
    ?>

    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['judul']; ?></td>
        <td><?php echo $d['penulis']; ?></td>
        <td><?php echo $d['penerbit']; ?></td>
        <td><?php echo $d['tahun_terbit']; ?></td>

        <td>
            <a href="edit.php?id=<?php echo $d['id']; ?>">
                Edit
            </a>

            |

            <a href="hapus.php?id=<?php echo $d['id']; ?>">
                Hapus
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>