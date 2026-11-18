<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Laravel tidak mengatur locale Carbon otomatis; tanpa ini nama hari/bulan tetap Inggris
        Carbon::setLocale(config('app.locale'));

        Paginator::useBootstrapFive();
    }
}
