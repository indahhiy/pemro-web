<?php
include 'koneksi.php';

// tambah data
if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($conn, "INSERT INTO mahasiswa VALUES('', '$nama', '$jurusan')");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP</title>
    <style>
        body{
            font-family: Arial;
            background: #f4f4f4;
            padding: 30px;
        }

        .container{
            width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align: center;
        }

        input{
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button{
            margin-top: 10px;
            padding: 10px 15px;
            background: dodgerblue;
            color: white;
            border: none;
            cursor: pointer;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid #ccc;
        }

        th, td{
            padding: 10px;
            text-align: center;
        }

        a{
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }

        .edit{
            background: orange;
        }

        .hapus{
            background: red;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>CRUD Data Mahasiswa</h2>

    <form method="POST">
        <input type="text" name="nama" placeholder="Masukkan nama" required>

        <input type="text" name="jurusan" placeholder="Masukkan jurusan" required>

        <button type="submit" name="submit">Tambah Data</button>
    </form>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM mahasiswa");

        while($d = mysqli_fetch_array($data)){
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['nama']; ?></td>
            <td><?php echo $d['jurusan']; ?></td>
            <td>
                <a class="edit" href="edit.php?id=<?php echo $d['id']; ?>">Edit</a>

                <a class="hapus" href="hapus.php?id=<?php echo $d['id']; ?>">Hapus</a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>

