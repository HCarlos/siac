<?php

namespace App\Http\Requests\User;

use App\Classes\MessageAlertClass;
use App\Rules\CurrentPassword;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Classes\ValidatorPassword;
use Illuminate\Support\Facades\Hash;

class UserUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    protected $redirectRoute = "showEditProfilePassword/";

    public function authorize()
    {
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
            'password_actual.min' => 'El :attribute debe ser por lo menos de 6 caracteres.',
            'password_actual.current_password' => 'El :attribute no es correcto.',
            'password.required' => 'Se requiere el :attribute.',
            'password.min' => ':attribute debe ser por lo menos de 6 caracteres.',
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

    /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize()
    {
        return $this->only('password');
    }

    public function updateUserPassword(){

        try {
            $user = Auth::user();
//            dd($user);
            $user->password  = bcrypt($this->password);
            $user->save();
            auth()->login($user);
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return redirect()->route($this->redirectRoute);

    }

}
