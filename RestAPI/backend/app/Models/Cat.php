<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $table = 'cats';

    protected $fillable = [
        'nama',
        'ras',
        'warna',
        'umur',
        'jenis_kelamin',
        'berat',
        'status_vaksin'
    ];
}