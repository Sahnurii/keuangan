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
        $query = "INSERT INTO transaksi_pajak (
        id_transaksi_sumber, id_transaksi_pembayaran, id_jenis_pajak, tipe_buku, nominal_transaksi, nilai_pajak
    ) VALUES (
        :id_transaksi_sumber, :id_transaksi_pembayaran, :id_jenis_pajak, :tipe_buku, :nominal_transaksi, :nilai_pajak
    )";

        $this->db->query($query);
        $this->db->bind('id_transaksi_sumber', $data['id_transaksi_sumber']);
        $this->db->bind('id_transaksi_pembayaran', $data['id_transaksi_pembayaran']);
        $this->db->bind('id_jenis_pajak', $data['id_jenis_pajak']);
        $this->db->bind('tipe_buku', 'Pajak'); // fixed
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
        $this->db->bind('nilai_pajak', $data['nilai_pajak']);
        $this->db->execute();

        return $this->db->rowCount();
    }


    public function getTransaksiPajakLengkap($bulan, $tahun)
    {
        $query = "SELECT 
                tp.id,
                tp.id_transaksi_sumber,
                tp.id_transaksi_pembayaran,
                trx_pajak.tanggal,
                trx_pajak.no_bukti,
                trx_pajak.keterangan,
                trx_pajak.tipe_kategori,
                tp.nominal_transaksi,
                tp.nilai_pajak,
                jp.tipe AS tipe_pajak,
                jp.tarif_pajak,
                trx_pajak.tipe_buku
              FROM transaksi_pajak tp
              INNER JOIN transaksi trx_sumber ON tp.id_transaksi_sumber = trx_sumber.id
              INNER JOIN transaksi trx_pajak ON tp.id_transaksi_pembayaran = trx_pajak.id
              INNER JOIN jenis_pajak jp ON tp.id_jenis_pajak = jp.id
              WHERE MONTH(trx_pajak.tanggal) = :bulan 
                AND YEAR(trx_pajak.tanggal) = :tahun
              ORDER BY trx_pajak.tanggal ASC";

        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }


    public function getTransaksiPajakByIdGabungan($id)
    {
        $this->db->query("SELECT 
                        tp.id,
                        tp.id_transaksi_sumber,
                        tp.id_transaksi_pembayaran,
                        tp.id_jenis_pajak,
                        tp.tipe_buku,
                        tp.nominal_transaksi,
                        tp.nilai_pajak,

                        trx_bayar.tanggal AS tanggal,
                        trx_bayar.no_bukti,
                        trx_bayar.keterangan,
                        trx_bayar.id_kategori,
                        trx_bayar.tipe_kategori,
                        trx_bayar.tipe_buku AS sumber_saldo
                    FROM transaksi_pajak tp
                    JOIN transaksi trx_bayar ON tp.id_transaksi_pembayaran = trx_bayar.id
                    WHERE tp.id = :id");

        $this->db->bind('id', $id);
        return $this->db->single();
    }



    // public function getTransaksiPajakByIdGabungan($id)
    // {
    //     $this->db->query("SELECT 
    //                     tp.*, 
    //                     t.tanggal,
    //                     t.no_bukti,
    //                     t.keterangan,
    //                     t.nominal_transaksi,
    //                     t.tipe_kategori,
    //                     t.id_kategori,
    //                     t.tipe_buku AS sumber_saldo
    //                 FROM transaksi_pajak tp
    //                 JOIN transaksi t ON tp.id_transaksi_sumber = t.id
    //                 WHERE tp.id = :id");
    //     $this->db->bind('id', $id);
    //     return $this->db->single();
    // }



    public function getTransaksiById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function editDataTransaksiPajakGabungan($data)
    {
        // 1. Update transaksi_pajak
        $queryPajak = "UPDATE transaksi_pajak SET 
                    id_transaksi_sumber = :id_transaksi_sumber,
                    id_jenis_pajak = :id_jenis_pajak,
                    tipe_buku = :tipe_buku,
                    nominal_transaksi = :nominal_transaksi,
                    nilai_pajak = :nilai_pajak
                WHERE id = :id";

        $this->db->query($queryPajak);
        $this->db->bind('id', $data['id']);
        $this->db->bind('id_transaksi_sumber', $data['id_transaksi']);
        $this->db->bind('id_jenis_pajak', $data['id_jenis_pajak']);
        $this->db->bind('tipe_buku', $data['tipe_buku']);
        $this->db->bind('nominal_transaksi', $data['nominal_transaksi']);
        $this->db->bind('nilai_pajak', $data['nilai_pajak']);
        $this->db->execute();

        // 2. Update transaksi pembayaran
        $queryTransaksi = "UPDATE transaksi SET 
                        tanggal = :tanggal,
                        keterangan = :keterangan,
                        tipe_kategori = :tipe_kategori,
                        id_kategori = :id_kategori,
                        nominal_transaksi = :nominal_transaksi
                    WHERE id = :id_transaksi_pembayaran";

        $this->db->query($queryTransaksi);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('tipe_kategori', $data['tipe_kategori']);
        $this->db->bind('id_kategori', $data['id_kategori']);
        $this->db->bind('nominal_transaksi', $data['nilai_pajak']); // pembayaran = nilai pajak
        $this->db->bind('id_transaksi_pembayaran', $data['id_transaksi_pembayaran']);
        $this->db->execute();

        return $this->db->rowCount();
    }




    public function hapusDataTransaksi($id)
    {
        // Ambil id_transaksi_pembayaran dari transaksi_pajak
        $this->db->query("SELECT id_transaksi_pembayaran FROM transaksi_pajak WHERE id = :id");
        $this->db->bind('id', $id);
        $result = $this->db->single();

        $idPembayaran = $result['id_transaksi_pembayaran'] ?? null;

        // Hapus dari transaksi_pajak
        $this->db->query("DELETE FROM transaksi_pajak WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();

        // Hapus dari transaksi jika id_transaksi_pembayaran ditemukan
        if ($idPembayaran) {
            $this->db->query("DELETE FROM transaksi WHERE id = :idPembayaran");
            $this->db->bind('idPembayaran', $idPembayaran);
            $this->db->execute();
        }

        return $this->db->rowCount(); // ini hanya jumlah terakhir, tapi cukup oke
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
                MONTH(t.tanggal) AS bulan, 
                YEAR(t.tanggal) AS tahun 
              FROM transaksi_pajak tp
              INNER JOIN transaksi t ON tp.id_transaksi_pembayaran = t.id
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

    // public function getTransaksiPajakLengkap($bulan, $tahun)
    // {
    //     $query = "SELECT 
    //             tp.id,
    //             tp.id_transaksi,
    //             tp.tanggal,
    //             tp.no_bukti,
    //             tp.keterangan,
    //             tp.tipe_kategori,
    //             tp.nominal_transaksi,
    //             tp.nilai_pajak,
    //             jp.tipe AS tipe_pajak,
    //             jp.tarif_pajak
    //           FROM transaksi_pajak tp
    //           INNER JOIN jenis_pajak jp ON tp.id_jenis_pajak = jp.id
    //           WHERE MONTH(tp.tanggal) = :bulan 
    //             AND YEAR(tp.tanggal) = :tahun
    //           ORDER BY tp.tanggal ASC";
    //     $this->db->query($query);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);
    //     return $this->db->resultSet();
    // }

    public function getAllNoBuktiTransaksi($tahun)
    {
        $query = "SELECT t.id, t.tanggal, t.no_bukti, t.keterangan, t.nominal_transaksi 
              FROM transaksi t
              WHERE t.tipe_buku IN ('Kas', 'Bank')
              AND YEAR(t.tanggal) = :tahun
              AND NOT EXISTS (
                  SELECT 1 FROM transaksi_pajak tp 
                  WHERE tp.id_transaksi_pembayaran = t.id
              )
              ORDER BY t.tanggal DESC";
              
        $this->db->query($query);
        $this->db->bind('tahun', $tahun);
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

    public function getNomorBuktiTerakhir($bulan, $tahun)
    {
        $kodeBukti = 'BPJ';

        $query = "SELECT MAX(CAST(SUBSTRING(t.no_bukti, 4) AS UNSIGNED)) AS nomor_terakhir
              FROM transaksi t
              JOIN transaksi_pajak tp ON tp.id_transaksi_pembayaran = t.id
              WHERE t.no_bukti LIKE 'BPJ%'
                AND MONTH(t.tanggal) = :bulan
                AND YEAR(t.tanggal) = :tahun";

        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);

        $result = $this->db->single();
        $nomorTerakhir = $result['nomor_terakhir'] ?? 0;

        $nomorBerikutnya = (int)$nomorTerakhir + 1;

        return $kodeBukti . $nomorBerikutnya;
    }



    // public function getNomorBuktiTerakhir($tipe_buku, $bulan, $tahun)
    // {
    //     // $kodeBukti = ($tipe_buku === 'Kas') ? 'BPK' : 'BPB';

    //     if ($tipe_buku === 'Kas') {
    //         $kodeBukti = 'BPK';
    //     } elseif ($tipe_buku === 'Bank') {
    //         $kodeBukti = 'BPB';
    //     } elseif ($tipe_buku === 'Pajak') {
    //         $kodeBukti = 'BPJ';
    //     } else {
    //         $kodeBukti = 'BPX'; // Default atau bisa disesuaikan
    //     }

    //     $query = "SELECT MAX(CAST(SUBSTRING(no_bukti, 4) AS UNSIGNED)) AS nomor_terakhir
    //           FROM transaksi
    //           WHERE tipe_buku = :tipe_buku 
    //             AND MONTH(tanggal) = :bulan 
    //             AND YEAR(tanggal) = :tahun";

    //     $this->db->query($query);
    //     $this->db->bind('tipe_buku', $tipe_buku);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);

    //     $result = $this->db->single();
    //     $nomorTerakhir = $result['nomor_terakhir'] ?? 0;

    //     // Nomor berikutnya
    //     $nomorBerikutnya = (int)$nomorTerakhir + 1;

    //     return $kodeBukti . $nomorBerikutnya;
    // }
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
