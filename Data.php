<?php
    error_reporting(0);
    session_start();

    $APIID = $_GET['id']?$_GET['id']:'defaultMethod';

    $config=array(
        'defaultMethod'=>defaultMethod,
        'getNews'=>getNews,
        'uploadImg'=>uploadImg,
        'userLogin'=>userLogin,
        'userVerify'=>userVerify
    );
    $config[$APIID]();


    function userLogin(){
        $username = $_GET['username'];
        $password = $_GET['password'];
        if($username=='admin'&& $password=='admin'){
            /*记录session值并写入cookie*/
            setcookie('SSID',session_id());
            $_SESSION['stat']='login';
            $_SESSION['Verifyed']=true;
            echo array(
                'stat'=>200,
                'msg'=>'login sucessed!'
            );
            header($_GET['ref']?$_GET['ref']:'/');
        }else{
            echo array(
                'stat'=>201,
                'msg'=>'login failed!'
            );
        }
    }

    function userVerify(){
        if($_SESSION['stat']=='login'){
            return true;
        }else{
            echo false;
        }
    }

	function getNews()
	{
		echo 'this is '.$_GET['param']?$_GET['param']:'api unformated!'.'s news';
		$xmlPath = '../../myfolder/test.xml';
		$xmlPath_newslist = '../../myfolder/newslist.xml';
		$xmlPath_contentPageDate = '../../myfolder/contentPageDate.xml';

		$xmlDoc = simplexml_load_file($xmlPath_newslist);
		$ctpg = simplexml_load_file($xmlPath_contentPageDate);
		echo '<pre>';
		print_r(utf8_encode($ctpg->children()));
		echo '</pre>';
	}

	function defaultMethod(){
		echo 'api unformated!';
	}

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