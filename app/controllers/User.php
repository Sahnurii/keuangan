<?php

class User extends BaseController
{
    // protected $allowedRoles = ['Admin'];

    public function index()
    {

        if ($_SESSION['user']['role'] !== 'Admin') {
            header('Location: ' . BASEURL . '/forbidden');
            exit;
        }

        $userModel = $this->model('User_model');
        $data['users'] = $userModel->getAllUser();
        $data['judul'] = 'Manage Users';

        $this->view('templates/header', $data);
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SESSION['user']['role'] !== 'Admin') {
            header('Location: ' . BASEURL . '/forbidden');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->model('User_model')->cekUsernameDuplikat($_POST['username'])) {
                Flasher::setFlash('Username sudah digunakan.', '', 'error');
                header('Location: ' . BASEURL . '/user/tambah');
                exit;
            }

            if ($this->model('User_model')->cekIdPegawaiDuplikat($_POST['id_pegawai'])) {
                Flasher::setFlash('Pegawai sudah terdaftar sebagai user.', '', 'error');
                header('Location: ' . BASEURL . '/user/tambah');
                exit;
            }

            if ($_POST['password'] !== $_POST['confirm_password']) {
                Flasher::setFlash('Password dan konfirmasi tidak cocok.', '', 'error');
                header('Location: ' . BASEURL . '/user/tambah');
                exit;
            }

            $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

            if ($this->model('User_model')->tambahDataUser($_POST) > 0) {
                Flasher::setFlash('Berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'ditambahkan', 'error');
                header('Location: ' . BASEURL . '/user/tambah');
                exit;
            }
        }

        $data['pegawai'] = $this->model('Pegawai_model')->getPegawaiAktif();

        $data['judul'] = 'Tambah User';
        $this->view('templates/header', $data);
        $this->view('user/tambah', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        // $data['user'] = $this->model('User_model')->getUserById($id);
        $user = $this->model('User_model')->getUserById($id);
        $data['user'] = $user;

        if (!$user) {
            // Handle jika user tidak ditemukan
            Flasher::setFlash('User tidak ditemukan', '', 'danger');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
        $currentUserId = $_SESSION['user']['id'];
        $currentUserRole = $_SESSION['user']['role'];

        if ($currentUserRole !== 'Admin' && $currentUserId != $id) {
            Flasher::setFlash('Anda tidak punya akses untuk edit user ini.', '', 'error');
            header('Location: ' . BASEURL . '/user');
            exit;
        }

        $data['user'] = $user;

        // Ambil data pegawai terkait jika ada
        $data['pegawai'] = null;
        if (!empty($user['id_pegawai'])) {
            $data['pegawai'] = $this->model('Pegawai_model')->getPegawaiById($user['id_pegawai']);
        }
        $data['judul'] = 'Edit User';
        $data['pegawailist'] = $this->model('Pegawai_model')->getPegawaiAktif();
        $this->view('templates/header', $data);
        $this->view('user/edit', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($_SESSION['user']['role'] !== 'Admin') {
            header('Location: ' . BASEURL . '/forbidden');
            exit;
        }

        if ($this->model('User_model')->hapusDataUser($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/forbidden');
            exit;
        }

        $userModel = $this->model('User_model');
        $existingUser = $userModel->getUserById($id);
        $oldpassword = $existingUser['password'];

        if ($userModel->cekIdPegawaiDuplikat($_POST['id_pegawai'], $id)) {
            Flasher::setFlash('Pegawai sudah terdaftar sebagai user.', '', 'error');
            header('Location: ' . BASEURL . '/user/edit/' . $id);
            exit;
        }

        if ($_POST['username'] !== $existingUser['username']) {
            if ($userModel->cekUsernameDuplikat($_POST['username'])) {
                Flasher::setFlash('Username sudah digunakan.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $id);
                exit;
            }
        }

        $newpassword = $_POST['newPass'];
        if (!empty($newpassword)) {
            if ($newpassword !== $_POST['confirm_password']) {
                Flasher::setFlash('Password dan konfirmasi tidak cocok.', '', 'error');
                header('Location: ' . BASEURL . '/user/edit/' . $id);
                exit;
            }
            $_POST['password'] = password_hash($newpassword, PASSWORD_BCRYPT);
        } else {
            $_POST['password'] = $oldpassword;
        }

        // 💡 Tambahan validasi role
        $currentUserRole = $_SESSION['user']['role'];
        if ($currentUserRole !== 'Admin') {
            // Non-admin tidak boleh ganti role
            $_POST['role'] = $existingUser['role'];
        }
        if ($userModel->updateUser($id, $_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success');
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'error');
        }

        if ($_SESSION['user']['role'] === 'Admin') {
            header('Location: ' . BASEURL . '/user');
        } else {
            header('Location: ' . BASEURL . '/dashboard'); // atau halaman lain yang sesuai untuk user biasa
        }
        exit;
    }


    public function cekUsernameDuplikat($username)
    {
        $jumlah = $this->model('User_model')->cekUsernameDuplikat($username);
        echo json_encode(['jumlah' => $jumlah]);
    }
}
