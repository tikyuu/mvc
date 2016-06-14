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
          title="%s", description="%s"
        WHERE
          id=%d
        ', $table, $data['title'], $data['description'], $data['id']);
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
  public function search($post, $check)
  {
    $table = 'ticket';
    $sql = sprintf('SELECT * FROM %s WHERE ', $table);
    if ($check == "and")
    {
      foreach ($post as $key => $value) {
        $sql .= $key . ' LIKE "%' . $value . '%" AND ';
      }
      // 最後の' AND 'を削除
      $sql = substr($sql, 0, -5);
    }
    else if($check == "or")
    {
      foreach ($post as $key => $value) {
        $sql .= $key . ' LIKE "%' . $value . '%" OR ';
      }
      // 最後の' OR 'を削除
      $sql = substr($sql, 0, -4);
    }
    try
    {
      $state = $this->pdo->query($sql);
      $res = $state->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo $e->getMessage();
      Util::u_log($e->getMessage());
      exit;
    }
    var_dump($res);
    exit;
    return $res;
  }

  // @return array([id => ?, name => ?]) 
  public function getUser()
  {
    $table = 'user';
    $sql = sprintf('SELECT id, name FROM %s', $table);
    $state = $this->pdo->prepare($sql);
    if (!$state->execute()) { echo "err getUsers"; exit; }
    $res = $state->fetchAll(PDO::FETCH_ASSOC);

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
          ticket.id, name, title
        FROM
          user
        INNER JOIN
          ticket
        ON
          user.id = ticket.dst_user_id
        ORDER BY
          ticket.id
        DESC
        LIMIT %d, %d',
        $limit_start, $limit_end);
    } else {
      $sql = sprintf(
        'SELECT
          ticket.id, name, title
        FROM
          user
        INNER JOIN
          ticket
        ON
          user.id = ticket.dst_user_id
        WHERE
          user.id = "%s"
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
  public function getAllTicket()
  {
    $table = 'ticket';
    $sql = sprintf('SELECT * FROM %s ORDER BY id DESC', $table);
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    $error[] = $this->_checkPost($post, 'src_user_id');
    $error[] = $this->_checkPost($post, 'dst_user');
    $error[] = $this->_checkPost($post, 'title');
    $error[] = $this->_checkPost($post, 'description', true);
    $error = array_filter($error);
    
    if (!empty($this->errors))
    {
      var_dump($this->errors);
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
          id, title, description
        FROM
          %s
        WHERE
          id = %d'
        , $table, $ticket_id);
      $res = $this->pdo->query($sql)->fetch();
    }
    catch (Exception $e)
    {
      Util::u_log($e->getMessage());
      exit;
    }

    return $res;
  }
  public function add($post)
  {
      try{
        // ticket add prepare
       $data1 = array(
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
