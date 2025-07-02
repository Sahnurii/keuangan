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

            $data['judul'] = 'Tambah Pegawai';
            $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawai();
            $this->view('templates/header', $data);
            $this->view('gaji/tambah', $data);
            $this->view('templates/footer');
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

    public function getTemplateByPegawai($id)
    {
        // Ambil tanggal hari ini sebagai parameter
        $tanggal = date('Y-m-d');

        $data = $this->model('Gaji_model')->getDataGajiOtomatis($id, $tanggal);

        // Ubah jadi JSON
        echo json_encode($data);
    }
}
