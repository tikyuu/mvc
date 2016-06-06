<?php
class TicketModel extends ModelBase
{
  protected $table = "ticket"; // string
  protected $errors = array(); // string[]

  // public function show()
  // {
  //   $sql = 'SELECT * FROM '. $this->table;
  //   $stmt = $this->pdo->query($sql);
  //   while ($ary = $stmt->fetchAll(PDO::FETCH_ASSOC))
  //   {
  //     foreach ($ary as $row) {
  //       foreach ($row as $key => $val) {
  //         echo $key . ' ' . $val . ' ';
  //       }
  //       echo "<br>";
  //     }
  //   }
  // }
  public function getAll()
  {
    $sql = 'SELECT * FROM ' . $this->table;
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
  public function add($post)
  {
    $sql = sprintf('INSERT INTO %s (label, status, src_user, dst_user, title, description) VALUES (?, ?, ?, ?, ?, ?) ', $this->table);
    try {
      $stmt = $this->pdo->prepare($sql);
      if (!$stmt) {
        echo $this->pdo->errorInfo();
      }
      $data = array((int)$post['label'], (int)$post['status'], $post['src_user'], $post['dst_user'], $post['title'], $post['description']);
      $res = $stmt->exectute($data);
      if (!$res) {
        echo $this->pdo->errorInfo();
      }
    }catch (PDOException $e){
      Log::m_log($e->getMessage());
      $e->getMessage();
      throw $e;
      exit;
    }

    if (!empty($this->errors))
    {
      var_dump($this->errors);
      foreach ($this->error as $error) {
        Log::m_log($error);
      }
      exit;
    }

  }
}
