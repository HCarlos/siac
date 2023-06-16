<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutComponentTags();

        Blade::component('componentes._home','home');
        Blade::component('componentes._card','card');
        Blade::component('componentes._catalogo','catalogo');
        Blade::component('componentes._form_full_modal','formFullModal');
        Blade::component('componentes.tools._form_full_modal_search','formFullModalSearch');
        Blade::component('componentes._asignaciones','asignaciones');
        Blade::component('componentes._details','details');

        Blade::component('componentes._denuncia','denunciaContainer');
        Blade::component('componentes.tools._buttonsFormDenuncia','buttonsFormDenuncia');

        Blade::component('componentes.form._form_modal','formModal');
        Blade::component('componentes.form._form_dropzone','formDropZone');

        //error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

        date_default_timezone_set('America/Mexico_City');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
