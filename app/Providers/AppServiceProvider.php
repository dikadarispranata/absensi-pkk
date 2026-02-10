<?php

namespace App\Providers;

use App\Models\departemen;
use App\Models\jabatan;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Hanya share ke view yang membutuhkan
        View::composer(['karyawan.*'], function ($view) {
            $view->with([
                'departemens' => departemen::all(),
                'jabatans' => jabatan::all(),
            ]);
        });
    }
}
