<?php
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Karyawan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            Edit Karyawan
        </h2>

        <form id="formEdit">

            <input type="hidden" id="id" value="<?= $id ?>">

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" id="nip" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" id="nama" class="form-control">
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" id="jabatan" class="form-control">
            </div>

            <div class="mb-3">
                <label>Departemen</label>
                <input type="text" id="departemen" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>

            <a href="index.php" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

    <script src="./assets/js/edit.js"></script>

</body>

</html>