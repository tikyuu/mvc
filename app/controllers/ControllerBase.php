<?php

/*
* Dispatcherでのシングルページのコントロールで使用
* Dispatcher内で継承したコントローラがrunする
* preAction内でview(tpl)に対しての処理が可能
*/
abstract class ControllerBase
{
    # 1: systemRoot
    const SMARTY_TEMPLATES_PATH = '%s/views/templates/';
    const SMARTY_TEMPLATES_C_PATH = '%s/views/templates_c/';
    # 1: systemRoot 2: file-name
    const PARTIAL_PATH = '%s/views/templates/Partial/%s.tpl';

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

            if (file_exists($this->templatePath)) {
                $this->view->display($this->templatePath);
            } else {
                Log::v_log('not found template View');
            }
        } catch (SmartyException $e) {
            // $e->message();
            // echo $e->message;
            var_dump($e);
            exit;
        }
    }
    protected function partial($file_name)
    {
        $path = sprintf(ControllerBase::PARTIAL_PATH, $this->systemRoot, $file_name);
        $this->view->assign($file_name, $path);
    }
    protected function initializeView()
    {
        $this->view = new Smarty();
        $this->view->template_dir = sprintf(ControllerBase::SMARTY_TEMPLATES_PATH, $this->systemRoot);
        $this->view->compile_dir = sprintf(ControllerBase::SMARTY_TEMPLATES_C_PATH, $this->systemRoot);
        $this->templatePath = sprintf('%s/%s.tpl', $this->controller, $this->action);
    }
    protected function preAction()
    {
        
    }
    protected function createModel($className)
    {
        require_once sprintf('%s/models/ModelBase.php', $this->systemRoot);
        $classFile = sprintf('%s/models/%s.php', $this->systemRoot, $className);

        if (false == file_exists($classFile)) {
            echo $classFile . ': not found';
            return false;
        }

        require_once $classFile;
        if (false == class_exists($className)) {
            echo $className . ': not found';
            return false;
        }
        return new $className();
    }
}
