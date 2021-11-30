<?php

// aikavyöhyke
date_default_timezone_set('Europe/Helsinki');

// apufunktiot
Functions::init();



// ohjaa etusivulle
$r = new Request();
if(empty($r->input('route'))) {
    redirect(base_url() . '?' . http_build_query(['route'=>'index']));
}

// jotta tiedosto ladataan
class Config { 
    public static $start_time;
    public static $end_time;
    public static $start_sql_time;
    public static $end_sql_time;
    public static function init() {}}