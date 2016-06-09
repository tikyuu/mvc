<?php
class TicketModel extends ModelBase
{

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
  // @return 2次元配列 array([name => ?, title => ?, description => ?])
  public function getUserTicket($user_id)
  {
    $sql = sprintf('SELECT ticket.id, name, title, description FROM user INNER JOIN ticket ON user.id = ticket.dst_user_id WHERE user.id = "%s" ORDER BY ticket.id DESC', $user_id);
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
