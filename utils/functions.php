<?php
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 2017/4/6
 * Time: 上午9:21
 */

function userVerify(){
    return $_SESSION['stat'] == 'login';
}