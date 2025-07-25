<?php

require_once 'Controller.php';

class BaseController extends Controller
{
    protected $allowedRoles = [];

    protected $data = [];

    public function __construct()
    {
        parent::__construct(); // load model, view, dsb kalau ada

        AuthMiddleware::isAuthenticated();


        if (!empty($this->allowedRoles)) {
            AuthMiddleware::requireRole($this->allowedRoles);
        }

        // Ambil nama pegawai berdasarkan id_pegawai di session
        if (isset($_SESSION['user']['id_pegawai'])) {
            $pegawai = $this->model('Pegawai_model')->getNamaById($_SESSION['user']['id_pegawai']);
            $this->data['nama_pegawai'] = $pegawai['nama'] ?? '';
            $this->data['jenis_kelamin'] = $pegawai['jenis_kelamin'] ?? '';
        }
    }
}
