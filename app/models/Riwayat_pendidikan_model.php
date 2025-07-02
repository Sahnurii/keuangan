<?php

class Riwayat_pendidikan_model
{

    private $table = 'riwayat_pendidikan_pegawai';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // public function getAllRiwayatPendidikan()
    // {
    //     $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id ASC");
    //     return $this->db->resultSet();
    // }

    public function getAllRiwayatPendidikan()
    {
        $this->db->query("
        SELECT r.*, p.nama AS nama_pegawai,
        tj.jenjang AS nama_jenjang
        FROM riwayat_pendidikan_pegawai r
        JOIN pegawai p ON r.id_pegawai = p.id
        JOIN master_tunjangan_pendidikan tj ON r.id_jenjang = tj.id
    ");
        return $this->db->resultSet();
    }


    public function getRiwayatPendidikanById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusDataRiwayatPendidikan($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataRiwayatPendidikan($data)
    {
        $query = "INSERT INTO " . $this->table . " 
              (id_pegawai, id_jenjang, gelar, program_studi, nama_kampus) 
              VALUES 
              (:id_pegawai, :id_jenjang, :gelar, :program_studi, :nama_kampus)";

        $this->db->query($query);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('id_jenjang', $data['id_jenjang']);
        $this->db->bind('gelar', $data['gelar']);
        $this->db->bind('program_studi', $data['program_studi']);
        $this->db->bind('nama_kampus', $data['nama_kampus']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editDataRiwayatPendidikan($data)
    {
        $query = "UPDATE " . $this->table . " SET 
                id_pegawai = :id_pegawai,
                id_jenjang = :id_jenjang, 
                gelar = :gelar, 
                program_studi = :program_studi, 
                nama_kampus = :nama_kampus 
              WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('id_jenjang', $data['id_jenjang']);
        $this->db->bind('gelar', $data['gelar']);
        $this->db->bind('program_studi', $data['program_studi']);
        $this->db->bind('nama_kampus', $data['nama_kampus']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getRiwayatPendidikanByPegawaiId($idPegawai)
    {
        $this->db->query("SELECT r.*, tj.jenjang AS nama_jenjang
        FROM " . $this->table . " r
        JOIN master_tunjangan_pendidikan tj ON r.id_jenjang = tj.id
        WHERE r.id_pegawai = :id_pegawai
    ");
        $this->db->bind('id_pegawai', $idPegawai);
        return $this->db->resultSet();
    }
}
