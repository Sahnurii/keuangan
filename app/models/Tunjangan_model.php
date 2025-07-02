<?php

class Tunjangan_model
{
    private $table = 'master_tunjangan_pendidikan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllTunjangan()
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY jenjang ASC");
        return $this->db->resultSet();
    }

    public function getTunjanganById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahTunjangan($data)
    {
        $query = "INSERT INTO {$this->table} (jenjang, nominal) VALUES (:jenjang, :nominal)";
        $this->db->query($query);
        $this->db->bind('jenjang', $data['jenjang']);
        $this->db->bind('nominal', $data['nominal']);
        $this->db->execute();
        return $this->db->rowCount();   
    }

    public function updateTunjangan($data)
    {
        $query = "UPDATE {$this->table} SET jenjang = :jenjang, nominal = :nominal WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('jenjang', $data['jenjang']);
        $this->db->bind('nominal', $data['nominal']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusTunjangan($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekJenjangDuplikat($jenjang)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE jenjang = :jenjang");
        $this->db->bind('jenjang', $jenjang);
        $result = $this->db->single();
        return $result['total'] > 0;
    }

    public function getTotalTunjangan()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $this->db->single();
    }
}
