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
    static public function login($id, $name)
    {
        session_start();
        $_SESSION['login'] = $id;
        $_SESSION['name'] = $name;
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
    static public function getID()
    {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        } else {
            return 0;
        }
    }
    static public function getName()
    {
        if (isset($_SESSION['name'])) {
            return $_SESSION['name'];
        } else {
            echo "セッション失敗<br>";
            exit;
        }
    }
}