<?php

class AuthMiddleware
{
    public static function isAuthenticated()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login
        if (!isset($_SESSION['user'])) {
            // Jangan redirect jika sudah di halaman login (Auth controller)
            $currentController = self::getCurrentController();
             if ($currentController !== 'Auth') {
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        }
    }

    public static function requireRole($roles = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        if (!in_array($_SESSION['user']['role'], $roles)) {
            // Jika tidak punya role yang sesuai, lempar ke halaman tidak diizinkan
            header('Location: ' . BASEURL . '/errorcontroller/index');
            exit;
        }
    }

    private static function getCurrentController()
    {
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $url = explode('/', $url);
        return $url[0] ?? 'Auth';
    }
}
