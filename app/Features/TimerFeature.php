<?php

class TimerFeature
{
    public static $sql;
    public static $php;
    public static $rows;

    public static function sql() {
        if(empty(self::$sql)) self::$sql = [];
        self::$sql[] = microtime(true);
    }
    public static function php() {
        if(empty(self::$php)) self::$php = [];
        self::$php[] = microtime(true);
    }

    public static function phpTot() {
        return self::$php[1] - self::$php[0];
    }
    
    public static function sqlTot() {
        return self::$sql[1] - self::$sql[0];
    }

    public static function rows($count) {
        return self::$rows = $count;
    }

    public static function getRows() {
        return self::$rows;
    }
}