<?php


class Controller {
    public $request;
    public $Service;

    public function __construct($request, $service = null) {
        if(!empty($service)) {
            $this->Service = $service;
        }
        $this->request = $request;
    }

    public function loadModel($model_name) {
        $model = $model_name . 'Model';
        $this->$model_name = new $model($this->request);
    }
}