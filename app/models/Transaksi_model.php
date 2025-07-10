<?php

class Transaksi_model
{
    private $table = 'transaksi';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLastInsertedId()
    {
        return $this->db->lastInsertId();
    }

    public function tambahDataTransaksi($data)
    {
        // echo '<pre>';
        // print_r($data);  // Debug sebelum insert
        // echo '</pre>';
        // exit;

        $query = "INSERT INTO transaksi (tipe_buku, tanggal, no_bukti, keterangan, id_kategori, tipe_kategori, nominal_transaksi) VALUES (:tipe_buku, :tanggal, :no_bukti, :keterangan, :id_kategori, :tipe_kategori, :nominal_transaksi)";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('no_bukti', $data['no_bukti']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('id_kategori', $data['id_kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);

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

    // public function getAllTransaksi($bulan, $tahun)
    // {
    //     $query = "SELECT * FROM transaksi WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY DATE(tanggal) ASC";
    //     $this->db->query($query);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);
    //     return $this->db->resultSet();
    // }

    // public function getAllTransaksi($bulan, $tahun)
    // {
    //     $query = "SELECT 
    //             transaksi.*, 
    //             kategori.nama_kategori 
    //           FROM transaksi 
    //           LEFT JOIN kategori ON transaksi.id_kategori = kategori.id
    //           WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun
    //           ORDER BY tanggal ASC";

    //     $this->db->query($query);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);
    //     return $this->db->resultSet();
    // }

    // public function getAllTransaksi($bulan, $tahun)
    // {
    //     $this->db->query("
    //     SELECT 
    //         t.id,
    //         t.tanggal,
    //         t.no_bukti,
    //         t.keterangan,
    //         k.nama_kategori,
    //         t.nominal_transaksi,
    //         t.tipe_kategori,
    //         t.tipe_buku
    //     FROM transaksi t
    //     LEFT JOIN kategori k ON t.id_kategori = k.id
    //     WHERE MONTH(t.tanggal) = :bulan AND YEAR(t.tanggal) = :tahun

    //     UNION ALL

    //     SELECT 
    //         tp.id,
    //         tp.tanggal,
    //         tp.no_bukti,
    //         tp.keterangan,
    //         'Pajak' AS nama_kategori,
    //         tp.nilai_pajak AS nominal_transaksi,
    //         tp.tipe_kategori,
    //         'Pajak' AS tipe_buku
    //     FROM transaksi_pajak tp
    //     WHERE MONTH(tp.tanggal) = :bulan AND YEAR(tp.tanggal) = :tahun

    //     ORDER BY tanggal ASC
    // ");
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);

    //     return $this->db->resultSet();
    // }


    // public function getTransaksiByTipeBuku($tipeBuku, $bulan, $tahun)
    // {
    //     $query = "SELECT * FROM transaksi WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY DATE(tanggal) ASC";
    //     $this->db->query($query);
    //     $this->db->bind('tipe_buku', $tipeBuku);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);
    //     return $this->db->resultSet();
    // }

    public function getAllTransaksi($bulan, $tahun)
    {
        $query = "SELECT t.*, k.nama_kategori,
                     EXISTS (
                         SELECT 1 FROM transaksi_pajak tp WHERE tp.id_transaksi_sumber = t.id
                     ) AS is_pajak
              FROM transaksi t
              JOIN kategori k ON t.id_kategori = k.id
              WHERE MONTH(t.tanggal) = :bulan AND YEAR(t.tanggal) = :tahun
              ORDER BY t.tanggal ASC";

        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getTransaksiByTipeBuku($tipeBuku, $bulan, $tahun)
    {
        $query = "SELECT 
            t.*, 
            k.nama_kategori 
          FROM transaksi t
          LEFT JOIN kategori k ON t.id_kategori = k.id
          WHERE t.tipe_buku = :tipe_buku 
            AND MONTH(t.tanggal) = :bulan 
            AND YEAR(t.tanggal) = :tahun
          ORDER BY t.tanggal ASC";

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
        $query = "UPDATE transaksi SET tipe_buku = :tipe_buku, tanggal = :tanggal, no_bukti = :no_bukti, keterangan = :keterangan, id_kategori = :id_kategori, tipe_kategori = :tipe_kategori, nominal_transaksi = :nominal_transaksi WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('no_bukti', $data['no_bukti']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('id_kategori', $data['id_kategori']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
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

    public function getSummaryBulanan($tahun)
    {
        $this->db->query("
        SELECT 
            MONTH(tanggal) AS bulan,
            SUM(CASE WHEN tipe_kategori = 'Pemasukan' THEN nominal_transaksi ELSE 0 END) AS pemasukan,
            SUM(CASE WHEN tipe_kategori = 'Pengeluaran' THEN nominal_transaksi ELSE 0 END) AS pengeluaran
        FROM transaksi
        WHERE YEAR(tanggal) = :tahun
        GROUP BY MONTH(tanggal)
        ORDER BY bulan
    ");
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getKomposisiPemasukan($bulan, $tahun)
    {
        $this->db->query("
        SELECT 
            k.nama_kategori AS kategori,
            SUM(t.nominal_transaksi) AS total
        FROM transaksi t
        JOIN kategori k ON t.id_kategori = k.id
        WHERE MONTH(t.tanggal) = :bulan
          AND YEAR(t.tanggal) = :tahun
          AND t.tipe_kategori = 'Pemasukan'
        GROUP BY k.nama_kategori
    ");
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getKomposisiPengeluaran($bulan, $tahun)
    {
        $this->db->query("
        SELECT 
            k.nama_kategori AS kategori,
            SUM(t.nominal_transaksi) AS total
        FROM transaksi t
        JOIN kategori k ON t.id_kategori = k.id
        WHERE MONTH(t.tanggal) = :bulan
          AND YEAR(t.tanggal) = :tahun
          AND t.tipe_kategori = 'Pengeluaran'
        GROUP BY k.nama_kategori
    ");
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }
}
