<?php

namespace App\Http\Requests\DenunciaCiudadana;

use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Controllers\Storage\StorageDenunciaController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Models\Denuncias\DenunciaEstatu;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DenunciaCiudadanaRequest extends FormRequest
{


    protected $redirectRoute = 'newDenunciaCiudadana';

    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'descripcion' => ['required'],
            'referencia'  => ['required'],
            'file'        => 'max:10000|mimes:pdf/png/jpeg/jpg/'
        ];
    }

    public function messages(){
        return [
            'descripcion.required' => 'La :attribute requiere por lo menos de 4 caracter',
            'referencia.required'  => 'La :attribute es requerida',
            'file1.max'            => 'El Tamaño del :attribute excede el limite de 10mb',
            'file1.mimes'          => 'Tipo de :attribute no permitido',
        ];
    }

    public function attributes(){
        return [
            'descripcion' => 'Denuncia',
            'referencia'  => 'Referencia',
            'file1'       => 'Archivo',
        ];
    }

    public function manageDC(){

        // dd( $this->all() );

        try {

            ini_set('max_execution_time', 300000);

            $F            = new FuncionesController();
            $filters      = strtolower($this->ubicacion_problema_ciudadano);
            $filters      = $F->str_sanitizer($filters);
            $tsString     = $F->string_to_tsQuery( strtoupper($filters),' & ');
            $ubic = Ubicacion::query()
                ->search($tsString)
                ->orderBy('id')
                ->first();

//            dd($ubic);

            if (is_null($ubic)){
                $this->ubicacion_id = Auth::user()->Ubicacion->id;
            }else{
                $this->ubicacion_id = $ubic->id;
            }

            $deps = explode('-',$this->servicios);

//            dd($deps[0]);

//            dd($this->ubicacion_id);


            $fecha_i = date('Y-m-d',strtotime($this->fecha_ingreso));
            $fecha_f = date('H:i:s');

            $fi = $fecha_i.' '.$fecha_f;


            $Ubicacion = Ubicacion::findOrFail( $this->ubicacion_id );

            $items = [
                'fecha_ingreso'                => $fi,
                'fecha_limite'                 => $fi,
                'fecha_ejecucion'              => $fi,

                'descripcion'                  => strtoupper(trim($this->descripcion)),
                'referencia'                   => strtoupper(trim($this->referencia)),

                'calle'                        => strtoupper($Ubicacion->calle),
                'num_ext'                      => strtoupper($Ubicacion->num_ext),
                'num_int'                      => strtoupper($Ubicacion->num_int),
                'colonia'                      => strtoupper($Ubicacion->colonia),
                'comunidad'                    => strtoupper($Ubicacion->comunidad),
                'ciudad'                       => strtoupper($Ubicacion->ciudad),
                'municipio'                    => strtoupper($Ubicacion->municipio),
                'estado'                       => strtoupper($Ubicacion->estado),
                'cp'                           => strtoupper($Ubicacion->cp),

                'prioridad_id'                 => 2,
                'origen_id'                    => 4,
                'dependencia_id'               => (int)$deps[3],
                'ubicacion_id'                 => (float)$this->ubicacion_id,
                'servicio_id'                  => (int)$deps[0],
                'estatus_id'                   => 8,
                'ciudadano_id'                 => Auth::id(),
                'creadopor_id'                 => Auth::id(),
                'modificadopor_id'             => (float)$this->modificadopor_id,
                'domicilio_ciudadano_internet' => strtoupper(trim($this->ubicacion_problema_ciudadano)),

            ];

//            dd( $Item );


//            if ( (int)$this->id == 0) {
                $Item = Denuncia::create($items);
//            }
            $Item = $this->attaches($Item);

            // if ($Item->cerrado == false) {
                $Storage = new StorageDenunciaController();
                $Storage->subirArchivoDenuncia($this, $Item);
            //}
            event(new IUQDenunciaEvent($Item->id,Auth::user()->id,0));
            return $Item;



        }catch (QueryException $e){
            Log::alert( "Error del Sistema: " . $e->getMessage() );
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $Item;

    }

    public function attaches($Item){
        try {
            $Obj = DB::table('denuncia_prioridad')
                ->where('denuncia_id','=',$Item->id)
                ->where('prioridad_id','=',$this->prioridad_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->prioridades()->attach($this->prioridad_id);

            $Obj = DB::table('denuncia_origen')
                ->where('denuncia_id','=',$Item->id)
                ->where('origen_id','=',$this->origen_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->origenes()->attach($this->origen_id);

            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$Item->dependencia_id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->where('estatu_id','=',$Item->estatus_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->dependencias()->attach($Item->dependencia_id,['servicio_id'=>$Item->servicio_id,'estatu_id'=>$Item->estatus_id,'fecha_movimiento' => now() ]);

            $Obj = DB::table('denuncia_ubicacion')
                ->where('denuncia_id','=',$Item->id)
                ->where('ubicacion_id','=',$Item->ubicacion_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ubicaciones()->attach($Item->ubicacion_id);

            $Obj = DB::table('denuncia_servicio')
                ->where('denuncia_id','=',$Item->id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->servicios()->attach($Item->servicio_id);

            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$Item->dependencia_id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->where('estatu_id','=',$Item->estatus_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->estatus()->attach($Item->estatus_id,['ultimo'=>true]);

            $Obj = DB::table('ciudadano_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('ciudadano_id','=',$Item->ciudadano_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ciudadanos()->attach($Item->ciudadano_id);

            $Obj = DB::table('creadopor_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('creadopor_id','=',$Item->creadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->creadospor()->attach($Item->creadopor_id);

            $Obj = DB::table('denuncia_modificadopor')
                ->where('denuncia_id','=',$Item->id)
                ->where('modificadopor_id','=',$Item->modificadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->modificadospor()->attach($Item->modificadopor_id);

        }catch (Exception $e){

        }
        return $Item;
    }

    public function detaches($Item){
        $Item->prioridades()->detach($this->prioridad_id);
        $Item->origenes()->detach($this->origen_id);
        $Item->ubicaciones()->detach($this->ubicacion_id);
        DenunciaEstatu::where('denuncia_id',$this->id)->orderByDesc('id')->update(['ultimo'=>true]);
        $Item->ciudadanos()->detach($this->usuario_id);
        $Item->creadospor()->detach($this->creadopor_id);
        $Item->modificadospor()->detach($this->modificadopor_id);
        return $Item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newDenunciaCiudadana');
        }
    }







}
