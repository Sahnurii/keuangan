<?php

class Saldo extends Controller
{
    public function index()
    {
        $data['judul'] = 'Saldo';
        $data['sldo'] = $this->model('Saldo_model')->getAllSaldo();
        $this->view('templates/header', $data);
        $this->view('saldo/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggalExploded = explode('-', $_POST['tanggal']);
            $bulan = $tanggalExploded[1];
            $tahun = $tanggalExploded[0];

            // Periksa duplikasi saldo
            if ($this->model('Saldo_model')->cekSaldoDuplikat($_POST['tipe_buku'], $bulan, $tahun)) {
                Flasher::setFlash('gagal', 'ditambahkan. Saldo untuk tipe buku ini di bulan yang sama sudah ada.', 'danger');
                header('Location: ' . BASEURL . '/saldo/tambah');
                exit;
            }

            // Proses tambah saldo jika tidak duplikat
            if ($this->model('Saldo_model')->tambahDataSaldo($_POST) > 0) {
                Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            } else {
                Flasher::setFlash('gagal', 'ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            }
        } else {
            $data['judul'] = 'Tambah Saldo';
            $this->view('templates/header', $data);
            $this->view('saldo/tambah', $data);
            $this->view('templates/footer');
        }
    }


    public function hapus($id)
    {
        if ($this->model('Saldo_model')->hapusDataSaldo($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/saldo');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/saldo');
            exit;
        }
    }

    public function edit($id)
    {
        $data['saldo'] = $this->model('Saldo_model')->getSaldoById($id);
        $data['judul'] = 'Edit Saldo';

        $this->view('templates/header', $data);
        $this->view('saldo/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggalExploded = explode('-', $_POST['tanggal']);
            $bulan = $tanggalExploded[1];
            $tahun = $tanggalExploded[0];

            // Periksa duplikasi saldo saat edit
            if ($this->model('Saldo_model')->cekSaldoDuplikatEdit($_POST['id'], $_POST['tipe_buku'], $bulan, $tahun)) {
                Flasher::setFlash('gagal', 'diubah. Saldo untuk tipe buku ini di bulan yang sama sudah ada.', 'danger');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            }

            // Proses update saldo jika tidak ada duplikasi
            if ($this->model('Saldo_model')->editDataSaldo($_POST) > 0) {
                Flasher::setFlash('berhasil', 'diubah', 'success');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            } else {
                Flasher::setFlash('gagal', 'diubah', 'danger');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
