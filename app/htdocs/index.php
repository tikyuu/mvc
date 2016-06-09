<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/..'));
define('LIB_PATH', realpath(dirname(__FILE__) . '/../../library'));
define('DEBUG', false);
define('ERROR_DB', 'ただ今システム障害が発生しております。');

require_once LIB_PATH . '/global.php';
require_once LIB_PATH . '/smarty/Smarty.class.php';

function autoload_mvc($className) {
    $file = LIB_PATH . '/mvc/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        // echo  $file;
    } else {
        echo 'not found' . $file;
        exit;
    }
}
spl_autoload_register('autoload_mvc');

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(ROOT_PATH);
$dispatcher->dispatch();
