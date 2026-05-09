<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h2>Tambah Data Mahasiswa</h2>

    <form method="post">
        NIM:<br>
        <input type="text" name="nim" required><br><br>

        Nama:<br>
        <input type="text" name="nama" required><br><br>

        Jurusan:<br>
        <input type="text" name="jurusan" required><br><br>

        Alamat:<br>
        <textarea name="alamat" required></textarea><br><br>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];
        $alamat = $_POST['alamat'];

        // Query berdasarkan struktur tabel
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, alamat)
                  VALUES ('$nim', '$nama', '$jurusan', '$alamat')";

        mysqli_query($conn, $query);

        echo "<script>
                alert('Data berhasil ditambah!');
                window.location='index.php';
              </script>";
    }
    ?>
</body>
</html>