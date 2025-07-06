<?php

class Auth extends Controller
{
    public function index()
    {

        $this->view('auth/index');
    }

    public function process()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

            // Ambil user berdasarkan username atau email
            $user = $this->model('User_model')->getUserByUsername($username);

            if (!$user) {
                // Jika user tidak ditemukan, kirim pesan error
                Flasher::setFlash('Login Gagal', 'User tidak ditemukan', 'error');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            // Verifikasi password dengan hash
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'id_pegawai' => $user['id_pegawai']
                ];

                Flasher::setFlash('Login Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            } else {
                // Password salah
                Flasher::setFlash('Login Gagal', 'Username atau password salah', 'error');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        }
    }


    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}
