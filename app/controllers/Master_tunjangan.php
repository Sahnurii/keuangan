<?php

class Master_tunjangan extends BaseController
{
    protected $allowedRoles = ['Admin'];

    public function index()
    {
        $data['judul'] = 'Master Tunjangan Pendidikan';
        $data['tunjangan'] = $this->model('Tunjangan_model')->getAllTunjangan();
        $this->view('templates/header', $data);
        $this->view('master_tunjangan/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'jenjang' => trim($_POST['jenjang']),
                'nominal' => trim($_POST['nominal']),
            ];

            $jenjang = $_POST['jenjang'];

            // Validasi untuk mengecek duplikat data
            if ($this->model('Tunjangan_model')->cekJenjangDuplikat($jenjang)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan Jenjang yang sama', 'error');
                header('Location: ' . BASEURL . '/master_tunjangan');
                exit;
            }

            if ($this->model('Tunjangan_model')->tambahTunjangan($data) > 0) {
                Flasher::setFlash('Tambah Tunjangan Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Tambah Tunjangan Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/master_tunjangan');
            exit;
        }

        $data['judul'] = 'Tambah Tunjangan Pendidikan';
        $this->view('templates/header', $data);
        $this->view('master_tunjangan/tambah', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['tunjangan'] = $this->model('Tunjangan_model')->getTunjanganById($id);
        $data['judul'] = 'Edit Tunjangan Pendidikan';
        $this->view('templates/header', $data);
        $this->view('master_tunjangan/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'jenjang' => trim($_POST['jenjang']),
                'nominal' => trim($_POST['nominal']),
            ];

            if ($this->model('Tunjangan_model')->updateTunjangan($data) > 0) {
                Flasher::setFlash('Update Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Update Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/master_tunjangan');
            exit;
        }
    }

    public function hapus($id)
    {
        if ($this->model('Tunjangan_model')->hapusTunjangan($id) > 0) {
            Flasher::setFlash('Hapus Berhasil', '', 'success');
        } else {
            Flasher::setFlash('Hapus Gagal', '', 'error');
        }

        header('Location: ' . BASEURL . '/master_tunjangan');
        exit;
    }
}
