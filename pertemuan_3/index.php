<?php
include "config.php";
?>



<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa</title>

    
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Data Mahasiswa</h2>

    <form method="POST">

        Nama:
        <input type="text" name="nama">

        Jurusan:
        <input type="text" name="jurusan">

        <button type="submit" name="simpan">
            Simpan
        </button>

    </form>

<?php

if(isset($_POST['simpan'])){

    $nama = trim($_POST['nama']);
    $jurusan = trim($_POST['jurusan']);

    if($nama != "" && $jurusan != ""){

        $stmt = mysqli_prepare($conn,
            "INSERT INTO tb_mahasiswa (nama, jurusan)
             VALUES (?, ?)");

        mysqli_stmt_bind_param($stmt, "ss",
            $nama, $jurusan);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        echo "Data berhasil disimpan";
    }
}

$data = mysqli_query($conn,
    "SELECT * FROM tb_mahasiswa");

while($row = mysqli_fetch_assoc($data)){
?>

    <div class="data">

        <b><?= htmlspecialchars($row['nama']); ?></b>
        <br>

        <?= htmlspecialchars($row['jurusan']); ?>

        <br><br>

        <a class="edit"
           href="edit.php?id=<?= $row['id']; ?>">
           Edit
        </a>

        <a class="hapus"
           href="hapus.php?id=<?= $row['id']; ?>"
           onclick="return confirm('Yakin ingin hapus?')">
           Hapus
        </a>

    </div>

<?php } ?>

</div>

</body>
</html>