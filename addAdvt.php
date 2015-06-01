<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
    require('./widgets/loginboard.php');
    echo "</body></html>";
    return;
}
?>

/*<!--导航-->*/
<?php include('./widgets/nav.php');?>


<!--已有广告展示-->
<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 已有广告</div>
    <div class="panel-body">
        下面表格展示了已经添加了的广告
    </div>

    <!-- Table -->
    <table class="table">
        <tr  style="text-align: left">
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
                上架日期
            </td>
            <td>
                <span class="glyphicon glyphicon-time"></span>
                下架日期
            </td>
            <td>
                <span class="glyphicon glyphicon-cog"></span>
                操作
            </td>
        </tr>
        <?php

        $adCollection = array(
            array('index'=>1,'title'=>'第一个的标题','cover'=>'http://tangweimm.com/img/imgveiw/3.jpg','update'=>'2015-04-25 00:00:00','dndate'=>'2015-06-25 00:00','remark'=>'默认备注'),
            array('index'=>2,'title'=>'第一个的标题','cover'=>'http://tangweimm.com/img/imgveiw/3.jpg','update'=>'2015-04-25 00:00:00','dndate'=>'2015-06-25 00:00','remark'=>'默认备注'),
            array('index'=>3,'title'=>'第一个的标题','cover'=>'http://tangweimm.com/img/imgveiw/3.jpg','update'=>'2015-04-25 00:00:00','dndate'=>'2015-06-25 00:00','remark'=>'默认备注'),
        );

        foreach($adCollection as $items){?>
            <tr>
                <td><img height=100 src="<?php echo $items['cover']?>" alt="缩略图"></td>
                <td><?php echo $items['title']?></td>
                <td><?php echo substr($items['update'],0,10)?></td>
                <td><?php echo substr($items['dndate'],0,10)?></td>
                <td><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;"><span class="glyphicon glyphicon-trash"></span></button>
                        <button type="button" class="btn btn-default" onclick="fillForMod(this)"
                                data-index="<?php echo $items['index']?>"
                                data-title="<?php echo $items['title']?>"
                                data-cover="<?php echo $items['cover']?>"
                                data-update="<?php echo substr($items['update'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-dndate="<?php echo substr($items['dndate'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-remark="<?php echo $items['remark']?>">
                            <span class="glyphicon glyphicon-list-alt"></span></button></div></td>
            </tr>

        <?php }?>
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

<!--创建新广告-->
<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto;">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 新建一条广告</div>
    <div class="panel-body">
        下面表格展示了已经添加了的广告
    </div>
    <div  style="margin: 20px;">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">广告顺序</span>
            <input id="ad_index" type="number" class="form-control" placeholder="填写广告序号" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">广告标题</span>
            <input id="ad_title" type="text" class="form-control" placeholder="填写广告标题" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">图片上传</span>
            <input id="ad_img" type="file" class="form-control" placeholder="上传广告图" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">开始时间</span>
            <input id="ad_update" type="datetime-local" class="form-control" placeholder="广告上架时间" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">结束时间</span>
            <input id="ad_dndate" type="datetime-local" class="form-control" placeholder="广告下架时间" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">备注信息</span>
            <textarea id="ad_remark" class="form-control" placeholder="备注信息" aria-describedby="basic-addon1"></textarea>
        </div>
    </div>
    <button style="margin:20px 0;min-width: 100%;" type="button" class="btn btn-default" ><span class="glyphicon glyphicon-list-alt"></span>添加一条</button>
</div>
<script>

    function fillForMod(node){
        var ad_index  = document.getElementById('ad_index').value=node.getAttribute('data-index')||'';
        var ad_title  = document.getElementById('ad_title').value=node.getAttribute('data-title')||'';
//        var ad_cover  = document.getElementById('ad_cover').value=node.getAttribute('data-cover')||'';
        var ad_update = document.getElementById('ad_update').value=node.getAttribute('data-update')||'';
        var ad_dndate = document.getElementById('ad_dndate').value=node.getAttribute('data-dndate')||'';
        var ad_remark = document.getElementById('ad_remark').value=node.getAttribute('data-remark')||'';
    }
</script>
</body>
</html>