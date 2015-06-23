<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 15/6/16
 * Time: 下午5:21
 */
$pageID = 'photoLib';
include './widgets/head.php';
include './tools/Kodbc.class.php';
$id = $_GET['id'] or die('相册不存在');
$photobase = new Kodbc('./Database/photolib/photobase.xml');
$photoalbum = new Kodbc('./Database/photolib/photoAlbum.xml');
$album = $photoalbum->getById($id) or null;
$photos = $photobase->getByAttr('albumid',$id) or null;
?>
<!--album-->
<div class="panel panel-default"  style="width: 960px;margin: 60px auto 0 auto">

    <div class="panel-heading">
        <h3 class="panel-title">相册《<?php echo $album['remark']?>》下的图片</h3>
    </div>

    <!-- 文件上传控制按钮 -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#fileuploadpannel" style="margin: 20px 0 10px 30px;">
        <span class="glyphicon glyphicon-level-up"></span>上传图片
    </button>

    <div class="panel-body">
    <?php
    /*首先检查是否维护相册统计数*/
    if($album['count']!=count($photos)){
        $photoalbum->updateItem($id,array('count'=>count($photos)));
    }
    if(!$photos||count($photos)==0){
        echo '相册中没有图片';
    }else{
        foreach($photos as $photo){?>
            <div class="col-xs-6 col-md-3">
                <a href="<?php echo $photo['imgsrc']?>" class="thumbnail">
                    <img src="<?php echo $photo['imgsrc']?>" alt="<?php echo $photo['remark']?>">
                </a>
            </div>
    <?php
        }
    }
    ?>
    </div>
</div>

<!-- 文件上传模块 -->
<div class="modal fade" id="fileuploadpannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">文件上传</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-link"></span></span>
                    <input type="text" class="form-control" placeholder="如果不上传，则在此处填写图片url" id="onlineurl" aria-describedby="basic-addon1">
                </div>
                <div class="col-xs-6 col-md-10" style="position: relative;float: none;margin: 0 auto">
                    <a href="#" class="thumbnail">
                        <img id="imguploadpreview" name="forupload" data-selected="0" src="./UI/area-add.png" alt="添加图片">
                    </a>
                    <input id="imageupload" type="file" value="选择图片" accept="image/*" style="opacity:0;width:100%;height:100%;position: absolute;top:0;left: 0;">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-tags"></span></span>
                    <input type="text" class="form-control" placeholder="添加该图片的描述" id="remark" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button id="saveimg" type="button" class="btn btn-success" data-albumid="<?php echo $id?>">保存</button>
            </div>

            <script>
                var uploadbtn = document.getElementById('imageupload');
                var uploadprv = document.getElementById('imguploadpreview');
                var savebtn = document.getElementById('saveimg');
                var albumid = savebtn.getAttribute('data-albumid');

                uploadbtn.addEventListener('click',function(){
                    var self = this;
                    var reader = new FileReader();
                    reader.onload = function(){
                        uploadprv.src = this.result;
                        /*设置为保存标记*/
                        uploadprv.setAttribute('data-selected','1');
                    };
                    uploadbtn.addEventListener('change',function(){
                        /*进而可考虑上传多张图片*/
                        reader.readAsDataURL(self.files[0]);
                    });
                });
                savebtn.addEventListener('click',function(){
                    var imgs = document.getElementsByName('forupload');
                    var remark = document.getElementById('remark').value;
                    var onlineurl = document.getElementById('onlineurl').value;

                    Array.prototype.some.call(imgs,function(it,id,ar){
                        if(it.getAttribute('data-selected')!=0){
                            savebtn.setAttribute('disabled','disabled');
                            savebtn.innerHTML = '上传中请稍等……';
                            $.ajax({
                                url:'Data.php?id=uploadImgAjax',
                                type:'POST',
                                data:{
                                    'imgDataString':it.src,
                                    'albumid':albumid,
                                    'remark':remark,
                                    'onlineurl':onlineurl
                                },
                                success:function(data){
                                    data = eval('(' + data + ')');
                                    console.log(data);

                                    if (data.stat == 200) {
                                        alert(data.msg);
                                        location.reload();
                                    } else{
                                        savebtn.removeAttribute('disabled');
                                        savebtn.innerHTML = '上传出错，请调试';
                                    }
                                },
                                error:function(data){
                                    data = eval('(' + data + ')');
                                    console.log(data);
                                    savebtn.removeAttribute('disabled');
                                    savebtn.innerHTML = 'data.msg';
                                }
                            });
                        }
                    });
                })
            </script>
        </div>
    </div>
</div>
<?php
include './widgets/foot.php';
?>