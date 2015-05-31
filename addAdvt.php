<?php
error_reporting(0);
session_start();
if(!$_SESSION['stat']=='login'){
    return false;
}
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
<!--导航-->
<?php include('./widgets/nav.php');?>



<!--已有新闻展示-->
<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 已有广告</div>
    <div class="panel-body">
        下面表格展示了已经添加了的广告
    </div>

    <!-- Table -->
    <table class="table">
        <tr  style="text-align: center">
            <td>
                <span class="glyphicon glyphicon-picture"></span>
                图片
            </td>
            <td>
                <span class="glyphicon glyphicon-bookmark"></span>
                标题
            </td>
            <td>
                <span class="glyphicon glyphicon-time"></span>
                发布日期
            </td>
            <td>
                <span class="glyphicon glyphicon-cog"></span>
                操作
            </td>
        </tr>
        <tr><td><img height=100 src="http://tangweimm.com/img/imgveiw/3.jpg" alt="缩略图"></td><td>广告标题1234</td><td>2015-04-28</td><td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span></button></div></td></tr>
        <tr><td><img height=100 src="http://tangweimm.com/img/imgveiw/3.jpg" alt="缩略图"></td><td>广告标题1234</td><td>2015-04-28</td><td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span></button></div></td></tr>
        <tr><td><img height=100 src="http://tangweimm.com/img/imgveiw/3.jpg" alt="缩略图"></td><td>广告标题1234</td><td>2015-04-28</td><td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span></button></div></td></tr>
        <tr><td><img height=100 src="http://tangweimm.com/img/imgveiw/3.jpg" alt="缩略图"></td><td>广告标题1234</td><td>2015-04-28</td><td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span></button></div></td></tr>
        <tr><td><img height=100 src="http://tangweimm.com/img/imgveiw/3.jpg" alt="缩略图"></td><td>广告标题1234</td><td>2015-04-28</td><td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span></button></div></td></tr>
    </table>

    <!--分页组件-->
    <nav style="margin: 0 auto">
        <ul class="pagination">
            <li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
            <li class="active"><a href="#">1</a></li>
            <li ><a href="#">2 </a></li>
            <li ><a href="#">3 </a></li>
            <li ><a href="#">4 </a></li>
            <li ><a href="#">5 </a></li>
            <li ><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
        </ul>
    </nav>
</div>

</body>
</html>