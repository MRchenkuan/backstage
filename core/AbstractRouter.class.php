<?php
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/29
 * Time: 下午11:19
 */
namespace core;
use core\interfaces\Router;
require($_SERVER['DOCUMENT_ROOT'] . '/definitions.php');
require_once CORE_PATH . 'Router.interface.php';
error_reporting(E_ALL);
abstract class AbstractRouter implements Router
{
    public static $allRouters = array();
    public $routers=array();

    // 初始化时,将对象的router加入全局router
    public function __construct(){
        self::addRouter($this->routers);
        var_dump(self::$allRouters);
    }

    // 执行指定router
    public static function go($router)
    {
        // 执行全局router
        self::executeRouter($router,self::$allRouters);
    }

    // 补充全局router
    public static function addRouter($routers)
    {
        self::$allRouters = array_merge(self::$allRouters,$routers);
    }

    // 执行全局router
    private static function executeRouter($router, $allRouters)
    {
        $fn = $allRouters[$router];
        $fn();
    }

}