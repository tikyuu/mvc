<?php
class ModelBase
{
  protected $pdo;

  public function __construct($conf = null)
  {
    $this->initDb($conf);
  }
  private function initDb($conf)
  {
    $this->pdo = DB::connect($conf);
    if (is_null($this->pdo)){ exit(); }
  }

  public function query($sql, array $params = array())
  {
    $stmt = $this->pdo->prepare($sql);
    if ($params != null)
    {
      foreach ($params as $key => $val) {
        $stmt->bindValue(':' . $key, $val);
      }
    }
    if (!$stmt->execute()) {
      echo "error";
      exit;
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }

  // return: "(filed) VALUES (bind)"
  public function bindString($data)
  {
    $fields = array();
    $values = array();
    foreach ($data as $key => $value) {
      $fields[] = $key;
      $values[] = ':' . $key;
    }
    return sprintf("(%s) VALUES (%s)", implode(',', $fields), implode(',', $values));
  }
  // public function insert($data)
  // {
  //   $fields = array();
  //   $values = array();
  //   foreach ($data as $key => $val) {
  //     $fields[] = $key;
  //     $values[] = ':' . $key;
  //   }
  //   $sql = sprintf(
  //     "INSERT INTO %s (%s) VALUES (%s)",
  //     $this->table,
  //     implode(',', $fields),
  //     implode(',', $values)
  //     );

  //   $stmt = $this->pdo->prepare($sql);
  //   foreach ($data as $key => $val) {
  //     $stmt->bindValue(':' . $key, $val);
  //   }
  //   $res = $stmt->execute();
  //   return $res;
  // }
  // public function delete($where, $params = null)
  // {
  //   $sql  = sprintf("DELETE FROM %s", $this->table);
  //   if ($where != "")
  //   {
  //     $sql .= " WHERE "  . $where;
  //   }
  //   $stmt = $this->pdo->prepare($sql);
  //   if ($params != null) {
  //     foreach ($params as $key => $val) {
  //       $stmt->bindValue(':' . $key, $val);
  //     }
  //   }
  //   $res = $stmt->execute();

  //   return $res;
  // }
}
