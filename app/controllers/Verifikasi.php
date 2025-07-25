<?php

class Verifikasi extends Controller
{
    public function verrified($id)
    {
        $pengajuan = $this->model('Pengajuan_anggaran_model')->getByIdWithPimpinan($id);
        if (!$pengajuan || $pengajuan['status'] !== 'diterima') {
            echo "Data tidak ditemukan atau belum disetujui.";
            return;
        }

        $data['judul'] = 'Detail Pengajuan';
        $data['pengajuan'] = $pengajuan;

        $this->view('verrified/verrified', $data);
    }
}
