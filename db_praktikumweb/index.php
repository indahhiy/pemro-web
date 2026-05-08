<?php
include 'koneksi.php';

// proses insert data ke database
if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];

    // query insert
    $insert = mysqli_query($koneksi,
        "INSERT INTO mahasiswa(nama)
         VALUES('$nama')"
    );

    // notifikasi
    if($insert){

        echo "
        <script>
            alert('Data berhasil disimpan');
            window.location='index.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data gagal disimpan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Mahasiswa</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #56ab2f, #a8e063);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 35px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #2e7d32;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            background-color: #2e7d32;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1b5e20;
        }

        #hasil {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Input Data Mahasiswa</h2>

    <form method="POST">

        <input type="text"
               id="nama"
               name="nama"
               placeholder="Masukkan nama mahasiswa"
               required>

        <button type="button" onclick="sapaUser()">
            Sapa Pengguna
        </button>

        <button type="submit" name="simpan">
            Simpan Data
        </button>

    </form>

    <div id="hasil"></div>

</div>

<script>

function sapaUser(){

    let nama = document.getElementById("nama").value;

    if(nama == ""){

        document.getElementById("hasil").innerHTML =
        "Nama tidak boleh kosong!";

    }else{

        document.getElementById("hasil").innerHTML =
        "Halo, " + nama + "! Selamat datang 👋";
    }
}

</script>

</body>
</html>