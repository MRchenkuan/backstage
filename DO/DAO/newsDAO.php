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

class newsDAO extends DBC implements DataOri{
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
    public function getRecentNews($count){
        $rs = $this->getResult(__FUNCTION__,array('count'=>$count));
        $row = $rs->fetch();
        return $row;
    }


    /**
     * 插入新闻数据
     * @return int|PDOStatement
     */
    public function addNewsData(){
        return $this->getResult(__FUNCTION__);
    }

    function getById($id)
    {
        return $this->getNewsDataById($id);
    }

    function delById($id)
    {
        // TODO: Implement delById() method.
    }

    function getByAttr($attr, $val)
    {
        // TODO: Implement getByAttr() method.
    }

    function getAllItems()
    {
        // TODO: Implement getAllItems() method.
    }

    /**
     *
     * ------暂时不能用 待调试
     *
     * 排序方法
     * @$arr 被排序的结果集 - 数组
     * @$by 被排序的字段
     * @$rule 排序规则 DESC为反序，其他为正序
     * */
    function sort($arr, $by, $rule)
    {
        // TODO: Implement sort() method.
    }

    /**统计所有
     * @return mixed
     */
    function count()
    {
        // TODO: Implement count() method.
    }

    function getByPeriod($start, $end)
    {
        // TODO: Implement getByPeriod() method.
    }

    function insertItem($attrs)
    {
        // TODO: Implement insertItem() method.
    }

    function updateItem($id, $info)
    {
        // TODO: Implement updateItem() method.
    }
}

