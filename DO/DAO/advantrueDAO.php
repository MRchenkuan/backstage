<?php
//error_reporting(0);
require_once(BACKSTAGE_DIR.'/DO/DBC.class.php');
/**
 * Created by PhpStorm.
 * User: chenkuan
 * Date: 16/3/16
 * Time: 下午12:16
 */

class advantrueDAO extends DBC{
    public function __construct(){
        return parent:: __construct(get_class($this));
    }

    /**
     * 更新图片信息
     * @param $id
     * @param $info
     * @return mixed
     */
    function updateItemByInfo($id,$info)
    {
        $colname = array();
        $value = array();
        foreach($info as $k=>$v ){
            array_push($colname,"`".$k."`");
            array_push($value,"'".$v."'");
        }
        $colname = implode(",",$colname);
        $value = implode(",",$value);
        $rs = $this->getResult(__FUNCTION__,array('colname'=>$colname,'value'=>$value,'id'=>$id));
        $row = $rs->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}