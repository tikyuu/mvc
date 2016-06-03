
<?php
class TicketController extends ControllerBase
{
    public function addAction()
    {
        $this->partial('_header_bootstrap');
        $this->view->assign('send_file', '/Ticket/check');
    }
    public function checkAction()
    {
        // $post = $this->request->getPost();
        // foreach ($post as $key => $value) {
        //     echo $key. ': ' . $value . '<br>';
        header('Location: ' . '/Ticket/index');
        exit();
    }
    public function indexAction()
    {
        $this->partial('_header_bootstrap');
    }
}

