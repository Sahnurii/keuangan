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
        (tanggal, id_pegawai, gaji_pokok, insentif, bobot_masa_kerja, pendidikan, beban_kerja, pemotongan, status_pembayaran) 
        VALUES 
        (:tanggal, :id_pegawai, :gaji_pokok, :insentif, :bobot_masa_kerja, :pendidikan, :beban_kerja, :pemotongan, :status_pembayaran)";

        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->bind('bobot_masa_kerja', $data['bobot_masa_kerja'] ?? '');
        $this->db->bind('pendidikan', $data['pendidikan'] ?? '');
        $this->db->bind('beban_kerja', $data['beban_kerja'] ?? '');
        $this->db->bind('pemotongan', $data['pemotongan'] ?? '');
        $this->db->bind('status_pembayaran', 'pending');

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
            pemotongan = :pemotongan,
            status_pembayaran = :status_pembayaran,
            payment_reference = NULL,
            snap_token = NULL
            WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->bind('bobot_masa_kerja', $data['bobot_masa_kerja']);
        $this->db->bind('pendidikan', $data['pendidikan']);
        $this->db->bind('beban_kerja', $data['beban_kerja']);
        $this->db->bind('pemotongan', $data['pemotongan']);
        $this->db->bind('status_pembayaran', 'pending');
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

    public function getDataGajiOtomatis($id_pegawai, $tanggal)
    {
        // Ambil semua jabatan bidang aktif pada tanggal tertentu
        $this->db->query("
        SELECT pjb.id_jabatan_bidang
        FROM pegawai_jabatan_bidang pjb
        WHERE pjb.id_pegawai = :id_pegawai
          AND pjb.tanggal_mulai <= :tanggal
          AND (pjb.tanggal_selesai IS NULL OR pjb.tanggal_selesai > :tanggal)
    ");
        $this->db->bind('id_pegawai', $id_pegawai);
        $this->db->bind('tanggal', $tanggal);
        $jabatanBidangs = $this->db->resultSet();

        $total_gaji_pokok = 0;
        $total_insentif = 0;

        // Loop semua jabatan aktif, dan total gaji pokok & insentif
        foreach ($jabatanBidangs as $row) {
            $this->db->query("SELECT gaji_pokok, insentif FROM template_gaji_jabatan WHERE id_jabatan_bidang = :id");
            $this->db->bind('id', $row['id_jabatan_bidang']);
            $template = $this->db->single();
            if ($template) {
                $total_gaji_pokok += (float)$template['gaji_pokok'];
                $total_insentif += (float)$template['insentif'];
            }
        }

        // Ambil pendidikan tertinggi dari riwayat_pendidikan_pegawai
        $this->db->query("
        SELECT mtp.nominal
        FROM riwayat_pendidikan_pegawai rpp
        JOIN master_tunjangan_pendidikan mtp ON rpp.id_jenjang = mtp.id
        WHERE rpp.id_pegawai = :id_pegawai
        ORDER BY rpp.id_jenjang DESC
        LIMIT 1
    ");
        $this->db->bind('id_pegawai', $id_pegawai);
        $pendidikan = $this->db->single();
        $nominal_pendidikan = $pendidikan ? (float)$pendidikan['nominal'] : 0;

        // Ambil data pegawai untuk menghitung masa kerja
        $this->db->query("SELECT tmt, id_klasifikasi FROM pegawai WHERE id = :id_pegawai");
        $this->db->bind('id_pegawai', $id_pegawai);
        $pegawai = $this->db->single();

        $tmt = new DateTime($pegawai['tmt']);
        $end = new DateTime($tanggal);
        $interval = $tmt->diff($end);
        $jumlah_bulan = ($interval->y * 12) + $interval->m;

        // Ambil bobot per bulan
        $this->db->query("SELECT bobot FROM master_bobot_masa_kerja WHERE id = :id_klasifikasi");
        $this->db->bind('id_klasifikasi', $pegawai['id_klasifikasi']);
        $bobot = $this->db->single();
        $bobot_per_bulan = $bobot ? (float)$bobot['bobot'] : 0;

        // Hitung total bobot masa kerja
        $bobot_masa_kerja = $jumlah_bulan * $bobot_per_bulan;

        // $bobot_masa_kerja = $this->getBobotMasaKerja($id_pegawai);

        return [
            'gaji_pokok' => $total_gaji_pokok,
            'insentif' => $total_insentif,
            'pendidikan' => $nominal_pendidikan,
            'bobot_masa_kerja' => $bobot_masa_kerja,
            'bobot_per_bulan' => $bobot_per_bulan,
            'jumlah_bulan' => $jumlah_bulan
        ];
    }

    private function hitungSelisihBulan($tmt, $tanggal_input)
    {
        $start = new DateTime($tmt);
        $end = new DateTime($tanggal_input);
        $interval = $start->diff($end);
        return ($interval->y * 12) + $interval->m;
    }

    public function getBobotMasaKerja($id_pegawai)
    {
        // Ambil data TMT dan ID klasifikasi dari tabel pegawai
        $sql = "SELECT tmt, id_klasifikasi FROM pegawai WHERE id = :id_pegawai";
        $this->db->query($sql);
        $this->db->bind('id_pegawai', $id_pegawai);
        $pegawai = $this->db->single();

        if (!$pegawai) {
            return 0;
        }

        // Hitung masa kerja dalam bulan dari TMT
        $now = new DateTime();
        $tmt = new DateTime($pegawai['tmt']);
        $interval = $tmt->diff($now);
        $masaKerjaBulan = ($interval->y * 12) + $interval->m;

        // Ambil bobot dari master_bobot_masa_kerja berdasarkan id_klasifikasi
        $sql = "SELECT bobot FROM master_bobot_masa_kerja WHERE id = :id_klasifikasi";
        $this->db->query($sql);
        $this->db->bind('id_klasifikasi', $pegawai['id_klasifikasi']);
        $bobot = $this->db->single();

        if ($bobot) {
            return $masaKerjaBulan * $bobot['bobot'];
        } else {
            return 0;
        }
    }

    public function updateLinkUrl($id_gaji, $url)
    {
        $this->db->query("UPDATE gaji SET link_pembayaran = :url WHERE id = :id");
        $this->db->bind(':url', $url);
        $this->db->bind(':id', $id_gaji);
        return $this->db->execute();
    }

    public function updatePaymentInfo($id, $data)
    {
        $query = "UPDATE gaji SET payment_reference = :ref, status_pembayaran = :status, snap_token = :snap_token WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('ref', $data['payment_reference']);
        $this->db->bind('status', $data['status_pembayaran']);
        $this->db->bind('snap_token', $data['snap_token']);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function updatePaymentStatus($orderId, $status)
    {
        // Karena order_id = "GJ-{id}", kita perlu ambil id-nya
        // $idGaji = str_replace('GJ-', '', $orderId);
        $query = "UPDATE gaji SET status_pembayaran = :status WHERE payment_reference = :ref";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('ref', $orderId);
        return $this->db->execute();
    }

    public function cekGajiDuplikat($id_pegawai, $tanggal)
    {
        // Ekstrak bulan dan tahun dari tanggal input (format YYYY-MM-DD)
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $query = "SELECT COUNT(*) as total 
              FROM " . $this->table . " 
              WHERE id_pegawai = :id_pegawai 
                AND MONTH(tanggal) = :bulan 
                AND YEAR(tanggal) = :tahun";

        $this->db->query($query);
        $this->db->bind('id_pegawai', $id_pegawai);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);

        $result = $this->db->single();
        return $result['total'] > 0;
    }
}
