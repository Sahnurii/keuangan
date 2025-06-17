<?php

class Buku_kas_umum extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $data['judul'] = 'Buku Kas Umum';

        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYearsUniversal();

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET

        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        // print_r($bulan);

        // Ambil data dari model
        $transaksi = $this->model('Transaksi_model')->getAllTransaksi($bulan, $tahun);
        // print_r($transaksiBank);

        // Ambil saldo awal untuk bulan dan tahun tertentu
        $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        $bank = $saldoBank['saldo_awal'] ?? 0;
        // print_r($saldoBank);
        $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);
        $kas = $saldoKas['saldo_awal'] ?? 0;
        // print_r($saldoKas);
        $saldoAwal = $bank + $kas;
        // print_r($saldoAwal);
        error_log(print_r($saldoAwal, true)); // Debug saldo_awal

        // Kirim data ke view
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal ?? 0; // Jika saldo tidak ditemukan, set ke 0
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('buku_kas_umum/index', $data);
        $this->view('templates/footer');
    }

    public function cetak()
    {
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');



        $data['saldo_awal'] = $saldoAwal ?? 0; // Jika saldo tidak ditemukan, set ke 0
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $this->view('buku_kas_umum/cetak');
    }
}
