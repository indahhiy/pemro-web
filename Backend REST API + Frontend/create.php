<?php

header("Content-Type: application/json");

include "./config/database.php";

/** @var mysqli $conn */

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$errors = [];

if (empty($data['nip'])) {
    $errors['nip'][] = "NIP wajib diisi";
}

if (empty($data['nama'])) {
    $errors['nama'][] = "Nama wajib diisi";
}

if (empty($data['jabatan'])) {
    $errors['jabatan'][] = "Jabatan wajib diisi";
}

if (empty($data['departemen'])) {
    $errors['departemen'][] = "Departemen wajib diisi";
}

if (empty($data['tanggal_masuk'])) {
    $errors['tanggal_masuk'][] = "Tanggal masuk wajib diisi";
}

if (!empty($errors)) {

    http_response_code(422);

    echo json_encode([
        "status" => false,
        "message" => "Validasi gagal",
        "errors" => $errors
    ]);

    exit;
}

$query = "INSERT INTO karyawan
    (
        nip,
        nama,
        jabatan,
        departemen,
        tanggal_masuk
    )
    VALUES
    (
        '{$data['nip']}',
        '{$data['nama']}',
        '{$data['jabatan']}',
        '{$data['departemen']}',
        '{$data['tanggal_masuk']}'
    )";

if (!mysqli_query($conn, $query)) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Gagal menyimpan data: " . mysqli_error($conn)
    ]);
    exit;
}

$id = mysqli_insert_id($conn);

$result = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM karyawan WHERE id='$id'"
    )
);

http_response_code(201);

echo json_encode([
    "status" => true,
    "message" => "Data berhasil ditambahkan",
    "data" => $result
]);
