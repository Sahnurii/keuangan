<?php

class Kategori extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas'];

    public function index()
    {
        $data['judul'] = 'Kategori';
        $data['ktg'] = $this->model('Kategori_model')->getAllKategori();
        $this->view('templates/header', $data);
        $this->view('kategori/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Kategori_model')->HapusDataKategori($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }

    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_kategori = $_POST['nama_kategori'];
            $tipe_kategori = $_POST['tipe_kategori'];

            // Validasi untuk mengecek duplikat data
            if ($this->model('Kategori_model')->cekKategoriDuplikat($nama_kategori, $tipe_kategori)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan nama dan tipe kategori yang sama', 'error');
                header('Location: ' . BASEURL . '/kategori');
                exit;
            }
            // Proses data POST
            if ($this->model('Kategori_model')->tambahDataKategori($_POST) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/kategori');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/kategori');
                exit;
            }
        } else {
            // Tampilkan form tambah
            $data['judul'] = 'Tambah Kategori';
            $this->view('templates/header', $data);
            $this->view('kategori/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['ktg'] = $this->model('Kategori_model')->getKategoriById($id);
        $data['judul'] = 'Edit Kategori';

        $this->view('templates/header', $data);
        $this->view('kategori/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Kategori_model')->editDataKategori($_POST) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/kategori');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/kategori');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
