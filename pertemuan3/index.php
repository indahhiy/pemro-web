<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sapa Pengguna - DOM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
        }
        input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        #greeting {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
            min-height: 24px;
        }
    </style>
</head>
<body>

<div class="container">
    <form action="simpan.php" method="POST">
        <h2>Halo!</h2>
    <p>Masukkan nama kamu di bawah ini:</p>
    <br>
    <!-- <button onclick="sapa()">Kirim</button> -->
        <input type="text" name="nama" placeholder="Ketik nama di sini..." required>
        <input type="number" name="nim" placeholder="Ketik NIM di sini..." required>
        <input type="number" name="umur" placeholder="Ketik umur di sini..." >
        <br>
        <button type="submit" value="simpan">Kirim</button>
    </form>
    <div id="greeting"></div>
</div>

<script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const nama = document.querySelector('input[name="nama"]').value.trim();
        const nim = document.querySelector('input[name="nim"]').value.trim();
        const umur = document.querySelector('input[name="umur"]').value.trim();

        if (!nama || !nim || !umur) {
            event.preventDefault();
            alert('Semua field harus diisi. Mohon lengkapi semua data.');
        }
    });
</script>

</body>
</html>