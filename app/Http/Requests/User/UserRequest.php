<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\User;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Permission;
use App\Role;
use App\Rules\IsCURPRule;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    protected $redirectRoute = 'editUser';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['curp'] = strtoupper(trim($attributes['curp']));
        $this->replace($attributes);
        return parent::all();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        $arr =  [
            'ubicacion_nueva_id' => ['required','numeric','not_in:0'],
            'curp'               => ['unique:users,curp,'.$this->id, new IsCURPRule() ],
            'ap_paterno'         => ['required', 'string'],
            'nombre'             => ['required', 'string'],
        ];
        if (trim($this->email) != "" ){
            $arr['email'] = ['required', 'string', 'email', 'max:255','unique:users,email,'.$this->id];
        }
        return $arr;
    }

    public function messages(){
        return [

            'ubicacion_nueva_id.required' => 'Se requiere la :attribute',
            'ubicacion_nueva_id.not_in'   => 'Falta la :attribute',
            'curp.required'               => 'Se requiere la :attribute',
            'curp.min'                    => 'La :attribute requiere 18 caracteres',
            'curp.max'                    => 'La :attribute requiere 18 caracteres',
            'curp.unique'                 => 'La :attribute ya existe',
            'email.required'              => 'Se requiere el :attribute',
            'email.min'                   => 'El :attribute requiere por lo menos de 1 caracter',
            'email.unique'                => 'El :attribute ya existe',
            'nombre.required'             => 'Se requiere el :attribute',
            'nombre.min'                  => 'El :attribute requiere por lo menos de 1 caracter',
            'ap_paterno.required'         => 'Se requiere el :attribute',
            'ap_paterno.min'              => 'El :attribute requiere por lo menos de 1 caracter',

        ];
    }

    public function attributes()
    {
        return [
            'ubicacion_nueva_id' => 'Ubicación',
            'nombre'             => 'Nombre',
            'curp'               => 'CURP',
            'email'              => 'Email',
            'nombre'             => 'Nombre',
            'ap_paterno'         => 'Apellido Paterno',
        ];
    }

    public function manageUser()
    {

        // dd($this->all());
        $this->ubicacion_nueva_id = $this->ubicacion_nueva_id ?? 1;
        $ubicacion_actual_id = $this->ubicacion_actual_id;
        If ( $ubicacion_actual_id != $this->ubicacion_nueva_id ){
            $ubicacion_actual_id = $this->ubicacion_nueva_id;
        }
        //dd($ubicacion_actual_id);
        if ($ubicacion_actual_id == 0){
            throw new HttpResponseException(response()->json( 'Falta la Ubicación', 422));
        }
        $Ubi = Ubicacion::findOrFail($ubicacion_actual_id);

        if (!$Ubi){
            $ubicacion_actual_id = 1;
            $Ubi = Ubicacion::findOrFail($ubicacion_actual_id);
        }

        //dd($Ubi->id);

        if ($this->id == 0) {

            $CURP     = strtoupper(trim($this->curp));

            if ( $CURP  === "" ){
                $UN       =  User::getUsernameNext('CIU');
                $CURP = $UN['username'];
            }

            $Username = $CURP;

            if ( trim($this->email)  != "" ){
                $Email    = strtolower(trim($this->email));
            }else{
                $Email    =  strtolower(trim($Username)) . '@example.com' ;
            }

            $UserN = [
                'username' => $Username,
                'curp'     => $CURP,
                'email'    => $Email,
                'password' => Hash::make($Username),
            ];

        }else{
            $UserN = [ 'email' => strtolower(trim($this->email)), ];
            $CURP  = $this->curp;
        }
        $User = [
            'ap_paterno'       => strtoupper(trim($this->ap_paterno)),
            'ap_materno'       => strtoupper(trim($this->ap_materno)),
            'nombre'           => strtoupper(trim($this->nombre)),
            'curp'             => $CURP,
            'emails'           => $this->emails,
            'celulares'        => strtoupper(trim($this->celulares)),
            'telefonos'        => strtoupper(trim($this->telefonos)),
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'genero'           => $this->genero,
            'ubicacion_id'     => $Ubi->id,
            'imagen_id'        => 0,
        ];
        //dd($Ubi);

        $User_Adress = [
            'calle'     => strtoupper(trim($Ubi->calle)),
            'num_ext'   => $Ubi->num_ext,
            'num_int'   => $Ubi->num_int,
            'colonia'   => strtoupper(trim($Ubi->colonia)),
            'localidad' => strtoupper(trim($Ubi->localidad)),
            'municipio' => strtoupper(trim($Ubi->municipio)),
            'estado'    => strtoupper(trim($Ubi->estado)),
            'pais'      => strtoupper(trim($Ubi->pais)),
            'cp'        => $Ubi->cp,
        ];

        $User_Data_Extend = [
            'lugar_nacimiento' => strtoupper(trim($this->lugar_nacimiento)),
            'ocupacion'        => strtoupper(trim($this->ocupacion)),
            'profesion'        => strtoupper(trim($this->profesion)),
        ];
        try {

            if ($this->id == 0) {
                $user = User::create($UserN);
                $user->user_adress()->create();
                $user->user_data_extend()->create();
                $user->update($User);
                $role_invitado = Role::findByName('Invitado');
                $user->roles()->attach($role_invitado);
                $role_ciudadano = Role::findByName('CIUDADANO');
                $user->roles()->attach($role_ciudadano);
                $role_ciudadano_interner = Role::findByName('CIUDADANO_INTERNET');
                $user->roles()->attach($role_ciudadano_interner);
                $P1 = Permission::findByName('consultar');
                $user->permissions()->attach($P1);
                $F = new FuncionesController();
                $F->validImage($user, 'profile', 'profile/');

                $user->user_adress()->update($User_Adress);
                $user->user_data_extend()->update($User_Data_Extend);
            } else {
                $user = User::find($this->id);
                $user->update($User);
                $user->update($UserN);
                //dd($user);

                $user->user_adress()->update($User_Adress);
                $user->user_data_extend()->update($User_Data_Extend);
            }
            If ( $this->ubicacion_actual_id !== $this->ubicacion_nueva_id ){
                $user->ubicaciones()->detach($this->ubicacion_nueva_id );
                $user->ubicaciones()->attach($this->ubicacion_nueva_id );
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $user;
    }

    protected function validPhoto(User $user){
        $F = new FuncionesController();
        $F->validImage($user,'profile','profile/');

    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newUser');
        }
    }

}
