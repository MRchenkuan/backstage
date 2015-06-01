<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <title>主页</title>
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
}
?>
<!--导航-->
<?php include('./widgets/nav.php');?>

</body>
</html>