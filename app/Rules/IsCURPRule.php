<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsCURPRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){

        if ($value == ""){
            return true;
        }

        $string = mb_strtoupper($value, "UTF-8");
        $pattern = "/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/";
        $validate = preg_match($pattern, $string, $match);

//            dd($validate);

        if( $validate === 0 ){
            return false;
        }
        $ind = preg_split( '//u', '0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ', null, PREG_SPLIT_NO_EMPTY );
//            dd($match);
        $vals = str_split( strrev( $match[0]."?" ) );
        unset( $vals[0] );
        unset( $vals[1] );
        $tempSum = 0;
        foreach( $vals as $v => $d ){
            $tempSum = (array_search( $d, $ind ) * $v)+$tempSum;
        }
        $digit = 10 - $tempSum % 10;
        $digit = $digit == 10 ? 0 : $digit;

        return $match[2] == $digit;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.iscurp');
    }
}
