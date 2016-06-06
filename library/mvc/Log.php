<?php

// 適当なつくりです
class Log
{
  // type
  const MODEL = 'model';
  const VIEW = 'view';
  const CONTROLLER = 'controller';

  static public function _log($message, $type)
  {
    $path = '/var/www/html/mvc/log/' . $type . '.log';
    if (file_exists($path)) {
      error_log($message, '3', $path);
    }
    else
    {
      // なんかできなかったっす。
      touch($path);
    }
  }
  static public function m_log($message)
  {
    Log::_log($message, Log::MODEL);
  }
  static public function v_log($message)
  {
    Log::_log($message, Log::VIEW);
  }
  static public function c_log($message) 
  {
    Log::_log($message, Log::CONTROLLER);
  }
}
