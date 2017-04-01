<?php
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/3/29
 * Time: 下午11:09
 */
require($_SERVER['DOCUMENT_ROOT'] . '/definitions.php');
require_once CORE_PATH . 'AbstractRouter.class.php';
error_reporting(E_ALL);
\core\AbstractRouter::addRouter(array(
    'defaultMethod' => function(){
        echo "defaultMethod";
    },

    /**
     * 用户登陆的方法
     * */
    'userLogin' => function() {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $trylimit = 10;//最大登录尝试次数

        //    if (!$_COOKIE['_auth']) return;

        if ($_SESSION['trycount'] && $_SESSION['trycount'] >= $trylimit) {
            echo json_encode(array(
                'stat' => 205,
                'msg' => 'login failed! too frequently you try!'
            ));
            return;
        }
        if ($username == '' && $password == '') {
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
            if (!$_SESSION['trycount']) {
                $_SESSION['trycount'] = 0;
            }
            $_SESSION['trycount'] += 1;

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
        if ($_SESSION['stat'] == 'login') {
            return true;
        } else {
            return false;
        }
    },


));
