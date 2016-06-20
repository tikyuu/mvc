
<?php
class TicketController extends ControllerBase
{
    const TICKET_ROW = 5; // チケット最大表示数
    const PAGENATION_MAX = 5; // 表示されるページ数
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

        // チケットID配列
        $ticket_ids = $this->model->getTicketID();
        $this->view->assign('ticket_ids', $ticket_ids);
        // ステータステーブル
        $statuses = $this->model->getStatus();
        $this->view->assign('statuses', $statuses);
        // ユーザテーブル
        $users = $this->model->getUser();
        $this->view->assign('users', $users);
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
            // ID search button
            if (isset($post['button_id']))
            {
                $post = array_filter($post); // 空配列削除
                if (isset($post['ticket_id']))
                {
                    header('Location: /Ticket/detail/' . $post['ticket_id']);
                    exit;
                }
            }
            else 
            {
                $post = array_filter($post); // 空配列削除
                if (isset($post['status']) || isset($post['user']))
                {
                    // getデータへ変換し、searchResultへ送る
                    $query = http_build_query($post);
                    $location = 'Location: /Ticket/searchResult/?' . $query;
                    header($location);
                    exit;
                }
            }
            header('Location: /Ticket/search');
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
        // ページネーション設定
        $request = new Request(); 
        $param = $request->getParam();
        $query = $request->getQuery();
        $page_index = is_null($param) ? 1 : $param[0];
        $d2ary = $this->model->search($query, ($page_index - 1) * TicketController::TICKET_ROW, TicketController::TICKET_ROW);
        if (empty($d2ary)) {
            header('Location: /Ticket/empty');
            exit;
        }
        $ticket_max = $this->model->searchCount();
        $ary_th = array_keys($d2ary[0]);

        $page_send_file = '/Ticket/searchResult';
        $query_url = http_build_query($query);

        // viewに追加
        $this->partial('_header_bootstrap');
        $this->partial('_menu_ticket');
        $this->_partialPagenation($page_index, $ticket_max, $page_send_file, $query_url);
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
     * デバッグ ユーザ情報確認用
     */
    private function _user_check()
    {
        echo Session::getID() . '<br>';
        echo Session::getName() . '<br>';
    }
    /**
     * デバッグ 全チケット表示
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

        if (empty($d2ary)) {
            header('Location: /Ticket/empty');
            exit;
        }
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
     * @param string $send_file ページ遷移するurl
     * @param string $query_url get用url  例: hoge=100&hoge2=200&hoge3=300
     */
    private function _partialPagenation($page_index, $ticket_max, $send_file, $query_url = null)
    {
        // (チケット数 / [表示row数]row_max) = 最大ページ数
        $page_max = ceil(($ticket_max / TicketController::TICKET_ROW));
        if ($page_index > $page_max) {
            $page_index = $page_max;
        }

        $page_ary = array();
        if ($page_max < self::PAGENATION_MAX) {
            // 総ページ数がページネーション基準数より少ない場合
            // 全て表示
            $page_ary = range(1, $page_max);
        } else {
            // 現在のページ数を中心にする。
            $center_index = ceil(self::PAGENATION_MAX / 2);
            if ($page_index != 1) {
                $this->view->assign('left_arrow', '');
            } 
            if ($page_index != $page_max) {
                $this->view->assign('right_arrow', '');
            }

            $count;
            // 　現在のページ数が真ん中の値より低い場合,一番左(1)
            if ($page_index < $center_index) {
                $count = 1;

            // 現在のページ数 + 真ん中の値がページ数を超えた場合、max - center - 1
            } else if ($page_index + $center_index > $page_max) {
                $count = $page_max - $center_index - 1;

            // 現在の値がセンターに来るように調整
            } else {
                $count = $page_index - $center_index + 1;
            }

            for($i = 0; $i < self::PAGENATION_MAX; ++$i) {
                $page_ary[] = $count + $i;
            }
        }

        // viewに追加
        $this->partial('_pagenation_ticket');
        $this->view->assign('page_send_file', $send_file);
        $this->view->assign('page_index', $page_index);
        $this->view->assign('page_ary', $page_ary);
        $this->view->assign('PAGENATION_MAX', self::PAGENATION_MAX);
        // ごり押しの$_GET(query)追加
        if (!is_null($query)) {
            $this->view->assign('query', '?' . $query_url);
        }
    }
}

