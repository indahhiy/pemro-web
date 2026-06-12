<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai_yusuf';

    // Sesuaikan nama kolom dengan migration yang baru
    protected $fillable = [
        'nip_yusuf', 
        'nama_yusuf', 
        'jabatan_yusuf', 
        'divisi_yusuf', 
        'tanggal_masuk_yusuf'
    ];
}