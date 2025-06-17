    <?php

    class Transaksi extends Controller
    {
        protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

        public function index()
        {
            $tahun = $_GET['tahun'] ?? date('Y');
            $bulan = $_GET['bulan'] ?? date('m');


            $data['judul'] = 'Transaksi';
            $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
            $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');
            
            $data['no_bukti_transaksi'] = $this->model('Pajak_model')->getAllNoBuktiTransaksi();
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
                'nama_kategori' => $_POST['nama_kategori'],
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
            $data = [
                'id_transaksi' => $_POST['id_transaksi'],
                'id_jenis_pajak' => $_POST['id_jenis_pajak'],
                'tipe_buku' => $_POST['tipe_buku'],
                'tanggal' => $_POST['tanggal'],
                'no_bukti' => $_POST['no_bukti'],
                'keterangan' => $_POST['keterangan'],
                'tipe_kategori' => $_POST['tipe_kategori'],
                'nominal_transaksi' => $_POST['nominal_transaksi'],
                'nilai_pajak' => $_POST['nilai_pajak'],
            ];

            if ($this->model('Pajak_model')->tambahDataTransaksiPajak($data)) {

                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/transaksi_pajak');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/transaksi_pajak');
                exit;
            }
        }


        public function getNomorBuktiPajak($tipe_buku, $tanggal)
        {
            $tanggalExploded = explode('-', $tanggal);
            $bulan = $tanggalExploded[1];
            $tahun = $tanggalExploded[0];

            $nomorBukti = $this->model('Pajak_model')->getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun);

            echo $nomorBukti;
        }

        public function getNominalById($id)
        {
            $nominal = $this->model('Pajak_model')->getNominalTransaksiById($id);
            echo json_encode(['nominal' => $nominal]);
        }
    }


