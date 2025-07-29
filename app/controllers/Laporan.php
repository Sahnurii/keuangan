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

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
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

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
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
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
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
        $saldoAwalPajak = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Pajak', $bulan, $tahun)['saldo_awal'] ?? 0;
        $transaksiPajak = $this->model('Pajak_model')->getTransaksiPajakLengkap($bulan, $tahun);

        $saldoPajak = $saldoAwalPajak;
        foreach ($transaksiPajak as $trx) {
            $tipeKat = $trx['tipe_kategori']; // Pemasukan / Pengeluaran
            $nilai = (float)$trx['nilai_pajak'];
            if ($tipeKat === 'Pemasukan') {
                $saldoPajak += $nilai;
            } elseif ($tipeKat === 'Pengeluaran') {
                $saldoPajak -= $nilai;
            }
        }

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
            'Pajak' => $saldoPajak,
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
        $saldoAwalPajak = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Pajak', $bulan, $tahun)['saldo_awal'] ?? 0;
        $transaksiPajak = $this->model('Pajak_model')->getTransaksiPajakLengkap($bulan, $tahun);

        $saldoPajak = $saldoAwalPajak;
        foreach ($transaksiPajak as $trx) {
            $tipeKat = $trx['tipe_kategori']; // Pemasukan / Pengeluaran
            $nilai = (float)$trx['nilai_pajak'];
            if ($tipeKat === 'Pemasukan') {
                $saldoPajak += $nilai;
            } elseif ($tipeKat === 'Pengeluaran') {
                $saldoPajak -= $nilai;
            }
        }
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
            'Pajak' => $saldoPajak,
        ];

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['transaksi'] = $transaksi;

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
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
                if (!isset($pemasukan[$trx['nama_kategori']])) {
                    $pemasukan[$trx['nama_kategori']] = 0; // Inisialisasi nama_kategori
                }
                $pemasukan[$trx['nama_kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPemasukan += $trx['nominal_transaksi'];
            } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                if (!isset($pengeluaran[$trx['nama_kategori']])) {
                    $pengeluaran[$trx['nama_kategori']] = 0; // Inisialisasi nama_kategori
                }
                $pengeluaran[$trx['nama_kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
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
                if (!isset($pemasukan[$trx['nama_kategori']])) {
                    $pemasukan[$trx['nama_kategori']] = 0; // Inisialisasi nama_kategori
                }
                $pemasukan[$trx['nama_kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
                $totalPemasukan += $trx['nominal_transaksi'];
            } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                if (!isset($pengeluaran[$trx['nama_kategori']])) {
                    $pengeluaran[$trx['nama_kategori']] = 0; // Inisialisasi nama_kategori
                }
                $pengeluaran[$trx['nama_kategori']] += $trx['nominal_transaksi']; // Tambahkan nominal ke kategori
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

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
        $this->view('laporan/cetak_pempeng_print', $data);
    }

    public function cetakPajak()
    {

        $data['judul'] = 'Cetak Buku Pajak';

        // Ambil daftar bulan & tahun unik dari tabel transaksi_pajak
        $bulanTahun = $this->model('Pajak_model')->getUniqueMonthsAndYears();
        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil bulan & tahun dari GET (atau default ke sekarang)
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        $raw = $this->model('Pajak_model')->getTransaksiPajakLengkap($bulan, $tahun);

        // GROUP per no_bukti
        $transaksiGroup = [];
        foreach ($raw as $row) {
            $no = $row['no_bukti'];
            if (!isset($transaksiGroup[$no])) {
                $transaksiGroup[$no] = [
                    'id' => $row['id'],
                    'tipe_buku' => $row['tipe_buku'],
                    'tanggal' => $row['tanggal'],
                    'no_bukti' => $row['no_bukti'],
                    'keterangan' => $row['keterangan'],
                    'pajak' => [
                        'PPN' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh21' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh22' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh23' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'Pph4(2)Final' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                    ]
                ];
            }

            $tipePajak = $row['tipe_pajak'];
            $tipeKat = $row['tipe_kategori'];
            if (isset($transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat])) {
                $transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat] += (float)$row['nilai_pajak'];
            }
        }

        // Ambil saldo awal untuk bulan dan tahun tertentu
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Pajak', $bulan, $tahun);
        // print_r($saldoAwal);
        error_log(print_r($saldoAwal, true)); // Debug saldo_awal


        $saldo = $saldoAwal['saldo_awal'] ?? 0;

        foreach ($transaksiGroup as &$trx) {
            $totalPemasukan = 0;
            $totalPengeluaran = 0;

            foreach ($trx['pajak'] as $jenis => $nilai) {
                $totalPemasukan += $nilai['Pemasukan'];
                $totalPengeluaran += $nilai['Pengeluaran'];
            }

            $saldo += ($totalPemasukan - $totalPengeluaran);

            $trx['total_pemasukan'] = $totalPemasukan;
            $trx['total_pengeluaran'] = $totalPengeluaran;
            $trx['saldo'] = $saldo;
        }


        $data['transaksi'] = array_values($transaksiGroup);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('buku_pajak/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetakPajak_print()
    {
        $data['judul'] = 'Cetak Buku Pajak';

        // Ambil daftar bulan & tahun unik dari tabel transaksi_pajak
        $bulanTahun = $this->model('Pajak_model')->getUniqueMonthsAndYears();
        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil bulan & tahun dari GET (atau default ke sekarang)
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        $raw = $this->model('Pajak_model')->getTransaksiPajakLengkap($bulan, $tahun);

        // GROUP per no_bukti
        $transaksiGroup = [];
        foreach ($raw as $row) {
            $no = $row['no_bukti'];
            if (!isset($transaksiGroup[$no])) {
                $transaksiGroup[$no] = [
                    'id' => $row['id'],
                    'tipe_buku' => $row['tipe_buku'],
                    'tanggal' => $row['tanggal'],
                    'no_bukti' => $row['no_bukti'],
                    'keterangan' => $row['keterangan'],
                    'pajak' => [
                        'PPN' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh21' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh22' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh23' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'Pph4(2)Final' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                    ]
                ];
            }

            $tipePajak = $row['tipe_pajak'];
            $tipeKat = $row['tipe_kategori'];
            if (isset($transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat])) {
                $transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat] += (float)$row['nilai_pajak'];
            }
        }

        // Ambil saldo awal untuk bulan dan tahun tertentu
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Pajak', $bulan, $tahun);
        // print_r($saldoAwal);
        error_log(print_r($saldoAwal, true)); // Debug saldo_awal


        $saldo = $saldoAwal['saldo_awal'] ?? 0;

        foreach ($transaksiGroup as &$trx) {
            $totalPemasukan = 0;
            $totalPengeluaran = 0;

            foreach ($trx['pajak'] as $jenis => $nilai) {
                $totalPemasukan += $nilai['Pemasukan'];
                $totalPengeluaran += $nilai['Pengeluaran'];
            }

            $saldo += ($totalPemasukan - $totalPengeluaran);

            $trx['total_pemasukan'] = $totalPemasukan;
            $trx['total_pengeluaran'] = $totalPengeluaran;
            $trx['saldo'] = $saldo;
        }


        $data['transaksi'] = array_values($transaksiGroup);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['saldo_awal'] = $saldoAwal['saldo_awal'] ?? 0;


        $data['saldo_awal_keterangan'] = $saldoAwal['keterangan'] ?? '-'; // Default keterangan "-"
        $data['saldo_awal_tanggal'] = $saldoAwal['tanggal'] ?? '-'; // Default tanggal "-"

        if (!empty($data['transaksi'])) {
            $last = end($data['transaksi']);
            $data['saldo_akhir'] = $last['saldo'];
        } else {
            $data['saldo_akhir'] = $data['saldo_awal']; // fallback kalau nggak ada transaksi
        }
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
        $this->view('buku_pajak/cetak_print', $data);
    }

    public function cetakGaji()
    {
        $data['judul'] = 'Laporan Gaji';

        // Ambil data tahun dan bulan unik dari tabel gaji
        $bulanTahun = $this->model('Gaji_model')->getUniqueMonthsAndYears();

        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        $data['gaji'] = $this->model('Gaji_model')->getGajiByBulanTahunPaid($bulan, $tahun);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('gaji/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetakGaji_print()
    {
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        $data['gaji'] = $this->model('Gaji_model')->getGajiByBulanTahunPaid($bulan, $tahun);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();
        $this->view('gaji/cetak_gaji_print', $data); // mPDF view
    }

    public function cetak_slip()
    {
        $data['judul'] = 'Data Gaji';

        // Ambil data tahun dan bulan unik dari tabel gaji
        $bulanTahun = $this->model('Gaji_model')->getUniqueMonthsAndYears();

        // Grouping berdasarkan tahun
        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil filter dari GET
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        // Ambil data gaji berdasarkan filter bulan dan tahun
        $data['gaji'] = $this->model('Gaji_model')->getGajiByBulanTahunPaid($bulan, $tahun);
        // var_dump($data['gaji']);
        // exit;

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        // $data['test'] = $_ENV['XENDIT_API_KEY'];

        $this->view('templates/header', $data);
        $this->view('gaji/cetak_slip', $data);
        $this->view('templates/footer');
    }

    public function slip($id)
    {
        $data['judul'] = 'Slip Gaji';
        $data['gaji'] = $this->model('Gaji_model')->getSlipGajiById($id);

        if (!$data['gaji']) {
            Flasher::setFlash('Data gaji tidak ditemukan.', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('gaji/slip', $data);
        $this->view('templates/footer');
    }

    public function slipPdf($id)
    {
        $data['gaji'] = $this->model('Gaji_model')->getSlipGajiById($id);

        if (!$data['gaji']) {
            die('Data tidak ditemukan');
        }

        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();

        $this->view('gaji/slip_pdf', $data);
    }

    public function cetak_pegawai()
    {
        $data['judul'] = 'Laporan Data Pegawai';
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();

        $this->view('templates/header', $data);
        $this->view('pegawai/cetak', $data);
        $this->view('templates/footer');
    }

    public function cetakPegawai_print()
    {
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiLengkap();

        $direktur = null;
        $wakilDirektur3 = null;

        foreach ($data['pegawai'] as $pgw) {
            if (!isset($pgw['jabatan_bidang'])) continue;

            foreach ($pgw['jabatan_bidang'] as $jb) {
                $jabatan = strtolower($jb['jabatan']);
                $bidang = strtolower($jb['nama_bidang'] ?? '');

                // Cari direktur
                if (strpos($jabatan, 'direktur') !== false && strpos($jabatan, 'wakil') === false) {
                    $direktur = $pgw;
                }

                // Cari Wakil Direktur III Kepegawaian
                if (
                    strpos($jabatan, 'wakil direktur iii') !== false &&
                    (strpos($bidang, 'kepegawaian') !== false || strpos($bidang, 'sdm') !== false)
                ) {
                    $wakilDirektur3 = $pgw;
                }
            }
        }


        // Set data ke view
        $data['direktur'] = [
            'nama' => $direktur['nama'] ?? 'Direktur',
            'nipy' => $direktur['nipy'] ?? '-',
        ];

        $data['wakil_direktur_3'] = [
            'nama' => $wakilDirektur3['nama'] ?? 'Wakil Direktur III',
            'nipy' => $wakilDirektur3['nipy'] ?? '-',
        ];

        ob_start();
        $this->view('pegawai/cetak_print', $data);
        $viewContent = ob_get_clean();

        $imageUrl = 'http://localhost/keuangan/public/img/Logo.png'; // atau path absolut di server (lebih aman)

        $html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 10pt; }
    .header { text-align: center; font-size: 14pt; font-weight: bold; }
    .sub-header { text-align: center; font-size: 10pt; }
    .spacer { margin-top: 10px; }
    table { border-collapse: collapse; width: 100%; font-size: 9pt; table-layout: fixed; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 4px; word-wrap: break-word; }
    th { background-color: #ccc; text-align: center; vertical-align: middle; }
    ul { margin: 0; padding-left: 15px; }
    .kop td {
    border: none !important;
    padding: 0 !important;
}
</style>

<table width="100%" class="kop">
    <tr>
        <td width="10%" style="text-align: left;">
            <img src="' . $imageUrl . '" width="50">
        </td>
        <td width="90%" style="text-align: center;">
            <div class="header" style="font-size: 16pt;">POLITEKNIK BATULICIN</div>
            <div class="sub-header">Izin Pendirian dari Menteri Pendidikan dan Kebudayaan Republik Indonesia</div>
            <div class="sub-header">Nomor : 568/E/O/2014, Tanggal 17 Oktober 2014</div>
            <div class="sub-header">Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin, Kec. Batulicin, Kab. Tanah Bumbu</div>
            <div class="sub-header">Prov. Kalimantan Selatan, Kode Pos: 72273, E-mail: Politeknikbatulicin@gmail.com, Website: www.politeknikbatulicin.ac.id</div>
        </td>
    </tr>
</table>
<hr style="height: 3px; background-color: black; border: none;">
<div class="spacer"></div>
<br>';
        $html .= $viewContent;

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']); // Landscape
        $mpdf->WriteHTML($html);
        $mpdf->Output('Laporan_Data_Pegawai.pdf', 'I');
    }
}
