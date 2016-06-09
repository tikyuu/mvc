<?php
class LoginModel extends ModelBase
{
  public function show()
  {
    $table = 'user';
    $sql = sprintf('SELECT * FROM %s', $table);
    $stmt = $this->pdo->query($sql);
    while ($ary = $stmt->fetchAll(PDO::FETCH_ASSOC))
    {
      foreach ($ary as $row) {
        foreach ($row as $key => $val) {
          echo $key . ' ' . $val . ' ';
        }
        echo "<br>";
      }
    }
  }
  public function check($user_id, $password)
  {
    $table = 'user';
    $sql = sprintf('SELECT id FROM %s WHERE name="%s" AND password="%s";', $table, $user_id, md5($password));
    try {
      $state = $this->pdo->query($sql);
      $res = $state->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }

    if($res) {
      return $res['id'];
    } else {
      return 0;
    }
  }
}
