<?php
class TicketModel extends ModelBase
{
  /**
   * チケット更新
   * @param array-hash $data ('id', 'title', 'description')
   */
  public function ticketUpdate($data)
  {
    $table = 'ticket';
    try
    {
      $sql = sprintf('
        UPDATE
          %s
        SET
          title="%s", description="%s", status=%d
        WHERE
          id=%d
        ', $table, $data['title'], $data['description'], $data['status'], $data['id']);
      $state = $this->pdo->prepare($sql);
      $state->execute();
    }
    catch (PDOException $e)
    {
      echo "失敗";
      Util::u_log($e->getMessage());
      exit;
    }
  }
  /**
   * ユーザor全てのチケット数を取得
   * @param int $user_id 0の場合全て取得、0以外はそのIDのユーザのチケットを取得
   * @return int チケット数
   */
  public function ticketMax($user_id)
  {
    $table = 'ticket';
    if ($user_id == 0)
    {
      $sql = sprintf('
        SELECT
          COUNT(*)
        FROM
          %s',
        $table);
    }
    else
    {
      $sql = sprintf('
        SELECT
          SUM(CASE WHEN dst_user_id = %d THEN 1 ELSE 0 END) AS MAX
        FROM
          %s',
        $user_id, $table);
    }
    $res = $this->pdo->query($sql)->fetch(PDO::FETCH_COLUMN);
    return $res;
  }
  
  /**
   * sqlでSQL_CALC_FOUND_ROWSを使用することにより、その後にCOUNT(*)を書かずとも、
   * SELECT FOUND_ROWS(); で行数が取得可能になる。
   * searchCountの対で使ってます。
   * @param array($_POST) $data 検索自体がセレクトリストでユーザ入力ないのでセキリティは安全！
   * @param int $limit_start テーブルスタート地点
   * @param int $limit_end テーブルエンド地点
   */
  public function search($data, $limit_start, $limit_end)
  {
    // where check
    if (isset($data['user']) && isset($data['status'])) {
      $where = 'WHERE user.id = ' . $data['user'] . ' AND status.id = ' . $data['status'];
    } else if(isset($data['user'])) {
      $where = 'WHERE user.id = ' . $data['user'];
    } else {
      $where = 'WHERE status.id = ' . $data['status'];
    }
    $sql = sprintf(
      'SELECT
      SQL_CALC_FOUND_ROWS
        ticket.id, status.name, title
      FROM
        ticket
      INNER JOIN
        user
      ON
        user.id = ticket.dst_user_id
      INNER JOIN
        status
      ON
        status.id = ticket.status
      %s
      ORDER BY
        ticket.id
      DESC
      LIMIT %d, %d',
      $where, $limit_start, $limit_end);
    try {
      // $res = $this->pdo->query($sql_data)->fetchAll();
      // $res = $this->pdo->query($sql_count)->fetch(PDO::FETCH_COLUMN);
      $res = $this->pdo->query($sql)->fetchAll();
    } catch(PDOException $e) {
      echo $e->getMessage();
      Util::u_log($e->getMessage());
      exit;
    }
    return $res;
  }
  /**
   * 前のsqlでSQL_CALC_FOUND_ROWSを行った場合のみ有効
   * 上記のsearch関数の後にこれを呼び出すと総数が取得できる。
   */
  public function searchCount()
  {
    $sql = 'SELECT FOUND_ROWS()';
    try {
      $res = $this->pdo->query($sql)->fetch(PDO::FETCH_COLUMN);
    } catch(PDOException $e) {
      echo $e->getMessage();
      Util::u_log($e->getMessage());
      exit;
    }
    return $res;
  }

  /**
   * ユーザテーブル取得
   * @return [](id => ?, name => ?)
   */
  public function getUser()
  {
    $table = 'user';
    $sql = sprintf('SELECT id, name FROM %s', $table);
    $res = $this->pdo->query($sql)->fetchAll();
    return $res;
  }
  /**
   * チケットID取得
   * @return int[]
   */
  public function getTicketID()
  {
    $sql = 'SELECT id FROM ticket';
    $res = $this->pdo->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    return $res;
  }
  /**
   * ステータステーブル取得
   * @return [](id => ?, name => ?)
   */
  public function getStatus()
  {
    $table = 'status';
    $sql = sprintf('SELECT id, name FROM %s', $table);
    $res = $this->pdo->query($sql)->fetchAll();
    return $res;
  }
  // @return ログ全データ 2次元配列
  public function getLog()
  {
    $table = 'log';
    $sql = sprintf('SELECT * FROM %s ORDER BY id DESC', $table);

    $state = $this->pdo->prepare($sql);
    if (!$state->execute()) { echo "err getLog"; exit; }
    $res = $state->fetchAll(PDO::FETCH_ASSOC);

    return $res;
  }

  /**
   * ユーザもしくはすべてのチケットをlimit_startからlimit_endまで取得する。
   * @param int $user_id  チケットに割り振られるユーザID; 0の場合全てのチケットを調べる
   * @param int $limit_start 存在するチケットを分割; start;
   * @param int $limit_end 存在するチケットを分割; offset;
   * @return tickets
   */
  public function getUserTicket($user_id, $limit_start = 0, $limit_end = 10)
  {
    if ($user_id == 0){
      $sql = sprintf(
        'SELECT
          ticket.id, status.name, title
        FROM
          ticket
        INNER JOIN
          user
        ON
          user.id = ticket.dst_user_id
        INNER JOIN
          status
        ON
          status.id = ticket.status
        WHERE
          status.id != 3
        ORDER BY
          ticket.id
        DESC
        LIMIT %d, %d',
        $limit_start, $limit_end);
    } else {
      $sql = sprintf(
        'SELECT
          ticket.id, status.name, title
        FROM
          ticket
        INNER JOIN
          user
        ON
          user.id = ticket.dst_user_id
        INNER JOIN
         status
        ON
         status.id = ticket.status
        WHERE
          user.id = "%s"
        AND
          status.id != 3
        ORDER BY
          ticket.id
        DESC
        LIMIT %d,%d', 
        $user_id, $limit_start, $limit_end);
    }

    $state = $this->pdo->prepare($sql);
    if (!$state->execute()) { echo "err getUserTicket"; exit; }
    $res = $state->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
  // @return チケット全データ array([key => value ...])
  // public function getAllTicket()
  // {
  //   $sql = '
  //     SELECT
  //       *
  //     FROM
  //       ticket
  //     ORDER BY
  //       id
  //     DESC';
  //   $stmt = $this->pdo->query($sql);
  //   return $stmt->fetchAll(PDO::FETCH_ASSOC);
  // }
  public function getArchiveTicket()
  {
    $sql = '
      SELECT 
        ticket.id, status.name, title
      FROM
        ticket
      INNER JOIN
        user
      ON
        user.id = ticket.dst_user_id
      INNER JOIN
        status
      ON
        status.id = ticket.status
      WHERE
        status = 3
      ORDER BY
        id
      DESC';
    $res = $this->pdo->query($sql)->fetchAll();
    return $res;
  }
  public function _checkPost($post, $key, $check_empty = false)
  { 
    if ($check_empty) 
    { 
      if (empty($post[$key]))
      {
        return 'empty: ' . $key . '<br>';
      }
    }
    else
    {
      if (!isset($post[$key]))
      {
        return '!isset: ' . $key . '<br>';
      }
    }
    return '';
  } 
  public function check($post)
  {
    $error = array();
    $error[] = $this->_checkPost($post, 'status');
    $error[] = $this->_checkPost($post, 'src_user_id');
    $error[] = $this->_checkPost($post, 'dst_user');
    $error[] = $this->_checkPost($post, 'title');
    $error[] = $this->_checkPost($post, 'description', true);
    $error = array_filter($error);
    
    if (!empty($error))
    {
      var_dump($error);
      exit;
    }
    return true;
  }
  public function delete($id)
  {
    try {

      // ticket delete prepare
      $table_ticket = 'ticket';
      $sql1 = sprintf('DELETE FROM %s WHERE id = :id', $table_ticket);
      $state1 = $this->pdo->prepare($sql1);

       // log add prepare
       $data2 = array(
          "ticket_id" => 1,
          "description" => "チケットを削除しました。"
        );
       $table_log = 'log';
       $bind2 = $this->bindString($data2);
       $sql2 = sprintf('INSERT INTO %s ' . $bind2, $table_log);
       $state2 = $this->pdo->prepare($sql2);

      // トランザクション
      try {
        // delete ticket
        $this->pdo->beginTransaction();
        $state1->bindValue(':id', $id);
        $state1->execute();

        // add log
        foreach ($data2 as $key => $value) {
          $state2->bindValue(':' . $key, $value);
        }
        $state2->execute();

        $this->pdo->commit();
      } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
      }
    } catch (PDOException $e) {
      if(DEBUG){ echo $e->getMessage(); } else { echo ERROR_DB; }
      Log::u_log($e->getMessage());
      exit;
    }
  }
  /**
   * チケット詳細取得
   * @return array("id" => ?, "title" => ?, "description" => ?)
   */
  public function getTicketDetail($ticket_id)
  {
    try
    {
      $table = 'ticket';
      $sql = sprintf('
        SELECT 
          ticket.id, status, title, description
        FROM
          %s
        WHERE
          ticket.id = %d'
        , $table, $ticket_id);
      $res = $this->pdo->query($sql)->fetch();
    }
    catch (Exception $e)
    {
      Util::u_log($e->getMessage());
      echo "error";
      exit;
    }

    return $res;
  }
  public function add($post)
  {
      try{
        // ticket add prepare
       $data1 = array(
        "status" => $post['status'],
        "src_user_id" => $post['src_user_id'],
        "dst_user_id" => $post['dst_user'],
        "title" => $post['title'],
        "description" => $post['description']
        );
       $table_ticket = 'ticket';
       $bind1 = $this->bindString($data1);
       $sql1 = sprintf('INSERT INTO %s ' . $bind1, $table_ticket);
       $state1 = $this->pdo->prepare($sql1);

       // log add prepare
       $data2 = array(
          "ticket_id" => 1,
          "description" => "チケットを追加しました。"
        );
       $table_log = 'log';
       $bind2 = $this->bindString($data2);
       $sql2 = sprintf('INSERT INTO %s ' . $bind2, $table_log);
       $state2 = $this->pdo->prepare($sql2);

       // トランザクション
       $this->pdo->beginTransaction();
       try {
        // ticket add
        foreach ($data1 as $key => $value) {
          $state1->bindValue(':' . $key, $value);
        }
        $state1->execute();

        // log add
        foreach ($data2 as $key => $value) {
          $state2->bindValue(':' . $key, $value);
        }
        $state2->execute();

        // コミット
        $this->pdo->commit();

      } catch (Exception $e){
        // ロールバック
        $this->pdo->rollBack();
        echo $e->getMessage();
        throw $e;
      }

    } catch (PDOException $e) {
        if(DEBUG){ echo $e->getMessage(); } else { echo ERROR_DB; }
        Log::u_log($e->getMessage());
        exit;
    }
  }
}
