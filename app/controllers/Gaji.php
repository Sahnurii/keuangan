<?php

class Gaji extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas'];

    public function index()
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
        $data['gaji'] = $this->model('Gaji_model')->getGajiByBulanTahun($bulan, $tahun);
        // var_dump($data['gaji']);
        // exit;

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        // $data['test'] = $_ENV['XENDIT_API_KEY'];

        $this->view('templates/header', $data);
        $this->view('gaji/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPegawai = $_POST['id_pegawai'];
            $tanggal = $_POST['tanggal'];

            // Ambil data pegawai berdasarkan ID
            $pegawai = $this->model('Pegawai_model')->getPegawaiById($idPegawai);

            if ($this->model('Gaji_model')->cekGajiDuplikat($_POST['id_pegawai'], $_POST['tanggal'])) {
                Flasher::setFlash('Gagal', 'Data gaji untuk pegawai ini di bulan dan tahun tersebut sudah ada!', 'error');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            }
            
            //cek pegawai
            if (!$pegawai) {
                Flasher::setFlash('Tambah Data Gagal', 'Data pegawai tidak ditemukan', 'error');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            }

            // Ambil data otomatis
            $getData = $this->model('Gaji_model')->getDataGajiOtomatis($idPegawai, $tanggal);

            // Jika data tidak lengkap (misalnya template tidak ada)
            if (!$getData || $getData['gaji_pokok'] === 0 && $getData['insentif'] === 0) {
                Flasher::setFlash('Gagal Tambah Gaji', 'Komponen gaji tidak lengkap', 'error');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            }

            // Simpan data ke DB
            $data = [
                'id_pegawai' => $idPegawai,
                'tanggal' => $tanggal,
                'gaji_pokok' => $getData['gaji_pokok'],
                'insentif' => $getData['insentif'],
                'pendidikan' => $getData['pendidikan'],
                'bobot_masa_kerja' => $getData['bobot_masa_kerja'],
                'beban_kerja' => $_POST['beban_kerja'] ?? 0,
                'pemotongan' => $_POST['pemotongan'] ?? 0
            ];

            if ($this->model('Gaji_model')->tambahGaji($data) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            }
        } else {
            // Tampilkan form tambah

            $data['judul'] = 'Tambah Gaji';
            $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawai();
            $this->view('templates/header', $data);
            $this->view('gaji/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Gaji';
        $data['gaji'] = $this->model('Gaji_model')->getGajiById($id);
        $this->view('templates/header', $data);
        $this->view('gaji/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Gaji_model')->updateGaji($_POST) > 0) {
                Flasher::setFlash('Update Gaji Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            } else {
                Flasher::setFlash('Update Gaji Gagal', '', 'error');
                header('Location: ' . BASEURL . '/gaji');
                exit;
            }
        }
    }

    public function hapus($id)
    {
        if ($this->model('Gaji_model')->hapusGaji($id) > 0) {
            Flasher::setFlash('Hapus Gaji Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        } else {
            Flasher::setFlash('Hapus Gaji Gagal', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }
    }

    public function bayar($id)
    {
        $gaji = $this->model('Gaji_model')->getGajiById($id);

        if (!is_array($gaji) || !isset($gaji['id'])) {
            Flasher::setFlash('Data tidak ditemukan', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }

        // Hitung total gaji
        $total = ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan'];

        // Kirim ke Midtrans untuk mendapatkan Snap Token
        $result = $this->sendToPaymentGateway($gaji, $total);

        if ($result['success']) {
            // Kirim snap token ke view
            $data['snap_token'] = $result['snap_token'];
            $data['judul'] = 'Bayar Gaji';
            $data['gaji'] = $gaji;
            $data['total'] = $total;

            $this->view('templates/header', $data);
            $this->view('gaji/bayar', $data); // View ini harus menggunakan JS Midtrans Snap
            $this->view('templates/footer');
        } else {
            Flasher::setFlash('Gagal memproses pembayaran: ' . $result['message'], '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }
    }

    public function bayar1($id)
    {
        // var_dump($id); // Tambahkan ini sementara
        $gaji = $this->model('Gaji_model')->getGajiById($id);
        // var_dump($gaji); // Tambahkan ini juga sementara
        // exit;

        if (!is_array($gaji) || !isset($gaji['id'])) {
            Flasher::setFlash('Data tidak ditemukan', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }

        // Hitung total gaji
        $total = ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan'];

        // Kirim ke payment gateway (contoh dengan Tripay API misalnya)
        $result = $this->sendToPaymentGateway($gaji, $total); // Buat method ini di controller

        if ($result['success']) {
            header('Location: ' . $result['snap_token']);
            exit;
        } else {
            Flasher::setFlash('Gagal memproses pembayaran: ' . $result['message'], '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }
    }

    public function snap($id)
    {
        $gaji = $this->model('Gaji_model')->getGajiById($id);
        // Hitung total gaji
        $total = ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan'];
        $data['total'] = $total;
        $data['gaji'] = $gaji;
        $data['judul'] = 'SNAP';
        $this->view('templates/header', $data);
        $this->view('gaji/bayar', $data);
        $this->view('templates/footer');
    }

    public function getTemplateByPegawai($id)
    {
        // Ambil tanggal hari ini sebagai parameter
        $tanggal = date('Y-m-d');

        $data = $this->model('Gaji_model')->getDataGajiOtomatis($id, $tanggal);

        // Ubah jadi JSON
        echo json_encode($data);
    }

    private function sendToPaymentGateway($gaji, $total)
    {
        $pegawai = $this->model('Pegawai_model')->getPegawaiById($gaji['id_pegawai']);

        // Inisialisasi Midtrans
        \Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
        \Midtrans\Config::$isProduction = $_ENV['MIDTRANS_IS_PRODUCTION'] === 'true';
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Buat parameter transaksi
        $transaction_details = [
            'order_id'     => 'GJ-' . $gaji['id'] . '-' . time(), // membuat order id yang uniq terus
            'gross_amount' => (int) $total,
        ];

        $customer_details = [
            'first_name' => $pegawai['nama'],
            'email' => $pegawai['email'] ?? 'default@email.com',
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan ke database
            $this->model('Gaji_model')->updatePaymentInfo($gaji['id'], [
                'payment_reference' => $transaction_details['order_id'],
                'snap_token' => $snapToken,
                'status_pembayaran' => 'pending'
            ]);

            return [
                'success' => true,
                'snap_token' => $snapToken
            ];
        } catch (Exception $e) {
            error_log('Midtrans Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    // public function tambah()
    // {
    //     $data['title'] = 'Tambah Gaji Pegawai';

    //     // Ambil semua data referensi di awal
    //     $pegawaiModel = $this->model('Pegawai_model');
    //     $jabatanModel = $this->model('Bidang_model');
    //     $templateModel = $this->model('Template_gaji_jabatan_model');
    //     $tunjanganModel = $this->model('Tunjangan_model');
    //     $masaKerjaModel = $this->model('Master_bobot_model');
    //     $gajiModel = $this->model('Gaji_model');

    //     $data['pegawai'] = $pegawaiModel->getAllPegawaiWithJabatanBidang();
    //     $data['jabatan_bidang'] = $jabatanModel->getAllBidang();
    //     $data['pendidikan'] = $tunjanganModel->getAllTunjangan();
    //     $data['masa_kerja'] = $masaKerjaModel->getAllBobot();

    //     // Cek apakah form disubmit
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id_pegawai = $_POST['id_pegawai'];
    //         $id_jabatan_bidang = $_POST['id_jabatan_bidang'];
    //         $id_pendidikan = $_POST['id_pendidikan'];
    //         $masa_kerja = $_POST['masa_kerja'];

    //         // Ambil gaji pokok dan insentif berdasarkan jabatan
    //         $template = $templateModel->getByIdJabatan($id_jabatan_bidang);
    //         $gaji_pokok = $template ? $template['gaji_pokok'] : 0;
    //         $insentif = $template ? $template['insentif'] : 0;

    //         // Ambil tunjangan pendidikan
    //         $tunjangan = $tunjanganModel->getById($id_pendidikan);
    //         $tunjangan_pendidikan = $tunjangan ? $tunjangan['nilai_tunjangan'] : 0;

    //         // Ambil bobot masa kerja
    //         $bobot = $masaKerjaModel->getByTahun($masa_kerja);
    //         $bobot_masa_kerja = $bobot ? $bobot['nilai_bobot'] : 0;

    //         // Hitung total gaji
    //         $total_gaji = $gaji_pokok + $insentif + $tunjangan_pendidikan + $bobot_masa_kerja;

    //         // Siapkan data untuk insert
    //         $insertData = [
    //             'id_pegawai' => $id_pegawai,
    //             'id_jabatan_bidang' => $id_jabatan_bidang,
    //             'id_pendidikan' => $id_pendidikan,
    //             'masa_kerja' => $masa_kerja,
    //             'gaji_pokok' => $gaji_pokok,
    //             'insentif' => $insentif,
    //             'tunjangan_pendidikan' => $tunjangan_pendidikan,
    //             'bobot_masa_kerja' => $bobot_masa_kerja,
    //             'total_gaji' => $total_gaji,
    //         ];

    //         // Simpan ke database
    //         if ($gajiModel->insert($insertData) > 0) {
    //             Flasher::setFlash('Berhasil', 'ditambahkan', 'success');
    //             header('Location: ' . BASEURL . '/gaji');
    //             exit;
    //         } else {
    //             Flasher::setFlash('Gagal', 'ditambahkan', 'danger');
    //             // Kirim data pegawai terpilih kembali agar tidak kosong di form
    //             $data['selected'] = $_POST;
    //         }
    //     }

    //     // Tampilkan form tambah
    //     $this->view('templates/header', $data);
    //     $this->view('gaji/tambah', $data);
    //     $this->view('templates/footer');
    // }

    // public function buat_link($id)
    // {
    //     $gaji = $this->model('Gaji_model')->getGajiById($id);
    //     if (!$gaji) {
    //         Flasher::setFlash('Gagal!', 'Data gaji tidak ditemukan', 'danger');
    //         header('Location: ' . BASEURL . '/gaji');
    //         exit;
    //     }

    //     $pegawai = $this->model('Gaji_model')->getPegawaiById($gaji['id_pegawai']);
    //     if (!$pegawai) {
    //         Flasher::setFlash('Gagal!', 'Data pegawai tidak ditemukan', 'danger');
    //         header('Location: ' . BASEURL . '/gaji');
    //         exit;
    //     }

    //     $params = [
    //         'external_id' => 'gaji-' . $id . '-' . time(),
    //         'payer_email' => $pegawai['email'] ?? 'default@example.com',
    //         'description' => 'Pembayaran gaji untuk ' . $pegawai['nama'],
    //         'amount' => (int) $gaji['total_gaji'],
    //     ];

    //     $invoice = $this->model('Gaji_model')->createLinkPayment($params);

    //     if (isset($invoice['error'])) {
    //         Flasher::setFlash('Gagal!', 'Gagal membuat link pembayaran: ' . $invoice['error'], 'danger');
    //     } else {
    //         $this->model('Gaji_model')->updateLinkUrl($id, $invoice['invoice_url']);
    //         Flasher::setFlash('Berhasil!', 'Link pembayaran berhasil dibuat.', 'success');
    //     }

    //     header('Location: ' . BASEURL . '/gaji');
    //     exit;
    // }

    // private function sendToPaymentGateway($gaji, $total)
    // {
    //     $pegawai = $this->model('Pegawai_model')->getPegawaiById($gaji['id_pegawai']);

    //     $client = new \GuzzleHttp\Client();

    //     try {
    //         $response = $client->request('POST', 'https://api.xendit.co/v2/invoices', [
    //             'auth' => [$_ENV['XENDIT_API_KEY'], ''],
    //             'json' => [
    //                 'external_id' => 'gaji-' . $gaji['id'],
    //                 'payer_email' => $pegawai['email'] ?? 'default@email.com',
    //                 'description' => 'Gaji bulan ' . date('F Y', strtotime($gaji['tanggal'])) . ' untuk ' . $pegawai['nama'],
    //                 'amount' => (int) $total,
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);

    //         // Update info pembayaran ke tabel gaji
    //         $this->model('Gaji_model')->updatePaymentInfo($gaji['id'], [
    //             'payment_reference' => $body['id'],
    //             'status_pembayaran' => 'pending'
    //         ]);

    //         return [
    //             'success' => true,
    //             'payment_url' => $body['invoice_url']
    //         ];
    //     } catch (\GuzzleHttp\Exception\RequestException $e) {
    //         error_log('Xendit Error: ' . $e->getMessage());
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ];
    //     }
    // }


}
