<?php
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Hapus Karyawan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body>

    <div class="container mt-5">

        <div class="card">

            <div class="card-header bg-danger text-white">
                Konfirmasi Hapus Data
            </div>

            <div class="card-body">

                <h5>
                    Apakah Anda yakin ingin menghapus data ini?
                </h5>

                <br>

                <form id="formDelete">

                    <input
                        type="hidden"
                        id="id"
                        value="<?= $id ?>">

                    <button
                        type="submit"
                        class="btn btn-danger">
                        Ya, Hapus
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary">
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>

    <script src="./assets/js/hapus.js"></script>

</body>

</html>