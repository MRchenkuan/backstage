<?php
error_reporting(0);

session_start();
use core\AbstractRouter;
require_once './definitions.php';
$APIID = $_GET['id'] ? $_GET['id'] : 'defaultMethod';
if($_GET['id']){
//    var_dump($_POST);
    // 导入路由
     include_once CORE_PATH . 'AbstractRouter.class.php';
     include_once ROUTER_PATH.'DefaultRouter.php';
     include_once ROUTER_PATH.'ImageUploadRouter.php';
     AbstractRouter::go($APIID);

}else{
    echo phpinfo();
}
