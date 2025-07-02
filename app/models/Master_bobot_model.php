<?php

class Master_bobot_model
{
    private $table = 'master_bobot_masa_kerja';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

        public function getAllBobot()
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY klasifikasi  ASC");
        return $this->db->resultSet();
    }

    public function getBobotById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahBobot($data)
    {
        $query = "INSERT INTO {$this->table} (klasifikasi, bobot) VALUES (:klasifikasi, :bobot)";
        $this->db->query($query);
        $this->db->bind('klasifikasi', $data['klasifikasi']);
        $this->db->bind('bobot', $data['bobot']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateBobot($data)
    {
        $query = "UPDATE {$this->table} SET klasifikasi = :klasifikasi, bobot = :bobot WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('klasifikasi', $data['klasifikasi']);
        $this->db->bind('bobot', $data['bobot']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusBobot($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekBobotDuplikat($klasifikasi)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE klasifikasi = :klasifikasi");
        $this->db->bind('klasifikasi', $klasifikasi);
        $result = $this->db->single();
        return $result['total'] > 0;
    }

    public function getTotalBobot()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $this->db->single();
    }

}
