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

class photoAlbumDAO extends DBC{
    public function __construct(){
        return parent:: __construct(get_class($this));
    }


    /**
     * 根据ID查找相册
     * @param $id
     * @return mixed
     */
    function getAlbumInfoById($id)
    {
        $rs = $this->getResult(__FUNCTION__,array('id'=>$id));
        $row = $rs->fetch();
        return $row;
    }

    /**
     * 根据相册id查找图片
     * @param $id
     * @return mixed
     */
    public function getPhotoInfoByAlbumId($id)
    {
        $rs = $this->getResult(__FUNCTION__,array('id'=>$id));
        $rows = $rs->fetchAll();
        return $rows;
    }

    /**
     * 获得所有相册
     * @param int $count
     * @return array
     */
    public function getAllAlbums($count = 100)
    {
        $rs = $this->getResult(__FUNCTION__,array("count"=>$count));
        $rows = $rs->fetchAll();
        return $rows;
    }

}