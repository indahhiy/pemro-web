@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Data Laptop
</h2>

<div class="mb-3">

    <a href="/laptops/create"
       class="btn btn-success">

        Tambah Laptop

    </a>

    <a href="/laptops/export/pdf"
       class="btn btn-danger">

        Export PDF

    </a>

</div>

<form method="GET"
      action="/laptops"
      class="row g-2 mb-3">

    <div class="col-md-5">

        <input
            type="text"
            name="keyword"
            class="form-control"
            placeholder="Cari nama laptop atau merk..."
            value="{{ request('keyword') }}">

    </div>

    <div class="col-md-3">

        <select
            name="kondisi"
            class="form-select">

            <option value="">
                Semua Kondisi
            </option>

            <option value="Baik"
                {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>
                Baik
            </option>

            <option value="Rusak Ringan"
                {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>
                Rusak Ringan
            </option>

            <option value="Rusak Berat"
                {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>
                Rusak Berat
            </option>

        </select>

    </div>

    <div class="col-md-2">

        <button
            type="submit"
            class="btn btn-primary w-100">

            Cari

        </button>

    </div>

    <div class="col-md-2">

        <a href="/laptops"
           class="btn btn-secondary w-100">
            Tampilkan semua
        </a>

    </div>

</form>

<table class="table table-bordered table-striped shadow">

    <thead class="table-dark">

        <tr>

            <th>ID</th>
            <th>Nama Laptop</th>
            <th>Merk</th>
            <th>RAM</th>
            <th>Kondisi</th>
            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

        @if($laptops->count() > 0)

            @foreach($laptops as $laptop)

                <tr>

                    <td>{{ $laptop->id }}</td>

                    <td>{{ $laptop->nama_laptop }}</td>

                    <td>{{ $laptop->merk }}</td>

                    <td>{{ $laptop->ram }}</td>

                    <td>{{ $laptop->kondisi }}</td>

                    <td>

                        <a href="/laptops/{{ $laptop->id }}/edit"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="/laptops/{{ $laptop->id }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

        @else

            <tr>

                <td colspan="6"
                    class="text-center text-danger">

                    Upss... data laptop tidak ditemukan.
                    Silakan gunakan kata kunci atau filter yang lain.

                </td>

            </tr>

        @endif

    </tbody>

</table>

<div class="mt-3">

    {{ $laptops->links() }}

</div>

@endsection