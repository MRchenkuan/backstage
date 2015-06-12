<?php
    error_reporting(0);
    session_start();

    require_once('./tools/Kodbc.class.php');

    $APIID = $_GET['id']?$_GET['id']:'defaultMethod';

//    /*整体验证*/
//    if(!userVerify()){
//        /*验证用户登陆*/
//        echo json_encode(array(
//            'stat'=>201,
//            'msg'=>'login failed!'
//        ));
//        return false;
//    }

    $config=array(
        'defaultMethod'=>defaultMethod,
        'getNews'=>getNews,
        'uploadImg'=>uploadImg,
        'userLogin'=>userLogin,
        'userVerify'=>userVerify,
        'createAdvt'=>createAdvt,
        'delAdvt'=>delAdvt
    );
    $config[$APIID]();



    /**
     * 用户登陆的方法
     * */

    function userLogin(){

        $username = $_GET['username'];
        $password = $_GET['password'];
        if($username=='admin'&& $password=='admin'){
            /*记录session值并写入cookie*/
            setcookie('SSID',session_id());
            $_SESSION['stat']='login';
            $_SESSION['Verifyed']=true;

            echo json_encode(array(
                'stat'=>200,
                'msg'=>'login sucessed!'
            ));
        }else{
            echo json_encode(array(
                'stat'=>201,
                'msg'=>'login failed!'
            ));
        }
    }

    /**
     * 用户登陆态验证的方法
     * */
    function userVerify(){
        if($_SESSION['stat']=='login'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 用户创建广告的方法
     * */
	function createAdvt(){
        $id     = $_GET['adid'];
        $order  = $_GET['order'];
        $title  = $_GET['title'];
        $imgsrc=  $_GET['imgsrc'];
        $update = $_GET['update'];
        $dndate = $_GET['dndate'];
        $remark = $_GET['remark'];

        if(!userVerify()){
            /*验证用户登陆*/
            echo json_encode(array(
                    'stat'=>201,
                    'msg'=>'login failed!'
                ));
            echo false;
        }

        $Kodbc = new Kodbc('./myfolder/NEWSDATA.xml');
        $dataitem = array(
            'order'=>$order,
            'stat'=>'disable',
            'title'=>$title,
            'imgsrc'=>$imgsrc,
            'update'=>$update,
            'dndate'=>$dndate,
            'remark'=>$remark
        );

        /*更新或者新增取决于ID是否存在*/
        if($id&&$id!=''){
            $Kodbc->updateItem($id,$dataitem);
        }else{
            $Kodbc->insertItem($dataitem);
        }
        echo json_encode(array(
            'stat'=>200,
            'msg'=>'add sucess！'
        ));
    }

    /**
     * 用户删除广告方法
     * */
    function delAdvt(){
        $id = $_GET['adid'];
        $Kodbc = new Kodbc('./myfolder/NEWSDATA.xml');
        echo $Kodbc->delById($id);
    }

    /**
     * 默认返回的方法
     * */
	function defaultMethod(){
		echo 'api unformated!';
	}

    /**
     * 图片上传的方法
     * */
	function uploadImg(){
		$uploaddir = './image/'.date('Ymd').'/';
		if(!file_exists($uploaddir)){
			if(mkdir($uploaddir)){
                chmod($uploaddir,0777);
            }else{
				echo 'faile to create '.$uploaddir.'maybe the path you have no permit!<br>';
			};
		}
		$uploadfileUrl = $uploaddir.time().'.jpg';
        echo $uploadfileUrl."<body style='padding:0;margin:0'><input type='hidden' value='".$uploadfileUrl."' id='uploadCallBack-ImgSrc' /></body>";

        if($_FILES['userfile']['error']!==0){
            echo 'upload failed! error code:'.$_FILES['userfile']['error'];
            var_dump($_FILES['userfile']);
        }else{
//            var_dump(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfileUrl));
            if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfileUrl)) {
                echo "<img src='".$uploadfileUrl."'>";
                header($uploadfileUrl);
            } else {
                header('#');
            }
        }
	}
?>