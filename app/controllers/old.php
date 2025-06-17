<?php

class Transaksi_pajak extends Controller
{
    public function __construct()
    {
        AuthMiddleware::isAuthenticated();
    }

    public function index()
    {
        // $tahun = $_GET['tahun'] ?? date('Y');
        // $bulan = $_GET['bulan'] ?? date('m');


        $data['judul'] = 'Transaksi Pajak';
        $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
        $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');
        $data['no_bukti_transaksi'] = $this->model('Pajak_model')->getAllNoBuktiTransaksi();
        $data['jenis_pajak'] = $this->model('Pajak_model')->getAllJenisPajak();

        // $data['transaksi'] = $this->model('Transaksi_model')->getTransaksiPajakLengkap($bulan, $tahun);
        // Menyertakan data ke view
        $this->view('templates/header', $data);
        $this->view('transaksi_pajak/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'id_transaksi' => $_POST['id_transaksi'],
            'id_jenis_pajak' => $_POST['id_jenis_pajak'],
            'tipe_buku' => $_POST['tipe_buku'],
            'tanggal' => $_POST['tanggal'],
            'no_bukti' => $_POST['no_bukti'],
            'keterangan' => $_POST['keterangan'],
            'nama_kategori' => $_POST['nama_kategori'],
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


    public function getNomorBukti($tipe_buku, $tanggal)
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
