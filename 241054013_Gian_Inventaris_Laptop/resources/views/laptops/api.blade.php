@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Data Laptop Dari REST API
</h2>

<div class="row mb-3">

    <div class="col-md-6">

        <input
            type="text"
            id="searchInput"
            class="form-control"
            placeholder="Cari nama laptop atau merk...">

    </div>

    <div class="col-md-2">

        <button
            class="btn btn-primary w-100"
            onclick="loadData(1)">

            Cari

        </button>

    </div>

</div>

<table class="table table-bordered table-striped">

    <thead class="table-dark">

        <tr>

            <th>ID</th>
            <th>Nama Laptop</th>
            <th>Merk</th>
            <th>RAM</th>
            <th>Kondisi</th>

        </tr>

    </thead>

    <tbody id="dataLaptop">

        <tr>

            <td colspan="5">

                Memuat data...

            </td>

        </tr>

    </tbody>

</table>

<div class="d-flex justify-content-between">

    <button
        class="btn btn-secondary"
        id="prevBtn">

        Sebelumnya

    </button>

    <span id="infoPage"></span>

    <button
        class="btn btn-secondary"
        id="nextBtn">

        Berikutnya

    </button>

</div>

<script>

let currentPage = 1;
let totalPages = 1;

function loadData(page = 1)
{
    const keyword =
        document.getElementById(
            'searchInput'
        ).value;

    fetch(
        `/api/laptops?page=${page}&search=${keyword}`
    )

    .then(response => response.json())

    .then(result => {

        let html = '';

        result.data.forEach(function(laptop){

            html += `
            <tr>

                <td>${laptop.id}</td>

                <td>${laptop.nama_laptop}</td>

                <td>${laptop.merk}</td>

                <td>${laptop.ram}</td>

                <td>${laptop.kondisi}</td>

            </tr>
            `;

        });

        document.getElementById(
            'dataLaptop'
        ).innerHTML = html;

        currentPage =
            result.pagination.page;

        totalPages =
            result.pagination.total_pages;

        document.getElementById(
            'infoPage'
        ).innerHTML =
            `Halaman ${currentPage} dari ${totalPages}`;

    })

    .catch(error => {

        document.getElementById(
            'dataLaptop'
        ).innerHTML = `

        <tr>

            <td colspan="5">

                Gagal mengambil data API

            </td>

        </tr>
        `;

    });
}

document.getElementById(
    'prevBtn'
).addEventListener(
    'click',
    function(){

        if(currentPage > 1){

            loadData(
                currentPage - 1
            );

        }

    }
);

document.getElementById(
    'nextBtn'
).addEventListener(
    'click',
    function(){

        if(currentPage < totalPages){

            loadData(
                currentPage + 1
            );

        }

    }
);

loadData();

</script>

@endsection