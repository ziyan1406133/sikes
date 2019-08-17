<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Pengeluaran;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        $nav_pending = Pengeluaran::where('jenis', 'Non Rutin')->where('status', 'Menunggu Konfirmasi')->orderBy('created_at', 'desc')->get();        
        $nav_tolak = Pengeluaran::where('jenis', 'Non Rutin')->where('status', 'Ditolak')->orderBy('created_at', 'desc')->get();

        View::share('nav_tolak', $nav_tolak);
        View::share('nav_pending', $nav_pending);

    }
}
