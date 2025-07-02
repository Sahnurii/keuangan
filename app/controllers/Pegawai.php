<?php

class Pegawai extends BaseController
{
    protected $allowedRoles = ['Admin'];

    public function index()
    {
        $data['judul'] = 'Pegawai';
        $data['pegawai'] = $this->model('Pegawai_model')->getAllPegawaiWithJabatanBidang();
        $this->view('templates/header', $data);
        $this->view('pegawai/index', $data);
        $this->view('templates/footer');
    }

    public function hapus($id)
    {
        if ($this->model('Pegawai_model')->hapusPegawai($id) > 0) {
            Flasher::setFlash('Hapus Data Berhasil', '', 'success');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        } else {
            Flasher::setFlash('Hapus Data Gagal', '', 'error');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        }
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nipy = $_POST['nipy'];

            if ($this->model('Pegawai_model')->cekNipyDuplikat($nipy)) {
                Flasher::setFlash('Tambah Data Gagal', 'NIPY sudah terdaftar', 'error');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            }

            // Simpan data pegawai
            if ($this->model('Pegawai_model')->tambahPegawai($_POST) > 0) {
                // Ambil ID terakhir (asumsi AUTO_INCREMENT)
                $lastId = $this->model('Pegawai_model')->getLastInsertId();

                // Simpan relasi jabatan_bidang ke tabel pivot
                if (!empty($_POST['jabatan_bidang'])) {
                    $this->model('Pegawai_model')->updateJabatanPegawai($lastId, $_POST['jabatan_bidang']);
                }

                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/pegawai');
                exit;
            }
        } else {
            $data['judul'] = 'Tambah Pegawai';
            $data['jabatan_bidang'] = $this->model('Bidang_model')->getAllBidang();
            $data['bobot_klasifikasi'] = $this->model('Master_bobot_model')->getAllBobot();
            $this->view('templates/header', $data);
            $this->view('pegawai/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['pegawai'] = $this->model('Pegawai_model')->getPegawaiById($id);
        $data['judul'] = 'Edit Pegawai';
        $data['jabatan_bidang'] = $this->model('Bidang_model')->getAllBidang();
        $data['bobot_klasifikasi'] = $this->model('Master_bobot_model')->getAllBobot();

        // Ambil relasi jabatan_bidang yang sudah dipilih pegawai
        $data['selected_jabatan_bidang'] = $this->model('Pegawai_model')->getJabatanAktif($id);

        $this->view('templates/header', $data);
        $this->view('pegawai/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        $id = $_POST['id'];
        $nipy = $_POST['nipy'];

        // Cek duplikat NIPY
        if ($this->model('Pegawai_model')->cekNipyDuplikat($nipy, $id)) {
            Flasher::setFlash('Ubah Data Gagal', 'NIPY sudah digunakan', 'error');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        }

        // Ambil data awal dari database
        $dataLama = $this->model('Pegawai_model')->getPegawaiById($id);
        $dataBaru = $_POST;

        // Bandingkan data satu per satu
        $pegawaiChanged = false;
        foreach ($dataLama as $key => $value) {
            if (isset($dataBaru[$key])) {
                $dbValue = trim((string)$value);
                $formValue = trim((string)$dataBaru[$key]);
                if ($dbValue !== $formValue) {
                    $pegawaiChanged = true;
                    break;
                }
            }
        }


        // Jalankan update hanya jika ada perubahan
        $pegawaiUpdated = 0;
        if ($pegawaiChanged) {
            $pegawaiUpdated = $this->model('Pegawai_model')->editPegawai($_POST);
        }

        // Cek apakah jabatan berubah
        $jabatanUpdated = false;
        if (isset($_POST['jabatan_bidang'])) {
            if ($this->model('Pegawai_model')->isJabatanBerubah($id, $_POST['jabatan_bidang'])) {
                $this->model('Pegawai_model')->updateJabatanPegawai($id, $_POST['jabatan_bidang']);
                $jabatanUpdated = true;
            }
        }

        if ($pegawaiUpdated > 0 || $jabatanUpdated) {
            Flasher::setFlash('Ubah Data Berhasil', '', 'success');
        } else {
            Flasher::setFlash('Tidak ada perubahan data', '', 'info');
        }

        header('Location: ' . BASEURL . '/pegawai');
        exit;
    }




    public function detail($id)
    {
        $data['judul'] = 'Detail Pegawai';
        $pegawai = $this->model('Pegawai_model')->getPegawaiById($id);
        $pegawai['jabatan_bidang'] = $this->model('Pegawai_model')->getJabatanBidangByPegawaiId($id);
        $data['riwayat_pendidikan'] = $this->model('Riwayat_pendidikan_model')->getRiwayatPendidikanByPegawaiId($id);

        // Hitung lama kerja berdasarkan TMT (dalam bulan dan hari)
        if (!empty($pegawai['tmt'])) {
            $tmtDate = new DateTime($pegawai['tmt']);
            $now = new DateTime();
            $interval = $tmtDate->diff($now);
            $lamaKerja = ($interval->y * 12 + $interval->m) . ' bulan ' . $interval->d . ' hari';
        } else {
            $lamaKerja = 'Tanggal TMT tidak tersedia';
        }

        $pegawai['lama_kerja'] = $lamaKerja;

        $data['pegawai'] = $pegawai;
        $this->view('templates/header', $data);
        $this->view('pegawai/detail', $data);
        $this->view('templates/footer');
    }

    public function toggleStatus($id)
    {
        $pegawai = $this->model('Pegawai_model')->getPegawaiById($id);
        if (!$pegawai) {
            Flasher::setFlash('Pegawai tidak ditemukan', '', 'danger');
            header('Location: ' . BASEURL . '/pegawai');
            exit;
        }

        $statusBaru = ($pegawai['status_aktif'] == 'aktif') ? 'nonaktif' : 'aktif';
        $this->model('Pegawai_model')->updateStatusAktif($id, $statusBaru);

        Flasher::setFlash('Status pegawai berhasil diubah menjadi ' . $statusBaru, '', 'success');
        header('Location: ' . BASEURL . '/pegawai');
        exit;
    }
}
