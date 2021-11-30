<?php

class App {
    public static function run() {
        // haetaan apiin tullut route-parametri
        $request = new Request();

        // haetaan route
        $route = $request->input('route');

        // haetaan routen käsittelijän tiedot
        $handler = isset(Routes::$routes[$route]) ? Routes::$routes[$route] : '';

        if(empty($handler)) {
            // ilmoitetaan virheestä
            $request->status('404');
            
            // tulostetaan näytölle
            if($request->is_api()) {
                $handler = 'ErrorController@json';
            } else {
                $handler = 'ErrorController@html';
            }
        } else {
            $request->status('200');
        }
        
        // otetaan käsittelijän tiedoista controller sekä haluttu metodi
        $tmp = explode('@', $handler);
        $controller = $tmp[0];
        $action = $tmp[1];

        // instantiate services and model
        $class_prefix = str_replace('Controller', '', $controller);
        $service = $class_prefix . 'Service';
        $model = $class_prefix . 'Model';

        try {
            if($request->is_api()) {
                $model = new $model($request);
                $service = new $service($request, $model);
            }
        } catch(Exception $e) {
            $service = null;
        }

        // instansioidaan controller
        $instance = new $controller($request, $service);

        // kutsutaan metodia
        $response = $instance->$action($request);

        if($request->is_api()) {
            Response::json(...$response);
        } else {
            Response::html($response);
        }
    }
}