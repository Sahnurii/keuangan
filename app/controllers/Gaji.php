<?php

class Gaji extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

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

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('gaji/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $nipy = $_POST['nipy'];

            // // Validasi untuk mengecek duplikat data
            // if ($this->model('Pegawai_model')->cekNipyDuplikat($nipy)) {
            //     Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan NIPY yang sama', 'error');
            //     header('Location: ' . BASEURL . '/pegawai');
            //     exit;
            // }
            // Proses data POST
            if ($this->model('Gaji_model')->tambahGaji($_POST) > 0) {
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
            $data['judul'] = 'Tambah Pegawai';
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
        if (!$gaji) {
            Flasher::setFlash('Data tidak ditemukan', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }

        // Hitung total gaji
        $total = ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan'];

        // Kirim ke payment gateway (contoh dengan Tripay API misalnya)
        $result = $this->sendToPaymentGateway($gaji, $total); // Buat method ini di controller

        if ($result['success']) {
            header('Location: ' . $result['payment_url']);
            exit;
        } else {
            Flasher::setFlash('Gagal memproses pembayaran', '', 'error');
            header('Location: ' . BASEURL . '/gaji');
            exit;
        }
    }

    private function sendToPaymentGateway($gaji, $total)
    {
        $apiKey = 'API_KEY_ANDA';
        $payload = [
            'method' => 'QRIS',
            'merchant_ref' => 'INV-' . time(),
            'amount' => $total,
            'customer_name' => $gaji['nama'],
            'order_items' => [
                [
                    'name' => 'Pembayaran Gaji',
                    'price' => $total,
                    'quantity' => 1
                ]
            ],
            'return_url' => BASEURL . '/gaji',
            'callback_url' => BASEURL . '/gaji/callback'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://tripay.co.id/api/transaction/create");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey"
        ]);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (isset($response['success']) && $response['success']) {
            // Simpan referensi ke DB
            $this->model('Gaji_model')->simpanReferensiPembayaran($gaji['id'], $response['data']['reference']);
            return [
                'success' => true,
                'payment_url' => $response['data']['checkout_url']
            ];
        } else {
            return ['success' => false];
        }
    }

    public function callback()
    {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if (!$data || !isset($data['reference']) || !isset($data['status'])) {
            http_response_code(400);
            echo 'Invalid payload';
            return;
        }

        if ($data['status'] === 'PAID') {
            $this->model('Gaji_model')->updateStatusBayar($data['reference'], 'paid');
        } elseif ($data['status'] === 'FAILED') {
            $this->model('Gaji_model')->updateStatusBayar($data['reference'], 'failed');
        }

        http_response_code(200);
        echo 'OK';
    }
}
