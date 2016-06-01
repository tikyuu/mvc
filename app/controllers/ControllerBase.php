<?php

/*
* 
*/
abstract class ControllerBase
{
    protected $systemRoot;
    protected $controller = 'index';
    protected $action = 'index';
    protected $view;
    protected $request;
    protected $templatePath;

    function __construct()
    {
        $this->request = new Request();
    }
    public function setSystemRoot($path)
    {
        $this->systemRoot = $path;
    }
    public function setControllerAction($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }
    public function run()
    {
        try {
            $this->initializeView();
            $this->preAction();
            $methodName = sprintf('%sAction', $this->action);
            $this->$methodName();

            $this->view->display($this->templatePath);

        } catch (Exception $e) {
            echo $e.Message();
        }
    }
    protected function initializeView()
    {
        $this->view = new Smarty();
        $this->view->template_dir = sprintf('%s/views/templates/', $this->systemRoot);
        $this->view->compile_dir = sprintf('%s/views/templates_c/', $this->systemRoot);
        $this->templatePath = sprintf('%s/%s.tpl', $this->controller, $this->action);
    }
    protected function preAction()
    {
        
    }
    protected function createModel($className)
    {
        // $classFile = sprintf('%s/app/models/%s.php', $this->systemRoot, $className);
        // if (false == file_exists($className)) {
        //     return false;
        // }
        // require_once $classFile;
        // if (false == class_exists($className)) {
        //     return false;
        // }
        
        // return new $className();
    }
}