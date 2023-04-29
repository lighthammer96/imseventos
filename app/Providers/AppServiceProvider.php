<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        require_once(__DIR__ . "/../Helpers/Saludo.php");
        require_once(__DIR__ . "/../Helpers/Traductor.php");
        require_once(__DIR__ . "/../Helpers/Funciones.php");
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
