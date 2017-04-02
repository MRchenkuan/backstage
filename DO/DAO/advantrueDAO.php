<?php
error_reporting(E_ALL);
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
        $setting = [];
        foreach($info as $k=>$v ){
            array_push($setting,"`".$k."`"."="."'".$v."'");
        }
        $rs = $this->getResult(__FUNCTION__,array('setting'=>implode($setting,","),'id'=>$id));
        return $rs;
    }

    /**
     * 获取所有图片信息
     */
    function getALlItems($type){
        $rs = $this->getResult(__FUNCTION__,array("type"=>$type));
        $rows = $rs->fetchAll();
        return $rows;
    }
}