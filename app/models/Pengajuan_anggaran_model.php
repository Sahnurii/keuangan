<?php

class Pengajuan_anggaran_model
{
    private $table = 'pengajuan_anggaran';
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Sesuai arsitektur buatan kamu
    }

    public function getAllPengajuan($id_pegawai = null)
    {
        if ($id_pegawai) {
            $this->db->query("SELECT pa.*, p.nama AS nama_pegawai 
                          FROM {$this->table} pa
                          JOIN pegawai p ON pa.id_pegawai = p.id
                          WHERE pa.id_pegawai = :id_pegawai");
            $this->db->bind('id_pegawai', $id_pegawai);
        } else {
            $this->db->query("SELECT pa.*, p.nama AS nama_pegawai 
                          FROM {$this->table} pa
                          JOIN pegawai p ON pa.id_pegawai = p.id");
        }

        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT pa.*, p.nama AS nama_pegawai 
                          FROM {$this->table} pa
                          JOIN pegawai p ON pa.id_pegawai = p.id
                          WHERE pa.id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahPengajuan($data)
    {
        $query = "INSERT INTO {$this->table} 
                  (id_pegawai, judul, deskripsi, file_rab, total_anggaran, tanggal_upload, status) 
                  VALUES (:id_pegawai, :judul, :deskripsi, :file_rab, :total_anggaran, :tanggal_upload, :status)";

        $this->db->query($query);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('file_rab', $data['file_rab']);
        $this->db->bind('total_anggaran', $data['total_anggaran']);
        $this->db->bind('tanggal_upload', $data['tanggal_upload']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function setujui($id, $data)
    {
        $query = "UPDATE {$this->table} SET 
                    status = :status, 
                    catatan_atasan = :catatan_atasan, 
                    tanggal_disetujui = :tanggal_disetujui, 
                    id_atasan = :id_atasan 
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('status', $data['status']);
        $this->db->bind('catatan_atasan', $data['catatan_atasan']);
        $this->db->bind('tanggal_disetujui', $data['tanggal_disetujui']);
        $this->db->bind('id_atasan', $data['id_atasan']);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE {$this->table} SET 
                judul = :judul, 
                deskripsi = :deskripsi, 
                total_anggaran = :total_anggaran, 
                file_rab = :file_rab,
                status = :status
              WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('total_anggaran', $data['total_anggaran']);
        $this->db->bind('file_rab', $data['file_rab']);
        $this->db->bind('status', 'diajukan');
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }


    public function hapus($id)
    {
        // Ambil data pengajuan terlebih dahulu untuk mendapatkan nama file-nya
        $pengajuan = $this->getById($id);

        if ($pengajuan && !empty($pengajuan['file_rab'])) {
            $filePath = 'uploads/rab/' . $pengajuan['file_rab'];

            // Pastikan file-nya ada sebelum dihapus
            if (file_exists($filePath)) {
                unlink($filePath); // 🔥 Hapus file dari server
            }
        }

        // Lanjut hapus data dari database
        $this->db->query("DELETE FROM pengajuan_anggaran WHERE id = :id");
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }


    public function updateStatusOnly($data)
    {
        if ($data['status'] === 'diajukan') {
            $query = "UPDATE {$this->table} 
                  SET status = :status, 
                  tanggal_disetujui = NULL,
                  id_atasan = NULL 
                  WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('status', $data['status']);
            $this->db->bind('id', $data['id']);
        } else {
            $query = "UPDATE {$this->table} 
                  SET status = :status 
                  WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('status', $data['status']);
            $this->db->bind('id', $data['id']);
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getTotalPengajuan()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $this->db->single();
    }


    public function getRekapTotalPengajuanByStatus()
    {
        $this->db->query("
        SELECT 
            status, 
            COUNT(*) as total 
        FROM {$this->table} 
        GROUP BY status
    ");
        return $this->db->resultSet();
    }

    public function getRekapByPegawai($idPegawai)
    {
        $this->db->query("
        SELECT status, COUNT(*) as total 
        FROM {$this->table} 
        WHERE id_pegawai = :id_pegawai 
        GROUP BY status
    ");
        $this->db->bind('id_pegawai', $idPegawai);
        return $this->db->resultSet();
    }

    public function getFiltered($status = null, $idPegawai = null)
    {
        $query = "SELECT pa.*, p.nama AS nama_pegawai,
                at.nama AS nama_pimpinan
              FROM {$this->table} pa
              JOIN pegawai p ON pa.id_pegawai = p.id
              LEFT JOIN pegawai at ON pa.id_atasan = at.id
              WHERE 1=1";

        if ($status) {
            $query .= " AND pa.status = :status";
        }
        if ($idPegawai) {
            $query .= " AND pa.id_pegawai = :id_pegawai";
        }

        $this->db->query($query);

        if ($status) {
            $this->db->bind('status', $status);
        }
        if ($idPegawai) {
            $this->db->bind('id_pegawai', $idPegawai);
        }

        return $this->db->resultSet();
    }

    public function getByIdWithPimpinan($id)
    {
        $this->db->query("
        SELECT 
            pa.*, 
            p.nama AS nama_pimpinan, 
            p.nipy AS nipy_pimpinan, 
            jb_pimpinan.jabatan AS jabatan_pimpinan,
            peg.nama AS nama_pegawai,
            peg.nipy AS nipy_pegawai,
            jb_pengaju.jabatan AS jabatan_pengaju
        FROM pengajuan_anggaran pa
        JOIN pegawai p ON p.id = pa.id_atasan
        LEFT JOIN pegawai_jabatan_bidang pjb_pimpinan ON pjb_pimpinan.id_pegawai = p.id AND pjb_pimpinan.tanggal_selesai IS NULL
        LEFT JOIN jabatan_bidang jb_pimpinan ON jb_pimpinan.id = pjb_pimpinan.id_jabatan_bidang
        
        JOIN pegawai peg ON peg.id = pa.id_pegawai
        LEFT JOIN pegawai_jabatan_bidang pjb_pengaju ON pjb_pengaju.id_pegawai = peg.id AND pjb_pengaju.tanggal_selesai IS NULL
        LEFT JOIN jabatan_bidang jb_pengaju ON jb_pengaju.id = pjb_pengaju.id_jabatan_bidang
        
        WHERE pa.id = :id
    ");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getDiterimaPimpinanOnly()
    {
        $query = "SELECT pa.*, p.nama AS nama_pegawai, at.nama AS nama_pimpinan
              FROM {$this->table} pa
              JOIN pegawai p ON pa.id_pegawai = p.id
              LEFT JOIN pegawai at ON pa.id_atasan = at.id
              WHERE pa.status = 'diterima'
              ORDER BY pa.tanggal_disetujui DESC";

        $this->db->query($query);
        return $this->db->resultSet();
    }
}
