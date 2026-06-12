<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Pastikan menggunakan "return new class"
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai_yusuf', function (Blueprint $table) {
            $table->id();
            $table->string('nip_yusuf')->unique();
            $table->string('nama_yusuf');
            $table->string('jabatan_yusuf');
            $table->string('divisi_yusuf');
            $table->date('tanggal_masuk_yusuf');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai_yusuf');
    }
};