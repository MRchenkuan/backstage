<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/bootstrap-theme.min.css">

    <script src="../PUBLIC/javascripts/jquery.min.js"></script>
    <script src="../bootstrap/bootstrap.min.js"></script>
    <style>
        .input-group{margin: 10px auto;}
    </style>
    <title></title>
</head>
<body style="overflow-x: hidden;padding: 20px 5%;">
<!--content-->
<?php
/*连接数据库*/
$newsid = $_GET['id'];
require_once('../DO/Kodbc.class.php');
$kodbc = new Kodbc('../DO/T_TABLE_IDEA.xml');

$news = $kodbc->getById($newsid);

$newsfile = fopen($news['text'],'r') or die('can not find newsfiles,because no newsfiles file found');
echo htmlspecialchars_decode(fread($newsfile,filesize($news['text'])));
fclose($newsfile);
?>
</body>
</html>