<?php
class LoginModel extends ModelBase
{
  protected $table = "user";

  public function show()
  {
    $sql = 'SELECT * FROM '. $this->table;
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
    $sql = sprintf('SELECT id FROM %s WHERE name="%s" AND password="%s";', $this->table, $user_id, $password);
    try {
      $stmt = $this->pdo->query($sql);
      $res = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $e->getMessage();
      exit;
    }

    return $res;
  }
}
