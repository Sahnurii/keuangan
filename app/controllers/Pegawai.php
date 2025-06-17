<?php

class Pegawai extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $data['judul'] = 'Pegawai';
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawai();
        $this->view('templates/header', $data);
        $this->view('pegawai/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Pegawai_model')->hapusPegawai($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        }
    }

    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nipy = $_POST['nipy'];

            // Validasi untuk mengecek duplikat data
            if ($this->model('Pegawai_model')->cekNipyDuplikat($nipy)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan NIPY yang sama', 'error');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            }
            // Proses data POST
            if ($this->model('Pegawai_model')->tambahPegawai($_POST) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            }
        } else {
            // Tampilkan form tambah
            $data['judul'] = 'Tambah Pegawai';
            $data['bidang'] = $this->model('Bidang_model')->getAllBidang();
            $this->view('templates/header', $data);
            $this->view('pegawai/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['pegawai'] = $this->model('Pegawai_model')->getPegawaiById($id);
        $data['judul'] = 'Edit Pegawai';
        $data['bidang'] = $this->model('Bidang_model')->getAllBidang();
        $this->view('templates/header', $data);
        $this->view('pegawai/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        $id = $_POST['id'];
        $nipy = $_POST['nipy'];
        if ($this->model('Pegawai_model')->cekNipyDuplikat($nipy, $id)) {
            Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan NIPY yang sama', 'error');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Pegawai_model')->editPegawai($_POST) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
