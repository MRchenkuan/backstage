<?php
error_reporting(0);
session_start();
?>
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

<!--登录框-->
<?php
if(!$_SESSION['stat']=='login'){
    include('./widgets/Loginboard_.php');
}else{
    include('./widgets/nav.php');
}
?>

</body>
</html>