<!--here is head-->
<?php
error_reporting(0);
session_start();
$pageID='addNews';
include "./widgets/head.php";
?>


<?php
/*--连接数据库--*/
require_once('./tools/Kodbc.class.php');
$Kodbc = new Kodbc('./myfolder/NEWSDATA.xml');
$pageNow = $_GET['page'];
$sliceParam = 'page';

if(!$pageNow){$pageNow=1;}
$pagesize = 5;
$adCollection = $Kodbc->getAllItems(-$pagesize*$pageNow,$pagesize);
$count = $Kodbc->count();//总共条目数
$pageCount = ceil($count/$pagesize);//总页数

/*排序*/
usort($adCollection, function($a, $b) {
    $al = (int)$a['order'];
    $bl = (int)$b['order'];
    if ($al == $bl)
        return 0;
    return ($al > $bl) ? -1 : 1;
});
?>

<!--below is content-->
<div class="panel panel-default" style="width: 960px;margin: 60px auto 0 auto">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span> 已有广告
        <button type="button" class="btn btn-default" style="float: right" onclick="document.getElementById('ad_id').value='';location='#donewAdvt'"><span class="glyphicon glyphicon-plus"></span>新增一条广告</button>
    </div>
    <div class="panel-body">
        下面表格展示了已经添加了的新闻,序号越大,排序越靠前
    </div>
    <!--分页组件-->
    <?php include './widgets/pageSliceBar.php' ?>
    <!-- Table -->
    <table class="table">
        <tr  style="text-align: left">
            <td><span class="glyphicon glyphicon-picture"></span>图片</td>
            <td><span class="glyphicon glyphicon-sort-by-attributes"></span>排序</td>
            <td><span class="glyphicon glyphicon-flag"></span>ID</td>
            <td><span class="glyphicon glyphicon-bookmark"></span>标题</td>
            <td><span class="glyphicon glyphicon-time"></span>上架日期</td>
            <td><span class="glyphicon glyphicon-time"></span>下架日期</td>
            <td><span class="glyphicon glyphicon-info-sign"></span>备注</td>
            <td><span class="glyphicon glyphicon-cog"></span>操作</td>
        </tr>
        <?php
        foreach($adCollection as $items){?>
            <tr>
                <td><img height=100 src="<?php echo $items['cover']?>" alt="缩略图"></td>
                <td><?php echo $items['order']?></td>
                <td><?php echo $items['id']?></td>
                <td><?php echo $items['title']?></td>
                <td><?php echo substr($items['update'],0,10)?></td>
                <td><?php echo substr($items['dndate'],0,10)?></td>
                <td><?php echo $items['remark']?></td>
                <td><div class="btn-group" role="group" aria-label="...">
                        <button type="button"
                                class="btn btn-default"
                                onclick="if(!confirm('是否删除此条记录?'))return false;delRecord(<?php echo $items['id']?>)">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <button type="button"
                                class="btn btn-default"
                                onclick="fillForMod(this)"
                                data-id="<?php echo $items['id']?>"
                                data-index="<?php echo $items['order']?>"
                                data-title="<?php echo $items['title']?>"
                                data-cover="<?php echo $items['cover']?>"
                                data-update="<?php echo substr($items['update'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-dndate="<?php echo substr($items['dndate'],0,10).'T'.substr($items['update'],11,16)?>"
                                data-remark="<?php echo $items['remark']?>">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php }?>
    </table>

    <!--分页组件-->
    <?php include './widgets/pageSliceBar.php' ?>
</div>

<iframe id="editor" src="./widgets/RichTxtEditor.html" style="height: 700px;width:100%;border: none;">

</iframe>


<!--here this foot-->
<?php
include "./widgets/foot.php";
?>

