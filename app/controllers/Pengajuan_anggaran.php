<?php

class Pengajuan_anggaran extends BaseController
{
    protected $allowedRoles = ['Admin', 'Pimpinan', 'Pegawai', 'Petugas'];

    public function index()
    {

        $data['judul'] = 'Daftar Pengajuan Anggaran';

        $role = $_SESSION['user']['role'];
        $idPegawai = $_SESSION['user']['id_pegawai'];

        if ($role === 'Admin' || $role === 'Pimpinan') {
            $data['pengajuan'] = $this->model('Pengajuan_anggaran_model')->getAllPengajuan();
        } else {
            $data['pengajuan'] = $this->model('Pengajuan_anggaran_model')->getAllPengajuan($idPegawai);
        }
        $this->view('templates/header', $data);
        $this->view('pengajuan_anggaran/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validasi input form
            if (empty($_POST['judul']) || empty($_POST['deskripsi']) || empty($_POST['total_anggaran'])) {
                Flasher::setFlash('Semua field wajib diisi', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran/tambah');
                exit;
            }

            // Validasi file wajib diunggah
            if (!isset($_FILES['file_rab']) || $_FILES['file_rab']['error'] === UPLOAD_ERR_NO_FILE) {
                Flasher::setFlash('File RAB wajib diunggah', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran/tambah');
                exit;
            }

            $uploadDir = 'uploads/rab/';
            $file = $_FILES['file_rab'];

            // Validasi ekstensi dan ukuran file
            $allowedExtensions = ['pdf', 'docx', 'xlsx'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExtensions) || $file['size'] > $maxSize) {
                Flasher::setFlash('File tidak valid (PDF/DOCX/XLSX max 2MB)', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran/tambah');
                exit;
            }

            // Amankan nama file
            $originalName = preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($file['name']));
            $fileName = time() . '_' . $originalName;
            $uploadPath = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $_POST['file_rab'] = $fileName;
            } else {
                Flasher::setFlash('Gagal upload file', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran');
                exit;
            }

            $_POST['id_pegawai'] = $_SESSION['user']['id_pegawai'];
            $_POST['tanggal_upload'] = date('Y-m-d');
            $_POST['status'] = 'diajukan';

            if ($this->model('Pengajuan_anggaran_model')->tambahPengajuan($_POST) > 0) {
                Flasher::setFlash('Tambah Data Berhasil', '', 'success');
            } else {
                Flasher::setFlash('Tambah Data Gagal', '', 'error');
            }

            header('Location: ' . BASEURL . '/pengajuan_anggaran');
            exit;
        } else {
            $data['judul'] = 'Tambah Pengajuan';
            $this->view('templates/header', $data);
            $this->view('pengajuan_anggaran/tambah', $data);
            $this->view('templates/footer');
        }
    }

    public function approve($id)
    {
        if ($_SESSION['user']['role'] !== 'Pimpinan') {
            Flasher::setFlash('Anda tidak memiliki akses', '', 'error');
            header('Location: ' . BASEURL . '/pengajuan_anggaran');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'status' => $_POST['status'],
                'catatan_atasan' => $_POST['catatan_atasan'],
                'tanggal_disetujui' => date('Y-m-d'),
                'id_atasan' => $_SESSION['user']['id_pegawai']
            ];

            if ($this->model('Pengajuan_anggaran_model')->setujui($id, $data)) {
                Flasher::setFlash('Pengajuan berhasil diperbarui', '', 'success');
            } else {
                Flasher::setFlash('Gagal memperbarui pengajuan', '', 'error');
            }

            header('Location: ' . BASEURL . '/pengajuan_anggaran');
            exit;
        } else {
            $data['judul'] = 'Verifikasi Pengajuan Anggaran';
            $data['pengajuan'] = $this->model('Pengajuan_anggaran_model')->getById($id);

            $this->view('templates/header', $data);
            $this->view('pengajuan_anggaran/approve', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Pengajuan';
        $data['pengajuan'] = $this->model('Pengajuan_anggaran_model')->getById($id);

        $this->view('templates/header', $data);
        $this->view('pengajuan_anggaran/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {

        $post = $_POST;
        $role = $_SESSION['user']['role'];

        // ADMIN HANYA BOLEH UPDATE STATUS
        if ($role === 'Admin') {
            $dataUpdate = [
                'id' => $post['id'],
                'status' => $post['status']
            ];

            if ($this->model('Pengajuan_anggaran_model')->updateStatusOnly($dataUpdate) > 0) {
                Flasher::setFlash('Status berhasil diperbarui', '', 'success');
            } else {
                Flasher::setFlash('Gagal memperbarui status', '', 'error');
            }

            header('Location: ' . BASEURL . '/pengajuan_anggaran');
            exit;
        }
        $uploadDir = 'uploads/rab/';
        $fileBaru = $_FILES['file_rab'];
        $fileName = $post['file_rab_lama']; // default

        // Jika ada file baru, upload & hapus file lama
        if (!empty($fileBaru['name'])) {
            $originalName = preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($fileBaru['name']));
            $fileName = time() . '_' . $originalName;
            $uploadPath = $uploadDir . $fileName;

            // Validasi ekstensi dan ukuran
            $allowedExtensions = ['pdf', 'docx', 'xlsx'];
            $maxSize = 2 * 1024 * 1024;

            $ext = strtolower(pathinfo($fileBaru['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions) || $fileBaru['size'] > $maxSize) {
                Flasher::setFlash('File tidak valid (PDF/DOCX/XLSX max 2MB)', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran/edit/' . $post['id']);
                exit;
            }

            if (move_uploaded_file($fileBaru['tmp_name'], $uploadPath)) {
                if (!empty($post['file_rab_lama']) && file_exists($uploadDir . $post['file_rab_lama'])) {
                    unlink($uploadDir . $post['file_rab_lama']);
                }
            } else {
                Flasher::setFlash('Gagal upload file baru', '', 'error');
                header('Location: ' . BASEURL . '/pengajuan_anggaran');
                exit;
            }
        }

        $dataUpdate = [
            'id' => $post['id'],
            'judul' => $post['judul'],
            'deskripsi' => $post['deskripsi'],
            'total_anggaran' => $post['total_anggaran'],
            'file_rab' => $fileName,
        ];
        // echo '<pre>';
        // print_r($dataUpdate);
        // echo '</pre>';
        // exit;

        if ($this->model('Pengajuan_anggaran_model')->update($dataUpdate) > 0) {
            Flasher::setFlash('berhasil', 'diedit', 'success');
        } else {
            Flasher::setFlash('gagal', 'diedit', 'error');
        }

        header('Location: ' . BASEURL . '/pengajuan_anggaran');
        exit;
    }


    public function delete($id)
    {
        if ($this->model('Pengajuan_anggaran_model')->hapus($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'error');
        }
        header('Location: ' . BASEURL . '/pengajuan_anggaran');
        exit;
    }
}
