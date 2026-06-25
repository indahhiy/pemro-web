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

$query = "UPDATE karyawan SET
        nip = '{$data['nip']}',
        nama = '{$data['nama']}',
        jabatan = '{$data['jabatan']}',
        departemen = '{$data['departemen']}',
        tanggal_masuk = '{$data['tanggal_masuk']}'
    WHERE id='$id'";

if (!mysqli_query($conn, $query)) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Gagal mengubah data: " . mysqli_error($conn)
    ]);
    exit;
}

$result = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM karyawan WHERE id='$id'"
    )
);

echo json_encode([
    "status" => true,
    "message" => "Data berhasil diperbarui",
    "data" => $result
]);
