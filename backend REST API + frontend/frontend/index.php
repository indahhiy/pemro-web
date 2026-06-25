<?php
require "../backend/koneksi.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 2;
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = mysqli_query($con, "
    SELECT COUNT(*) AS total
    FROM data_buku
    WHERE judul_buku LIKE '%$search%'
");

$totalData = mysqli_fetch_assoc($totalQuery);
$totalRows = $totalData['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman
$query = mysqli_query($con, "
    SELECT *
    FROM data_buku
    WHERE judul_buku LIKE '%$search%'
    LIMIT $offset, $limit
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2>Data Buku Perpustakaan</h2>

    <a href="tambah.php" class="btn btn-primary mb-3">
        Tambah Buku
    </a>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari Judul Buku..."
                    value="<?= $search; ?>"
                >
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php if (mysqli_num_rows($query) > 0) { ?>

                <?php while ($data = mysqli_fetch_assoc($query)) { ?>

                    <tr>
                        <td><?= $data['id']; ?></td>
                        <td><?= $data['kode_buku']; ?></td>
                        <td><?= $data['judul_buku']; ?></td>
                        <td><?= $data['penulis']; ?></td>
                        <td><?= $data['penerbit']; ?></td>
                        <td><?= $data['tahun_terbit']; ?></td>
                        <td><?= $data['stok']; ?></td>

                        <td>
                            <a
                                href="edit.php?id=<?= $data['id']; ?>"
                                class="btn btn-warning btn-sm"
                            >
                                Edit
                            </a>

                            <a
                                href="hapus.php?id=<?= $data['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus data?')"
                            >
                                Hapus
                            </a>
                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="8" class="text-center">
                        Tidak ada data buku yang ditemukan.
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">

            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?page=<?= $page - 1; ?>&search=<?= $search; ?>"
                    >
                        Previous
                    </a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                    <a
                        class="page-link"
                        href="?page=<?= $i; ?>&search=<?= $search; ?>"
                    >
                        <?= $i; ?>
                    </a>
                </li>
            <?php } ?>

            <?php if ($page < $totalPages) { ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?page=<?= $page + 1; ?>&search=<?= $search; ?>"
                    >
                        Next
                    </a>
                </li>
            <?php } ?>

        </ul>
    </nav>

</div>

</body>
</html>
