<?php

class Laporan extends BaseController
{
    protected $allowedRoles = ['Admin', 'Pimpinan'];

    public function __construct()
    {
        parent::__construct();
    }

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
        $data['saldo_awal_keterangan'] = $saldoAwal['keterangan'] ?? '-'; // Default keterangan "-"
        $data['saldo_awal_tanggal'] = $saldoAwal['tanggal'] ?? '-'; // Default tanggal "-"

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
        $data['saldo_awal_keterangan'] = $saldoAwal['keterangan'] ?? '-'; // Default keterangan "-"
        $data['saldo_awal_tanggal'] = $saldoAwal['tanggal'] ?? '-'; // Default tanggal "-"

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
        // Ambil saldo awal untuk Bank dan Kas
        $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);

        // Set data saldo Bank
        $data['saldo_bank'] = $saldoBank['saldo_awal'] ?? 0; // Nilai default jika tidak ditemukan
        $data['saldo_bank_keterangan'] = $saldoBank['keterangan'] ?? '-';
        $data['saldo_bank_tanggal'] = $saldoBank['tanggal'] ?? null;

        // Set data saldo Kas
        $data['saldo_kas'] = $saldoKas['saldo_awal'] ?? 0; // Nilai default jika tidak ditemukan
        $data['saldo_kas_keterangan'] = $saldoKas['keterangan'] ?? '-';
        $data['saldo_kas_tanggal'] = $saldoKas['tanggal'] ?? null;

        // Gabungkan saldo awal
        $data['saldo_awal'] = $data['saldo_kas'] + $data['saldo_bank'];

        // Debugging data
        error_log(print_r($data, true)); // Untuk melihat apakah data sesuai dengan ekspektasi

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

        // Tambahkan data lain
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;

        // Panggil view
        $this->view('buku_kas_umum/cetak_print', $data);
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

    // public function cetakPemasukanDanPengeluaran()
    // {


    //     $data['judul'] = 'Cetak Pemasukan Dan Pengeluaran';
    //     $bulanTahun = $this->model('Transaksi_model')->getUniqueMonthsAndYearsUniversal();

    //     $groupedBulanTahun = [];
    //     foreach ($bulanTahun as $bt) {
    //         $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
    //     }

    //     $data['bulan_tahun'] = $groupedBulanTahun;

    //     // Ambil filter dari GET
    //     $tahun = $_GET['tahun'] ?? date('Y');
    //     $bulan = $_GET['bulan'] ?? date('m');

    //     // Ambil data dari model
    //     $transaksi = $this->model('Transaksi_model')->getAllTransaksi($bulan, $tahun);

    //     // Hitung total pemasukan dan pengeluaran
    //     $totalPemasukan = 0;
    //     $totalPengeluaran = 0;

    //     foreach ($transaksi as $trx) {
    //         if ($trx['tipe_kategori'] === 'Pemasukan') {
    //             $totalPemasukan += $trx['nominal_transaksi'];
    //         } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
    //             $totalPengeluaran += $trx['nominal_transaksi'];
    //         }
    //     }

    //     $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
    //     $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);

    //     $saldoAwal = ($saldoBank['saldo_awal'] ?? 0) + ($saldoKas['saldo_awal'] ?? 0);

    //     $data['tahun'] = $tahun;
    //     $data['bulan'] = $bulan;
    //     $data['transaksi'] = $transaksi;
    //     $data['saldo_awal'] = $saldoAwal;
    //     $data['total_pemasukan'] = $totalPemasukan;
    //     $data['total_pengeluaran'] = $totalPengeluaran;

    //     $this->view('templates/header', $data);
    //     $this->view('laporan/cetak_pempeng', $data);
    //     $this->view('templates/footer');
    // }

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

        // Pisahkan pemasukan dan pengeluaran
        $pemasukan = [];
        $pengeluaran = [];
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        // foreach ($transaksi as $trx) {
        //     if ($trx['tipe_kategori'] === 'Pemasukan') {
        //         $pemasukan[] = $trx;
        //         $totalPemasukan += $trx['nominal_transaksi'];
        //     } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
        //         $pengeluaran[] = $trx;
        //         $totalPengeluaran += $trx['nominal_transaksi'];
        //     }
        // }

        foreach ($transaksi as $trx) {
            if ($trx['tipe_kategori'] === 'Pemasukan') {
                if (!isset($pemasukan[$trx['kategori']])) {
                    $pemasukan[$trx['kategori']] = 0; // Inisialisasi kategori
                }
                $pemasukan[$trx['kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPemasukan += $trx['nominal_transaksi'];
            } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                if (!isset($pengeluaran[$trx['kategori']])) {
                    $pengeluaran[$trx['kategori']] = 0; // Inisialisasi kategori
                }
                $pengeluaran[$trx['kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPengeluaran += $trx['nominal_transaksi'];
            }
        }


        // Ambil saldo awal
        $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);
        $saldoAwal = ($saldoBank['saldo_awal'] ?? 0) + ($saldoKas['saldo_awal'] ?? 0);

        // Data yang dikirim ke view
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;
        $data['rincian_pemasukan'] = $pemasukan;
        $data['rincian_pengeluaran'] = $pengeluaran;

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

        // Pisahkan pemasukan dan pengeluaran
        $pemasukan = [];
        $pengeluaran = [];
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        foreach ($transaksi as $trx) {
            if ($trx['tipe_kategori'] === 'Pemasukan') {
                if (!isset($pemasukan[$trx['kategori']])) {
                    $pemasukan[$trx['kategori']] = 0; // Inisialisasi kategori
                }
                $pemasukan[$trx['kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPemasukan += $trx['nominal_transaksi'];
            } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                if (!isset($pengeluaran[$trx['kategori']])) {
                    $pengeluaran[$trx['kategori']] = 0; // Inisialisasi kategori
                }
                $pengeluaran[$trx['kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPengeluaran += $trx['nominal_transaksi'];
            }
        }


        // Ambil saldo awal
        $saldoBank = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Bank', $bulan, $tahun);
        $saldoKas = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Kas', $bulan, $tahun);
        $saldoAwal = ($saldoBank['saldo_awal'] ?? 0) + ($saldoKas['saldo_awal'] ?? 0);

        // Data yang dikirim ke view
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['saldo_awal'] = $saldoAwal;
        $data['total_pemasukan'] = $totalPemasukan;
        $data['total_pengeluaran'] = $totalPengeluaran;
        $data['rincian_pemasukan'] = $pemasukan;
        $data['rincian_pengeluaran'] = $pengeluaran;


        $this->view('laporan/cetak_pempeng_print', $data);
    }
}
