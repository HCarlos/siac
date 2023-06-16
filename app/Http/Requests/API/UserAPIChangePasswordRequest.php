<?php

namespace App\Http\Requests\API;

use App\Classes\MessageAlertClass;
use App\Rules\CurrentPassword;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UserAPIChangePasswordRequest extends FormRequest{
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
    public function rules()
    {
        return [
            'password_actual' => ['required','min:5',new CurrentPassword()],
            'password' => ['required','confirmed','min:5'],
        ];
    }

    public function messages()
    {
        return [
            'password_actual.required' => 'Se requiere el :attribute.',
            'password_actual.min' => 'El :attribute debe ser por lo menos de 5 caracteres.',
            'password_actual.current_password' => 'El :attribute no es correcto.',
            'password.required' => 'Se requiere el :attribute.',
            'password.min' => ':attribute debe ser por lo menos de 5 caracteres.',
            'password.confirmed' => 'La confirmación del password no coincide con el nuevo password.',
        ];
    }

    public function attributes()
    {
        return [
            'password_actual' => 'Password Actual',
            'password' => 'Password',
            'password_confirmation' => 'Confirmar Password',
        ];
    }

    public function sanitize()
    {
        return $this->only('password');
    }


    public function manage()
    {
        try {
            app()['cache']->forget('spatie.permission.cache');
//            $user = Auth::user();
            $user = User::find($this->user_id);
            $user->password = bcrypt($this->password);
            $user->save();
            Auth::guard("web")->login($user,TRUE);
        } catch (QueryException $e) {
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
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


}
