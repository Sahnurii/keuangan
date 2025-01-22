<?php

class User extends Controller
{
    public function __construct()
    {
        AuthMiddleware::isAuthenticated();
    }

    public function index()
    {
        $userModel = $this->model('User_model');
        $data['users'] = $userModel->getAllUser();
        $data['judul'] = 'Manage Users';

        $this->view('templates/header', $data);
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['user'] = $this->model('User_model')->getUserById($id);
        $data['judul'] = 'Edit User';

        $this->view('templates/header', $data);
        $this->view('user/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $username = trim($_POST['username']);
            $nama = trim($_POST['nama']);
            $email = trim($_POST['email']);
            $oldpassword = trim($_POST['password'] ?? '');
            $newPass = $_POST['newPass'];
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            // Validasi input nama dan email
            if (empty($nama) || empty($email)) {
                Flasher::setFlash('Nama dan email tidak boleh kosong.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $username);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Flasher::setFlash('Format email tidak valid.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $username);
                exit;
            }

            // Validasi password jika diisi
            if (!empty($newPass) && $newPass !== $confirmPassword) {
                Flasher::setFlash('Password dan konfirmasi password tidak cocok.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $username);
                exit;
            }

            $userModel = $this->model('User_model');

            // Jika password diisi, hash password-nya, jika tidak, biarkan null
            $hashedPassword = !empty($newPass) ? password_hash($newPass, PASSWORD_BCRYPT) : $oldpassword;

            $updateData = [
                'password' => $hashedPassword,
                'nama' => $nama,
                'email' => $email,
                'id' => $id
            ];

            // Lakukan update
            if ($userModel->updateUser($username, $updateData)) {
                Flasher::setFlash('User berhasil diperbarui!', '', 'success');
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            } else {
                echo "Debugging: Update query gagal.";
                exit;
                Flasher::setFlash('Gagal memperbarui user.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $username);
                exit;
            }
        }
    }
}
