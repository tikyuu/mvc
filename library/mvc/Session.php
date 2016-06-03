<?php

class Session
{
    const LOGIN_URL = "/Login/login";

    static public function check()
    {
        session_start();
        session_regenerate_id(true);
        return isset($_SESSION['login']);
    }
    static public function login()
    {
        session_start();
        $_SESSION['login'] = 1;
    }
    static public function logout()
    {
        // セッションを空にする
        $_SESSION = array();
        
        // クッキーを削除する
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        @session_destroy();
    }
}