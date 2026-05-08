<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Week 3 - Form PHP</title>
</head>
<body>

<h2>Form Registrasi User</h2>

<form action="proses.php" method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Simpan</button>
</form>

</body>
</html>