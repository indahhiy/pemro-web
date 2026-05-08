<?php 
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($conn,"SELECT * FROM buku WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

<div class="card shadow col-md-6 mx-auto">
<div class="card-body">

<h3 class="text-center">Edit Buku</h3>
<hr>

<form method="POST">
<div class="mb-3">
<label>Judul</label>
<input type="text" name="judul" value="<?= $d['judul'] ?>" class="form-control">
</div>

<div class="mb-3">
<label>Penulis</label>
<input type="text" name="penulis" value="<?= $d['penulis'] ?>" class="form-control">
</div>

<div class="mb-3">
<label>Tahun</label>
<input type="number" name="tahun" value="<?= $d['tahun'] ?>" class="form-control">
</div>

<button name="update" class="btn btn-warning w-100">Update</button>
<a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
</form>

<?php
if(isset($_POST['update'])){
mysqli_query($conn,"UPDATE buku SET judul='$_POST[judul]',penulis='$_POST[penulis]',tahun='$_POST[tahun]' WHERE id='$id'");
echo "<script>location='index.php'</script>";
}
?>

</div>
</div>
</div>
</body>
</html>