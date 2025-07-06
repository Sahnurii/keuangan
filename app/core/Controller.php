<?php

class Controller
{
    protected $data = [];

    public function __construct() {}

    public function view($view, $data = [])
    {
        $data = array_merge($this->data ?? [], $data);
        extract($data);
        
        require_once '../app/views/' . $view . '.php';
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }
}
