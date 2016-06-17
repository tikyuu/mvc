<?php

define('ROOT_PATH', realpath(dirname(__FILE__) . '/..'));
define('LIB_PATH', realpath(dirname(__FILE__) . '/../../library'));
define('DEBUG', false);
define('ERROR_DB', 'ただ今システム障害が発生しております。');

require_once LIB_PATH . '/global.php';
require_once LIB_PATH . '/smarty/Smarty.class.php';
require_once LIB_PATH . '/mvc/ClassLoader.php';

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(ROOT_PATH);
$dispatcher->dispatch();
