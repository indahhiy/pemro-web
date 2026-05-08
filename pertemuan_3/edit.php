<?php include 'koneksi.php'; 
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM obat WHERE id=$id"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Obat</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Edit Obat</h2>
    <form method="POST">
        <label>Nama Obat</label>
        <input type="text" name="nama_obat" value="<?= $data['nama_obat']; ?>">

        <label>Jenis</label>
        <input type="text" name="jenis" value="<?= $data['jenis']; ?>">

        <label>Harga</label>
        <input type="number" step="0.01" name="harga" value="<?= $data['harga']; ?>">

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>">

        <button type="submit" name="update" class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama_obat'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "UPDATE obat SET nama_obat='$nama', jenis='$jenis', harga='$harga', stok='$stok' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate!');window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
