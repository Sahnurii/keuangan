<?php

class Gaji_model
{
    private $table = 'gaji';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllGaji()
    {
        $this->db->query("SELECT gaji.*, pegawai.nama FROM " . $this->table . " JOIN pegawai ON gaji.id_pegawai = pegawai.id");
        return $this->db->resultSet();
    }

    public function tambahGaji($data)
    {
        $query = "INSERT INTO gaji 
        (tanggal, id_pegawai, gaji_pokok, insentif, bobot_masa_kerja, pendidikan, beban_kerja, pemotongan) 
        VALUES 
        (:tanggal, :id_pegawai, :gaji_pokok, :insentif, :bobot_masa_kerja, :pendidikan, :beban_kerja, :pemotongan)";

        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->bind('bobot_masa_kerja', $data['bobot_masa_kerja'] ?? '');
        $this->db->bind('pendidikan', $data['pendidikan'] ?? '');
        $this->db->bind('beban_kerja', $data['beban_kerja'] ?? '');
        $this->db->bind('pemotongan', $data['pemotongan'] ?? '');

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getGajiById($id)
    {
        $this->db->query("SELECT gaji.*, pegawai.nama FROM " . $this->table . " JOIN pegawai ON gaji.id_pegawai = pegawai.id WHERE gaji.id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function updateGaji($data)
    {
        $query = "UPDATE gaji SET
            tanggal = :tanggal, 
            gaji_pokok = :gaji_pokok,
            insentif = :insentif,
            bobot_masa_kerja = :bobot_masa_kerja,
            pendidikan = :pendidikan,
            beban_kerja = :beban_kerja,
            pemotongan = :pemotongan
            WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->bind('bobot_masa_kerja', $data['bobot_masa_kerja']);
        $this->db->bind('pendidikan', $data['pendidikan']);
        $this->db->bind('beban_kerja', $data['beban_kerja']);
        $this->db->bind('pemotongan', $data['pemotongan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusGaji($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUniqueMonthsAndYears()
    {
        $this->db->query("SELECT DISTINCT MONTH(tanggal) AS bulan, YEAR(tanggal) AS tahun FROM gaji ORDER BY tahun DESC, bulan ASC");
        return $this->db->resultSet();
    }

    public function getGajiByBulanTahun($bulan, $tahun)
    {
        $this->db->query("SELECT gaji.*, pegawai.nama FROM gaji 
                      JOIN pegawai ON gaji.id_pegawai = pegawai.id 
                      WHERE MONTH(gaji.tanggal) = :bulan AND YEAR(gaji.tanggal) = :tahun 
                      ORDER BY gaji.tanggal ASC");
        $this->db->bind(':bulan', $bulan);
        $this->db->bind(':tahun', $tahun);
        return $this->db->resultSet();
    }

    public function simpanReferensiPembayaran($id, $reference)
    {
        $query = "UPDATE gaji SET payment_reference = :ref, status_pembayaran = 'pending' WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('ref', $reference);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function updateStatusBayar($reference, $status)
    {
        $query = "UPDATE gaji SET status_pembayaran = :status WHERE payment_reference = :ref";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('ref', $reference);
        $this->db->execute();
    }
}
