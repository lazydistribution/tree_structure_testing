<?php

class Routes {
    
    public static $routes = [];
    
    public static function get($route, $controller) {
        self::$routes[$route] = $controller;
    }
}