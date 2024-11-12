<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class StorageDenunciaAmbitoController extends Controller{

    protected $redirectTo = 'editDenuncia/';
    protected $disk = 'denuncia';
    protected $F;

    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }

    public function  subirArchivoDenunciaAmbito(Request $request, $DenunciaObject)
    {
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $data    = $request->all();
//        dd($request);
        $user = Auth::User();
        $arrFiles =$request->files->keys();
//        dd($arrFiles);
        try {
            foreach ($arrFiles as $fileDataName){
//                dd($fileDataName);
                if ( $fileDataName !== null ){
                    $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
                    $Item = [
                        'fecha'         => $DenunciaObject->fecha_ingreso,
                        'user__id'      => $DenunciaObject->ciudadano_id,
                        'denuncia__id'  => $DenunciaObject->id,
                    ];
//                    if ( $DenunciaObject->id == 0) {
                        $item = Imagene::create($Item);
                        $this->attaches($item,$DenunciaObject);
                        $this->saveFileAmbitoBase64($item,$request->file($fileDataName),$DenunciaObject);
//                    }
                }

            }

        }catch (\Exception $e){
            dd($e);
        }
        return redirect($this->redirectTo);
    }

    public function attaches($Item,$DenunciaObject){

        $Item->users()->attach($Item->user__id);
        $den = Denuncia::find($DenunciaObject->id);
        $den->imagenes()->attach($Item);
        return $Item;
    }

    public function detaches($Item,$DenunciaObject){
        $Item->users()->detach($Item->user__id);
        $den = Denuncia::find($DenunciaObject->id);
        $den->imagenes()->detach($DenunciaObject->id);

        return $Item;
    }

    public function saveFile($Item,$file,$DenunciaObject){

        if ( $file ) {
            $ext = $file->extension();
            $name = sha1(date('YmdHis') . time()).'-'.$Item->user__id.'-'.$DenunciaObject->id;
            $fileName = $name.'.' . $ext;
            $fileName2 = '_'.$name.'.png';
            $thumbnail = '_thumb_'.$name.'.png';
            $Item->update([
                'root'          => config('atemun.public_url'),
                'image'         => $fileName,
                'image_thumb'   => $thumbnail,
            ]);
            Storage::disk($this->disk)->put($fileName, File::get($file));
            if ( !in_array($ext, config('atemun.document_type_extension')) ) {
                $this->F->fitImage($file, $thumbnail, 128, 128, true, $this->disk, "DENUNCIA_ROOT");
                $this->F->fitImage($file, $fileName2, 300, 300, true, $this->disk, "DENUNCIA_ROOT");
            }
//            $this->F->fitImage( $file,$thumbnail,128,128,true,$this->disk,"DENUNCIA_ROOT");

        }
        return true;
    }


    public function quitarArchivoDenunciaAmbito(Request $request){

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

    public function  subirArchivoDenunciaAmbitoBase64(Request $request, $DenunciaObject)
    {
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $data    = $request->all();

//        dd($data);

        $user = Auth::User();
//        $arrFiles =$request->files->keys();
        try {
            if ( $request['scannerInputs'] ){
                $arrFiles = $request['scannerInputs']; // $request->files->keys();
                foreach ($arrFiles as $fileDataName){
                    if ( $fileDataName !== null ){
                        $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
                        $Item = [
                            'fecha'         => $DenunciaObject->fecha_ingreso,
                            'user__id'      => $DenunciaObject->ciudadano_id,
                            'denuncia__id'  => $DenunciaObject->id,
                        ];
                        $item = Imagene::create($Item);
                        $this->attaches($item,$DenunciaObject);
                        $this->saveFileAmbitoBase64($item,$fileDataName,$DenunciaObject);
                    }
                }
            }
        }catch (\Exception $e){
            dd($e->getMessage());
        }
        return redirect($this->redirectTo);
    }

    public function saveFileAmbitoBase64($Item,$data,$DenunciaObject){

//        $data = $fileDataName; //$request['scannerInput'];
        $ext = 'jpg';

        $name = sha1(date('YmdHis') . time()).'-'.$Item->user__id.'-'.$DenunciaObject->id;
        $fileName = $name.'.' . $ext;
        $fileName2 = '_'.$name.'.png';
        $thumbnail = '_thumb_'.$name.'.png';
        $Item->update([
            'root'          => config('atemun.public_url'),
            'image'         => $fileName,
            'image_thumb'   => $thumbnail,
        ]);
        Storage::disk($this->disk)->put($fileName, file_get_contents($data));
        $file = Storage::disk($this->disk)->get($fileName);

        if ( !in_array($ext, config('atemun.document_type_extension'), true)) {
            $this->F->fitImage($file, $thumbnail, 128, 128, true, $this->disk, "DENUNCIA_ROOT");
            $this->F->fitImage($file, $fileName2, 300, 300, true, $this->disk, "DENUNCIA_ROOT");
        }

        return true;
    }



}
