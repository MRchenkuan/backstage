<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 15/6/1
 * Time: 下午5:59
 */

class Kodbc {
    function __construct($xmlPath) {
        $this->xmlPath=$xmlPath;
        $this->xmlDoc = simplexml_load_file($xmlPath);
    }

    /*根据id查找节点*/
    function getById($id){
        return $this->xmlDoc->xpath('//database/item[@id=\''.$id.'\']')[0];
    }
    function getByPeriod($start,$end){}
    function insertItem(){

    }
    /*根据id和对象更新节点*/
    function update($id,$info){
        $item = $this->getByid($id);
        foreach($info as $k=>$v){
            echo $item->attributes()->$k=$v;
        }
        $this->xmlDoc->asXML($this->xmlPath);
    }
}

$k = new Kodbc('../myfolder/NEWSDATA.xml');
$k->getById(1);
$k->update(3,array(
    'order'=>10,
    'stat'=>'disable',
));