<?php

/**
* @link http://qiita.com/misogi@github/items/8d02f2eac9a91b4e6215
* @link or http://jes.st/2011/phpunit-bootstrap-and-autoloading-classes/
*/
class ClassLoader
{
    private static $dirs;

    public static function loadClass($class)
    {
        foreach (ClassLoader::directories() as $directory) {
            $file_name = $directory . '/' . $class . '.php';
            if (is_file($file_name)) {
                require_once $file_name;
                return true;
            }
        }
        echo $file_name . "が存在しません。";
        exit;
    }

    private static function directories()
    {
        if (empty(ClassLoader::$dirs)) {
            // $base = '/path/to/application/dir';
            $base = LIB_PATH;
            ClassLoader::$dirs = array(
                // $base . '/controllers',
                $base . '/mvc'
            );
        }

        return ClassLoader::$dirs;
    }
}

spl_autoload_register(array('ClassLoader', 'loadClass'));