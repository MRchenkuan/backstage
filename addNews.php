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
            <td><span class="glyphicon glyphicon-flag"></span>ID</td>
            <td><span class="glyphicon glyphicon-bookmark"></span>标题</td>
            <td><span class="glyphicon glyphicon-time"></span>发布日期</td>
            <td><span class="glyphicon glyphicon-info-sign"></span>备注</td>
            <td><span class="glyphicon glyphicon-cog"></span>操作</td>
        </tr>
        <?php
        foreach($adCollection as $items){?>
            <tr>
                <td><img height=100 src="<?php echo $items['cover']?>" alt="缩略图"></td>
                <td><?php echo $items['id']?></td>
                <td><?php echo $items['title']?></td>
                <td><?php echo substr($items['pubdata'],0,10)?></td>
                <td><?php echo substr($items['text'],0,20)?></td>
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
                                data-title="<?php echo $items['title']?>"
                                data-cover="<?php echo $items['cover']?>"
                                data-update="<?php echo substr($items['pubdata'],0,10).'T'.substr($items['pubdata'],0,10)?>">
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

<!--富文本编辑器-->

<div class="panel panel-default"  style="width: 960px;margin: 60px auto 0 auto">
    <div class="panel-heading">新闻发布器</div>
    <div class="panel-body" style="overflow-x: hidden;overflow-y: scroll;padding: 0">
        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">广告艾迪</span>
            <input id="news_id" type="number" class="form-control" readonly placeholder="自动填写" aria-describedby="basic-addon1">
        </div>
        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">文章封面</span>
            <iframe style="height: 100px;" id="news_cover" src="./fileupload.html" aria-describedby="basic-addon1" class="form-control"></iframe>
        </div>
        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">发布日期</span>
            <input id="news_publish_data" type="datetime-local" class="form-control" placeholder="填写发布日期" aria-describedby="basic-addon1">
        </div>

        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">标　　题</span>
            <input id="news_title" type="text" class="form-control" placeholder="填写作者" aria-describedby="basic-addon1">
        </div>

        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">作　　者</span>
            <input id="news_auth" type="text" class="form-control" placeholder="填写作者" aria-describedby="basic-addon1">
        </div>

        <div class="input-group" style="width: 80%">
            <span class="input-group-addon" id="basic-addon1">来　　源</span>
            <input id="news_origin" type="text" class="form-control" placeholder="填写新闻来源" aria-describedby="basic-addon1">
        </div>

        <iframe id="news_editor" src="./widgets/RichTxtEditor.html" style="height: 700px;width:960px;border: none">
            您的浏览器已经过时了
        </iframe>
    </div>
    <div style="margin: 20px;height: 50px;">
        <div class="dropup" style="float: right;margin-left:10px;">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                <span class="glyphicon glyphicon-send"></span> 发布文章
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0)" >隐藏</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-2" href="javascript:void(0)" onclick="submitNews()">上线</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-3" href="javascript:void(0)" >草稿</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    function submitNews(stat){
        var imgsrcobj = document.getElementById('news_cover').contentWindow.document.getElementById('uploadCallBack-ImgSrc');
        var cover;
        if(imgsrcobj){
            cover = imgsrcobj.getAttribute('src');/*不能直接取src，那样会录入绝对路径*/
        }else{
            cover = 'http://tangweimm.com/img/imgveiw/3.jpg';
        }

        var news_editor = document.getElementById('news_editor').contentWindow.document.getElementById('editor');
        var news_id = document.getElementById('news_id');
        var news_auth = document.getElementById('news_auth');
        var news_origin = document.getElementById('news_origin');
        var news_publish_data = document.getElementById('news_publish_data');
        var news_title = document.getElementById('news_title');
        var news_cover = document.getElementById('cover');

        console.log(news_editor.innerHTML);
        $.ajax({
            url: './Data.php?id=createNews',
            type:'POST',
            data:{
                stat:stat,
                newsid:news_id.value,
                title:news_title.value,
                text:news_editor.innerHTML,
                auth:news_auth.value,
                origin:news_origin.value,
                pubdata:news_publish_data.value,
                cover:cover
            },
            success: function (data) {
                console.log(data);
//                var rep = eval("(" + data.responseText + ")");
//                if (rep.stat == 200) {
//                    alert(rep.msg);
//                    location.reload();
//                } else{
//                    self.innerHTML = '提交出错，请重试';
//                    self.removeAttribute('disabled');
//                }
            },
            error: function () {
                alert('提交出错');
                self.removeAttribute('disabled');
            }
        })
    }

    function delRecord(id){
        $.ajax({
            url: './Data.php',
            data:{
                id: 'delNews',
                newsid:id
            },
            success: function (data) {
                console.log(data);
                var rep = eval("(" + data + ")");
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
</script>



<!--here this foot-->
<?php
include "./widgets/foot.php";
?>

