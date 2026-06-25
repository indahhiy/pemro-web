<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

require "koneksi.php";

function send_response($status, $message, $data = null){
    $response = [
        "status" => $status,
        "message" => $message
    ];
    if ($data !== null) {
        $response["data"] = $data;
    }
    echo json_encode($response);
    exit;
}

function validate_input(array $input, array $required){
    foreach($required as $field){
        if (!isset($input[$field]) || trim((string)$input[$field]) === '') {
            send_response(false, "Validasi gagal: field '$field' tidak boleh kosong");
        }
    }
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    case "GET":

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 2;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $offset = ($page - 1) * $limit;

        $query = mysqli_query($con,"
        SELECT * FROM data_buku
        WHERE judul_buku LIKE '%$search%'
        LIMIT $offset,$limit");

        $data = [];

        while($row = mysqli_fetch_assoc($query)){
            $data[] = $row;
        }

        if(count($data) > 0){
            send_response(true, "Data berhasil diambil", $data);
        }else{
            send_response(false, "Data tidak ditemukan", []);
        }

        break;

    case "POST":

        $input = json_decode(file_get_contents("php://input"), true);
        validate_input($input, ['kode_buku','judul_buku','penulis','penerbit','tahun_terbit','stok']);

        mysqli_query($con," 
        INSERT INTO data_buku
        (kode_buku,judul_buku,penulis,penerbit,tahun_terbit,stok)
        VALUES
        (
        '{$input['kode_buku']}',
        '{$input['judul_buku']}',
        '{$input['penulis']}',
        '{$input['penerbit']}',
        '{$input['tahun_terbit']}',
        '{$input['stok']}'
        )");

        send_response(true, "Data berhasil disimpan");
        break;

    case "PUT":

        parse_str($_SERVER['QUERY_STRING'],$query);

        $id = $query['id'];

        $input = json_decode(file_get_contents("php://input"), true);
        validate_input($input, ['kode_buku','judul_buku','penulis','penerbit','tahun_terbit','stok']);

        mysqli_query($con," 
        UPDATE data_buku
        SET
        kode_buku='{$input['kode_buku']}',
        judul_buku='{$input['judul_buku']}',
        penulis='{$input['penulis']}',
        penerbit='{$input['penerbit']}',
        tahun_terbit='{$input['tahun_terbit']}',
        stok='{$input['stok']}'
        WHERE id='$id'
        ");

        send_response(true, "Data berhasil diubah");
        break;

    case "DELETE":

        parse_str($_SERVER['QUERY_STRING'],$query);

        if (!isset($query['id']) || trim($query['id']) === '') {
            send_response(false, "Validasi gagal: id tidak boleh kosong");
        }

        $id = $query['id'];
        $delete = mysqli_query($con," 
        DELETE FROM data_buku
        WHERE id='$id'
        ");

        if ($delete && mysqli_affected_rows($con) > 0) {
            send_response(true, "Data berhasil dihapus");
        }

        send_response(false, "Data tidak ditemukan");
        break;

    default:
        send_response(false, "Method tidak didukung");
        break;
}
?>
