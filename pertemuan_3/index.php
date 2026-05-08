<?php
include 'koneksi.php';

// TAMBAH DATA
if (isset($_POST['tambah'])) {

    $nim   = $_POST['nim'];
    $nama  = $_POST['nama'];
    $prodi = $_POST['prodi'];

    mysqli_query($conn, "INSERT INTO data_mahasiswa
                        (nim, nama, prodi)
                        VALUES
                        ('$nim', '$nama', '$prodi')");

    header("Location:index.php");
}

// HAPUS DATA
if (isset($_GET['hapus'])) {

    $nim = $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM data_mahasiswa
                        WHERE nim='$nim'");

    header("Location:index.php");
}

// EDIT DATA
if (isset($_POST['update'])) {

    $nim_lama = $_POST['nim_lama'];

    $nim   = $_POST['nim'];
    $nama  = $_POST['nama'];
    $prodi = $_POST['prodi'];

    mysqli_query($conn, "UPDATE data_mahasiswa
                        SET nim='$nim',
                            nama='$nama',
                            prodi='$prodi'
                        WHERE nim='$nim_lama'");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa</title>
</head>
<body>

<h2>CRUD Data Mahasiswa</h2>

<?php

$edit = false;

if (isset($_GET['edit'])) {

    $edit = true;

    $nim = $_GET['edit'];

    $data = mysqli_query($conn,
            "SELECT * FROM data_mahasiswa
             WHERE nim='$nim'");

    $d = mysqli_fetch_assoc($data);
}

?>

<form method="POST">

    <input type="hidden"
           name="nim_lama"
           value="<?= $edit ? $d['nim'] : '' ?>">

    <label>NIM</label><br>

    <input type="text"
           name="nim"
           required
           value="<?= $edit ? $d['nim'] : '' ?>">

    <br><br>

    <label>Nama</label><br>

    <input type="text"
           name="nama"
           required
           value="<?= $edit ? $d['nama'] : '' ?>">

    <br><br>

    <label>Prodi</label><br>

    <input type="text"
           name="prodi"
           required
           value="<?= $edit ? $d['prodi'] : '' ?>">

    <br><br>

    <?php if ($edit) { ?>

        <button type="submit" name="update">
            Update
        </button>

    <?php } else { ?>

        <button type="submit" name="tambah">
            Tambah
        </button>

    <?php } ?>

</form>

<hr>

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Prodi</th>
        <th>Aksi</th>
    </tr>

<?php

$no = 1;

$ambil = mysqli_query($conn,
         "SELECT * FROM data_mahasiswa");

while ($row = mysqli_fetch_assoc($ambil)) {

?>

<tr>

    <td><?= $no++; ?></td>
    <td><?= $row['nim']; ?></td>
    <td><?= $row['nama']; ?></td>
    <td><?= $row['prodi']; ?></td>

    <td>

        <a href="index.php?edit=<?= $row['nim']; ?>">
            Edit
        </a>

        |

        <a href="index.php?hapus=<?= $row['nim']; ?>"
           onclick="return confirm('Yakin hapus data?')">

            Hapus

        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>
