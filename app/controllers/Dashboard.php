<?php

class Dashboard extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $data['judul'] = 'Dashboard';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYearsUniversal();

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        // Ambil data dari model
        $transaksi = $this->model('Transaksi_model')->getAllTransaksi($bulan, $tahun);

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        foreach ($transaksi as $trx) {
            if ($trx['tipe_kategori'] === 'Pemasukan') {
                $totalPemasukan += $trx['nominal_transaksi'];
            } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                $totalPengeluaran += $trx['nominal_transaksi'];
            }
        }

        $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);

        $saldoAwal = ($saldoBank['saldo_awal'] ?? 0) + ($saldoKas['saldo_awal'] ?? 0);

        $totalKategori = $this->model('Kategori_model')->getTotalKategori();
        $totalBidang = $this->model('Bidang_model')->getTotalBidang();
        $totalPegawai = $this->model('Pegawai_model')->getTotalPegawai();
        

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;
        $data['total_kategori'] = $totalKategori['total'];
        $data['total_bidang'] = $totalBidang['total'];
        $data['total_pegawai'] = $totalPegawai['total'];

        $data['judul'] = 'Dashboard';
        $this->view('templates/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/footer');
    }
}
