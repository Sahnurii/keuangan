<?php

class Bidang extends BaseController
{
    protected $allowedRoles = ['Admin'];

    public function index()
    {
        $data['judul'] = 'Bidang';
        $data['bidang'] = $this->model('Bidang_model')->getAllBidang();
        $this->view('templates/header', $data);
        $this->view('bidang/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Bidang_model')->HapusDataBidang($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/bidang');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/bidang');
            exit;
        }
    }

    private function formatKata($string)
    {
        $kataSambung = ['dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'atau', 'pada'];

        $words = explode(' ', trim($string));
        $formatted = [];

        foreach ($words as $index => $word) {
            $startsWithParen = str_starts_with($word, '(');
            $endsWithParen = str_ends_with($word, ')');
            $cleanWord = trim($word, '()');

            if (ctype_upper($cleanWord)) {
                $formattedWord = $cleanWord;
            } elseif (in_array(strtolower($cleanWord), $kataSambung) && $index != 0) {
                $formattedWord = strtolower($cleanWord);
            } else {
                $formattedWord = ucfirst(strtolower($cleanWord));
            }

            // Tambahkan kurung hanya jika belum lengkap
            if ($startsWithParen && $endsWithParen && $word === '(' . $cleanWord . ')') {
                $formattedWord = '(' . $formattedWord . ')';
            } elseif ($startsWithParen && !$endsWithParen) {
                $formattedWord = '(' . $formattedWord;
            } elseif (!$startsWithParen && $endsWithParen) {
                $formattedWord = $formattedWord . ')';
            }

            $formatted[] = $formattedWord;
        }

        return implode(' ', $formatted);
    }





    public function tambah()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jabatan = $this->formatKata(trim($_POST['jabatan']));
            $nama_bidang = $this->formatKata(trim($_POST['nama_bidang']));


            // Validasi untuk mengecek duplikat data
            if ($this->model('Bidang_model')->cekBidangDuplikat($jabatan, $nama_bidang)) {
                Flasher::setFlash('Tambah Data Gagal', 'Data sudah ada dengan Jabatan dan nama Bidang yang sama', 'error');
                header('Location: ' . BASEURL . '/bidang');
                exit;
            }

            // Kirim data hasil olahan
            $data = [
                'jabatan' => $jabatan,
                'nama_bidang' => $nama_bidang
            ];

            // Proses data POST
            if ($this->model('Bidang_model')->tambahDataBidang($data) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/bidang');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/bidang');
                exit;
            }
        } else {
            // Tampilkan form tambah
            $data['judul'] = 'Tambah Bidang';
            $this->view('templates/header', $data);
            $this->view('bidang/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['bidang'] = $this->model('Bidang_model')->getBidangById($id);
        $data['judul'] = 'Edit Bidang';

        $this->view('templates/header', $data);
        $this->view('bidang/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'jabatan' => $this->formatKata(trim($_POST['jabatan'])),
                'nama_bidang' => $this->formatKata(trim($_POST['nama_bidang']))
            ];
            if ($this->model('Bidang_model')->editDataBidang($data) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/bidang');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/bidang');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
