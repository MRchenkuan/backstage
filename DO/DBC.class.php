<?php
require_once('../TOOLS/Config.class.php');
class  DBC
{
    function __construct($type)
    {
        $DB = Config::getSection("DB");
        $TYPE = $DB['TYPE'];
        $HOST = $DB['HOST'];
        $NAME = $DB['NAME'];
        $USERNAME = $DB['USERNAME'];
        $PASSWORD = $DB['PASSWORD'];
        $PORT = $DB['PORT'];
        $dsn = $TYPE.":host=".$HOST.";port=".$PORT.";dbname=".$NAME;
        $this->pdo = new PDO($dsn, $USERNAME, $PASSWORD);
    }

    static function getNewsInfo(){

    }
}