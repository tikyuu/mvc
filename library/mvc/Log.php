<?php

// 適当なつくりです
class Log
{
  // type
  const UTIL = 'util';

  static private function _log($message, $type)
  {
    $path = '/var/www/html/mvc/log/' . $type . '.log';
    $dbg = debug_backtrace();
    $dbg_msg = '[' .$dbg[2]['class'] . ' ' . $dbg[2]['function'] . '] ';
    $timestamp =  '[' . date("H:i:s") . '] ';
    $msg = $timestamp . $dbg_msg . $message . "\n";

    if (file_exists($path)) {
      error_log($msg, '3', $path);
    }
    else
    {
      echo "error Log::_log";
      exit;
    }
  }
  static public function u_log($message)
  {
    Log::_log($message, Log::UTIL);
  }

}
