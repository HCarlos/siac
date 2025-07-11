<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\StreamedResponse\Csv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VolcadoDBtoCSVController extends Controller{

    protected $arSelect = ['id','fecha_ingreso','denuncia','referencia','calle','num_ext','num_int','colonia','comunidad',
        'cp','ubicacion','search_google','gd_ubicacion', 'latitud','longitud','estatus','estatus_resuelto','status_denuncia',
        'prioridad_id','prioridad','origen_id','origen','servicio_id','servicio','habilitado','medida_id','subarea_id',
        'subarea','area_id','area','dependencia_id','dependencia','abreviatura','ambito_dependencia','ciudadano_id',
        'username','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano','ciudadano','genero',
        'genero_ciudadano','creadopor_id','creadopor','curp_creadopor','modificadopor_id','modificadopor',
        'curp_modificadopor','celulares','telefonos','email','telefonoscelularesemails','curp_ciudadano','observaciones',
        'cerrado','fecha_cerrado','clave_identificadora','ambito_estatus','ue_id','ultimo_estatus','fecha_ultimo_estatus',
        'due_id','dependencia_ultimo_estatus','ambito_servicio','sue_id','servicio_ultimo_estatus','dias_ejecucion','dias_maximos_ejecucion',
        'fecha_dias_ejecucion','fecha_dias_maximos_ejecucion','centro_localidad_id','dias_atendida','dias_rechazada',
        'dias_observada',
    ];

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
        'observaciones','clave_identificadora','ambito_sas','servicio_habilitado','ambito_servicio','ue_id','ultimo_estatus','fecha_ultimo_estatus','ultimo_estatus_resuelto',
        'due_id','dependencia_ultimo_estatus','sue_id','servicio_ultimo_estatus','fecha_dias_ejecucion',
        'fecha_dias_maximos_ejecucion','centro_localidad_id','dias_atendida','dias_rechazada',
        'dias_observada','codigo_postal_manual','search_google_select'];

    public function __construct(){
        $this->middleware('auth');
    }

    public function descargarCsv00(Request $request){
        FuncionesController::setConfigOne();

        $filename = 'datos_viddss_' . date('Ymd_His') . '.csv'; // Nombre del archivo con extensión
        $headers = $this->arSelect;

        $callback = function() use ($headers) {
            $data = DB::table('_viddss')
                ->select($headers) // Pasa $headers directamente
                ->cursor(); // Usar cursor para eficiencia de memoria

            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $csvRow[] = data_get($row, $header); // Usar data_get() para acceso seguro
                }
                fputcsv($file, $csvRow);
            }
            fclose($file);
        };

        return streamCsvResponse($callback, $filename);

    }

    public function descargarCsv02(Request $request){
        FuncionesController::setConfigOne();

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
        FuncionesController::setConfigOne();

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
        FuncionesController::setConfigOne();

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

    public function descargarCsv05(Request $request){
        FuncionesController::setConfigOne();

        $data = DB::table('_viddss_completa')
            ->select($this->arrSelDatbaseComplete)
            ->where('ambito_dependencia',2)
            ->where('fecha_ingreso','>','2025-01-19 00:00:00')
            ->orderBy('id','desc')
            ->get($this->arrSelDatbaseComplete);
        if ($data->isEmpty()) {
            $headers = $this->arrSelDatbaseComplete;
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
            'Content-Disposition' => 'attachment; filename="Datos_SM_20-01-2025_a_la_fecha' . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }

    public function descargarServicios(Request $request){
        FuncionesController::setConfigOne();

        $data = DB::table('_viddss_completa')
            ->select($this->arrSelDatbaseComplete)
            ->where('ambito_dependencia',2)
            ->where('fecha_ingreso','>','2025-01-19 00:00:00')
            ->orderBy('id','desc')
            ->get($this->arrSelDatbaseComplete);
        if ($data->isEmpty()) {
            $headers = $this->arrSelDatbaseComplete;
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
            'Content-Disposition' => 'attachment; filename="Datos_SM_20-01-2025_a_la_fecha' . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

    }


    // relleno 01






}
