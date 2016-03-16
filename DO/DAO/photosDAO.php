<?php
error_reporting(0);
require($_SERVER['DOCUMENT_ROOT'] . '/definitions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/DO/DBC.class.php');
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 16/3/16
 * Time: 下午12:16
 */

class photosDAO extends DBC{
    public function __construct(){
        return parent:: __construct(get_class($this));
    }

}