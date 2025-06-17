<?php

class Pajak_model
{
    private $table = 'transaksi_pajak';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function tambahDataTransaksiPajak($data)
    {
        $query = "INSERT INTO transaksi_pajak (id_transaksi, id_jenis_pajak, tipe_buku, tanggal, no_bukti, keterangan, tipe_kategori, nominal_transaksi, nilai_pajak ) VALUES (:id_transaksi, :id_jenis_pajak, :tipe_buku, :tanggal, :no_bukti, :keterangan, :tipe_kategori, :nominal_transaksi, :nilai_pajak)";
        $this->db->query($query);
        $this->db->bind('id_transaksi', $data['id_transaksi']);
        $this->db->bind('id_jenis_pajak', $data['id_jenis_pajak']);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('no_bukti', $data['no_bukti']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
        $this->db->bind('nilai_pajak', $data['nilai_pajak']);

        $this->db->execute();

        return $this->db->rowCount();
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

    public function hapusDataTransaksi($id)
    {
        $query = "DELETE FROM transaksi_pajak WHERE id= :id";
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




    public function getUniqueMonthsAndYears()
    {
        $query = "SELECT DISTINCT 
                MONTH(tanggal) AS bulan, 
                YEAR(tanggal) AS tahun 
              FROM transaksi_pajak
              ORDER BY tahun DESC, bulan DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }


    public function getTransaksiByBulanTahun($bulan, $tahun)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun ORDER BY tanggal ASC");
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    // public function getTransaksiPajakLengkap($bulan, $tahun)
    // {
    //     $query = "SELECT 
    //             t.id AS id_transaksi,
    //             tp.id_jenis_pajak,
    //             t.tanggal,
    //             t.no_bukti,
    //             t.keterangan,
    //             t.kategori,
    //             t.tipe_kategori,
    //             t.nominal_transaksi,
    //             tp.nilai_pajak
    //           FROM transaksi
    //           LEFT JOIN transaksi_pajak tp ON t.id = tp.id_transaksi
    //           WHERE t.tipe_buku = 'Pajak' 
    //           AND MONTH(t.tanggal) = :bulan 
    //           AND YEAR(t.tanggal) = :tahun
    //           ORDER BY t.tanggal ASC";

    //     $this->db->query($query);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);

    //     return $this->db->resultSet();
    // }

    public function getTransaksiPajakLengkap($bulan, $tahun)
    {
        $query = "SELECT 
                tp.id,
                tp.id_transaksi,
                tp.tanggal,
                tp.no_bukti,
                tp.keterangan,
                tp.tipe_kategori,
                tp.nominal_transaksi,
                tp.nilai_pajak,
                jp.tipe AS tipe_pajak,
                jp.tarif_pajak
              FROM transaksi_pajak tp
              INNER JOIN jenis_pajak jp ON tp.id_jenis_pajak = jp.id
              WHERE MONTH(tp.tanggal) = :bulan 
                AND YEAR(tp.tanggal) = :tahun
              ORDER BY tp.tanggal ASC";
        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function getAllNoBuktiTransaksi()
    {
        $query = "SELECT id, no_bukti, keterangan, nominal_transaksi FROM transaksi ORDER BY tanggal DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getAllJenisPajak()
    {
        $query = "SELECT id, tarif_pajak, tipe FROM jenis_pajak";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getNominalTransaksiById($id)
    {
        $this->db->query("SELECT nominal_transaksi FROM transaksi WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single()['nominal_transaksi'];
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
              FROM transaksi_pajak 
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
}


//  DIBAWAH INI OPSI UNTUK PENGGABUNGAN TRANSAKSI NANTI DENGAN DINAMIS FORM

// public function getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun)
// {
//     if ($tipe_buku === 'Kas') {
//         $kodeBukti = 'BPK';
//         $tabel = 'transaksi';
//     } elseif ($tipe_buku === 'Bank') {
//         $kodeBukti = 'BPB';
//         $tabel = 'transaksi';
//     } elseif ($tipe_buku === 'Pajak') {
//         $kodeBukti = 'BPJ';
//         $tabel = 'transaksi_pajak'; // ← ganti ke tabel pajak
//     } else {
//         $kodeBukti = 'BPX';
//         $tabel = 'transaksi';
//     }

//     $query = "SELECT MAX(CAST(SUBSTRING(no_bukti, 4) AS UNSIGNED)) AS nomor_terakhir
//               FROM $tabel 
//               WHERE tipe_buku = :tipe_buku 
//                 AND MONTH(tanggal) = :bulan 
//                 AND YEAR(tanggal) = :tahun";

//     $this->db->query($query);
//     $this->db->bind('tipe_buku', $tipe_buku);
//     $this->db->bind('bulan', $bulan);
//     $this->db->bind('tahun', $tahun);

//     $result = $this->db->single();
//     $nomorTerakhir = $result['nomor_terakhir'] ?? 0;

//     // Nomor berikutnya
//     $nomorBerikutnya = (int)$nomorTerakhir + 1;
//     $noBukti = $kodeBukti . str_pad($nomorBerikutnya, 3, '0', STR_PAD_LEFT);

//     return $noBukti;

