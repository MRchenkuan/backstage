<?php
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/definitions.php' ;
require_once CORE_PATH . 'AbstractRouter.class.php';
require_once TOOLS_PATH.'imgUploader.php';
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/29
 * Time: 下午10:57
 */
use core\AbstractRouter;
AbstractRouter::addRouter(array(

    /**
     * 图片上传方法
     */
    'imageUpload' => function(){
        // 登录校验
//        if($_SESSION['stat'] != 'login'){
//            echo json_encode(array(
//                'stat' => 201,
//                'msg' => 'login failed!'
//            ));
//            return;
//        };
        var_dump($_POST);
        $imageDateSource = $_POST['imageDataSource'];
        echo $imageDateSource;
        $imgTitle = $_POST['imgTitle'];
        $imgDesc = $_POST['imgDesc'];
        $imgSrc = $_POST['imgSrc'];
        $identification = $_POST['identification'];
        $imgObj = uploadImage($imageDateSource);
        if($imgObj['pid']){
            $dao = new advantrueDAO();
            $dao->updateItemByInfo($identification,array(
                'PHOTO_ID'=>$imgObj['pid'],
                'FILE_PATH'=>$imgObj['FS_PATH'],
                'IMG_URL'=>$imgObj['PATH'],
                'IMG_THUMB'=>$imgObj['THUMB'],
            ));
            echo json_encode(array(
                'stat' => 200,
                'imgSrc' => $imgObj['imgurl']
            ));
            return;
        }
    },

    'uploadImg' => function()
    {
        {
            $uploaddir = '../PUBLIC/images/' . date('Ymd') . '/';
            if (!file_exists($uploaddir)) {
                if (mkdir($uploaddir)) {
                    chmod($uploaddir, 0777);
                } else {
                    echo 'faile to create ' . $uploaddir . 'maybe the path you have no permit!<br>';
                };
            }
            $uploadfileUrl = $uploaddir . time() . '.jpg';

            if ($_FILES['userfile']['error'] !== 0) {
                echo 'upload failed! error code:' . $_FILES['userfile']['error'];
                var_dump($_FILES['userfile']);
            } else {
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfileUrl)) {
                    /*********
                     * 记录入库
                     ********/
                    $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_PHOTOBASE.xml');
                    $Kodbc->insertItem(array(
                        'albumid'=>'0',
                        'remark'=>'from uploadImg',
                        'imgsrc'=>$uploadfileUrl,
                        'pubdata'=>date('Y-m-d\TH:i')
                    ));

                    /*********
                     * 页面输出
                     ********/
                    echo "<body style='padding: 0;margin: 0'>";
                    echo "<form style='padding: 0;margin: 0;' enctype='multipart/form-data' action='API.php?id=uploadImg' method='POST' name='form'>";
                    echo "<img id='uploadCallBack-ImgSrc' style='height:100%;max-width: 300px;' src='" . $uploadfileUrl . "'>";
                    echo "<input style='float: right' id='userfile' name='userfile' type='file' onchange=\"document.getElementById('uploadform').submit()\">";
//                echo "<input style='float: right' type='submit' value='上传图片'>";
                    echo "</body>";
                    echo "</form>";
                    // header($uploadfileUrl); // 此处有问题 导致服务器报500
                } else {
                    header('#');
                }
            }
        }
    },

));