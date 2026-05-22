<?php
include "config.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM tb_mahasiswa WHERE id='$id'");
$d = mysqli_fetch_assoc($data);
?>

<form method="POST">
    <input type="text" name="nama" value="<?=$d['nama']?>">
    <input type="text" name="jurusan" value="<?=$d['jurusan']?>">
    <button name="update">Update</button>
</form>

<?php
if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE tb_mahasiswa SET 
        nama='$_POST[nama]',
        jurusan='$_POST[jurusan]'
        WHERE id='$id'");

    header("Location: index.php");
}
?>