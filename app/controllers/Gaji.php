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
            // $getData = $this->model('Gaji_model')->getDataGajiOtomatis($idPegawai, $tanggal);

            // Jika data tidak lengkap (misalnya template tidak ada)
            // if (!$getData || $getData['gaji_pokok'] === 0 && $getData['insentif'] === 0) {
            //     Flasher::setFlash('Gagal Tambah Gaji', 'Komponen gaji tidak lengkap', 'error');
            //     header('Location: ' . BASEURL . '/gaji');
            //     exit;
            // }

            // Simpan data ke DB
            $data = [
                'id_pegawai' => $idPegawai,
                'tanggal' => $tanggal,
                'gaji_pokok' => $_POST['gaji_pokok'],
                'insentif' => $_POST['insentif'],
                'pendidikan' => $_POST['pendidikan'],
                'bobot_masa_kerja' => $_POST['bobot_masa_kerja'],
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
            $data['pegawai'] = $this->model('Pegawai_model')->getPegawaiAktif();
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

    
}
