<!--here is head-->
<?php
error_reporting(0);
session_start();
$pageID='news';
include "./widgets/head.php";
?>

<!--content-->
<?php
/*连接数据库*/
require_once('./tools/Kodbc.class.php');
$newsid = $_GET['id'];
$kodbc = new Kodbc('./Database/NEWSDATA.xml');

$news = $kodbc->getById($newsid);
?>

<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 新闻预览</div>
    <div class="panel-body">
    <?php

        $newsfile = fopen($news['text'],'r') or die('can not find news,because no news file found');
        echo htmlspecialchars_decode(fread($newsfile,filesize($news['text'])));
        fclose($newsfile);
    ?>
    </div>
</div>


<!--here this foot-->
<?php
include "./widgets/foot.php";
?>