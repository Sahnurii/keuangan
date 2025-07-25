<?php

class Riwayat_pendidikan extends BaseController
{
    protected $allowedRoles = ['Admin', 'Petugas'];

    public function index()
    {
        $data['judul'] = 'Riwayat Pendidikan';
        $data['pendidikan'] = $this->model('Riwayat_pendidikan_model')->getAllRiwayatPendidikan();
        $data['jenjang'] = $this->model('Tunjangan_model')->getAllTunjangan();
        $this->view('templates/header', $data);
        $this->view('riwayat_pendidikan/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Riwayat_pendidikan_model')->hapusDataRiwayatPendidikan($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/riwayat_pendidikan');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/riwayat_pendidikan');
            exit;
        }
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_pegawai'     => $_POST['id_pegawai'],
                'id_jenjang'        => $_POST['id_jenjang'],
                'gelar'          => $_POST['gelar'],
                'program_studi'  => $_POST['program_studi'],
                'nama_kampus'    => $_POST['nama_kampus']
            ];

            if ($this->model('Riwayat_pendidikan_model')->tambahDataRiwayatPendidikan($data) > 0) {
                Flasher::setFlash('Tambah Riwayat Pendidikan Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/riwayat_pendidikan');
                exit;
            } else {
                Flasher::setFlash('Tambah Riwayat Pendidikan Gagal', '', 'error');
                header('Location: ' . BASEURL . '/riwayat_pendidikan');
                exit;
            }
        } else {
            $data['judul'] = 'Tambah Riwayat Pendidikan';
            $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawai(); // untuk select dropdown pegawai
            $data['jenjang'] = $this->model('Tunjangan_model')->getAllTunjangan();
            $this->view('templates/header', $data);
            $this->view('riwayat_pendidikan/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['pendidikan'] = $this->model('Riwayat_pendidikan_model')->getRiwayatPendidikanById($id);
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawai();
        $data['jenjang'] = $this->model('Tunjangan_model')->getAllTunjangan();
        $data['judul'] = 'Edit Riwayat Pendidikan';

        $this->view('templates/header', $data);
        $this->view('riwayat_pendidikan/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id'             => $_POST['id'],
                'id_pegawai'     => $_POST['id_pegawai'],
                'id_jenjang'        => $_POST['id_jenjang'],
                'gelar'          => $_POST['gelar'],
                'program_studi'  => $_POST['program_studi'],
                'nama_kampus'    => $_POST['nama_kampus']
            ];

            if ($this->model('Riwayat_pendidikan_model')->editDataRiwayatPendidikan($data) > 0) {
                Flasher::setFlash('Ubah Riwayat Pendidikan Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/riwayat_pendidikan');
                exit;
            } else {
                Flasher::setFlash('Ubah Riwayat Pendidikan Gagal', '', 'error');
                header('Location: ' . BASEURL . '/riwayat_pendidikan');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
