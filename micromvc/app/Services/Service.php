<?php


class Service 
{
    protected $request;
    
    public function __construct($request, $model) {
        $model_name = str_replace('Model', '', get_class($model));
        $this->$model_name = $model;
        $this->request = $request;
    }

    public function loadModel($model_name) {
        $model = $model_name . 'Model';
        $this->$model_name = new $model($this->request);
    }
}