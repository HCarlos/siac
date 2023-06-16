<?php

namespace App\Providers;

use App\Classes\ValidatorPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        Validator::resolver(function ($translator, $data, $rules, $messages) {
//            return new ValidatorPassword($translator, $data, $rules, $messages);
//        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
