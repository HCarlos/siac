<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
        $h1 = ' 00:00:00';
        $h2 = ' 23:59:59';

        $fa0 = Carbon::now()->format('Y-m-d');
        $fa1 = $fa0 . $h1;
        $fa2 = $fa0 . $h2;

        $fy0 = Carbon::yesterday()->format('Y-m-d');
        $fy1 = $fy0 . $h1;
        $fy2 = $fy0 . $h2;

        $fh0 = Carbon::now()->format('H');
        $fh1 = $fa0 . " ".$fh0.":00:00";
        $fh2 = $fa0 . " ".$fh0.":59:59";

        $F = new FuncionesController();

        $arfecha = $F->getDatesFromMonthNow();
        $f1 = $arfecha["fecha_inicial"];
        $f2 = $arfecha["fecha_final"];


        $DenunciasHoy = Denuncia::query()->whereBetween('fecha_ingreso',[$fa1,$fa2])->count();
        $DenunciasAyer = Denuncia::query()->whereBetween('fecha_ingreso',[$fy1,$fy2])->count();
        $DenunciasUltimaHora = Denuncia::query()->whereBetween('fecha_ingreso',[$fh1,$fh2])->count();
        $DenunciasMesActual = Denuncia::query()->whereBetween('fecha_ingreso',[$f1,$f2])->count();
        $DenunciasUltima = Denuncia::all()->sortByDesc('id')->first();
        $porc = 0;
        if ($DenunciasAyer > 0){
            $porc = ((($DenunciasHoy / $DenunciasAyer) * 100) - 100);
        }

        $DMAs = Denuncia::select()->whereBetween('fecha_ingreso',[$f1,$f2])->get();

        $Top10Deps = Denuncia::query()->select('dependencia_id',DB::raw('count(dependencia_id) as cantidad_dependencia'))
            ->whereBetween('fecha_ingreso',[$fa1,$fa2])
            ->groupByRaw('dependencia_id')
            ->orderByDesc('cantidad_dependencia' )
            ->get()->take(5);

        $Top10MesDeps = Denuncia::query()->select('dependencia_id',DB::raw('count(dependencia_id) as cantidad_dependencia'))
            ->whereBetween('fecha_ingreso',[$f1,$f2])
            ->groupByRaw('dependencia_id')
            ->orderByDesc('cantidad_dependencia' )
            ->get()->take(5);


        $DenunciasMesActual=0;
        $DenunciasResueltasMesActual=0;
        $DenunciasNoResueltasMesActual=0;
        foreach ($DMAs as $DM){
            $DenunciasMesActual++;
            if($DM->ultimo_estatu_denuncia_dependencia_servicio()->orderByDesc('id')->first()->estatu->isResuelto()){
                $DenunciasResueltasMesActual++;
            }else{
                $DenunciasNoResueltasMesActual++;
            }
        }

        $colors = ['info','success','warning','danger','purple','cafe','coral','info','success','warning'];

        $PorcResuelto = 0;
        $PorcNoResuelto = 0;
        if ($DenunciasMesActual > 0){
            $PorcResuelto = (($DenunciasResueltasMesActual/$DenunciasMesActual)*100);
            $PorcNoResuelto = (($DenunciasNoResueltasMesActual/$DenunciasMesActual)*100);
        }


        return view('home-dashboard',
            [
                'DenunciasHoy' => $DenunciasHoy,
                'porc' => number_format($porc, 2, '.', ','),
                'DenunciasAyer' => $DenunciasAyer,
                'DenunciasUltimaHora' => $DenunciasUltimaHora,
                'DenunciasMesActual' => $DenunciasMesActual,
                'DenunciasUltima' => $DenunciasUltima,
                'DenunciasResueltasMesActual' => $DenunciasResueltasMesActual,
                'DenunciasNoResueltasMesActual' => $DenunciasNoResueltasMesActual,
                'PorcResuelto' => $PorcResuelto,
                'PorcNoResuelto' => $PorcNoResuelto,
                'Top10Deps' => $Top10Deps,
                'Top10MesDeps' => $Top10MesDeps,
                'colors' => $colors,
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
