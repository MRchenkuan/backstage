<?php
    error_reporting(0);
    session_start();

    require_once('./tools/Kodbc.class.php');

    $APIID = $_GET['id']?$_GET['id']:'defaultMethod';

    $config=array(
        'defaultMethod'=>defaultMethod,
        'getNews'=>getNews,
        'uploadImg'=>uploadImg,
        'userLogin'=>userLogin,
        'userVerify'=>userVerify
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
        $order = $_GET['order'];
        $title = $_GET['title'];
        $imgfile= $_FILES['order'];
        $update = $_GET['update'];
        $dndate = $_GET['dndate'];
        $remark = $_GET['remark'];

        if(!userVerify()){
            /*验证用户登陆*/
            echo json_encode(array(
                    'stat'=>201,
                    'msg'=>'login failed!'
                ));
            return false;
        }

        $Kodbc = new Kodbc('./myfolder/NEWSDATA.xml');


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
		$uploaddir = './'.date('Ymd').'/';
		if(!file_exists($uploaddir)){
			if(mkdir($uploaddir)){
				echo $uploaddir.' created!<br>';
			}else{
				echo 'faile to create '.$uploaddir.'maybe the path you have no permit!<br>';
			};
		}
		$uploadfile = $uploaddir.$_FILES['userfile']['name'];
		echo $uploadfile;
		print "<pre>";
		if (move_uploaded_file($_FILES['userfile']['tmp_name'],$uploaddir.$_FILES['userfile']['name'])) {
		    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
		    print_r($_FILES);
		} else {
		    print "Possible file upload attack!  Here's some debugging info:\n";
		    print_r($_FILES);
		}
		print "</pre>";
	}
?>