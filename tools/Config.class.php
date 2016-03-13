<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 16/3/13
 * Time: 下午3:54
 */
class Config
{
    private static $configDir = '../config.ini';

    public static function get($section,$key){
        $ini = parse_ini_file(Config::$configDir,true)[$section];
        return $ini[$key];
    }

    public static function getSection($section){
        return parse_ini_file(Config::$configDir,true)[$section];
    }
}
