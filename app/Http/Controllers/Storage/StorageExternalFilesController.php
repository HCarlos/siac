<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\_viDDSs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;


class StorageExternalFilesController extends Controller{

    protected $redirectTo = 'archivosConfig';
    protected $F;

    protected $arrSelDatbaseComplete = ['id','fecha_ingreso','descripcion','referencia','calle','num_ext','num_int',
        'colonia','comunidad','cp','ubicacion_id','ubicacion','search_google','gd_ubicacion',
        'calle_y_numero_searchtext','latitud','longitud','estatus_id','estatus','estatus_resuelto',
        'estatus_habilitado','estatus_denuncia','prioridad_id','prioridad','prioridad_habilitada',
        'origen_id','origen','origen_habilitado','servicio_id','servicio',
        'subarea_id','subarea','subarea_habilitada','area_id','area','area_habilitada',
        'dependencia_id','dependencia','abreviatura','ambito_dependencia','dependencia_habilitada',
        'ciudadano_id','username','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano',
        'ciudadano','genero','genero_ciudadano','creadopor_id','creadopor','curp_creadopor','creadopor_el',
        'modificadopor_id','modificadopor','curp_modificadopor','fecha_modificado','celulares',
        'telefonos','email','telefonoscelularesemails','curp_ciudadano','domicilio_ciudadano_internet',
        'observaciones','clave_identificadora','ambito_sas','servicio_habilitado','ambito_servicio',
        'estatus_general','ue_id','ultimo_estatus','fecha_ultimo_estatus','ultimo_estatus_resuelto',
        'due_id','dependencia_ultimo_estatus','sue_id','servicio_ultimo_estatus','fecha_dias_ejecucion',
        'fecha_dias_maximos_ejecucion','centro_localidad_id','dias_atendida','dias_rechazada',
        'dias_observada','codigo_postal_manual','search_google_select'];

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

    public function descargarCsv00(Request $request){
        ini_set('max_execution_time', 600);
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        $arSelect = [
            'id',
            'fecha_ingreso',
            'denuncia',
            'referencia',
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
//        $data = _viDDSs::where('fecha_ingreso','>=','2025-01-20 00:00:00')->get($arSelect); // O aplica filtros: Viddss::where(...)->get();

        $data = DB::table('_viddss')
            ->select($arSelect) // Aquí pasamos el array de columnas
            // Puedes añadir cláusulas where, orderBy, etc., si las necesitas:
            // ->where('estatus', 'activo')
            // ->orderBy('fecha_ingreso', 'desc')
            ->get($arSelect); // Esto te dará una colección de objetos StdClass



        if ($data->isEmpty()) {
            // Manejar el caso de no datos: puedes devolver un CSV con solo los encabezados
            // o redirigir con un mensaje de error.
            $headers = $arSelect; // Si no hay datos, los encabezados serán las columnas solicitadas
        } else {
            // Los encabezados del CSV serán los nombres de las columnas que solicitaste.
            // Esto garantiza que el CSV tenga exactamente los encabezados que deseas.
            $headers = $arSelect;
        }

        // 2. Crear una respuesta de descarga de flujo (StreamedResponse)
        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'w');

            // --- Escribir los encabezados ---
            fputcsv($file, $headers);

            // --- Escribir cada fila de datos ---
            foreach ($data as $row) {
                // $row será un objeto StdClass. Debes convertirlo a array para fputcsv.
                // Usamos un loop para asegurar que el orden de las columnas coincida con $arSelect
                $csvRow = [];
                foreach ($headers as $header) {
                    // Acceder a la propiedad del objeto StdClass
                    $csvRow[] = $row->$header;
                }
                fputcsv($file, $csvRow);
            }

            fclose($file);
        };

        // 3. Configurar la respuesta HTTP para la descarga
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="datos_viddss_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }

    public function descargarCsv02(Request $request){
        ini_set('max_execution_time', 600);
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        $data = DB::table('_viddss_completa')
            ->select($this->arrSelDatbaseComplete)
            ->where('ambito_dependencia',1)
            ->where('fecha_ingreso','<','2025-01-20 00:00:00')
            ->orderBy('id','desc')
            ->get($this->arrSelDatbaseComplete);
        if ($data->isEmpty()) {
            $headers = $this->arrSelDatbaseComplete; // Si no hay datos, los encabezados serán las columnas solicitadas
        } else {
            $headers = $this->arrSelDatbaseComplete;
        }

        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'wb');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $csvRow[] = $row->$header;
                }
                fputcsv($file, $csvRow);
            }
            fclose($file);
        };
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Datos_AS_19-01-2025_hacia_atras' . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }

    public function descargarCsv03(Request $request){
        ini_set('max_execution_time', 600);
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        $data = DB::table('_viddss_completa')
            ->select($this->arrSelDatbaseComplete)
            ->where('ambito_dependencia',1)
            ->where('fecha_ingreso','>','2025-01-19 00:00:00')
            ->orderBy('id','desc')
            ->get($this->arrSelDatbaseComplete);
        if ($data->isEmpty()) {
            $headers = $this->arrSelDatbaseComplete; // Si no hay datos, los encabezados serán las columnas solicitadas
        } else {
            $headers = $this->arrSelDatbaseComplete;
        }

        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'wb');
            fputcsv($file, $headers);
            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $csvRow[] = $row->$header;
                }
                fputcsv($file, $csvRow);
            }
            fclose($file);
        };
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Datos_AS_20-01-2025_a_la_fecha' . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }

    public function descargarCsv04(Request $request){
        ini_set('max_execution_time', 600);
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        $data = DB::table('_viddss_completa')
            ->select($this->arrSelDatbaseComplete)
            ->where('ambito_dependencia',99)
            ->where('fecha_ingreso','<','2025-01-20 00:00:00')
            ->orderBy('id','desc')
            ->get($this->arrSelDatbaseComplete);
        if ($data->isEmpty()) {
            $headers = $this->arrSelDatbaseComplete; // Si no hay datos, los encabezados serán las columnas solicitadas
        } else {
            $headers = $this->arrSelDatbaseComplete;
        }

        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'wb');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $csvRow[] = $row->$header;
                }
                fputcsv($file, $csvRow);
            }
            fclose($file);
        };
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Datos_SM_19-01-2025_hacia_atras' . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }









}
