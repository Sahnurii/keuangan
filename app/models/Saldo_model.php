<?php

class Saldo_model
{
    private $table = 'saldo';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllSaldo()
    {
        $this->db->query("SELECT * FROM saldo ORDER BY tanggal ASC");
        return $this->db->resultSet();
    }

    public function getSaldoById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataSaldo($data)
    { {

            $query = "INSERT INTO saldo (tipe_buku, saldo_awal, keterangan, tanggal) 
                      VALUES (:tipe_buku, :saldo_awal, :keterangan, :tanggal)";
            $this->db->query($query);

            // Bind parameter ke query
            $this->db->bind('tipe_buku', $data['tipe_buku']);
            $this->db->bind('saldo_awal', $data['saldo_awal']);
            $this->db->bind('keterangan',  $data['keterangan']);
            $this->db->bind('tanggal', $data['tanggal']);

            $this->db->execute();

            return $this->db->rowCount();
        }
    }

    public function hapusDataSaldo($id)
    {
        $query = "DELETE FROM saldo WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editDataSaldo($data)
    {
        $query = "UPDATE saldo SET tipe_buku = :tipe_buku, saldo_awal = :saldo_awal, keterangan = :keterangan, tanggal = :tanggal WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('saldo_awal', $data['saldo_awal']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('tanggal', $data['tanggal']);

        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getSaldoAwalByTipeBukuDanTanggal($tipeBuku, $bulan, $tahun)
    {
        $query = "SELECT saldo_awal FROM saldo WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipeBuku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        // print_r(gettype($tahun));
        // print_r($tahun);

        return $this->db->single();
    }

    public function cekSaldoDuplikat($tipe_buku, $bulan, $tahun)
    {
        $query = "SELECT COUNT(*) AS jumlah 
              FROM saldo 
              WHERE tipe_buku = :tipe_buku 
                AND MONTH(tanggal) = :bulan 
                AND YEAR(tanggal) = :tahun";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipe_buku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);

        $result = $this->db->single();
        return $result['jumlah'] > 0; // Mengembalikan `true` jika sudah ada data
    }

    public function cekSaldoDuplikatEdit($id, $tipe_buku, $bulan, $tahun)
    {
        $query = "SELECT COUNT(*) AS jumlah 
              FROM saldo 
              WHERE tipe_buku = :tipe_buku 
                AND MONTH(tanggal) = :bulan 
                AND YEAR(tanggal) = :tahun 
                AND id != :id";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipe_buku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        $this->db->bind('id', $id);

        $result = $this->db->single();
        return $result['jumlah'] > 0; // Mengembalikan `true` jika sudah ada data
    }
}
