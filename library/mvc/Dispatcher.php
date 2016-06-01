<?php

// require_once '../views/Smarty.class.php';

/**
* 
*/
class Dispatcher
{
    private $sysRoot;

    public function setSystemRoot($path)
    {
        $this->sysRoot = rtrim($path, '/');
    }
    public function dispatch()
    {
        // test
        $param = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $param = ereg_replace('/?$', '', $_SERVER['REQUEST_URI']);
            $param = ereg_replace('^/', '', $param);
        }

        $params = array();
        if ('' != $param) {
            $params = explode('/', $param);
        }

        $controller = 'index';
        if (0 < count($params)) {
            $controller = $params[0];
        }

        $controllerInstance = $this->getControllerInstance($controller);
        if (null == $controller) {
            header('HTTP/1.0 404 Not Found');
            echo "HTTP/1.0 404 Not Found";
            exit;
        }

        $action = 'index';
        if (1 < count($params)) {
            $action = $params[1];
        }
        if (false == method_exists($controllerInstance,  $action . 'Action')) {
            header("HTTP/1.0 404 Not Found");
            echo "HTTP/1.0 404 Not Found";
            exit;
        }

        $controllerInstance->setSystemRoot($this->sysRoot);
        $controllerInstance->setControllerAction($controller, $action);

        $controllerInstance->run();
    }


    private function getControllerInstance($controller)
    {
        require_once sprintf('%s/controllers/ControllerBase.php', $this->sysRoot);
        
        $className = ucfirst(strtolower($controller)) . 'Controller';
        $controllerFileName = sprintf('%s/controllers/%s.php', $this->sysRoot, $className);
        if (false == file_exists($controllerFileName)) {
            return null;
        }

        require_once $controllerFileName;
        if (false == class_exists($className)) {
            return  null;
        }

        $controllerInstance = new  $className();

        return $controllerInstance;
    }
}