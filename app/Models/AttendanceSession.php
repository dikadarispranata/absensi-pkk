<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'expired_at',
        'is_used',
    ];
    protected $casts = [
        'expired_at' => 'datetime',
        'is_used' => 'boolean',
    ];

}
