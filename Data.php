<?
	$APIID = $_GET['id']?$_GET['id']:'defaultMethod';

	$config=array();
	$config['defaultMethod']=defaultMethod;
	$config['getNews']=getNews;
	$config['uploadImg']=uploadImg;
	$config[$APIID]();



	function getNews()
	{
		// echo 'this is '.$_GET['param']?$_GET['param']:'api unformated!'.'s news';
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