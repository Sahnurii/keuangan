<?php

class Buku_bank extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $data['judul'] = 'Buku Bank';

        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYears('Bank');

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET

        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        // print_r($bulan);

        // Ambil data transaksi Buku Bank
        $transaksiBank = $this->model('Transaksi_model')->getTransaksiByTipeBuku('Bank', $bulan, $tahun);
        // print_r($transaksiBank);

        // Ambil saldo awal untuk bulan dan tahun tertentu
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        // print_r($saldoAwal);
        error_log(print_r($saldoAwal, true)); // Debug saldo_awal

        // Kirim data ke view
        $data['transaksi'] = $transaksiBank;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0; // Jika saldo tidak ditemukan, set ke 0
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('buku_bank/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['Bank'] = $this->model('Transaksi_model')->getTransaksiById($id);
        $data['judul'] = 'Edit Bank';

        $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
        $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');

        $this->view('templates/header', $data);
        $this->view('buku_bank/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Transaksi_model')->editDataTransaksi($_POST) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/buku_bank');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/buku_bank');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
