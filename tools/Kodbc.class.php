<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 15/6/1
 * Time: 下午5:59
 */
error_reporting(0);

class Kodbc {
    function __construct($xmlPath) {
        $this->xmlPath=$xmlPath;
        $this->xmlDoc = simplexml_load_file($xmlPath);
    }

    /*初始化列数*/
    function initCol(){
        //do something
    }

    /*根据id查找节点*/
    function getById($id){
        try{
            return $this->xmlDoc->xpath('//database/item[@id=\''.$id.'\']')[0];
        }catch(Exception $e){
            return null;
        }

    }

    /*根据起止时间查找ID*/
    function getByPeriod($start,$end){

    }

    /*根据ID删除节点*/
    function delById($id){
        //do something
    }

    /*根据属性插入新节点*/
    function insertItem($attrs){
        $NowId= $this->xmlDoc->attributes()['NOWID'];
        $item = $this->xmlDoc->addChild('item');
        $item->attributes()['id'] = $NowId;
        foreach($attrs as $k=>$v){
            $item->addAttribute($k,$v);
        };
        /*最大ID数+1*/
        $this->xmlDoc->attributes()['NOWID'] = $NowId+1;
        $this->xmlDoc->asXML($this->xmlPath);
    }

    /*根据id和对象更新节点*/
    function updateItem($id,$info){
        $item = $this->getByid($id);
        foreach($info as $k=>$v){
            echo $item->attributes()->$k=$v;
        }
        $this->xmlDoc->asXML($this->xmlPath);
    }
}

$k = new Kodbc('../myfolder/NEWSDATA.xml');
if($k->getById(5)){
    echo 'yes';
}else{
    echo 'no';
};