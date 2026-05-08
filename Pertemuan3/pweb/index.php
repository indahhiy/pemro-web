<?php

include 'koneksi.php';


// ================= TAMBAH DATA =================
if(isset($_POST['simpan'])){

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    $cek = mysqli_query($conn,
            "SELECT * FROM mahasiswa
             WHERE nim='$nim'");

    if(mysqli_num_rows($cek) > 0){

        echo "
        <script>
            alert('NIM sudah ada!');
        </script>
        ";

    }else{

        mysqli_query($conn,
            "INSERT INTO mahasiswa(nim,nama,prodi)
             VALUES('$nim','$nama','$prodi')");

        header("Location:index.php");
    }
}


// ================= HAPUS DATA =================
if(isset($_GET['hapus'])){

    $nim = $_GET['hapus'];

    mysqli_query($conn,
        "DELETE FROM mahasiswa
         WHERE nim='$nim'");

    header("Location:index.php");
}


// ================= UPDATE DATA =================
if(isset($_POST['update'])){

    $nimLama = $_POST['nimLama'];

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    mysqli_query($conn,
        "UPDATE mahasiswa
         SET nim='$nim',
             nama='$nama',
             prodi='$prodi'
         WHERE nim='$nimLama'");

    header("Location:index.php");
}


// ================= EDIT DATA =================
$nimValue = "";
$namaValue = "";
$prodiValue = "";

$edit = false;

if(isset($_GET['edit'])){

    $edit = true;

    $nim = $_GET['edit'];

    $data = mysqli_query($conn,
            "SELECT * FROM mahasiswa
             WHERE nim='$nim'");

    $d = mysqli_fetch_assoc($data);

    $nimValue = $d['nim'];
    $namaValue = $d['nama'];
    $prodiValue = $d['prodi'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa</title>
</head>
<body>

<h2>
    <?php

    if($edit){
        echo "Edit Data Mahasiswa";
    }else{
        echo "Tambah Data Mahasiswa";
    }

    ?>
</h2>

<form method="POST">

    <?php if($edit){ ?>

        <input type="hidden"
               name="nimLama"
               value="<?php echo $nimValue; ?>">

    <?php } ?>

    <table>

        <tr>

            <td>NIM</td>

            <td>

                <input type="text"
                       name="nim"
                       required
                       value="<?php echo $nimValue; ?>">

            </td>

        </tr>

        <tr>

            <td>Nama</td>

            <td>

                <input type="text"
                       name="nama"
                       required
                       value="<?php echo $namaValue; ?>">

            </td>

        </tr>

        <tr>

            <td>Prodi</td>

            <td>

                <input type="text"
                       name="prodi"
                       required
                       value="<?php echo $prodiValue; ?>">

            </td>

        </tr>

        <tr>

            <td></td>

            <td>

                <?php if($edit){ ?>

                    <button type="submit" name="update">
                        Update
                    </button>

                <?php }else{ ?>

                    <button type="submit" name="simpan">
                        Simpan
                    </button>

                <?php } ?>

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
        <th>Aksi</th>
    </tr>

    <?php

    $no = 1;

    $ambil = mysqli_query($conn,
             "SELECT * FROM mahasiswa");

    while($row = mysqli_fetch_assoc($ambil)){

    ?>

    <tr>

        <td><?php echo $no++; ?></td>
        <td><?php echo $row['nim']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['prodi']; ?></td>

        <td>

            <a href="index.php?edit=<?php echo $row['nim']; ?>">
                Edit
            </a>

            |

            <a href="index.php?hapus=<?php echo $row['nim']; ?>"
               onclick="return confirm('Yakin hapus data?')">

                Hapus

            </a>

        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
