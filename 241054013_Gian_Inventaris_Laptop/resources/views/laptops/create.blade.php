@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">

        <h3 class="mb-0">
            Tambah Data Laptop
        </h3>

    </div>

    <div class="card-body">

        <form action="/laptops" method="POST">

            @csrf

            <!-- Nama Laptop -->
            <div class="mb-3">

                <label class="form-label">
                    Nama Laptop
                </label>

                <input type="text"
                       name="nama_laptop"
                       class="form-control"
                       value="{{ old('nama_laptop') }}">

                @error('nama_laptop')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Merk -->
            <div class="mb-3">

                <label class="form-label">
                    Merk
                </label>

                <input type="text"
                       name="merk"
                       class="form-control"
                       value="{{ old('merk') }}">

                @error('merk')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Processor -->
            <div class="mb-3">

                <label class="form-label">
                    Processor
                </label>

                <input type="text"
                       name="processor"
                       class="form-control"
                       value="{{ old('processor') }}">

                @error('processor')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- RAM -->
            <div class="mb-3">

                <label class="form-label">
                    RAM
                </label>

                <input type="text"
                       name="ram"
                       class="form-control"
                       placeholder="Contoh: 16 GB"
                       value="{{ old('ram') }}">

                @error('ram')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Stok -->
            <div class="mb-3">

                <label class="form-label">
                    Stok
                </label>

                <input type="number"
                       name="stok"
                       class="form-control"
                       value="{{ old('stok') }}">

                @error('stok')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Kondisi -->
            <div class="mb-3">

                <label class="form-label">
                    Kondisi
                </label>

                <select name="kondisi"
                        class="form-select">

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Rusak Ringan">
                        Rusak Ringan
                    </option>

                    <option value="Rusak Berat">
                        Rusak Berat
                    </option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-success">

                Simpan Data

            </button>

            <a href="/laptops"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection