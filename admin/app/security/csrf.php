<?php
class Csrf
{
    public static function get()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['token'];
    }

    public static function validate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_POST['token'])) {
            return false;
        }
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
            return true;
        }
        return false;
    }
}
