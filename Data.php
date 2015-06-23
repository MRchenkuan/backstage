<?php
error_reporting(0);
session_start();

require_once('./tools/Kodbc.class.php');

$APIID = $_GET['id'] ? $_GET['id'] : 'defaultMethod';
$DATABASEURL = './Database/ADVTSDATA.xml';


/*****************************************************
 *
 *                  转发路由
 *
 *****************************************************/
$config = array(
    'defaultMethod' => defaultMethod,
    'getNews' => getNews,
    'uploadImg' => uploadImg,
    'userLogin' => userLogin,
    'userVerify' => userVerify,
    'createAdvt' => createAdvt,
    'delAdvt' => delAdvt,
    'createNews' => createNews,
    'delNews' => delNews,
    'uploadImgAjax' => uploadImgAjax
);
$config[$APIID]();

/*****************************************************
 *
 *                  通用的处理函数
 *
 *****************************************************/
/**
 * 用户登陆的方法
 * */

function userLogin()
{

    $username = $_GET['username'];
    $password = $_GET['password'];
    $trylimit = 10;//最大登录尝试次数

    if (!$_COOKIE['_auth']) return;

    if ($_SESSION['trycount'] && $_SESSION['trycount'] >= $trylimit) {
        echo json_encode(array(
            'stat' => 201,
            'msg' => 'login failed!'
        ));
        return;
    }
    if ($username == 'admin' && $password == 'admin') {
        /*记录session值并写入cookie*/
        setcookie('SSID', session_id());
        $_SESSION['stat'] = 'login';
        $_SESSION['Verifyed'] = true;
        $_SESSION['trycount'] = 1;
        echo json_encode(array(
            'stat' => 200,
            'msg' => 'login sucessed!'
        ));
    } else {
        if (!$_SESSION['trycount']) {
            $_SESSION['trycount'] = 0;
        }
        $_SESSION['trycount'] += 1;

        echo json_encode(array(
            'stat' => 201,
            'msg' => 'login failed!'
        ));
    }
}

/**
 * 用户登陆态验证的方法
 * */
function userVerify()
{
    if ($_SESSION['stat'] == 'login') {
        return true;
    } else {
        return false;
    }
}


/*****************************************************
 *
 *                  广告的处理函数
 *
 *****************************************************/

/**
 * 用户创建广告的方法
 * */
function createAdvt()
{
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

    $Kodbc = new Kodbc('./Database/ADVTSDATA.xml');
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
}

/**
 * 用户删除广告方法
 * */
function delAdvt()
{
    $id = $_GET['adid'];
    global $DATABASEURL;
    $Kodbc = new Kodbc($DATABASEURL);
    echo $Kodbc->delById($id);
}

/**
 * 默认返回的方法
 * */
function defaultMethod()
{
    echo 'api unformated!';
}

/**
 * 图片上传的方法
 * */
function uploadImg()
{
    $uploaddir = './image/' . date('Ymd') . '/';
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
            echo "<body style='padding: 0;margin: 0'>";
            echo "<form style='padding: 0;margin: 0;' enctype='multipart/form-data' action='./Data.php?id=uploadImg' method='POST' name='form'>";
            echo "<img id='uploadCallBack-ImgSrc' style='height:100%;max-width: 300px;' src='" . $uploadfileUrl . "'>";
            echo "<input style='float: right' id='userfile' name='userfile' type='file' onchange=\"document.getElementById('uploadform').submit()\">";
//                echo "<input style='float: right' type='submit' value='上传图片'>";
            echo "</body>";
            echo "</form>";
            header($uploadfileUrl);
        } else {
            header('#');
        }
    }
}



/*****************************************************
 *
 *                  新闻的处理函数
 *
 *****************************************************/

function createNews(){

    $newsid     =   $_POST['newsid'];
    $title     =   $_POST['title'];
    $auth       =   $_POST['auth'];
    $origin     =   $_POST['origin'];
    $pubdata    =   $_POST['pubdata'];
    $stat    =   $_POST['stat'];
    $cover    =   $_POST['cover'];

    $text       =   htmlspecialchars($_POST['text']);

    $Kodbc = new Kodbc('./Database/NEWSDATA.xml');
    /*************
     *
     * 储存大文本
     *
     ************/
    $newsDir = './news/'.date('Ymd').'/';
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
        $newsFileUrl = $newsDir . time() . '.news';
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
        'articId'=>$newsid[0]
    ));
}

/**
 * 用户删除新闻方法
 * */
function delNews()
{
    $id = $_GET['newsid'];
    $Kodbc = new Kodbc('./Database/NEWSDATA.xml');
    echo $Kodbc->delById($id);
}


/*****************************************************
 *
 *                  图库的处理函数
 *
 *****************************************************/
function uploadImgAjax()
{

    $imgdatastring = $_POST['imgDataString'] or null;
    $uploaddir = './image/' . date('Ymd') . '/';
    if (!file_exists($uploaddir)) {
        if (mkdir($uploaddir)) {
            chmod($uploaddir, 0777);
        } else {
            echo 'faile to create ' . $uploaddir . 'maybe the path you have no permit!<br>';
        };
    }

    /*base64保存为图片，并写入数据库*/
    if($imgdatastring){

        //do someting for 保存图片
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $imgdatastring, $result)){
            $type = $result[2];
            $uploadfileUrl = $uploaddir. time().'.'.$type;
            if (file_put_contents($uploadfileUrl, base64_decode(str_replace($result[1], '', $imgdatastring)))){
                //写入数据库
                $Kodbc = new Kodbc('./Database/photolib/photobase.xml');
                $Kodbc->insertItem(array(
                        'albumid'=>$_POST['albumid'],
                        'stat'=>'active',
                        'remark'=>$_POST['remark'],
                        'imgsrc'=>$uploadfileUrl,
                        'pubdata'=> date('Y-m-d')
                    )
                );

                echo json_encode(array(
                    'stat'=>200,
                    'imgurl'=>$uploadfileUrl,
                    'msg'=>'图片上传成功',
                ));
            }
        }else{
            echo json_encode(array(
                'stat'=>202,
                'imgurl'=>null,
                'msg'=>'图片字符串匹配失败！',
            ));
        }

    }else{
        echo json_encode(array(
            'stat'=>202,
            'msg'=>'后端未收到前端图片数据',
        ));
    }
}