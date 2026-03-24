<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Aviso;
use App\Models\Directorio;
use App\Observers\AvisoObserver;
use App\Observers\AgendaObserver;

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
    public function boot(): void
    {
        Aviso::observe(AvisoObserver::class);
        Directorio::observe(AgendaObserver::class);
    }
}
