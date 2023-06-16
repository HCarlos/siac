<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 21/11/18
 * Time: 10:33 AM
 */
namespace App\Classes;


use Illuminate\Database\QueryException;
use Psy\Util\Str;

class MessageAlertClass
{
    protected $Msg;
    public function __construct(){
        $this->Msg  = "";
    }

    public function Message(QueryException $e):string {
        $this->Msg = $e->errorInfo[2];
        if (str_contains($e->errorInfo[2],'duplicate key value')){
            $this->Msg = "Valor Duplicado";
        }
        return $this->Msg;
    }

}
