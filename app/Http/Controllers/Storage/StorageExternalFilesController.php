<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\_viDDSs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;


class StorageExternalFilesController extends Controller
{

    protected $redirectTo = 'archivosConfig';
    protected $F;

    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }

    public function subirArchivoBase(Request $request)
    {
        $data    = $request->all(['categ_file','base_file']);
        try {
            $validator = Validator::make($data, [
                'categ_file' => "required|filled",
                'base_file' => "required|mimes:xls,xlsx,doc,docx,ppt,pptx,txt,mp4,jpeg,jpg",
            ]);
            if ($validator->fails()){
                return redirect($this->redirectTo)
                    ->withErrors($validator)
                    ->withInput();
            }
            $file = $request->file('base_file');
            $fileName = $data['categ_file'];
            Storage::disk('externo')->put($fileName, File::get($file));
            return redirect($this->redirectTo);
        }catch (Exception $e){
            return redirect($this->redirectTo)
                ->with('error', 'Ocurrió un error durante la operación: ' . $e->getMessage());
        }

    }

    public function quitarArchivoBase(Request $request){

        $data    = $request->all(['driver','archivo']);
        $driver  = $data['driver'];
        $archivo = $data['archivo'];

        Storage::disk($driver)->delete($archivo);
        $e1 = Storage::disk($driver)->exists($archivo);
        if ($e1) {
            Storage::disk($driver)->delete($archivo);
        }

        return redirect($this->redirectTo);

    }

    public function archivos_config(){
        return view('catalogos.config.files',[
            "tableName" => "",
            "titulo_catalogo" => "Configuración de Archivos",
            "archivos" => Storage::disk('externo')->allFiles(),
        ]);
    }

    public function descargarCsv01(Request $request){

        $arSelect = [
            'id',
            'fecha_ingreso',
            'cantidad',
            'denuncia',
            'referencia',
            'oficio_envio',
            'fecha_oficio_dependencia',
            'fecha_limite',
            'fecha_ejecucion',
            'calle',
            'num_ext',
            'num_int',
            'colonia',
            'comunidad',
            'cp',
            'ubicacion',
            'search_google',
            'gd_ubicacion',
            'latitud',
            'longitud',
            'estatus',
            'estatus_resuelto',
            'status_denuncia',
            'prioridad_id',
            'prioridad',
            'origen_id',
            'origen',
            'servicio_id',
            'servicio',
            'habilitado',
            'medida_id',
            'subarea_id',
            'subarea',
            'area_id',
            'area',
            'dependencia_id',
            'dependencia',
            'abreviatura',
            'ambito_dependencia',
            'ciudadano_id',
            'username',
            'ap_paterno_ciudadano',
            'ap_materno_ciudadano',
            'nombre_ciudadano',
            'ciudadano',
            'genero',
            'genero_ciudadano',
            'creadopor_id',
            'creadopor',
            'curp_creadopor',
            'modificadopor_id',
            'modificadopor',
            'curp_modificadopor',
            'celulares',
            'telefonos',
            'email',
            'telefonoscelularesemails',
            'curp_ciudadano',
            'domicilio_ciudadano_internet',
            'observaciones',
            'cerrado',
            'fecha_cerrado',
            'clave_identificadora',
            'ambito_servicio',
            'ue_id',
            'ultimo_estatus',
            'fecha_ultimo_estatus',
            'ultimo_estatus_resuelto',
            'due_id',
            'dependencia_ultimo_estatus',
            'sue_id',
            'servicio_ultimo_estatus',
            'nombre_corto_ss',
            'dias_ejecucion',
            'dias_maximos_ejecucion',
            'fecha_dias_ejecucion',
            'fecha_dias_maximos_ejecucion',
            'centro_localidad_id',
            'dias_atendida',
            'dias_rechazada',
            'dias_observada',
            ];

        // 1. Obtener los datos de la vista
        $data = _viDDSs::select($arSelect)->where('fecha_ingreso','>=','2025-01-20 00:00:00')->get(); // O aplica filtros: Viddss::where(...)->get();

// dd($data);


        // Si no hay datos, puedes redirigir o devolver un CSV vacío con solo encabezados.
        if ($data->isEmpty()) {
            // Opción 1: Redirigir con un mensaje (si el usuario está en una página web)
            // return redirect()->back()->with('error', 'No hay datos disponibles para descargar.');

            // Opción 2: Devolver un CSV con solo encabezados si no hay datos.
            // Esto es a menudo preferible para scripts o automatización.
            $headers = ['No hay datos']; // Encabezado simple si está vacío
        } else {
            // Obtener los encabezados de forma dinámica desde las claves del primer elemento.
            // Esto es crucial para un CSV limpio: los nombres de las columnas serán tus encabezados.
            //$headers = array_keys($data->first()->toArray());
        }

//        dd($arSelect);

        // 2. Crear una respuesta de descarga de flujo (StreamedResponse)
        $callback = function() use ($data, $arSelect) {
            $file = fopen('php://output', 'wb');
            try {


//            ddd($arSelect);

            // --- PUNTO CLAVE 1: Escribir SOLO los encabezados al principio ---
            fputcsv($file, $arSelect);

            // --- PUNTO CLAVE 2: Escribir cada fila de datos ---
            foreach ($data as $row) {
                // Asegúrate de que $row->toArray() devuelva un array plano de valores
                // sin claves anidadas ni objetos.

//                ddd( $row->toArray() );

                $arr = [
                    'id' => $row->id,
                    'fecha_ingreso' => $row->fecha_ingreso,
                    'cantidad' => $row->cantidad,
                    'denuncia' => $row->denuncia,
                    'referencia' => $row->referencia,
                    'oficio_envio' => $row->oficio_envio,
                    'fecha_oficio_dependencia' => $row->fecha_oficio_dependencia,
                    'fecha_limite' => $row->fecha_limite,
                    'fecha_ejecucion' => $row->fecha_ejecucion,
                    'calle' => $row->calle,
                    'num_ext' => $row->num_ext,
                    'num_int' => $row->num_int,
                    'colonia' => $row->colonia,
                    'comunidad' => $row->comunidad,
                    'cp' => $row->cp,
                    'ubicacion' => $row->ubicacion,
                    'search_google' => $row->search_google,
                    'gd_ubicacion' => $row->gd_ubicacion,
                    'latitud' => $row->latitud,
                    'longitud' => $row->longitud,
                    'estatus' => $row->estatus,
                    'estatus_resuelto' => $row->estatus_resuelto,
                    'status_denuncia' => $row->status_denuncia,
                    'prioridad_id' => $row->prioridad_id,
                    'prioridad' => $row->prioridad,
                    'origen_id' => $row->origen_id,
                    'origen' => $row->origen,
                    'servicio_id' => $row->servicio_id,
                    'servicio' => $row->servicio,
                    'habilitado' => $row->habilitado,
                    'medida_id' => $row->medida_id,
                    'subarea_id' => $row->subarea_id,
                    'subarea' => $row->subarea,
                    'area_id' => $row->area_id,
                    'area' => $row->area,
                    'dependencia_id' => $row->dependencia_id,
                    'dependencia' => $row->dependencia,
                    'abreviatura' => $row->abreviatura,
                    'ambito_dependencia' => $row->ambito_dependencia,
                    'ciudadano_id' => $row->ciudadano_id,
                    'username' => $row->username,
                    'ap_paterno_ciudadano' => $row->ap_paterno_ciudadano,
                    'ap_materno_ciudadano' => $row->ap_materno_ciudadano,
                    'nombre_ciudadano' => $row->nombre_ciudadano,
                    'ciudadano' => $row->ciudadano,
                    'genero' => $row->genero,
                    'genero_ciudadano' => $row->genero_ciudadano,
                    'creadopor_id' => $row->creadopor_id,
                    'creadopor' => $row->creadopor,
                    'curp_creadopor' => $row->curp_creadopor,
                    'modificadopor_id' => $row->modificadopor_id,
                    'modificadopor' => $row->modificadopor,
                    'curp_modificadopor' => $row->curp_modificadopor,
                    'celulares' => $row->celulares,
                    'telefonos' => $row->telefonos,
                    'email' => $row->email,
                    'telefonoscelularesemails' => $row->telefonoscelularesemails,
                    'curp_ciudadano' => $row->curp_ciudadano,
                    'domicilio_ciudadano_internet' => $row->domicilio_ciudadano_internet,
                    'observaciones' => $row->observaciones,
                    'cerrado' => $row->cerrado,
                    'fecha_cerrado' => $row->fecha_cerrado,
                    'clave_identificadora' => $row->clave_identificadora,
                    'ambito_servicio' => $row->ambito_servicio,
                    'ue_id' => $row->ue_id,
                    'ultimo_estatus' => $row->ultimo_estatus,
                    'fecha_ultimo_estatus' => $row->fecha_ultimo_estatus,
                    'ultimo_estatus_resuelto' => $row->ultimo_estatus_resuelto,
                    'due_id' => $row->due_id,
                    'dependencia_ultimo_estatus' => $row->dependencia_ultimo_estatus,
                    'sue_id' => $row->sue_id,
                    'servicio_ultimo_estatus' => $row->servicio_ultimo_estatus,
                    'nombre_corto_ss' => $row->nombre_corto_ss,
                    'dias_ejecucion' => $row->dias_ejecucion,
                    'dias_maximos_ejecucion' => $row->dias_maximos_ejecucion,
                    'fecha_dias_ejecucion' => $row->fecha_dias_ejecucion,
                    'fecha_dias_maximos_ejecucion' => $row->fecha_dias_maximos_ejecucion,
                    'centro_localidad_id' => $row->centro_localidad_id,
                    'dias_atendida' => $row->dias_atendida,
                    'dias_rechazada' => $row->dias_rechazada,
                    'dias_observada' => $row->dias_observada,
                ];



                fputcsv($file, $arr );

            }

            }catch (Exception $e){

                fclose($file);

            }

            // Cerrar el archivo (buffer de salida)
            fclose($file);
        };

        // 3. Configurar la respuesta HTTP para la descarga
        // Estos encabezados son los estándar para forzar la descarga de un CSV.
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="datos_viddss_' . date('Ymd_His') . '.csv"',
            // Estos encabezados adicionales son buenas prácticas para asegurar la descarga
            // y evitar problemas de caché, pero no afectan el contenido del CSV.
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }



}
