<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    protected $fillable = [
        'users_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'keterangan',
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
