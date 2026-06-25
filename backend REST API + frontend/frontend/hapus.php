<?php

require "../backend/koneksi.php";

$id = $_GET['id'];

mysqli_query($con,
"DELETE FROM data_buku
WHERE id='$id'");

header("Location:index.php");

?>
