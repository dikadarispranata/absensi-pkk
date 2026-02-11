<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Str;

class Generate_Qr extends Controller
{
    public function showQr()
    {
        $session = AttendanceSession::create([
            'token' => Str::uuid(),
            'expired_at' => now()->addSeconds(20),
        ]);
    }
}
