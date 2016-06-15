
<?php
class TicketController extends ControllerBase
{
    const TICKET_ROW = 10; // チケット最大表示数
    private $model;

    /**
     * 全てのアクションが実行される前に必ず実行される
     * modelめんどくさくなってここで作成
     */
    public function preAction()
    {
        $this->model = $this->createModel('TicketModel');
    }

    public function emptyAction()
    {
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
    }
    /**
     * チケットアーカイブ画面
     * ステータスが終了になっているチケットは全てアーカイブに送られる。
     */
    public function archiveAction()
    {
        $request = new Request();
        $user_id = Session::getID();
        $page_send_file = '/Ticket/archive';

        // チケット設定
        $d2ary = $this->model->getArchiveTicket();
        if (empty($d2ary)) {
            header('Location: /Ticket/empty');
            exit;
        }

        // ページネーション設定
        $param = $request->getParam();
        $page_index = is_null($param) ? 1 : $param[0];
        $ticket_max = count($d2ary);

        // $d2ary = $this->model->getUserTicket($user_id, ($page_index - 1) * TicketController::TICKET_ROW, TicketController::TICKET_ROW);
        $ary_th = array_keys($d2ary[0]);

        // viewに追加
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->_partialPagenation($page_index, $ticket_max, $page_send_file);
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    /**
     * チケット詳細画面
     * post['ticket_id']
     */
    public function detailAction()
    {
        $request = new Request();
        $param = $request->getParam();
        $ticket_id = $param[0];

        $data = $this->model->getTicketDetail($ticket_id);
        if(empty($data)) {
            header('Location: /Ticket/home');
            exit;
        }

        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('send_file', '/Ticket/check');
        $this->view->assign('id', $data['id']);

        // ステータステーブル
        $status = $this->model->getStatus();
        $this->view->assign('status', $status);
        $this->view->assign('status_index', $data['status']);

        $this->view->assign('title', $data['title']);
        $this->view->assign('description', $data['description']);
    }

    /**
     * チケットの追加
     */
    public function addAction()
    {
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');

        //  action
        $this->view->assign('send_file', '/Ticket/check');

        // 自身
        $src_user_id = Session::GetID();
        $this->view->assign('src_user_id', $src_user_id);

        // ステータステーブル
        $status = $this->model->getStatus();
        $this->view->assign('status', $status);

        // ユーザテーブル
        $dst_user = $this->model->getUser();
        $this->view->assign('dst_user', $dst_user);

        // open_date
        // $open_date = date('Y-m-d H:i:s');
        // $this->view->assign('open_date', $open_date);
    }

    /**
     * チケットの検索
     */
    public function searchAction()
    {
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('send_file', '/Ticket/check');
    }

    /**
     * チケット操作に対してのログ画面
     * add,deleteアクション実行時にトランザクションで追加される
     */
    public function logAction()
    {
        $d2ary = $this->model->getLog();
        $ary_th = array_keys($d2ary[0]); 
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }

    /**
     * 画面内に表示されない処理分け
     * 送られてきたpostの値を確認し、正しい場合のみLocationで分岐する
     */
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
        if (isset($post['search']))
        {
            $data = array("id" => $post['id'], "title" => $post['title'], "description" => $post['description']);
            $data = array_filter($data);
            if (empty($data)) { 
                header('Location: /Ticket/search');
                exit;
            }
            $check_search = isset($post['or']) ? 'or' : 'and';
            // $res = $this->model->search($data, $check_search);

            foreach ($data as $key => $value) {
                $get .= '&' . $key . '=' . $value;
            }
            $get .= '&' . $check_search . "= ";
            $get = substr($get, 1); // 先頭の１文字削除
            header('Location: /Ticket/searchResult?' . $get);
            exit;
        }
        if (isset($post['detail']))
        {
            if (isset($post['id']))
            {
                header('Location: /Ticket/detail/' . $post['id']);
                exit;
            } 
            else 
            {
                header('Location: /Ticket/home');
                exit;
            }
        }
        if (isset($post['update']))
        {
            if (isset($post['id']))
            {
                $this->model->ticketUpdate($post);
            }
            header('Location: /Ticket/home');
            exit;
        }

        header('Location: /Ticket/home');
        exit;
    }
    public function searchResultAction()
    {
        $request = new Request();
        $query = $request->getQuery();
        $check_search = isset($post['or']) ? 'or' : 'and';
        $query = array_filter($query); 
        $res = $this->model->search($query, $check_search);
        var_dump($res);
        exit;
    }


    public function postAction()
    {
        $request = new Request();
        $post = $request->getPost();
        var_dump($post);
        exit;
    }
    /**
     * homeへ移動される
     */
    public function indexAction()
    {
        header('Location: /Ticket/home');
        exit;
    }
    /**
     * ログインユーザの全チケットを表示する
     */
    public function homeAction()
    {
        $request = new Request();
        $user_id = Session::getID();
        $page_send_file = '/Ticket/home';

        // ユーザIDからチケットを取得
        $this->_getTicket($request, $user_id, $page_send_file);
    }  
    /**
     * 全チケットを表示する
     */
    public function allTicketAction()
    {
        $request = new Request();
        $page_send_file = '/Ticket/allTicket';
        
        // 全チケット取得
        $this->_getTicket($request, 0, $page_send_file);
    }
    /**
     * @debug ユーザ情報確認用
     */
    private function _user_check()
    {
        echo Session::getID() . '<br>';
        echo Session::getName() . '<br>';
    }
    /**
     * @debug test
     */
    public function testAction()
    {
        $request = new Request();
        $param = $request->getParam();
        $user_id = Session::getID();
        $page_send_file = '/Ticket/test';

        // 全チケット取得
        $this->_getTicket($request, 0, $page_send_file);
    }
    /**
     * ユーザor全チケット取得
     * @param Request $request
     * @param int     $user_id
     */
    private function _getTicket($request, $user_id, $send_file)
    {
        // ページネーション設定
        $param = $request->getParam();
        $page_index = is_null($param) ? 1 : $param[0];
        $ticket_max = $this->model->ticketMax($user_id);

        // チケット設定
        $d2ary = $this->model->getUserTicket($user_id, ($page_index - 1) * TicketController::TICKET_ROW, TicketController::TICKET_ROW);
        $ary_th = array_keys($d2ary[0]);

        // viewに追加
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->_partialPagenation($page_index, $ticket_max, $send_file);
        $this->view->assign('ary_th', $ary_th);
        $this->view->assign('d2ary', $d2ary);
    }
    /**
     * ページネーション用のパーシャル作成 
     * @param int $page_index   現在選択しているページ
     * @param int $ticket_max   チケット最大数
     */
    private function _partialPagenation($page_index, $ticket_max, $send_file)
    {
        // (チケット数 / [表示row数]row_max) = 最大ページ数
        $page_max = ceil(($ticket_max / TicketController::TICKET_ROW));
        $page_ary = range(1, $page_max);

        // viewに追加
        $this->partial('_pagenation_ticket');
        $this->view->assign('page_send_file', $send_file);
        $this->view->assign('page_index', $page_index);
        $this->view->assign('page_ary', $page_ary);
    }
}

