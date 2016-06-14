
<?php
class LoginController extends ControllerBase
{
    /**
     * ログイン処理を行う
     * POSTを確認しなにも入ってなればログイン画面
     * POSTが入っていて間違っていればログイン失敗
     * POSTが入っていてあっていれば/Ticket/indexへ
     */
    public function loginAction()
    {
        $request = new Request();
        $post = $request->getPost();
        if (isset($post['name']) || isset($post['password']))
        {
            $model = $this->createModel('LoginModel');
            $id = $model->check($post['name'], $post['password']);
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
    /**
     * ログアウト
     * セッション、クッキー破壊
     */
    public function logoutAction()
    {
        Session::logout();
    }
}

