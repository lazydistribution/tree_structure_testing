<?php

function tulosta($arr = '') {
    echo '<PRE>';
    print_r($arr);
    echo '</PRE>';
}


function tapa($arr = '') {
    tulosta($arr);
    die;
}

function base_url() {
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $base_url = str_replace('index.php', '', $base_url);
    $base_url = strtok($base_url, '?');
    $base_url = rtrim($base_url,'/');
    return str_replace('index.php', '', $base_url);
}

function redirect($url) {
    header('Location: ' . $url);
}


function utf8_deep_encode($data) {
    if(is_iterable($data)) {
        if(is_array($data)) {
            $output = [];
            foreach($data as $key => $value) {
                $key = utf8_deep_encode($key);
                $output[$key] = utf8_deep_encode($value);
            }
        } else {
            $output = (object)[];
            foreach($data as $key => $value) {
                $key = utf8_deep_encode($key);
                $output->$key = utf8_deep_encode($value);
            }
        }
        $data = $output;
    } else {
        $data = utf8_encode($data);
    }
    return $data;
}

function alphanumerical($str) {
    preg_match_all('/[a-z0-9 ]+/i', $str, $arr);
    $text = '';
    foreach($arr[0] as $line) {
        $text .= $line;
    }
    return $text;
}

class Functions { public static function init(){} }