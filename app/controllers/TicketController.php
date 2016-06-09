
<?php
class TicketController extends ControllerBase
{
    private $model;
    public function preAction()
    {
        $this->model = $this->createModel('TicketModel');
    }
    public function addAction()
    {
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');

        //  action
        $this->view->assign('send_file', '/Ticket/check');

        // 自身
        $src_user_id = Session::GetID();
        $this->view->assign('src_user_id', $src_user_id);

        // ユーザ
        $dst_user = $this->model->getUser();
        $this->view->assign('dst_user', $dst_user);

        // open_date
        // $open_date = date('Y-m-d H:i:s');
        // $this->view->assign('open_date', $open_date);
    }
    public function logAction()
    {
        $d2ary = $this->model->getLog();
        $ary_th = array_keys($d2ary[0]); 
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    public function checkAction()
    {
        $request = new Request();
        $post = $request->getPost();

        if (isset($post['add']))
        {
            if (!$this->model->check($post))
            {
                echo "post roll back"; // TODO
                exit;
            }
            $this->model->add($post);
            header('Location: /Ticket/log');
            exit;
        }
        if (isset($post['delete'])) 
        {
            $this->model->delete($post['id']);
            header('Location: /Ticket/home');
            exit;
        }

        echo 'no ID';
        exit;
    }
    public function indexAction()
    {
        header('Location: /Ticket/home');
        exit;
    }
    public function homeAction()
    {
        $this->_user_check();

        $d2ary = $this->model->getUserTicket(Session::getID());
        $ary_th = array_keys($d2ary[0]);
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }  
    public function allTicketAction()
    {
        $d2ary = $this->model->getAllTicket();
        $ary_th = array_keys($d2ary[0]);
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    private function _user_check()
    {
        echo Session::getID() . '<br>';
        echo Session::getName() . '<br>';
    }
    private function _post_check()
    {
        $request = new Request();
        $post = $request->getPost();
        var_dump($post);
        exit;
    }
    private function _test_check()
    {
        $this->model->getUser();
    }
}

