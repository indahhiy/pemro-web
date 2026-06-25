<?php

header("Content-Type: application/json");

include "./config/database.php";

/** @var mysqli $conn */

$id = $_GET['id'] ?? '';

if (empty($id)) {

    http_response_code(400);

    echo json_encode([
        "status" => false,
        "message" => "ID wajib diisi"
    ]);

    exit;
}

$cek = mysqli_query(
    $conn,
    "SELECT * FROM karyawan WHERE id='$id'"
);

if (mysqli_num_rows($cek) == 0) {

    http_response_code(404);

    echo json_encode([
        "status" => false,
        "message" => "Data tidak ditemukan"
    ]);

    exit;
}

$query = "DELETE FROM karyawan WHERE id='$id'";

if (!mysqli_query($conn, $query)) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Gagal menghapus data: " . mysqli_error($conn)
    ]);
    exit;
}

echo json_encode([
    "status" => true,
    "message" => "Data berhasil dihapus"
]);
