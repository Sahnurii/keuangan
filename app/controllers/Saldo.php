<?php

class Saldo extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas'];

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
                Flasher::setFlash('Tambah Data Gagal', 'Saldo untuk tipe buku ini di bulan yang sama sudah ada.', 'error');
                header('Location: ' . BASEURL . '/saldo/tambah');
                exit;
            }

            // Proses tambah saldo jika tidak duplikat
            if ($this->model('Saldo_model')->tambahDataSaldo($_POST) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
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
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/saldo');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
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
                Flasher::setFlash('Ubah Data Gagal', 'Saldo untuk tipe buku ini di bulan yang sama sudah ada.', 'error');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            }

            // Proses update saldo jika tidak ada duplikasi
            if ($this->model('Saldo_model')->editDataSaldo($_POST) > 0) {
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            } else {
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/saldo');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }

    public function getSaldoSebelumnya()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipe = $_POST['tipe_buku'];
            $tanggal = $_POST['tanggal']; // Format: YYYY-MM-DD
            list($tahun, $bulan, $tgl) = explode('-', $tanggal);

            // Langsung kirim bulan dan tahun inputan ke model
            $saldoAkhir = $this->model('Saldo_model')->getSaldoAkhirBulanSebelumnya($tipe, $bulan, $tahun);

            // Berikan response JSON
            echo json_encode(['saldo_akhir' => $saldoAkhir]);
        }
    }
}
