<?php

spl_autoload_register(function ($class_name) {
    $classes = __DIR__ . DIRECTORY_SEPARATOR . 'app';
    $content = scandir($classes);
    $content = array_diff($content, ['..', '.']);
    
    //$found = false;
    foreach($content as $item) {
        $path = $classes . DIRECTORY_SEPARATOR . $item . DIRECTORY_SEPARATOR . $class_name . '.php';
        if(file_exists($path)) {
            include_once($path);
            break;
        }
    }
});

$vendor_autoload_path = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if(file_exists($vendor_autoload_path)) {
    include_once $vendor_autoload_path;
}

