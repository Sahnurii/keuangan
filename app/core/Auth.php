<?php
class Auth {
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setSession($key, $value) {
        self::startSession();
        $_SESSION[$key] = $value;
    }

    public static function getSession($key) {
        self::startSession();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function logout() {
        self::startSession();
        session_unset();
        session_destroy();
    }
}
