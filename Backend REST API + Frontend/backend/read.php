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

$query = mysqli_query(
    $conn,
    "SELECT * FROM karyawan WHERE id='$id'"
);

if (!$query) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Error query: " . mysqli_error($conn)
    ]);
    exit;
}

$data = mysqli_fetch_assoc($query);

if (!$data) {

    http_response_code(404);

    echo json_encode([
        "status" => false,
        "message" => "Data tidak ditemukan"
    ]);

    exit;
}

echo json_encode([
    "status" => true,
    "message" => "Data berhasil diambil",
    "data" => $data
]);
