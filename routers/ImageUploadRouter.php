<?php
//error_reporting(0);
include_once '../definitions.php' ;
include_once CORE_PATH . 'AbstractRouter.class.php';
include_once TOOLS_PATH.'imgUploader.php';
include_once DATABASE_DAO_DIR.'advantrueDAO.php';
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

        $imageDateSource = $_POST['imageDataSource'];
        $imgTitle = $_POST['imgTitle'];
        $imgDesc = $_POST['imgDesc'];
        $imgSrc = $_POST['imgSrc'];
        $identification = $_POST['identification'];

        $dao = new advantrueDAO();
        // 当存在datasource时，为新增,否则为更新
        if($imageDateSource){
            $imgObj = uploadImage($imageDateSource);
            if(isset($imgObj['pid']) && $imgObj['pid']>0){
                // 更新目标对象信息
                $dao->updateItemByInfo($identification,array(
                    'PHOTO_ID'=>$imgObj['pid'],
                    'FILE_PATH'=>isset($imgObj['FS_PATH'])?$imgObj['FS_PATH']:"",
                    'IMG_URL'=>isset($imgObj['imgurl'])?$imgObj['imgurl']:"",
                    'IMG_THUMB'=>isset($imgObj['thumburl'])?$imgObj['thumburl']:"",
                    'IMG_TITLE'=>$imgTitle,
                    'IMG_DESC'=>$imgDesc
                ));
                echo json_encode(array(
                    'stat' => 200,
                    'imgSrc' => isset($imgObj['imgurl'])?$imgObj['imgurl']:""
                ));
                return;
            }else{
                echo json_encode(array(
                    'stat' => 201,
                    'info' => "图片上传失败"
                ));
            }
        }else{
            $dao->updateItemByInfo($identification,array(
                'IMG_TITLE'=>$imgTitle,
                'IMG_DESC'=>$imgDesc
            ));
            echo json_encode(array(
                'stat' => 200,
                'info' => "更新成功"
            ));
        }
    },

    "getALlItems" => function(){
        $dao = new advantrueDAO();
        $type = $_POST['type'];
        if(!$type){
            echo json_encode(array(
                'stat' => 201,
                'info' => "请填提交type参数"
            ));
            return;
        }
        $date = $dao->getALlItems($type);
        echo json_encode(array(
            'stat' => 200,
            'allItems' => $date
        ));
    }

));