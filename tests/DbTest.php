<?php
use PHPUnit\Framework\TestCase;

class DbTest extends TestCase
{
    public function test_path()
    {
        if (!file_exists(LIB_PATH)) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
        // $this->assertTrue(false);
    }
    public function test_db_connect()
    {
        // $db = new PDO('mysql:host-localhost;dbname=bug_track;port=3306;');
        $db = DB::connect();

    }
}
