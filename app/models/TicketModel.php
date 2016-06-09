<?php
class TicketModel extends ModelBase
{
  protected $errors = array(); // string[]

  public function getUserDB()
  {
  }
  public function getUserTicket($user)
  {
    $sql = sprintf('SELECT name, title, description FROM user INNER JOIN ticket ON user.name = ticket.src_user WHERE user.name = "%s"', $user);
    $state = $this->pdo->prepare($sql);
    if (!$state->execute()) { echo "err execute"; exit; }
    $res = $state->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
  public function getAll()
  {
    $table = 'ticket';
    $sql = 'SELECT * FROM ' . $table;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function _checkPost($post, $key, $check_empty = false)
  { 
    if ($check_empty) 
    { 
      if (empty($post[$key]))
      {
        $this->errors[] = 'empty: ' . $key . '<br>';
      }
    }
    else
    {
      if (!isset($post[$key]))
      {
        $this->errors[] = '!isset: ' . $key . '<br>';
      }
    }
  } 
  public function check($post)
  {
    // isset 空文字許容 empty 空文字禁止
    $this->_checkPost($post, 'label');
    $this->_checkPost($post, 'status');
    $this->_checkPost($post, 'src_user');
    $this->_checkPost($post, 'dst_user');
    $this->_checkPost($post, 'title');
    $this->_checkPost($post, 'description', true);
    $this->_checkPost($post, 'open_date');
    $this->_checkPost($post, 'close_date');
    if (!empty($this->errors))
    {
      var_dump($this->errors);
      exit;
    }

    return true;
  }
  public function testAdd()
  {
    $sql = 'INSERT INTO ticket (src_user, dst_user, description) VALUES ("aa", "bb", "cc")';
    try
    {
      $state = $this->pdo->prepare($sql);
      if (!$state->execute())
      {
        throw new Exception("実行失敗");
      }
    } 
    catch (Exception $e)
    {
      Log::u_log($e->getMessage());
      exit;
    }
  }
  public function delete($id)
  {
    $table = 'ticket';
    $sql = sprintf('DELETE FROM %s WHERE id = :id', $table);
    try {
      $state = $this->pdo->prepare($sql);
      if (!$state) { throw new Exception("err prepare"); }
      $state->bindValue(':id', $id);
      if (!$state->execute()) { throw new Exception("実行失敗"); }
    } catch (Exception $e) {
      Log::u_log($e->getMessage());
      Log::u_log("error");
      exit;
    }
  }
  public function add($post)
  {
     $data = array(
      // "label" => intval($post['label']),
      // "status" => intval($post['status']),
      "src_user" => $post['src_user'],
      "dst_user" => $post['dst_user'],
      "title" => $post['title'],
      "description" => $post['description']
      );

    $table = 'ticket';
    $bind = $this->bindString($data);
    $sql = sprintf('INSERT INTO %s ' . $bind, $table);

    try {
      $state = $this->pdo->prepare($sql);
      if (!$state) { throw new Exception("err prepare"); }
      foreach ($data as $key => $value) {
        $state->bindValue(':' . $key, $value);
      }
      if (!$state->execute()) { throw new Exception("実行失敗"); }
    } catch (Exception $e){
      Log::u_log($e->getMessage());
      Log::u_log("errror");
      exit;
    }
  }
}
