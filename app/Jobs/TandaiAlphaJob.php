<?php

namespace App\Jobs;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TandaiAlphaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tanggal = Carbon::yesterday()->toDateString();
        $users = User::where('role', 'karyawan')->get();
        foreach ($users as $user){
            $udahabsen = Absensi::where('users_id', $user->id)->whereDate('tanggal', $tanggal)->exists();
            if(!$udahabsen){
                Absensi::create([
                    'users_id' => $user->id,
                    'tanggal' => $tanggal,
                    'jam_masuk' => '00:00:00',
                    'jam_pulang' => '00:00:00',
                    'status' => 'alpha',
                    'keterangan' => 'Tidak hadir',
                ]);
            }
        }
    }
}
