<?php

class Jenis_pajak extends BaseController
{
    protected $allowedRoles = ['Admin'];

    public function index()
    {
        $data['judul'] = 'Jenis Pajak';
        $data['jenis_pajak'] = $this->model('Jenis_model')->getAllJenisPajak();
        $this->view('templates/header', $data);
        $this->view('jenis_pajak/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Jenis_model')->HapusDataJenisPajak($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/jenis_pajak');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/jenis_pajak');
            exit;
        }
    }

    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarif_pajak = $_POST['tarif_pajak'];

            // Validasi untuk mengecek duplikat data
            if ($this->model('Jenis_model')->cekJenisPajakDuplikat($tarif_pajak)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan Tarif Pajak yang sama', 'error');
                header('Location: ' . BASEURL . '/jenis_pajak');
                exit;
            }


            // Proses data POST
            if ($this->model('Jenis_model')->tambahDataJenisPajak($_POST) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/jenis_pajak');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/jenis_pajak');
                exit;
            }
        } else {
            // Tampilkan form tambah
            $data['judul'] = 'Tambah Jenis Pajak';
            $this->view('templates/header', $data);
            $this->view('jenis_pajak/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['jenis_pajak'] = $this->model('Jenis_model')->getJenisPajakById($id);
        $data['judul'] = 'Edit Jenis Pajak';

        $this->view('templates/header', $data);
        $this->view('jenis_pajak/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Jenis_model')->editDataJenisPajak($_POST) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/jenis_pajak');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/jenis_pajak');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
