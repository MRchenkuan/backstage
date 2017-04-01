<?php
error_reporting(E_ALL);

session_start();
require($_SERVER['DOCUMENT_ROOT']. '/definitions.php');

$APIID = $_GET['id'] ? $_GET['id'] : 'defaultMethod';
if($_GET['id']){
    // 导入路由
    require_once CORE_PATH . 'AbstractRouter.class.php';
    require_once ROUTER_PATH.'./DefaultRouter.php';
    require_once ROUTER_PATH.'./ImageUploadRouter.php';
    \core\AbstractRouter::go($APIID);
}else{
    echo phpinfo();
}
