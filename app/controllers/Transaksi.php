    <?php

    class Transaksi extends BaseController
    {
        protected $allowedRoles = ['Admin', 'Petugas'];

        public function index()
        {
            $tahun = $_GET['tahun'] ?? date('Y');
            $bulan = $_GET['bulan'] ?? date('m');


            $data['judul'] = 'Transaksi';
            $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
            $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');

            $data['no_bukti_transaksi'] = $this->model('Pajak_model')->getAllNoBuktiTransaksi($tahun);
            $data['jenis_pajak'] = $this->model('Pajak_model')->getAllJenisPajak();

            // Menyertakan data ke view
            $this->view('templates/header', $data);
            $this->view('transaksi/index', $data);
            $this->view('templates/footer');
        }

        public function tambah()
        {
            $data = [
                'tipe_buku' => $_POST['tipe_buku'],
                'tanggal' => $_POST['tanggal'],
                'no_bukti' => $_POST['no_bukti'],
                'keterangan' => $_POST['keterangan'],
                'tipe_kategori' => $_POST['tipe_kategori'],
                'id_kategori' => $_POST['id_kategori'],
                'nominal_transaksi' => $_POST['nominal_transaksi'],
            ];

            if ($this->model('Transaksi_model')->tambahDataTransaksi($data)) {

                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/transaksi');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/transaksi');
                exit;
            }
        }

        public function hapusKas($id)
        {
            if ($this->model('Transaksi_model')->hapusDataTransaksi($id) > 0) {
                Flasher::setFlash('Hapus Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/buku_kas');
                exit;
            } else {
                Flasher::setFlash('Hapus Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/buku_kas');
                exit;
            }
        }
        public function hapusBank($id)
        {
            if ($this->model('Transaksi_model')->hapusDataTransaksi($id) > 0) {
                Flasher::setFlash('Hapus Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/buku_bank');
                exit;
            } else {
                Flasher::setFlash('Hapus Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/buku_bank');
                exit;
            }
        }

        public function hapusPajak($id)
        {
            if ($this->model('Pajak_model')->hapusDataTransaksi($id) > 0) {
                Flasher::setFlash('Hapus Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/buku_pajak');
                exit;
            } else {
                Flasher::setFlash('Hapus Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/buku_pajak');
                exit;
            }
        }

        public function getNomorBukti($tipe_buku, $tanggal)
        {
            $tanggalExploded = explode('-', $tanggal);
            $bulan = $tanggalExploded[1];
            $tahun = $tanggalExploded[0];

            $nomorBukti = $this->model('Transaksi_model')->getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun);

            echo $nomorBukti;
        }




        public function tambahPajak()
        {
            // 1) Simpan dulu transaksi (pengeluaran) ke tabel `transaksi`
            $trxData = [
                'tipe_buku'         => $_POST['sumber_saldo'],
                'tanggal'           => $_POST['tanggal'],
                'no_bukti'          => $_POST['no_bukti'],
                'keterangan'        => $_POST['keterangan'],
                'id_kategori'       => $_POST['id_kategori'],      // misal kategori "Pajak"
                'tipe_kategori'     => $_POST['tipe_kategori'],    // Pemasukan/Pengeluaran
                'nominal_transaksi' => $_POST['nilai_pajak'],
            ];

            // Insert ke transaksi
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            // exit;
            $this->model('Transaksi_model')->tambahDataTransaksi($trxData);

            $idTransaksiSumber = $_POST['id_transaksi']; // ambil ID dari select input

            // Ambil ID transaksi baru
            $idTransaksiPajak = $this->model('Transaksi_model')->getLastInsertedId();

            // 2) Simpan detail pajak ke tabel `transaksi_pajak`
            $pajakData = [
                'id_transaksi_sumber'      => $idTransaksiSumber,
                'id_transaksi_pembayaran'    => $idTransaksiPajak,
                'id_jenis_pajak'    => $_POST['id_jenis_pajak'],
                'tipe_buku'         => $_POST['tipe_buku'],
                'nominal_transaksi' => $_POST['nominal_transaksi'],
                'nilai_pajak'       => $_POST['nilai_pajak'],
            ];

            if ($this->model('Pajak_model')->tambahDataTransaksiPajak($pajakData)) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/transaksi');
            exit;
        }


        public function getNomorBuktiPajak($tipe_buku, $tanggal )
        {
            $tanggalExploded = explode('-', $tanggal);
            $bulan = $tanggalExploded[1];
            $tahun = $tanggalExploded[0];

            $nomorBukti = $this->model('Pajak_model')->getNomorBuktiTerakhir( $bulan, $tahun);

            echo $nomorBukti;
        }


        // public function getNominalById($id)
        // {
        //     $nominal = $this->model('Pajak_model')->getNominalTransaksiById($id);
        //     echo json_encode(['nominal' => $nominal]);
        // }
        public function getNominalById($id)
        {
            $transaksi = $this->model('Transaksi_model')->getTransaksiById($id);

            if ($transaksi) {
                echo json_encode([
                    'nominal' => $transaksi['nominal_transaksi'],
                    'tipe_kategori' => $transaksi['tipe_kategori'],
                    'id_kategori' => $transaksi['id_kategori']
                ]);
            } else {
                echo json_encode(null);
            }
        }
    }
