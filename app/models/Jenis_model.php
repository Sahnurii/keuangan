<?php

class Jenis_model
{

    private $table = 'jenis_pajak';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllJenisPajak()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function getJenisPajakById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusDataJenisPajak($id)
    {
        $query = "DELETE FROM jenis_pajak WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataJenisPajak($data)
    {
        $query = "INSERT INTO jenis_pajak ( tarif_pajak, tipe) VALUES ( :tarif_pajak, :tipe)";
        $this->db->query($query);
        $this->db->bind('tarif_pajak', $data['tarif_pajak']);
        $this->db->bind('tipe', $data['tipe']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editDataJenisPajak($data)
    {
        $query = "UPDATE jenis_pajak SET tarif_pajak = :tarif_pajak, tipe = :tipe WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('tarif_pajak', $data['tarif_pajak']);
        $this->db->bind('tipe', $data['tipe']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getTotalJenisPajak()
    {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single();
    }

    public function cekJenisPajakDuplikat($tarif_pajak, $tipe)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE tarif_pajak = :tarif_pajak AND tipe = :tipe";
        $this->db->query($query);
        $this->db->bind('tarif_pajak', $tarif_pajak);
        $this->db->bind('tipe', $tipe);
        $result = $this->db->single();
        return $result['total'] > 0; // Mengembalikan true jika ada duplikat
    }
}
