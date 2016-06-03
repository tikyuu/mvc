<?php
class ModelBase
{
  protected $pdo;
  protected $table;

  public function __construct($conf = null)
  {
    $this->initDb($conf);
  }
  private function initDb($conf)
  {
    $this->pdo = DB::connect($conf);
    if (is_null($this->pdo)){ exit(); }
  }
}
