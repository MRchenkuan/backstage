<?php
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/29
 * Time: 下午11:09
 */
require($_SERVER['DOCUMENT_ROOT'] . '/definitions.php');
include CORE_PATH . 'AbstractRouter.class.php';
error_reporting(E_ALL);
\core\AbstractRouter::addRouter(array(
    'defaultMethod' => function(){
        echo "defaultMethod";
    },

    'delAlbum'=>function(){
        if($_GET['albumid']){
            $albumid = $_GET['albumid'];
            $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_PHOTO_ALBUM.xml');
            $item = $Kodbc->getById($albumid);
            if($item['count']>0){
                echo json_encode(array(
                    'stat'=>200,
                    'msg'=>"相册内有照片，需要先清空相册！",
                ));
            }else{
                $Kodbc->delById($albumid);
                echo json_encode(array(
                    'stat'=>200,
                    'msg'=>"{$albumid}:成功删除",
                ));
            }
        }else{
            echo json_encode(array(
                'stat'=>202,
                'msg'=>"并没有找到什么卵ID",
            ));
        }
    },


    'createAlbum'=>function(){
        try{

            $albumname = $_GET['albumname'];
            $stat = $_GET['stat'];

            $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_PHOTO_ALBUM.xml');
            if($_GET['albumid']&&$_GET['albumid']!==''){
                $Kodbc->updateItem($_GET['albumid'],array(
                    'stat'=>$stat,
                    'remark'=>$albumname,
                    'pubdata'=>date('Y-m-d\TH:i')
                ));
                echo json_encode(array(
                    'stat'=>200,
                    'msg'=>"《{$albumname}》修改成功",
                ));
            }else{
                $Kodbc->insertItem(array(
                    'stat'=>$stat,
                    'remark'=>$albumname,
                    'editable'=>1,
                    'count'=>0,
                    'pubdata'=>date('Y-m-d\TH:i')
                ));
                echo json_encode(array(
                    'stat'=>200,
                    'msg'=>"《{$albumname}》创建成功",
                ));
            }
        }catch (Exception $e){
            echo json_encode(array(
                'stat'=>202,
                'msg'=>"出现异常:{$e}",
            ));
        }
    },

    /**
     * 物理删除图片
     */
    'removeImage'=> function (){
        $imgsrc = $_GET['imgsrc'];
        $filename=end(explode('/',$imgsrc));
        /*新建回收站*/
        $dashbindir = DUSTBIN_DIR.date('Ymd').'/';
        if (!file_exists($dashbindir)) {
            if (mkdir($dashbindir)) {
                chmod($dashbindir, 0777);
            } else {
                echo 'faile to create ' . $dashbindir . 'maybe the path you have no permit!<br>';
            };
        }

        $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_PHOTOBASE.xml');
        if($_GET['imgid']){
            $imgid=$_GET['imgid'];
            $Kodbc->delById($imgid);
        }

        if(rename($imgsrc,$dashbindir.$filename )){
            echo json_encode(array(
                'stat'=>200,
                'msg'=>"{$_GET['imgid']}在数据库中删除，{$filename}移动到服务器回收站",
            ));
            return true;
        }else{
            echo json_encode(array(
                'stat'=>200,
                'msg'=>"数据库删除成功，但服务器无此文件",
                '$imgsrc'=>$imgsrc,
                '$dashbindir.$filename'=>$dashbindir.$filename,
            ));
            return true;
        }
    },


    /**
     * 相册间移动图片
     */
    'moveImage'=>function (){
        $albumid=$_GET['albumid'];
        $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_PHOTOBASE.xml');
        if($_GET['imgid']){
            $imgid=$_GET['imgid'];
            $Kodbc->updateItem($imgid,array(
                'albumid'=>$albumid
            ));
            echo json_encode(array(
                'stat'=>200,
                'msg'=>"{$imgid}移动到{$albumid}",
            ));
        }elseif($_GET['imgsrc']){
            $imgsrc=$_GET['imgsrc'];
            $Kodbc->insertItem(array(
                'albumid'=>'0',
                'imgsrc'=>$imgsrc,
                'pubdata'=>date('Y-m-d\TH:i'),
                'remark'=>'from images binding'
            ));
            echo json_encode(array(
                'stat'=>200,
                'msg'=>"{$imgsrc}绑定到{$albumid}",
            ));
        }else{
            echo json_encode(array(
                'stat'=>202,
                'msg'=>"既没有图片ID也没有图片地址"
            ));
        }

    }
));
