<?php
include "config.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tb_mahasiswa WHERE id='$id'");

header("Location: index.php");
?>