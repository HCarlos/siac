<?php

namespace App\Http\Requests\API;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Role;
use App\Rules\IsCURPRule;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class UserAPIRegistryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
                'curp'       => ['required', 'unique:users', new IsCURPRule() ],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'ap_paterno' => ['required', 'string'],
                'ap_materno' => ['required', 'string'],
                'nombre'     => ['required', 'string'],
            ];
    }

    public function manage(){
        app()['cache']->forget('spatie.permission.cache');
        $F = new FuncionesController();
        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = config('atemun.empresa_id');

        $Username = strtoupper(trim($this->curp));
        $Email =  $this->email == "" ? strtolower($Username) . '@example.com' : $this->email;
        $user =  User::create([
            'username'   => strtoupper(trim($Username)),
            'email'      => $Email ,
            'password'   => Hash::make(trim($Username)),
            'curp'       => strtoupper(trim( $this->curp )),
            'ap_paterno' => strtoupper(trim( $this->ap_paterno )),
            'ap_materno' => strtoupper(trim( $this->ap_materno )),
            'nombre'     => strtoupper(trim( $this->nombre )),
            'genero'     => $this->genero ?? 0,
        ]);

        $role_invitado = Role::findByName('Invitado');
        $user->roles()->attach($role_invitado);
        $role_ciudadano = Role::findByName('CIUDADANO');
        $user->roles()->attach($role_ciudadano);
        $role_ciudadano_internet = Role::findByName('CIUDADANO_INTERNET');
        $user->roles()->attach($role_ciudadano_internet);
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
//        $user->email_verified_at = now();
        $user->ubicacion_id = 1;
        $user->save();
        $user->permissions()->attach(7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user->ubicaciones()->attach(1);

        return $user;
    }


    public function failedValidation(Validator $validator){
        $err = "";
        foreach ($validator->errors()->getMessages() as $ss){
            $err .= $err == "" ?  $ss[0] : " :: ". $ss[0];
        }
        throw new HttpResponseException(response()->json([
            'status' => 0,
            'msg'    => $err,
        ]));
    }

    public function messages(){
        return [
            'username.required' => 'La CURP es requerida',
            'password.required' => 'El password es requerido'
        ];
    }

}
