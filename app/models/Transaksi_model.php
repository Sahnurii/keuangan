<?php

class Transaksi_model
{
    private $table = 'transaksi';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function tambahDataTransaksi($data)
    {
        $query = "INSERT INTO transaksi (tipe_buku, tanggal, no_bukti, keterangan, kategori, tipe_kategori, nominal_transaksi, sumber_saldo) VALUES (:tipe_buku, :tanggal, :no_bukti, :keterangan, :kategori, :tipe_kategori, :nominal_transaksi, :sumber_saldo)";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('no_bukti', $data['no_bukti']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('kategori', $data['nama_kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
        $this->db->bind('sumber_saldo', $data['sumber_saldo']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusDataTransaksi($id)
    {
        $query = "DELETE FROM transaksi WHERE id= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getAllTransaksi($bulan, $tahun)
    {
        $query = "SELECT * FROM transaksi WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY DATE(tanggal) ASC";
        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getTransaksiByTipeBuku($tipeBuku, $bulan, $tahun)
    {
        $query = "SELECT * FROM transaksi WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY DATE(tanggal) ASC";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipeBuku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getTransaksiById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function editDataTransaksi($data)
    {
        $query = "UPDATE transaksi SET tipe_buku = :tipe_buku, tanggal = :tanggal, no_bukti = :no_bukti, keterangan = :keterangan, kategori = :kategori, tipe_kategori = :tipe_kategori, nominal_transaksi = :nominal_transaksi, sumber_saldo =:sumber_saldo WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('no_bukti', $data['no_bukti']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
        $this->db->bind('sumber_saldo', $data['sumber_saldo']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getUniqueMonthsAndYears($tipe)
    {
        $query = "SELECT DISTINCT 
                MONTH(tanggal) AS bulan, 
                YEAR(tanggal) AS tahun 
              FROM transaksi 
              WHERE tipe_buku = :tipe_buku
              ORDER BY tahun DESC, bulan DESC";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipe);
        return $this->db->resultSet();
    }

    public function getUniqueMonthsAndYearsUniversal()
    {
        $query = "SELECT DISTINCT 
                MONTH(tanggal) AS bulan, 
                YEAR(tanggal) AS tahun 
              FROM transaksi
              ORDER BY tahun DESC, bulan DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun)
    {
        // $kodeBukti = ($tipe_buku === 'Kas') ? 'BPK' : 'BPB';

        if ($tipe_buku === 'Kas') {
            $kodeBukti = 'BPK';
        } elseif ($tipe_buku === 'Bank') {
            $kodeBukti = 'BPB';
        } elseif ($tipe_buku === 'Pajak') {
            $kodeBukti = 'BPJ';
        } else {
            $kodeBukti = 'BPX'; // Default atau bisa disesuaikan
        }

        $query = "SELECT MAX(CAST(SUBSTRING(no_bukti, 4) AS UNSIGNED)) AS nomor_terakhir
              FROM transaksi 
              WHERE tipe_buku = :tipe_buku 
                AND MONTH(tanggal) = :bulan 
                AND YEAR(tanggal) = :tahun";

        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipe_buku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);

        $result = $this->db->single();
        $nomorTerakhir = $result['nomor_terakhir'] ?? 0;

        // Nomor berikutnya
        $nomorBerikutnya = (int)$nomorTerakhir + 1;

        return $kodeBukti . $nomorBerikutnya;
    }

    public function getTransaksiByBulanTahun($bulan, $tahun)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY tanggal ASC");
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }
    
    public function getSaldoAwal($bulan, $tahun)
    {
        $query = "SELECT SUM(nominal_transaksi) AS saldo_awal 
              FROM transaksi 
              WHERE (MONTH(tanggal) < :bulan AND YEAR(tanggal) = :tahun) OR (YEAR(tanggal) < :tahun)";
        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        $result = $this->db->single();
        return $result['saldo_awal'] ?? 0;
    }
}
