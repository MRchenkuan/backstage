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

    /**
     * @return bool
     * @param override
     */
    public static function get(){
        $args = func_get_args();
        // 根据key取
        if(count($args)==1){
            $ini = parse_ini_file(Config::$configDir,true)['PROPERTIES'];
            return trim($ini[$args[0]]);
        }

        // 根据section key取
        if(count($args)==2){
            $ini = parse_ini_file(Config::$configDir,true)[$args[0]];
            return trim($ini[$args[1]]);
        }

        return false;
    }

    public static function getSection($section){
        return parse_ini_file(Config::$configDir,true)[$section];
    }
}
