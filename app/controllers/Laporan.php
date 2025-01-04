<?php

class Laporan extends Controller
{
    public function index()
    {

        $data['judul'] = 'Cetak Buku Kas';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYears('Kas');

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        $transaksiKas = $this->model('Transaksi_model')->getTransaksiByTipeBuku('Kas', $bulan, $tahun);
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksiKas;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0; // 
        $this->view('templates/header', $data);
        $this->view('buku_kas/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetak_print()
    {
        $data['judul'] = 'Cetak Buku Kas';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYears('Kas');

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        $transaksiKas = $this->model('Transaksi_model')->getTransaksiByTipeBuku('Kas', $bulan, $tahun);
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksiKas;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0; // 

        $this->view('buku_kas/cetak_print', $data);
    }

    public function cetakBank()
    {

        $data['judul'] = 'Cetak Buku Bank';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYears('Bank');

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        $transaksiBank = $this->model('Transaksi_model')->getTransaksiByTipeBuku('Bank', $bulan, $tahun);
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksiBank;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0; // 
        $this->view('templates/header', $data);
        $this->view('buku_bank/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetakBank_print()
    {
        $data['judul'] = 'Cetak Buku Bank';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYears('Bank');

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }

        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
        $transaksiBank = $this->model('Transaksi_model')->getTransaksiByTipeBuku('Bank', $bulan, $tahun);
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksiBank;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0; // 

        $this->view('buku_bank/cetak_print', $data);
    }

    public function cetakKasUmum()
    {

        $data['judul'] = 'Cetak Buku Kas Umum';
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


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal ?? 0; // 
        $this->view('templates/header', $data);
        $this->view('buku_kas_umum/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetakKasUmum_print()
    {
        $data['judul'] = 'Cetak Buku Kas Umum';
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


        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal ?? 0;

        $this->view('buku_bank/cetak_print', $data);
    }

    public function cetakSaldo()
{
    $data['judul'] = 'Cetak Saldo';
    $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYearsUniversal();

    $groupedBulanTahun = [];
    foreach ($bulanTahun as $bt) {
        $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
    }

    $data['bulan_tahun'] = $groupedBulanTahun;

    // Ambil filter dari GET
    $tahun = $_GET['tahun'] ?? date('Y');
    $bulan = $_GET['bulan'] ?? date('m');

    // Ambil data saldo awal
    $saldoAwalBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun)['saldo_awal'] ?? 0;
    $saldoAwalKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun)['saldo_awal'] ?? 0;
    $saldoAwalKasUmum = $saldoAwalBank + $saldoAwalKas;

    // Ambil transaksi
    $transaksi = $this->model('Transaksi_model')->getAllTransaksi($bulan, $tahun);

    // Hitung saldo akhir berdasarkan tipe buku
    $saldoBank = $saldoAwalBank;
    $saldoKas = $saldoAwalKas;
    $saldoKasUmum = $saldoAwalKasUmum;

    foreach ($transaksi as $trx) {
        if ($trx['tipe_buku'] === 'Bank') {
            $saldoBank += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
        } elseif ($trx['tipe_buku'] === 'Kas') {
            $saldoKas += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
        }
        $saldoKasUmum += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
    }

    // Simpan hasil ke dalam $data
    $data['saldo_akhir'] = [
        'Bank' => $saldoBank,
        'Kas' => $saldoKas,
        'Kas Umum' => $saldoKasUmum,
    ];

    $data['tahun'] = $tahun;
    $data['bulan'] = $bulan;
    $data['transaksi'] = $transaksi;

    $this->view('templates/header', $data);
    $this->view('laporan/cetak_saldo', $data);
    $this->view('templates/footer');
}


    public function cetakSaldo_print()
    {
        $data['judul'] = 'Cetak Saldo';
        $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYearsUniversal();
    
        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
    
        $data['bulan_tahun'] = $groupedBulanTahun;
    
        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');
    
        // Ambil data saldo awal
        $saldoAwalBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun)['saldo_awal'] ?? 0;
        $saldoAwalKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun)['saldo_awal'] ?? 0;
        $saldoAwalKasUmum = $saldoAwalBank + $saldoAwalKas;
    
        // Ambil transaksi
        $transaksi = $this->model('Transaksi_model')->getAllTransaksi($bulan, $tahun);
    
        // Hitung saldo akhir berdasarkan tipe buku
        $saldoBank = $saldoAwalBank;
        $saldoKas = $saldoAwalKas;
        $saldoKasUmum = $saldoAwalKasUmum;
    
        foreach ($transaksi as $trx) {
            if ($trx['tipe_buku'] === 'Bank') {
                $saldoBank += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
            } elseif ($trx['tipe_buku'] === 'Kas') {
                $saldoKas += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
            }
            $saldoKasUmum += $trx['tipe_kategori'] === 'Pemasukan' ? $trx['nominal_transaksi'] : -$trx['nominal_transaksi'];
        }
    
        // Simpan hasil ke dalam $data
        $data['saldo_akhir'] = [
            'Bank' => $saldoBank,
            'Kas' => $saldoKas,
            'Kas Umum' => $saldoKasUmum,
        ];
    
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
    

        $this->view('laporan/cetak_saldo_print', $data);
    }

    public function cetakPemasukanDanPengeluaran()
    {


        $data['judul'] = 'Cetak Pemasukan Dan Pengeluaran';
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

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;

        $this->view('templates/header', $data);
        $this->view('laporan/cetak_pempeng', $data);
        $this->view('templates/footer');
    }

    public function cetakPemasukanDanPengeluaran_print()
    {

        $data['judul'] = 'Cetak Pemasukan Dan Pengeluaran';
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

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;


        $this->view('laporan/cetak_pempeng_print', $data);
    }
}
