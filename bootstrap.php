<?php

define('ROOT_PATH', realpath(dirname(__FILE__) . '/app'));
define('LIB_PATH', realpath(dirname(__FILE__) . '/library'));

require_once LIB_PATH . '/global.php';
require_once LIB_PATH . '/smarty/Smarty.class.php';
require_once LIB_PATH . '/mvc/ClassLoader.php';
