<?php

class Pegawai_model
{

    private $table = 'pegawai';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPegawai()
    {
        $this->db->query("SELECT pegawai.*, bidang.nama_bidang 
        FROM pegawai 
        JOIN bidang ON pegawai.bidang = bidang.id");
        return $this->db->resultSet();
    }

    public function getPegawaiById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusPegawai($id)
    {
        $query = "DELETE FROM pegawai WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahPegawai($data)
    {
        $query = "INSERT INTO pegawai (nama, nipy, bidang, rekening, bank) VALUES (:nama, :nipy, :bidang, :rekening, :bank)";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nipy', $data['nipy']);
        $this->db->bind('bidang', $data['bidang']);
        $this->db->bind('rekening', $data['rekening']);
        $this->db->bind('bank', $data['bank']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editPegawai($data)
    {
        $query = "UPDATE pegawai SET nama = :nama, nipy = :nipy, bidang = :bidang, rekening = :rekening, bank = :bank WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nipy', $data['nipy']);
        $this->db->bind('bidang', $data['bidang']);
        $this->db->bind('rekening', $data['rekening']);
        $this->db->bind('bank', $data['bank']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cekNipyDuplikat($nipy, $excludeId = null)
    {
        if ($excludeId) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE nipy = :nipy AND id != :id";
            $this->db->query($query);
            $this->db->bind('nipy', $nipy);
            $this->db->bind('id', $excludeId);
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE nipy = :nipy";
            $this->db->query($query);
            $this->db->bind('nipy', $nipy);
        }

        $result = $this->db->single();
        return $result['total'] > 0;
    }

     public function getTotalPegawai()
    {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single();
    }
}
