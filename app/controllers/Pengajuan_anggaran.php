<?php

class Pengajuan_anggaran extends BaseController
{
    protected $allowedRoles = ['Admin', 'Atasan'];

    public function index()
    {
        $data['judul'] = 'Daftar Pengajuan Anggaran';
        $data['pengajuan'] = $this->model('Pengajuan_anggaran_model')->getAll();

        $this->view('templates/header', $data);
        $this->view('pengajuan_anggaran/index', $data);
        $this->view('templates/footer');
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = $_FILES['file_rab'];
            $uploadDir = 'uploads/rab/';
            $fileName = time() . '_' . basename($file['name']);
            $uploadPath = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $data = [
                    'id_pegawai' => $_SESSION['user_id'],
                    'judul' => $_POST['judul'],
                    'deskripsi' => $_POST['deskripsi'],
                    'file_rab' => $fileName,
                    'total_anggaran' => $_POST['total_anggaran'],
                    'tanggal_upload' => date('Y-m-d'),
                    'status' => 'diajukan'
                ];

                if ($this->model('Pengajuan_anggaran_model')->tambah($data) > 0) {
                    Flasher::setFlash('Pengajuan RAB berhasil dikirim', '', 'success');
                } else {
                    Flasher::setFlash('Gagal menyimpan pengajuan', '', 'error');
                }
            } else {
                Flasher::setFlash('Gagal mengupload file', '', 'error');
            }

            header('Location: ' . BASEURL . '/pengajuan_anggaran');
            exit;
        } else {
            $data['judul'] = 'Upload Pengajuan Anggaran';
            $this->view('templates/header', $data);
            $this->view('pengajuan_anggaran/upload', $data);
            $this->view('templates/footer');
        }
    }

    public function approve($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'status' => $_POST['status'],
                'catatan_atasan' => $_POST['catatan_atasan'],
                'tanggal_disetujui' => date('Y-m-d'),
                'id_atasan' => $_SESSION['user_id']
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
}
