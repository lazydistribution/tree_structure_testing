<?php


class HTML {
    public static function view($view, $params = []) {
        $folder = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views';
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
        $file_path = $folder . DIRECTORY_SEPARATOR . $view . '.php';
        return self::render($file_path, $params);
    }

    private static function render($file_path, $params) {
        ob_start();
        extract($params);
        include($file_path);
        $var=ob_get_contents(); 
        ob_end_clean();
        return $var;
    }
}