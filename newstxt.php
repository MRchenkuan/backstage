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
            case 'remarkManager':echo '评论管理';break;
            default:echo '首页';break;
        }
        ?></title>
</head>
<body style="overflow-x: hidden">
<!--content-->
<?php
/*连接数据库*/
require_once('./tools/Kodbc.class.php');
$newsid = $_GET['id'];
$kodbc = new Kodbc('./Database/NEWSDATA.xml');

$news = $kodbc->getById($newsid);

$newsfile = fopen($news['text'],'r') or die('can not find news,because no news file found');
echo htmlspecialchars_decode(fread($newsfile,filesize($news['text'])));
fclose($newsfile);
?>
</body>
</html>