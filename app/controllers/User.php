<?php

class User extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $userModel = $this->model('User_model');
        $data['users'] = $userModel->getAllUser();
        $data['judul'] = 'Manage Users';

        $this->view('templates/header', $data);
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('User_model')->cekUsernameDuplikat($_POST['username'])) {
                Flasher::setFlash('Username sudah digunakan.', '', 'error');
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

        $data['judul'] = 'Tambah User';
        $this->view('templates/header', $data);
        $this->view('user/tambah');
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

    public function hapus($id)
    {
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
        $userModel = $this->model('User_model');
        $existingUser = $userModel->getUserById($id);
        $oldpassword = $existingUser['password'];

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

        if ($userModel->updateUser($id, $_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success');
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'error');
        }

        header('Location: ' . BASEURL . '/user');
        exit;
    }


    public function cekUsernameDuplikat($username)
    {
        $jumlah = $this->model('User_model')->cekUsernameDuplikat($username);
        echo json_encode(['jumlah' => $jumlah]);
    }
}
