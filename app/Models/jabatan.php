<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $fillable = ['nama_jabatan'];
    public function users()
    {
        return $this->hasMany(User::class, 'jabatans_id');
    }
}
