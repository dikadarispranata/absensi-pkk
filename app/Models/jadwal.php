<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    protected $fillable = [
        'nama_shift',
        'jam_masuk',
        'jam_keluar'
    ];
}
