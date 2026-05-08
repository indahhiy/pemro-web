<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Apotek Sederhana</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Daftar Obat Apotek</h2>
    <a href="tambah.php" class="btn btn-primary">Tambah Obat</a>
    <table>
        <tr>
            <th>ID</th><th>Nama Obat</th><th>Jenis</th><th>Harga</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM obat");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama_obat']}</td>
                    <td>{$row['jenis']}</td>
                    <td>Rp {$row['harga']}</td>
                    <td>{$row['stok']}</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                        <a href='hapus.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
