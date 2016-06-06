<?php
class TestModel extends ModelBase
{
  protected $table = "test";

  public function show()
  {
    $ary = $this->query("SELECT * FROM " . $this->table);
    foreach ($ary as $row)
    {
      echo '<form method="post" action="/Test/check">';
      echo 'id : ' . $row['id'] . ' ';
      echo 'name : ' . $row['name'] . ' ';
      echo '<input type="hidden" name="id" value="' . $row['id'] . '"></input>';
      echo '<input type="submit" name="delete" value="delete"></input>'; 
      echo '<input type="submit" name="edit" value="edit"></input>';
      echo '</form>';
    }

    // create
    echo '<form method="post" action="/Test/check">';
    echo 'name <input type="text" name="name"></input>';
    echo '<input type="submit" name="create" value="create"></input>';
    echo '</form>';
  }
  public function check($post)
  {
    if (isset($post['delete'])) {
      if (!isset($post['id'])){ echo "error"; exit; }
      $this->_delete($post['id']);
    }
    if (isset($post['edit'])) {
      if (!isset($post['id'])){ echo "error"; exit; }
      $this->_edit($post['id']);
    }
    if (isset($post['update'])) {
      if (!isset($post['name'])){ echo "error"; exit; }
      if (!isset($post['id'])){ echo "error"; exit; }
      $this->_update($post['name'], $post['id']);
    }
    if (isset($post['create'])) {
      if (!isset($post['name'])){ echo "error"; exit; }
      $this->_create($post['name']);
    }
    exit;
  }
  public function _edit($id)
  {
    $bind = array('id' => $id);
    $sql = sprintf('SELECT * FROM %s WHERE id = :id', $this->table);
    $query = $this->pdo->prepare($sql);
    $query->execute($bind);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      var_dump($sql);
      echo "失敗";
      exit;
    }

    echo '<form method="post" action="/Test/check">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '"></input>'; 
    echo 'name <input type="text" name="name" value="' . $row['name'] . '"></input>';
    echo '<input type="submit" name="update" value="update"></input>';
    echo '</form>';
  }
  public function _update($name, $id)
  {
    $bind = array('name' => $name, 'id' => $id);
    $sql = sprintf('UPDATE %s SET name = :name WHERE id = :id', $this->table);
    $query = $this->pdo->prepare($sql);
    if (!$query->execute($bind)) {
      var_dump($sql);
      echo "失敗";
      exit;
    }
    header('Location: ' . '/Test/index');
  }
  public function _create($name)
  {
    if(!$this->insert(array('name' => $name))) {
      echo "error";
      exit;
    }
    header('Location: ' . '/Test/index');
  }
  private function _delete($id)
  {
    if (!$this->delete("id = :id", array("id" => $id))) {
      echo "error";
      exit;
    }
    header('Location: '. '/Test/index');
  }
}
