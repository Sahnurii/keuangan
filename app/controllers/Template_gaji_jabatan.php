<?php 

class Template_gaji_jabatan extends Controller
{
    public function index()
    {
        $data['judul'] = 'Template Gaji Jabatan';
        $data['template'] = $this->model('Template_gaji_jabatan_model')->getAllTemplate();
        $this->view('templates/header', $data);
        $this->view('template_gaji_jabatan/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Template_gaji_jabatan_model')->tambahTemplate($_POST) > 0) {
                Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/template_gaji_jabatan');
                exit;
            }
        }

        $data['judul'] = 'Tambah Template Gaji Jabatan';
        $data['bidang'] = $this->model('Bidang_model')->getAllBidang();
        $this->view('templates/header', $data);
        $this->view('template_gaji_jabatan/tambah', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Template Gaji Jabatan';
        $data['template'] = $this->model('Template_gaji_jabatan_model')->getTemplateById($id);
        $data['bidang'] = $this->model('Bidang_model')->getAllBidang();
        $this->view('templates/header', $data);
        $this->view('template_gaji_jabatan/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($this->model('Template_gaji_jabatan_model')->update($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        }
        header('Location: ' . BASEURL . '/template_gaji_jabatan');
        exit;
    }

    public function hapus($id)
    {
        if ($this->model('Template_gaji_jabatan_model')->hapus($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        }
        header('Location: ' . BASEURL . '/template_gaji_jabatan');
        exit;
    }
}
