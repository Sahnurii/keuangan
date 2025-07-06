<?php

class Pegawai_model
{

    private $table = 'pegawai';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPegawai()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function getPegawaiById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getNamaById($id)
    {
        $this->db->query("SELECT nama FROM " . $this->table . " WHERE id = :id");
        $this->db->bind('id', $id);
         return $this->db->single();
    }


    public function hapusPegawai($id)
    {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function tambahPegawai($data)
    {
        $query = "INSERT INTO pegawai (
            nama, nipy, sk_pengangkatan, tmt, nomor_induk, jenis_nomor_induk,
            tempat_lahir, tanggal_lahir, jenis_kelamin, no_hp, agama, status_perkawinan,
            alamat_pegawai, keterangan, email, spk, no_rekening, bank, id_klasifikasi
        ) VALUES (
            :nama, :nipy, :sk_pengangkatan, :tmt, :nomor_induk, :jenis_nomor_induk,
            :tempat_lahir, :tanggal_lahir, :jenis_kelamin, :no_hp, :agama, :status_perkawinan,
            :alamat_pegawai, :keterangan, :email, :spk, :no_rekening, :bank, :id_klasifikasi
        )";

        $this->db->query($query);
        $this->bindPegawaiData($data);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function editPegawai($data)
    {
        $query = "UPDATE pegawai SET
            nama = :nama,
            nipy = :nipy,
            sk_pengangkatan = :sk_pengangkatan,
            tmt = :tmt,
            nomor_induk = :nomor_induk,
            jenis_nomor_induk = :jenis_nomor_induk,
            tempat_lahir = :tempat_lahir,
            tanggal_lahir = :tanggal_lahir,
            jenis_kelamin = :jenis_kelamin,
            no_hp = :no_hp,
            agama = :agama,
            status_perkawinan = :status_perkawinan,
            alamat_pegawai = :alamat_pegawai,
            keterangan = :keterangan,
            email = :email,
            spk = :spk,
            no_rekening = :no_rekening,
            bank = :bank,
            id_klasifikasi = :id_klasifikasi
        WHERE id = :id";

        $this->db->query($query);
        $this->bindPegawaiData($data);
        $this->db->bind('id', $data['id']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    private function bindPegawaiData($data)
    {
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nipy', $data['nipy']);
        $this->db->bind('sk_pengangkatan', $data['sk_pengangkatan']);
        $this->db->bind('tmt', $data['tmt']);
        $this->db->bind('nomor_induk', $data['nomor_induk']);
        $this->db->bind('jenis_nomor_induk', $data['jenis_nomor_induk']);
        $this->db->bind('tempat_lahir', $data['tempat_lahir']);
        $this->db->bind('tanggal_lahir', $data['tanggal_lahir']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind('no_hp', $data['no_hp']);
        $this->db->bind('agama', $data['agama']);
        $this->db->bind('status_perkawinan', $data['status_perkawinan']);
        $this->db->bind('alamat_pegawai', $data['alamat_pegawai']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('spk', $data['spk']);
        $this->db->bind('no_rekening', $data['no_rekening']);
        $this->db->bind('bank', $data['bank']);
        $this->db->bind('id_klasifikasi', $data['id_klasifikasi']);
    }

    public function cekNipyDuplikat($nipy, $excludeId = null)
    {
        if ($excludeId) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE nipy = :nipy AND id != :id";
            $this->db->query($query);
            $this->db->bind('nipy', $nipy);
            $this->db->bind('id', $excludeId);
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE nipy = :nipy";
            $this->db->query($query);
            $this->db->bind('nipy', $nipy);
        }

        $result = $this->db->single();
        return $result['total'] > 0;
    }

    public function getTotalPegawai()
    {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single();
    }

    public function getAllPegawaiWithJabatanBidang()
    {
        // Ambil semua data pegawai
        $this->db->query("SELECT * FROM pegawai");
        $pegawaiList = $this->db->resultSet();

        // Ambil data jabatan_bidang per pegawai
        foreach ($pegawaiList as &$pegawai) {
            $this->db->query("
            SELECT jb.jabatan, jb.nama_bidang 
            FROM pegawai_jabatan_bidang pjb 
            JOIN jabatan_bidang jb ON jb.id = pjb.id_jabatan_bidang 
            WHERE pjb.id_pegawai = :id
            AND pjb.tanggal_selesai IS NULL
        ");
            $this->db->bind('id', $pegawai['id']);
            $pegawai['jabatan_bidang'] = $this->db->resultSet();
        }

        return $pegawaiList;
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getJabatanBidangIdsByPegawai($idPegawai)
    {
        $this->db->query("SELECT id_jabatan_bidang FROM pegawai_jabatan_bidang WHERE id_pegawai = :id");
        $this->db->bind('id', $idPegawai);
        return array_column($this->db->resultSet(), 'id_jabatan_bidang');
    }

    // public function tambahRelasiJabatanBidang($idPegawai, $jabatanBidangIds)
    // {
    //     $query = "INSERT INTO pegawai_jabatan_bidang (id_pegawai, id_jabatan_bidang) VALUES (:id_pegawai, :id_jabatan_bidang)";
    //     foreach ($jabatanBidangIds as $idJabatanBidang) {
    //         $this->db->query($query);
    //         $this->db->bind('id_pegawai', $idPegawai);
    //         $this->db->bind('id_jabatan_bidang', $idJabatanBidang);
    //         $this->db->execute();
    //     }
    // }

    // public function updateRelasiJabatanBidang($idPegawai, $jabatanBidangIds)
    // {
    //     // Hapus semua relasi lama
    //     $this->db->query("DELETE FROM pegawai_jabatan_bidang WHERE id_pegawai = :id");
    //     $this->db->bind('id', $idPegawai);
    //     $this->db->execute();

    //     // Tambahkan relasi baru
    //     $this->tambahRelasiJabatanBidang($idPegawai, $jabatanBidangIds);
    // }

    public function getJabatanBidangByPegawaiId($idPegawai)
    {
        $this->db->query("SELECT jb.jabatan, jb.nama_bidang 
        FROM pegawai_jabatan_bidang pjb 
        JOIN jabatan_bidang jb ON jb.id = pjb.id_jabatan_bidang 
        WHERE pjb.id_pegawai = :id
        AND pjb.tanggal_selesai IS NULL");
        $this->db->bind('id', $idPegawai);
        return $this->db->resultSet();
    }

    public function isJabatanBidangChanged($idPegawai, $newIds)
    {
        $current = $this->getJabatanBidangIdsByPegawai($idPegawai);

        // Pastikan semuanya integer
        $current = array_map('intval', $current);
        $newIds = array_map('intval', $newIds);

        sort($current);
        sort($newIds);

        return $current !== $newIds;
    }

    public function getJabatanAktif($idPegawai)
    {
        $this->db->query("SELECT id_jabatan_bidang FROM pegawai_jabatan_bidang 
                      WHERE id_pegawai = :id AND tanggal_selesai IS NULL");
        $this->db->bind('id', $idPegawai);
        return array_column($this->db->resultSet(), 'id_jabatan_bidang');
    }

    public function isJabatanBerubah($idPegawai, $newIds)
    {
        $current = $this->getJabatanAktif($idPegawai);
        sort($current);
        sort($newIds);
        return $current !== $newIds;
    }

    public function tutupRiwayatJabatanAktif($idPegawai)
    {
        $this->db->query("UPDATE pegawai_jabatan_bidang SET tanggal_selesai = CURRENT_DATE 
                      WHERE id_pegawai = :id AND tanggal_selesai IS NULL");
        $this->db->bind('id', $idPegawai);
        $this->db->execute();
    }

    public function tambahRiwayatJabatan($idPegawai, $jabatanIds, $tanggalMulai = null)
    {
        $tanggal = $tanggalMulai ?? date('Y-m-d');
        foreach ($jabatanIds as $idJabatan) {
            $this->db->query("INSERT INTO pegawai_jabatan_bidang 
                          (id_pegawai, id_jabatan_bidang, tanggal_mulai) 
                          VALUES (:id_pegawai, :id_jabatan_bidang, :tanggal_mulai)");
            $this->db->bind('id_pegawai', $idPegawai);
            $this->db->bind('id_jabatan_bidang', $idJabatan);
            $this->db->bind('tanggal_mulai', $tanggal);
            $this->db->execute();
        }
    }

    public function updateJabatanPegawai($idPegawai, $newJabatanIds)
    {
        // Ambil jabatan aktif saat ini
        $currentJabatan = $this->getJabatanAktif($idPegawai);

        // Ubah jadi array map untuk pencocokan cepat
        $currentMap = array_flip($currentJabatan);
        $newMap = array_flip($newJabatanIds);

        // Tutup jabatan yang tidak dipilih lagi
        foreach ($currentJabatan as $jabatanId) {
            if (!isset($newMap[$jabatanId])) {
                $this->db->query("UPDATE pegawai_jabatan_bidang 
                              SET tanggal_selesai = CURRENT_DATE 
                              WHERE id_pegawai = :id_pegawai 
                                AND id_jabatan_bidang = :id_jabatan_bidang 
                                AND tanggal_selesai IS NULL");
                $this->db->bind('id_pegawai', $idPegawai);
                $this->db->bind('id_jabatan_bidang', $jabatanId);
                $this->db->execute();
            }
        }

        // Tambahkan jabatan baru yang belum aktif
        foreach ($newJabatanIds as $jabatanId) {
            if (!isset($currentMap[$jabatanId])) {
                $this->db->query("INSERT INTO pegawai_jabatan_bidang 
                              (id_pegawai, id_jabatan_bidang, tanggal_mulai) 
                              VALUES (:id_pegawai, :id_jabatan_bidang, :tanggal_mulai)");
                $this->db->bind('id_pegawai', $idPegawai);
                $this->db->bind('id_jabatan_bidang', $jabatanId);
                $this->db->bind('tanggal_mulai', date('Y-m-d'));
                $this->db->execute();
            }
        }
    }

    public function updateStatusAktif($id, $status)
    {
        $query = "UPDATE pegawai SET status_aktif = :status WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);

        return $this->db->execute();
    }
}
