<?php

/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/30
 * Time: 下午3:35
 */
namespace core\interfaces;

interface Router
{
    public function __construct();
    public static function go($router);
}