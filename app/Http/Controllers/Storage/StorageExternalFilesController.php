<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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


}
