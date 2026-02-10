<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class izin extends Model
{
    protected $fillable = [
        'users_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_izin',
        'alasan',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
