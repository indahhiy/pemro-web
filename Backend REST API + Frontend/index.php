<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "./config/database.php";

/** @var mysqli $conn */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$offset = ($page - 1) * $limit;

$where = "";

if ($search != "") {
    $where = "WHERE nama LIKE '%$search%'";
}

$totalQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM karyawan $where"
);

if (!$totalQuery) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Error query: " . mysqli_error($conn)
    ]);
    exit;
}

$totalData = mysqli_fetch_assoc($totalQuery)['total'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM karyawan
     $where
     LIMIT $offset,$limit"
);

if (!$query) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Error query: " . mysqli_error($conn)
    ]);
    exit;
}

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

if (!empty($data)) {
    echo json_encode([
        "status" => true,
        "message" => "Data berhasil diambil",
        "data" => $data,
        "pagination" => [
            "page" => $page,
            "limit" => $limit,
            "total" => (int)$totalData,
            "total_pages" => ceil($totalData / $limit)
        ]
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Data tidak ditemukan",
        "data" => [],
        "pagination" => [
            "page" => $page,
            "limit" => $limit,
            "total" => 0,
            "total_pages" => 0
        ]
    ]);
}
