<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{
    protected $fillable = [
        'nama_departemen',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'departemens_id');
    }
}
