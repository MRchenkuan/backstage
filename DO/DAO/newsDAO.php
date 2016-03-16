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

class newsDAO extends DBC{
    public function __construct(){
        return parent:: __construct(get_class($this));
    }

    /**
     * 根据ID获取新闻数据
     * @return int|PDOStatement
     */
    public function getNewsDataById($id){
        $rs = $this->getResult(__FUNCTION__,array('id'=>$id));
        $row = $rs->fetch();
        return $row;
    }

    /**
     * 获取最新的新闻数据
     * @return int|PDOStatement
     */
    public function getRecentNews($count)
    {
        $rs = $this->getResult(__FUNCTION__, array('count' => $count));
        $arr=$rs->fetchAll();
        return $arr;
    }
}

$a = new newsDAO();
var_dump($a->getRecentNews(5));