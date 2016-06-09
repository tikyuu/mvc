
<?php
class TicketController extends ControllerBase
{
    private $model;
    public function addAction()
    {
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');

        //  action
        $this->view->assign('send_file', '/Ticket/check');

        // label -> DBのFKになる table label
        $labels = array(0, 1, 2, 3, 4, 5);
        $this->view->assign('labels', $labels);

        // status -> DBのFKになる table status
        $statuses = array(0, 1, 2, 3, 4, 5);
        $this->view->assign('statuses', $statuses);

        // dst_user DBのFKになる table user
        $dst_user = array('新垣', 'test');
        $this->view->assign('dst_user', $dst_user);

        // open_date
        $open_date = date('Y-m-d H:i:s');
        $this->view->assign('open_date', $open_date);
    }
    public function checkAction()
    {
        $request = new Request();
        $post = $request->getPost();
        $this->_createModel();

        if (isset($post['add']))
        {
            if (!$this->model->check($post))
            {
                echo "roll back"; // TODO
                exit;
            }
            $this->model->add($post);
            header('Location: /Ticket/home');
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
    private function _createModel()
    {
       $this->model = $this->createModel('TicketModel');
    }
    public function indexAction()
    {
        header('Location: /Ticket/home');
        exit;
    }
    public function allTicketAction()
    {
        $this->model = $this->createModel('TicketModel');
        $d2ary = $this->model->getAll();
        $ary_th = array_keys($d2ary[0]);
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    public function homeAction()
    {
        // 配列テスト
        // $ary = array(1000, 1001, 1002);
        // $this->view->assign('ary', $ary);

        // 連想配列テスト
        // $ary = array('hoge' => 'Tennis', 'fuga' => 'swimming', 'test' => 'coding');
        // $this->view->assign('ary', $ary);
        echo Session::getID() . '<br>';
        echo Session::getName() . '<br>';
        $this->model = $this->createModel('TicketModel');
        // $d2ary = $this->model->getAll();
        $d2ary = $this->model->getUserTicket(Session::getName());
        $ary_th = array_keys($d2ary[0]);
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    public function postAction()
    {
        $request = new Request();
        $post = $request->getPost();
        var_dump($post);
        exit;
    }
}

