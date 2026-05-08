<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

<div class="card shadow col-md-6 mx-auto">
<div class="card-body">

<h3 class="text-center">Tambah Buku</h3>
<hr>

<form method="POST">
<div class="mb-3">
<label>Judul</label>
<input type="text" name="judul" class="form-control">
</div>

<div class="mb-3">
<label>Penulis</label>
<input type="text" name="penulis" class="form-control">
</div>

<div class="mb-3">
<label>Tahun</label>
<input type="number" name="tahun" class="form-control">
</div>

<button name="simpan" class="btn btn-success w-100">Simpan</button>
<a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
</form>

<?php
if(isset($_POST['simpan'])){
mysqli_query($conn,"INSERT INTO buku VALUES('','$_POST[judul]','$_POST[penulis]','$_POST[tahun]')");
echo "<script>location='index.php'</script>";
}
?>

</div>
</div>
</div>
</body>
</html>