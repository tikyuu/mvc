<?php
class DB
{
  static private $conf = array(
    "host" => "localhost",
    "dbname" => "bug_track",
    "user" => "arakaki",
    "password" => "arakaki"
  );
  static public function connect($conf)
  {
    $t_conf = DB::$conf;
    foreach ($conf as $key => $val)
    {
      if (isset(DB::$conf[$key]))
      {
        $t_conf[$key] = $val;
      }
    }
    $dsn = sprintf(
      'mysql:host=%s;dbname=%s;port=3306;',
      $t_conf['host'],
      $t_conf['dbname']
    );

    try
    {
      return new PDO($dsn, $t_conf['user'], $t_conf['password'],
        array(PDO::MYSQL_ATTR_READ_DEFAULT_FILE => '/etc/my.cnf'));
    }
    catch (PDOException $e)
    {
        echo 'Connection failed: ' . $e->getMessage();
        return null;
    }
  }
}
