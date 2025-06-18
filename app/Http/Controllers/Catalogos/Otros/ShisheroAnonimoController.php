<?php

namespace App\Http\Controllers\Catalogos\Otros;

use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShisheroAnonimoController extends Controller{

    public function welcome(){
        return view('welcome');
    }

    public function privacidad(){
        return view('privacidad');
    }
    public function about_app(){
        return view('partials.others.about_app');
    }

    public function aviso_app(){
        return view('partials.others.aviso_app');
    }

    public function delegaciones_colonias(){
        return view('partials.others.delegaciones_y_colonias');
    }

    public function fire(){
        event(new APIDenunciaEvent(1,1));
        return "event fired";
    }

    public function test(){
        return "event test";
    }

    public function get_csrf_token(){
        return response()->json(['csrf_token' => csrf_token()]);
    }

    public function tokenizer(){
        return view('partials.tokenizer');
    }

}
