<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 21/11/18
 * Time: 10:33 AM
 */
namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;


class ValidatorPassword extends LaravelValidator
{

    public function validateCurrentPassword($attribute, $value, $parameters)
    {
        return Hash::check($value, Auth::user()->password);
    }

}
