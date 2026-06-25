<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            Tambah Karyawan
        </h2>

        <form id="formTambah">

            <div class="mb-3">

                <label class="form-label">
                    NIP
                </label>

                <input
                    type="text"
                    id="nip"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    id="nama"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jabatan
                </label>

                <input
                    type="text"
                    id="jabatan"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Departemen
                </label>

                <input
                    type="text"
                    id="departemen"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Tanggal Masuk
                </label>

                <input
                    type="date"
                    id="tanggal_masuk"
                    class="form-control"
                    required>

            </div>

            <button
                type="submit"
                class="btn btn-primary">
                Simpan
            </button>

            <a
                href="index.php"
                class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

    <script src="./assets/js/tambah.js"></script>

</body>

</html>