<?php

namespace App\Http\Requests\Denuncia\Imagene;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use App\Models\Denuncias\Respuesta;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImagenAImagenRequest extends FormRequest
{





    protected $redirectRoute = '/ImagenAImagenEdit';
    protected $disk = 'denuncia';
    protected $F;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }


    public function manage()
    {
        $this->F = new FuncionesController();

        try {

            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $Item = [
                'fecha'         => $fechaActual,
                'user__id'      => $this->user__id,
                'denuncia__id'  => $this->denuncia__id,
                'parent__id'     => $this->imagen__id,
            ];
//            dd($Item);
            if ((int)$this->imagen__id > 0) {
                $item = Imagene::create($Item);
            }
            $this->attaches($item);
            $this->saveFile($item);

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $item;

    }

    public function manageEdit()
    {
        $this->F = new FuncionesController();

        try {

            $aplica = intval($this->aplicaa);

            $Item = [
                'titulo'      => $this->titulo,
                'descripcion' => $this->descripcion,
                'momento'     => $this->momento,
            ];

            if ( (int)$this->id > 0) {
                if ($aplica == 0) {
                    $item = Imagene::find($this->id);
                    $item->update($Item);
                }elseif ($aplica == 1) {
                    $item = Imagene::where('denuncia__id', $this->denuncia__id)->update($Item);
                }else{
                    $var2 = explode(',',$this->var2);
                    $item = Imagene::whereIn('id', $var2)->update($Item);
                }
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $item;

    }

    public function attaches($Item){

        $Item->users()->attach($this->user__id);
        $den = Denuncia::find($this->denuncia__id);
        $den->imagenes()->attach($Item);
        $res = Imagene::find($this->imagen__id);
        $res->childs()->attach($Item);
        return $Item;
    }

    public function detaches($Item){
        $Item->users()->detach($this->user__id);
        $den = Denuncia::find($this->denuncia__id);
        $den->imagenes()->detach($this->id);
        $res = Imagene::find($this->imagen__id);
        $res->childs()->detach($this->imagen__id);

        return $Item;
    }


    public function saveFile($Item){
        $file = $this->file('file');
        $ext = $file->extension();
        $name = sha1(date('YmdHis') . time()).'-'.$this->denuncia__id.'-'.$Item->id;
        $fileName = $name.'.' . $ext;
        $thumbnail = '_thumb_'.$name.'.png';
        $Item->update([
            'root'          => config('atemun.public_url'),
            'image'         => $fileName,
            'image_thumb'   => $thumbnail,
        ]);
        Storage::disk($this->disk)->put($fileName, File::get($file));
        // $img_thmb =
        $this->F->fitImage( $file,$thumbnail,128,128,true,$this->disk,"DENUNCIA_ROOT" );
        return true;
    }

    public function messages()
    {
//        return [
//            'file.required' => 'La IMAGEN es obligatoria.',
//        ];

        return [];

    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['denuncia_id'=>$this->denuncia__id,'Id'=>$this->id]);
        }else{
            return $url->route('/showModalImageneNew',['denuncia_id'=>$this->denuncia__id]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);

    }




}
