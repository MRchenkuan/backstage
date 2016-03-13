<?php
require_once('../TOOLS/Config.class.php');

$DB = Config::getSection("DB");
$TYPE = $DB['TYPE'];
$HOST = $DB['HOST'];
$NAME = $DB['NAME'];
$USERNAME = $DB['USERNAME'];
$PASSWORD = $DB['PASSWORD'];
$PORT = $DB['PORT'];
$dsn = $TYPE.":host=".$HOST.";port=".$PORT.";dbname=".$NAME;
$pdo = new PDO($dsn, $USERNAME, $PASSWORD);

function getNewsData(){
    $id = __FUNCTION__;
    echo Config::get('DATABASE_DAO_DIR');
    $DAO = simplexml_load_file(Config::get('DATABASE_DAO_DIR'));
    echo $DAO;
}

getNewsData();
