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


    /**
     * 创建广告方法
     */
    'createAdvt' => function(){
        $id = $_GET['adid'];
        $order = $_GET['order'];
        $title = $_GET['title'];
        $imgsrc = $_GET['imgsrc'];
        $update = $_GET['update'];
        $dndate = $_GET['dndate'];
        $remark = $_GET['remark'];

        if (!userVerify()) {
            /*验证用户登陆*/
            echo json_encode(array(
                'stat' => 201,
                'msg' => 'login failed!'
            ));
            echo false;
        }

        $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_ADVTS.xml');
        $dataitem = array(
            'order' => $order,
            'stat' => 'disable',
            'title' => $title,
            'imgsrc' => $imgsrc,
            'update' => $update,
            'dndate' => $dndate,
            'remark' => $remark
        );

        /*更新或者新增取决于ID是否存在*/
        if ($id && $id != '') {
            $Kodbc->updateItem($id, $dataitem);
        } else {
            $Kodbc->insertItem($dataitem);
        }
        echo json_encode(array(
            'stat' => 200,
            'msg' => 'add sucess！'
        ));
    },
    'createNews' => function()
    {
        $newsid     =   $_POST['newsid'];
        $title     =   $_POST['title'];
        $auth       =   $_POST['auth'];
        $origin     =   $_POST['origin'];
        $pubdata    =   $_POST['pubdata'];
        $stat    =   $_POST['stat'];
        $cover    =   $_POST['cover'];
        $text       =   htmlspecialchars($_POST['text']);
        $db         = $_POST['target'];
        $Kodbc = null;
        switch($db){
            case "newsfiles": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
            case "idea": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_IDEA.xml');break;
            default:$Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
        }

        /*************
         *
         * 储存大文本
         *
         ************/
        $newsDir = NEWS_FILE_DIR.date('Ymd').'/';
        if (!file_exists($newsDir)) {
            if (mkdir($newsDir)) {
                chmod($newsDir, 0777);
            } else {
                echo 'faile to create ' . $newsDir . 'maybe the path you have no permit!<br>';
            };
        }

        /*判断是修改文件还是新增文件*/
        if ($newsid && $newsid != ''){
            $item = $Kodbc->getById($newsid);
            $newsFileUrl = $item['text'];
        }else{
            $newsFileUrl = $newsDir . time() . '.newsfiles';
        }

        $fp = fopen($newsFileUrl, "w+");
        if(!fwrite($fp,$text)){
            fclose($fp);
            echo json_encode(array(
                'stat' => 201,
                'msg' => 'login failed!'
            ));
            throw new Exception("文件保存异常");
        }
        fclose($fp);
        /**************
         * 文件储存结束
         **************/

        if (!userVerify()) {
            /*验证用户登陆*/
            echo json_encode(array(
                'stat' => 201,
                'msg' => 'login failed!'
            ));
        }

        $dataitem = array(
            'stat' => $stat,
            'title' => $title,
            'auth' => $auth,
            'origin' => $origin,
            'pubdata' => $pubdata,
            'text' =>$newsFileUrl,
            'cover' => $cover
        );

        /*更新或者新增取决于ID是否存在*/
        if ($newsid && $newsid != '') {
            $Kodbc->updateItem($newsid, $dataitem);
        } else {
            $newsid = $Kodbc->insertItem($dataitem);
        }
        echo json_encode(array(
            'stat' => 200,
            'msg' => $newsid.' add sucess！',
            'articId'=>$newsid[0],
        ));
    },
    'delNews' => function(){
        $id = $_GET['newsid'];
        $db = $_POST['target'];
        $Kodbc = null;
        echo $db;
        switch($db){
            case "newsfiles": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
            case "idea": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_IDEA.xml');break;
            default:$Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
        }
        echo $Kodbc->delById($id);
    },
    'getNewsContent' => function(){
        $id=$_REQUEST['newsid'];
        $db = $_REQUEST['target'];

        $Kodbc = null;
        switch($db){
            case "newsfiles": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
            case "idea": $Kodbc= new Kodbc(DATA_TABLE_DIR.'T_TABLE_IDEA.xml');break;
            default: $Kodbc = new Kodbc(DATA_TABLE_DIR.'T_TABLE_NEWS.xml');break;
        }

        $item= $Kodbc->getById($id);
        $contentsrc = $item['text'];
        $newsfile = fopen($contentsrc,'r') or die('can not find newsfiles,because no newsfiles file found');
        echo json_encode(array(
            'stat' => 200,
            'msg' => $id.' get sucess！',
            'content'=>htmlspecialchars_decode(fread($newsfile,filesize($contentsrc)))
        ));
//    fclose($newsfile);

    }

));
