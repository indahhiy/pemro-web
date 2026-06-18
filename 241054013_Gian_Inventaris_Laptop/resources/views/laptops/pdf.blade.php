<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Laporan Inventaris Laptop
    </title>

    <style>

        body {

            font-family: Arial, sans-serif;
            font-size: 12px;

        }

        h2 {

            text-align: center;
            margin-bottom: 5px;

        }

        p {

            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;

        }

        table {

            width: 100%;
            border-collapse: collapse;

        }

        table,
        th,
        td {

            border: 1px solid black;

        }

        th {

            background-color: #dddddd;
            padding: 8px;

        }

        td {

            padding: 6px;

        }

    </style>

</head>

<body>

    <h2>
        LAPORAN INVENTARIS LAPTOP
    </h2>

    <p>
        Sistem Inventaris Laptop
    </p>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Nama Laptop</th>
                <th>Merk</th>
                <th>Processor</th>
                <th>RAM</th>
                <th>Stok</th>
                <th>Kondisi</th>

            </tr>

        </thead>

        <tbody>

            @foreach($laptops as $laptop)

            <tr>

                <td>{{ $laptop->id }}</td>

                <td>{{ $laptop->nama_laptop }}</td>

                <td>{{ $laptop->merk }}</td>

                <td>{{ $laptop->processor }}</td>

                <td>{{ $laptop->ram }}</td>

                <td>{{ $laptop->stok }}</td>

                <td>{{ $laptop->kondisi }}</td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>