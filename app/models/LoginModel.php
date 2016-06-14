<?php
class LoginModel extends ModelBase
{
  /**
   * ユーザ認証
   * @param string  $user_name 
   * @param int     $password 
   * @return int    userID [0 = 失敗]
   */
  public function check($user_name, $password)
  {
    $table = 'user';
    $sql = sprintf('SELECT id FROM %s WHERE name="%s" AND password="%s";', $table, $user_name, md5($password));
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
