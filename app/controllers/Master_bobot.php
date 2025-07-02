<?php

class Master_bobot extends BaseController
{
    protected $allowedRoles = ['Admin'];

    public function index()
    {
        $data['judul'] = 'Master Bobot Masa Kerja';
        $data['bobot_kerja'] = $this->model('Master_bobot_model')->getAllBobot();
        $this->view('templates/header', $data);
        $this->view('master_bobot/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'klasifikasi' => trim($_POST['klasifikasi']),
                'bobot' => trim($_POST['bobot']),
            ];

             $klasifikasi = $_POST['klasifikasi'];

            // Validasi untuk mengecek duplikat data
            if ($this->model('Master_bobot_model')->cekBobotDuplikat($klasifikasi)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan Klasifikasi yang sama', 'error');
                header('Location: ' . BASEURL . '/master_bobot');
                exit;
            }

            if ($this->model('Master_bobot_model')->tambahBobot($data) > 0) {
                Flasher::setFlash('Tambah Bobot Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Tambah Bobot Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/master_bobot');
            exit;
        }

        $data['judul'] = 'Tambah Bobot Masa Kerja';
        $this->view('templates/header', $data);
        $this->view('master_bobot/tambah', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['bobot_kerja'] = $this->model('Master_bobot_model')->getBobotById($id);
        $data['judul'] = 'Edit Bobot Masa Kerja';
        $this->view('templates/header', $data);
        $this->view('master_bobot/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'klasifikasi' => trim($_POST['klasifikasi']),
                'bobot' => trim($_POST['bobot']),
            ];

            if ($this->model('Master_bobot_model')->updateBobot($data) > 0) {
                Flasher::setFlash('Update Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Update Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/master_bobot');
            exit;
        }
    }

    public function hapus($id)
    {
        if ($this->model('Master_bobot_model')->hapusBobot($id) > 0) {
            Flasher::setFlash('Hapus Berhasil', '', 'success');
        } else {
            Flasher::setFlash('Hapus Gagal', '', 'error');
        }

        header('Location: ' . BASEURL . '/master_bobot');
        exit;
    }
}
