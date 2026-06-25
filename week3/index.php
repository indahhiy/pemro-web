<?php
include "koneksi.php";

$pesan = "";

if(isset($_POST['kirim'])){

    $nama = $_POST['nama'];

    $query = "INSERT INTO pengunjung (nama_pengunjung)
              VALUES ('$nama')";

    if(mysqli_query($conn, $query)){
        $pesan = "Halo, $nama! Data berhasil disimpan 🎉";
    } else {
        $pesan = "Data gagal disimpan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nama Pengunjung</title>

  <style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body{
      background: linear-gradient(to right, #1F3A5F, #3E5879);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container{
      background: white;
      width: 400px;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      text-align: center;
    }

    h1{
      color: #1F3A5F;
      margin-bottom: 15px;
    }

    p{
      color: #555;
      margin-bottom: 20px;
    }

    input{
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    button{
      width: 100%;
      padding: 12px;
      border: none;
      background: #1F3A5F;
      color: white;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover{
      background: #16304d;
    }

    #hasil{
      margin-top: 20px;
      font-size: 18px;
      color: #1F3A5F;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Data Pengunjung</h1>
    <p>Masukkan nama pengunjung</p>

    <form method="POST">

      <input 
        type="text" 
        name="nama" 
        placeholder="Masukkan nama pengunjung"
        required
      >

      <button type="submit" name="kirim">
        Kirim
      </button>

    </form>

    <div id="hasil">
      <?php echo $pesan; ?>
    </div>

  </div>

</body>
</html>
