<?php

define('ROOT_PATH', realpath(dirname(__FILE__) . '/..'));
define('LIB_PATH', realpath(dirname(__FILE__) . '/../../library'));
require_once LIB_PATH . '/smarty/Smarty.class.php';

// $includes = array(LIB_PATH . '/mvc', ROOT_PATH . '/models');
// $incPath = implode(PATH_SEPARATOR, $includes);
// set_include_path(get_include_path() . PATH_SEPARATOR . $incPath);

// function __autoload($className) {
//     require_once $className . ".php";
// }
// require_once LIB_PATH . '/smarty/Smarty.class.php';
// $connInfo = array(
//     'host' => 'localhost',
//     'dbname' => 'sample',
//     'dbuser' => 'hoge',
//     'password' => 'xxxxxx'
// );

// ModelBase::setConnectionInfo($connInfo);
function autoload_mvc($className) {
    $file = LIB_PATH . '/mvc/' . $className . '.php';
    if (file_exists($file)) {
        require_once LIB_PATH . '/mvc/' . $className . '.php';
    }
}
spl_autoload_register('autoload_mvc');

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(ROOT_PATH);
$dispatcher->dispatch();