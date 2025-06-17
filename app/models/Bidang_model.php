<?php

class Bidang_model
{

    private $table = 'bidang';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBidang()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function getBidangById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusDataBidang($id)
    {
        $query = "DELETE FROM bidang WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataBidang($data)
    {
        $query = "INSERT INTO bidang (jabatan, nama_bidang) VALUES (:jabatan, :nama_bidang)";
        $this->db->query($query);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('nama_bidang', $data['nama_bidang']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editDataBidang($data)
    {
        $query = "UPDATE bidang SET jabatan = :jabatan, nama_bidang = :nama_bidang WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('nama_bidang', $data['nama_bidang']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cekBidangDuplikat($jabatan, $nama_bidang)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE jabatan = :jabatan AND nama_bidang = :nama_bidang";
        $this->db->query($query);
        $this->db->bind('jabatan', $jabatan);
        $this->db->bind('nama_bidang', $nama_bidang);
        $result = $this->db->single();
        return $result['total'] > 0; // Mengembalikan true jika ada duplikat
    }

    public function getTotalBidang()
    {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single();
    }
}
