<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap/bootstrap-theme.min.css">

    <script src="./js/jquery.min.js"></script>
    <script src="./bootstrap/bootstrap.min.js"></script>
    <style>
        .input-group{margin: 10px auto;}
    </style>
    <title><?php
        switch($pageID){
            case 'home':echo '首页';break;
            case 'addAdvt':echo '广告管理';break;
            case 'addNews':echo '新闻管理';break;
            case 'photoLib':echo '图库管理';break;
            default:echo '首页';break;
        }
        ?></title>
</head>
<body>
<?php
error_reporting(0);
session_start();
if(!$_SESSION['stat']=='login'){
    /*未登录展示登录框*/
    require('./widgets/Signinboard.php');
    echo "</body></html>";
    return;
}else{
    include('./widgets/nav.php');
}
?>