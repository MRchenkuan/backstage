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
    <title>主页</title>
</head>
<body>
<?php
error_reporting(0);
session_start();
if(!$_SESSION['stat']=='login'){
    /*未登录展示登录框*/
    require('./Signinboard.php');
    echo "</body></html>";
    return;
}else{
    include('./widgets/nav.php');
}
?>