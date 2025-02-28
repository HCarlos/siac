<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeEmptyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application __dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(){

        $user = auth()->user();
        return view('home-empty',
            [
                'user' => $user,
            ]
        );
    }

    public function index2()
    {
        return view('home-original');
    }

    public function index_ciudadano()
    {
        return view('home-ciudadano');
    }

    public function index_dependencia()
    {
        return view('home-dependencia');
    }

}
