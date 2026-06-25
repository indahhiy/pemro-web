<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Data Karyawan</h2>

            <a href="tambah.php" class="btn btn-primary">
                Tambah Karyawan
            </a>

        </div>

        <div class="row mb-3">

            <div class="col-md-4">

                <input type="text" id="search" class="form-control" placeholder="Cari Nama Karyawan...">

            </div>

        </div>

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Tanggal Masuk</th>
                    <th width="180">Aksi</th>

                </tr>

            </thead>

            <tbody id="tableBody">

            </tbody>

        </table>

        <div id="pagination">

        </div>

    </div>

    <script src="./assets/js/index.js"></script>

</body>

</html>