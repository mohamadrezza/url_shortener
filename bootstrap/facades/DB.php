<?php


namespace Bootstrap\Facades;


use Bootstrap\App;

class DB
{
    public $builder;

    public function __construct()
    {
        $this->builder = App::get('database');
    }
}