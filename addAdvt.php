<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
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
    require('./widgets/Signinboard.php');
    echo "</body></html>";
    return;
}
?>

/*<!--导航-->*/
<?php include('./widgets/nav.php');?>


<!--已有广告展示-->
<?php
    /*--连接数据库--*/
    require_once('./tools/Kodbc.class.php');
    $Kodbc = new Kodbc('./myfolder/NEWSDATA.xml');
    $pageNow = $_GET['page'];
    if(!$pageNow){$pageNow=1;}
    $pagesize = 5;
    $adCollection = $Kodbc->getAllItems(-$pagesize*$pageNow,$pagesize);

    /*排序*/
    usort($adCollection, function($a, $b) {
        $al = (int)$a['order'];
        $bl = (int)$b['order'];
        if ($al == $bl)
            return 0;
        return ($al > $bl) ? -1 : 1;
    });

    $count = $Kodbc->count();//总共条目数
    $pageCount = ceil($count/$pagesize);//总页数


?>
<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 已有广告</div>
    <div class="panel-body">
        下面表格展示了已经添加了的广告,序号越大,排序越靠前
    </div>
    <!--分页组件-->
    <nav style="margin: 0 auto;text-align: center">
        <ul class="pagination">
            <li class="<?php echo $pageNow<=1?'disabled':'default'?>">
                <a <?php echo $pageNow<=1?'':"href='?page=".($pageNow-1)."'"; ?> aria-label='Previous'>
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <?php
            for($i=0;$i<$pageCount;$i++){
                echo ($pageNow==($i+1))?"<li class='active'>":"<li class='default'>";
                echo "<a href='?page=".($i+1)."'>".($i+1)."</a></li>";
            }
            ?>
            <li class="<?php echo $pageNow>=$pageCount?'disabled':'default'?>" >
                <a <?php echo $pageNow>=$pageCount?'':"href='?page=".($pageNow+1)."'"; ?> aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Table -->
    <table class="table">
        <tr  style="text-align: left">
            <td>
                <span class="glyphicon glyphicon-picture"></span>
                图片
            </td>
            <td>
                <span class="glyphicon glyphicon-picture"></span>
                排序
            </td>
            <td>
                <span class="glyphicon glyphicon-picture"></span>
                ID
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

        foreach($adCollection as $items){?>
            <tr>
                <td><img height=100 src="<?php echo $items['imgsrc']?>" alt="缩略图"></td>
                <td><?php echo $items['order']?></td>
                <td><?php echo $items['id']?></td>
                <td><?php echo $items['title']?></td>
                <td><?php echo substr($items['update'],0,10)?></td>
                <td><?php echo substr($items['dndate'],0,10)?></td>
                <td><div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default"  onclick="if(!confirm('是否删除此条记录?'))return false;delRecord(<?php echo $items['id']?>)"><span class="glyphicon glyphicon-trash"></span></button>
                        <button type="button" class="btn btn-default" onclick="fillForMod(this)"
                                data-id="<?php echo $items['id']?>"
                                data-index="<?php echo $items['order']?>"
                                data-title="<?php echo $items['title']?>"
                                data-cover="<?php echo $items['imgsrc']?>"
                                data-update="<?php echo substr($items['update'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-dndate="<?php echo substr($items['dndate'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-remark="<?php echo $items['remark']?>">
                            <span class="glyphicon glyphicon-list-alt"></span></button></div></td>
            </tr>

        <?php }?>
        </table>

    <!--分页组件-->
    <nav style="margin: 0 auto;text-align: center">
        <ul class="pagination">
            <li class="<?php echo $pageNow<=1?'disabled':'default'?>">
                <a <?php echo $pageNow<=1?'':"href='?page=".($pageNow-1)."'"; ?> aria-label='Previous'>
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <?php
                for($i=0;$i<$pageCount;$i++){
                    echo ($pageNow==($i+1))?"<li class='active'>":"<li class='default'>";
                    echo "<a href='?page=".($i+1)."'>".($i+1)."</a></li>";
                }
            ?>
            <li class="<?php echo $pageNow>=$pageCount?'disabled':'default'?>" >
                <a <?php echo $pageNow>=$pageCount?'':"href='?page=".($pageNow+1)."'"; ?> aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
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
            <span class="input-group-addon" id="basic-addon1">广告艾迪</span>
            <input id="ad_id" type="number" class="form-control" readonly placeholder="自动填写" aria-describedby="basic-addon1">
        </div>

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
<!--            <input id="ad_img" type="file" class="form-control" placeholder="上传广告图" aria-describedby="basic-addon1">-->
            <iframe id="ad_img" src="./fileupload.html" aria-describedby="basic-addon1" class="form-control"></iframe>
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
    <button style="margin:20px 0;min-width: 100%;" type="button" class="btn btn-default" onclick="submitDate(this)"><span class="glyphicon glyphicon-list-alt"></span>添加一条</button>
</div>
<script>

    function submitDate(self){
        var imgsrcobj = document.getElementById('ad_img').contentWindow.document.getElementById('uploadCallBack-ImgSrc');
        var imgsrc;
        if(imgsrcobj){
            imgsrc = imgsrcobj.value;
        }else{
            imgsrc = 'http://tangweimm.com/img/imgveiw/3.jpg';
        }
        var ad_id     = document.getElementById('ad_id').value;
        var ad_index  = document.getElementById('ad_index').value;
        var ad_title  = document.getElementById('ad_title').value;
        var ad_update = document.getElementById('ad_update').value;
        var ad_dndate = document.getElementById('ad_dndate').value;
        var ad_remark = document.getElementById('ad_remark').value;
        if(!(imgsrc&&ad_title&&ad_index&&ad_update&&ad_dndate&&ad_remark)){
            alert('信息不全');
            return false;
        }else{
            self.innerHTML = '提交中...';
            $.ajax({
                url: './Data.php',
                data:{
                    id: 'createAdvt',
                    order:ad_index,
                    title:ad_title,
                    update:ad_update,
                    dndate:ad_dndate,
                    remark:ad_remark,
                    adid:ad_id,
                    imgsrc:imgsrc
                },
                complete: function (data) {
                    console.log(data.responseText);
                    var rep = eval("(" + data.responseText + ")");
                    if (rep.stat == 200) {
                        alert(rep.msg);
                        location.reload();
                    } else{
                        self.innerHTML = '提交出错，请重试';
                        self.removeAttribute('disabled');
                    }
                },
                error: function () {
                    alert('提交出错');
                    self.removeAttribute('disabled');
                }
            })
        }
    }

    function delRecord(id){
        $.ajax({
            url: './Data.php',
            data:{
                id: 'delAdvt',
                adid:id
            },
            complete: function (data) {
                console.log(data.responseText);
                var rep = eval("(" + data.responseText + ")");
                if (rep.stat == 200) {
                    alert(rep.msg);
                    location.reload();
                } else{
                    self.innerHTML = '提交出错，请重试';
                    self.removeAttribute('disabled');
                }
            },
            error: function () {
                alert('提交出错');
                self.removeAttribute('disabled');
            }
        })
    }
    function fillForMod(node){
        var ad_id  = document.getElementById('ad_id').value=node.getAttribute('data-id')||'';
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