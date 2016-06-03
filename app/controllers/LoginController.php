
<?php
class LoginController extends ControllerBase
{
    private $model;
    public function loginAction()
    {
        // ログインしないと強制的にこのアクションが実行されるので、
        // postでuserID,passwordの存在確認を行う。
        $request = new Request();
        $post = $request->getPost();
        if (isset($post['user_id']) || isset($post['password']))
        {
            if ($this->_check($post['user_id'], $post['password']))
            {
                Session::login();
                header('Location: /Ticket/index');
                exit();
            }
            else
            {
                echo '<h2>ログインに失敗しました。</h2><br>';
            }
        }

        $this->partial("_header_bootstrap");
        $this->view->assign('send_file', '/Ticket/index');
        $this->view->assign('res_1', 'user_id');
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

