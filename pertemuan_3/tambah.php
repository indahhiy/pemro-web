<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Obat</title>
    <!-- Hubungkan ke CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>➕ Tambah Obat</h2>
    <form method="POST">
        <label>Nama Obat</label>
        <input type="text" name="nama_obat" required>

        <label>Jenis</label>
        <input type="text" name="jenis" required>

        <label>Harga</label>
        <input type="number" step="0.01" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <button type="submit" name="simpan" class="btn btn-success">💾 Simpan</button>
        <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_obat'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO obat (nama_obat, jenis, harga, stok) VALUES ('$nama','$jenis','$harga','$stok')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil disimpan!');window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
