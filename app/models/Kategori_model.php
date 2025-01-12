<?php

class kategori_model
{

    private $table = 'kategori';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getKategoriByTipe($tipe_kategori)
    {
        // Jika tipe_kategori ada, ambil data kategori dari tabel kategori berdasarkan tipe_kategori
        if ($tipe_kategori) {
            $this->db->query("SELECT id, nama_kategori, tipe_kategori FROM " . $this->table . " WHERE tipe_kategori = :tipe_kategori");
            $this->db->bind('tipe_kategori', $tipe_kategori);
            return $this->db->resultSet(); // Mengembalikan hasil dalam bentuk array
        }
        return []; // Jika tidak ada tipe_kategori, mengembalikan array kosong
    }

    public function getAllKategori()
    {
        // $this->db->query("SELECT * FROM " . $this->table);
        // return $this->db->resultSet();
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tipe_kategori ASC");
        return $this->db->resultSet();
    }

    public function getKategoriById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusDataKategori($id)
    {
        $query = "DELETE FROM kategori WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataKategori($data)
    {
        $query = "INSERT INTO kategori (nama_kategori, tipe_kategori) VALUES (:nama_kategori, :tipe_kategori)";
        $this->db->query($query);
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editDataKategori($data)
    {
        $query = "UPDATE kategori SET nama_kategori = :nama_kategori, tipe_kategori = :tipe_kategori WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getTotalKategori()
    {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single();
    }
}
