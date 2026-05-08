<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    $query = "INSERT INTO mahasiswa (nim, nama, prodi)
              VALUES ('$nim', '$nama', '$prodi')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data berhasil disimpan');</script>";
    } else {
        echo "<script>alert('Data gagal disimpan');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Mahasiswa</title>
</head>
<body>

    <h2>Form Data Mahasiswa</h2>

    <form method="POST">

        <table>
            <tr>
                <td>NIM</td>
                <td>
                    <input type="text" name="nim" required>
                </td>
            </tr>

            <tr>
                <td>Nama</td>
                <td>
                    <input type="text" name="nama" required>
                </td>
            </tr>

            <tr>
                <td>Prodi</td>
                <td>
                    <input type="text" name="prodi" required>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit" name="simpan">
                        Simpan
                    </button>
                </td>
            </tr>
        </table>

    </form>

    <hr>

    <h2>Data Mahasiswa</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Prodi</th>
        </tr>

        <?php
        $no = 1;

        $ambil = mysqli_query($conn, "SELECT * FROM mahasiswa");

        while ($data = mysqli_fetch_array($ambil)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nim']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['prodi']; ?></td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>
