<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Perpustakaan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">📚 Sistem Perpustakaan</span>
  </div>
</nav>

<div class="container mt-4">

<div class="card shadow">
<div class="card-body">

<div class="d-flex justify-content-between mb-3">
<h3>Data Buku</h3>
<a href="tambah.php" class="btn btn-primary">+ Tambah Buku</a>
</div>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Tahun</th>
    <th>Aksi</th>
</tr>
</thead>

<?php
$no=1;
$data = mysqli_query($conn,"SELECT * FROM buku");
while($d=mysqli_fetch_array($data)){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['judul'] ?></td>
<td><?= $d['penulis'] ?></td>
<td><?= $d['tahun'] ?></td>
<td>
<a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="hapus.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Yakin hapus?')">Hapus</a>
</td>
</tr>

<?php } ?>
</table>

</div>
</div>
</div>
</body>
</html>