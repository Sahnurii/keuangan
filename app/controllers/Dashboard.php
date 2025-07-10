<?php

class Dashboard extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $role = $_SESSION['user']['role'];
        $idPegawai = $_SESSION['user']['id_pegawai'];

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

        $pengajuanByStatus = [
            'diajukan' => 0,
            'diterima' => 0,
            'ditolak'  => 0
        ];

        // ADMIN: Semua data
        if ($role === 'Admin') {
            $totalPengajuan = $this->model('Pengajuan_anggaran_model')->getTotalPengajuan();
            $rekapPengajuan = $this->model('Pengajuan_anggaran_model')->getRekapTotalPengajuanByStatus();
            foreach ($rekapPengajuan as $item) {
                $status = strtolower($item['status']);
                if (isset($pengajuanByStatus[$status])) {
                    $pengajuanByStatus[$status] = $item['total'];
                }
            }
            $data['total_pengajuan'] = $totalPengajuan['total'];
        }

        // PIMPINAN: Rekap per status
        elseif ($role === 'Pimpinan') {
            $rekapPengajuan = $this->model('Pengajuan_anggaran_model')->getRekapTotalPengajuanByStatus();
            foreach ($rekapPengajuan as $item) {
                $status = strtolower($item['status']);
                if (isset($pengajuanByStatus[$status])) {
                    $pengajuanByStatus[$status] = $item['total'];
                }
            }
            $data['total_pengajuan'] = array_sum($pengajuanByStatus);
        }

        // PETUGAS & PEGAWAI: Berdasarkan user_id sendiri
        else {
            $rekapUser = $this->model('Pengajuan_anggaran_model')->getRekapByPegawai($idPegawai);
            foreach ($rekapUser as $item) {
                $status = strtolower($item['status']);
                if (isset($pengajuanByStatus[$status])) {
                    $pengajuanByStatus[$status] = $item['total'];
                }
            }
            $data['total_pengajuan'] = array_sum($pengajuanByStatus);
        }

        $data['pengajuan'] = $pengajuanByStatus;


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;
        $data['total_kategori'] = $totalKategori['total'];
        $data['total_bidang'] = $totalBidang['total'];
        $data['total_pegawai'] = $totalPegawai['total'];

        $data['grafik_bulanan'] = $this->model('Transaksi_model')->getSummaryBulanan($tahun);
        $data['komposisi_pemasukan'] = $this->model('Transaksi_model')->getKomposisiPemasukan($bulan, $tahun);
        $data['komposisi_pengeluaran'] = $this->model('Transaksi_model')->getKomposisiPengeluaran($bulan, $tahun);

        $data['judul'] = 'Dashboard';
        $this->view('templates/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/footer');
    }
}
