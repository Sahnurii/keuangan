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
    {

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

    // public function getSaldoAwalByTipeBukuDanTanggal($tipeBuku, $bulan, $tahun)
    // {
    //     $query = "SELECT saldo_awal FROM saldo WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun";
    //     $this->db->query($query);
    //     $this->db->bind('tipe_buku', $tipeBuku);
    //     $this->db->bind('bulan', $bulan);
    //     $this->db->bind('tahun', $tahun);
    //     // print_r(gettype($tahun));
    //     // print_r($tahun);

    //     return $this->db->single();
    // }
    public function getSaldoAwalByTipeBukuDanTanggal($tipeBuku, $bulan, $tahun)
    {
        $query = "SELECT saldo_awal, keterangan, tanggal 
              FROM saldo 
              WHERE tipe_buku = :tipe_buku 
                AND MONTH(tanggal) = :bulan 
                AND YEAR(tanggal) = :tahun 
              LIMIT 1"; // Gunakan LIMIT untuk memastikan hanya 1 data yang diambil
        $this->db->query($query);
        $this->db->bind('tipe_buku', $tipeBuku);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);

        return $this->db->single(); // Mengembalikan data saldo awal, keterangan, dan tanggal
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

    // public function getSaldoAkhirBulanSebelumnya($tipe_buku, $bulan, $tahun)
    // {
    //     // Hitung bulan & tahun sebelumnya
    //     $tanggalSebelumnya = date_create("$tahun-$bulan-01");
    //     date_sub($tanggalSebelumnya, date_interval_create_from_date_string("1 month"));
    //     $bulanLalu = $tanggalSebelumnya->format('m');
    //     $tahunLalu = $tanggalSebelumnya->format('Y');

    //     // Ambil saldo awal bulan lalu
    //     $saldo = $this->getSaldoAwalByTipeBukuDanTanggal($tipe_buku, $bulanLalu, $tahunLalu);
    //     $saldo_awal = $saldo && isset($saldo['saldo_awal']) ? $saldo['saldo_awal'] : 0;

    //     // Ambil transaksi bulan lalu
    //     if ($tipe_buku === 'Pajak') {
    //         $this->db->query("
    //         SELECT t.tipe_kategori, p.nilai_pajak AS nominal
    //         FROM transaksi_pajak p
    //         JOIN transaksi t ON p.id_transaksi_sumber = t.id
    //         WHERE MONTH(t.tanggal) = :bulan AND YEAR(t.tanggal) = :tahun
    //     ");
    //         $this->db->bind('bulan', $bulanLalu);
    //         $this->db->bind('tahun', $tahunLalu);
    //     } else {
    //         $this->db->query("
    //         SELECT tipe_kategori, nominal_transaksi AS nominal
    //         FROM transaksi
    //         WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun
    //     ");
    //         $this->db->bind('tipe_buku', $tipe_buku);
    //         $this->db->bind('bulan', $bulanLalu);
    //         $this->db->bind('tahun', $tahunLalu);
    //     }

    //     $transaksi = $this->db->resultSet();

    //     // Hitung saldo akhir
    //     foreach ($transaksi as $trx) {
    //         if ($trx['tipe_kategori'] === 'Pemasukan') {
    //             $saldo_awal += $trx['nominal'];
    //         } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
    //             $saldo_awal -= $trx['nominal'];
    //         }
    //     }

    //     return $saldo_awal;
    // }

    public function getSaldoAkhirBulanSebelumnya($tipe_buku, $bulan, $tahun)
    {
        // Hitung bulan & tahun sebelumnya
        $tanggalSebelumnya = date_create("$tahun-$bulan-01");
        date_sub($tanggalSebelumnya, date_interval_create_from_date_string("1 month"));
        $bulanLalu = $tanggalSebelumnya->format('m');
        $tahunLalu = $tanggalSebelumnya->format('Y');

        // Ambil saldo awal bulan lalu
        $saldo = $this->getSaldoAwalByTipeBukuDanTanggal($tipe_buku, $bulanLalu, $tahunLalu);
        $saldo_awal = $saldo && isset($saldo['saldo_awal']) ? $saldo['saldo_awal'] : 0;

        // Ambil transaksi sesuai tipe buku
        if ($tipe_buku === 'Pajak') {
            // Khusus pajak ambil nilai_pajak
            $this->db->query("
            SELECT t.tipe_kategori, p.nilai_pajak
            FROM transaksi_pajak p
            JOIN transaksi t ON p.id_transaksi_pembayaran = t.id
            WHERE MONTH(t.tanggal) = :bulan AND YEAR(t.tanggal) = :tahun
        ");
            $this->db->bind('bulan', $bulanLalu);
            $this->db->bind('tahun', $tahunLalu);

            $transaksi = $this->db->resultSet();

            // Perhitungan berdasarkan nilai_pajak
            foreach ($transaksi as $trx) {
                if ($trx['tipe_kategori'] === 'Pemasukan') {
                    $saldo_awal += (float)$trx['nilai_pajak'];
                } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                    $saldo_awal -= (float)$trx['nilai_pajak'];
                }
            }
        } else {
            // Untuk kas & bank
            $this->db->query("
            SELECT tipe_kategori, nominal_transaksi AS nominal
            FROM transaksi
            WHERE tipe_buku = :tipe_buku AND MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun
        ");
            $this->db->bind('tipe_buku', $tipe_buku);
            $this->db->bind('bulan', $bulanLalu);
            $this->db->bind('tahun', $tahunLalu);

            $transaksi = $this->db->resultSet();

            foreach ($transaksi as $trx) {
                if ($trx['tipe_kategori'] === 'Pemasukan') {
                    $saldo_awal += (float)$trx['nominal'];
                } elseif ($trx['tipe_kategori'] === 'Pengeluaran') {
                    $saldo_awal -= (float)$trx['nominal'];
                }
            }
        }

        return $saldo_awal;
    }
}
