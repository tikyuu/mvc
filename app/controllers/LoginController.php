
<?php
class LoginController extends ControllerBase
{
    private $model;
    public function loginAction()
    {
        $request = new Request();
        $post = $request->getPost();
        if (isset($post['name']) || isset($post['password']))
        {
            $id = $this->_check($post['name'], $post['password']);
            if ($id == 0)
            {
                echo '<h2>ログインに失敗しました。</h2><br>';
            }
            else
            {
                Session::login($id, $post['name']);
                header('Location: /Ticket/home');
                exit;
            }
        }
        $this->partial("_header_bootstrap");
        $this->view->assign('send_file', '/Ticket/index');
        $this->view->assign('res_1', 'name');
        $this->view->assign('res_2', 'password');
    }
    private function _check($user_id, $password)
    {
       $this->model = $this->createModel('LoginModel');
       return $this->model->check($user_id, $password);
    }
    public function logoutAction()
    {
        Session::logout();
    }
}

