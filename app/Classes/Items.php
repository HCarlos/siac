<?php
/**
 * Copyright (c) 2019. Realizado por Carlos Hidalgo
 */

/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/02/19
 * Time: 07:19 PM
 */

namespace App\Classes;


class Items
{
    /**
     * Items constructor.
     */
    private static $instancia;

    protected $Items;

    public function __construct()
    {
    }

    public static function getInstance(){
        if (  !self::$instancia instanceof self){
            self::$instancia = new self;
        }
        return self::$instancia;
    }


    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->Items;
    }

    /**
     * @param mixed $Items
     */
    public function setItems($Items): void
    {
        $this->Items = $Items;
    }





}
