<?php

class Pengajuan_anggaran_model
{
    private $table = 'pengajuan_anggaran';
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Sesuai arsitektur buatan kamu
    }

    public function getAll()
    {
        $this->db->query("SELECT pa.*, p.nama AS nama_pegawai 
                          FROM {$this->table} pa
                          JOIN pegawai p ON pa.id_pegawai = p.id");
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

    public function tambah($data)
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
}
