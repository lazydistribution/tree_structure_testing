<?php

class Response {

    public static function html($html) {
        echo $html;
    }

    public static function json($msg, $status = 200) {
        switch($status) {
            case 400: $header_prefix = "HTTP/1.1 400 Bad Request;"; break;
            case 404: $header_prefix = "HTTP/1.1 404 Not Found;"; break;
            case 200: default: $header_prefix = "HTTP/1.1 200 OK;"; break;
        }

        TimerFeature::php();
        
        $timer_arr = [
            'php_tot' => TimerFeature::phpTot(),
            'sql_tot' => TimerFeature::sqlTot(),
            'rows' => TimerFeature::getRows(),
        ];

        $msg = array_merge($timer_arr, ['response' => $msg]);
        
        header("{$header_prefix} Content-Type: application/json; charset=utf-8");
        echo json_encode($msg);
    }
}