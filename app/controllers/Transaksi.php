<?php

class Transaksi extends Controller
{
    public function __construct()
    {
        AuthMiddleware::isAuthenticated();
    }

    public function index()
    {
        $data['judul'] = 'Transaksi';
        $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
        $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');

        // Menyertakan data ke view
        $this->view('templates/header', $data);
        $this->view('transaksi/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'tipe_buku' => $_POST['tipe_buku'],
            'tanggal' => $_POST['tanggal'],
            'no_bukti' => $_POST['no_bukti'],
            'keterangan' => $_POST['keterangan'],
            'tipe_kategori' => $_POST['tipe_kategori'],
            'nama_kategori' => $_POST['nama_kategori'],
            'nominal_transaksi' => $_POST['nominal_transaksi'],
        ];

        if ($this->model('Transaksi_model')->tambahDataTransaksi($data)) {

            Flasher::setFlash('Berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        }
    }

    public function hapusKas($id)
    {
        if ($this->model('Transaksi_model')->hapusDataTransaksi($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/buku_kas');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/buku_kas');
            exit;
        }
    }
    public function hapusBank($id)
    {
        if ($this->model('Transaksi_model')->hapusDataTransaksi($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/buku_bank');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/buku_bank');
            exit;
        }
    }

    public function getNomorBukti($tipe_buku, $tanggal)
    {
        $tanggalExploded = explode('-', $tanggal);
        $bulan = $tanggalExploded[1];
        $tahun = $tanggalExploded[0];

        $nomorBukti = $this->model('Transaksi_model')->getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun);

        echo $nomorBukti;
    }
}
