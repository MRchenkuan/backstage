<?php
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/29
 * Time: 下午11:09
 */
include_once '../definitions.php';
include_once CORE_PATH . 'AbstractRouter.class.php';
error_reporting(E_ERROR);
\core\AbstractRouter::addRouter(array(
    'defaultMethod' => function(){
        echo "defaultMethod";
    },

    /**
     * 用户登陆的方法
     * */
    'userLogin' => function() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $trylimit = 10;//最大登录尝试次数

        //    if (!$_COOKIE['_auth']) return;

        if ($_SESSION['trycount'] && $_SESSION['trycount'] >= $trylimit) {
            echo json_encode(array(
                'stat' => 205,
                'msg' => 'login failed! too frequently you try!'
            ));
            return;
        }
        if ($username == 'ckadol' && $password == 'ckadol') {
            /*记录session值并写入cookie*/
            setcookie('SSID', session_id(),time()+43200);
            $_SESSION['stat'] = 'login';
            $_SESSION['Verifyed'] = true;
            $_SESSION['trycount'] = 1;
            echo json_encode(array(
                'stat' => 200,
                'msg' => 'login sucessed!'
            ));
        } else {
            if (!isset($_SESSION['trycount']) || !$_SESSION['trycount']) {
                $_SESSION['trycount'] = 0;
            }
            $_SESSION['trycount'] += 1;
            $_SESSION['stat'] = "offline";
            echo json_encode(array(
                'stat' => 201,
                'msg' => 'login failed!'
            ));
        }
    },


    /**
     * 用户登陆态验证的方法
     * */
    'userVerify' => function () {
        if (isset($_SESSION['stat'])&&$_SESSION['stat'] == 'login') {
            echo json_encode(array(
                'stat' => 200,
                'msg' => 'success'
            ));
            return true;
        } else {
            echo json_encode(array(
                'stat' => 302,
                'msg' => '登录失效'
            ));
            return false;
        }
    },


));
