<!--here is head-->
<?php
error_reporting(0);
session_start();
$pageID='photoLib';
include "./widgets/head.php";
/*--连接数据库--*/
require_once('./tools/Kodbc.class.php');
?>

<!--album-->
<div class="panel panel-default" style="width: 960px;margin: 80px auto 0 auto">
    <div class="panel-heading">
        <h3 class="panel-title">图片相册</h3>
    </div>

    <div class="panel-body">
        <?php
        $albumDoc = new Kodbc('./Database/photolib/photoAlbum.xml');
        $albums = $albumDoc->getAllItems();
        foreach($albums as $album) {
            ?>
            <div class="col-xs-6 col-md-3">
                <a href="./album.php?id=<?php echo $album['id']; ?>" class="thumbnail">
                    <img style="width: 70%" src="./UI/<?php echo $album['count']==0?'folder-empty.png':'folder.png';?>" alt="...">
                    <div class="caption" style="text-align: center">
                        <button type="button" class="btn btn-info">
                            <?php echo $album['remark'].' '; ?><span class="badge"><?php echo $album['count'] ;?></span>
                        </button>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
        <div class="col-xs-6 col-md-3" data-toggle="modal" data-target="#alertBoard">
            <a href="#" class="thumbnail">
                <img style="width: 70%" src="./UI/area-add.png" alt="...">
                <div class="caption" style="text-align: center">
                    <!-- 面板控制按钮 -->
                    <button type="button" class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus"></span> 新建相册
                    </button>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- 弹出面板 -->
<div class="modal fade" id="alertBoard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">文件上传</h4>
            </div>
            <div class="modal-body">
                <?php include 'fileupload.html'?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success">保存</button>
            </div>
        </div>
    </div>
</div>
<!--here this foot-->
<?php
include "./widgets/foot.php";
?>