-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2025 at 02:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `id` int NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `id_pegawai` int NOT NULL,
  `gaji_pokok` decimal(18,2) NOT NULL,
  `insentif` decimal(18,2) NOT NULL,
  `bobot_masa_kerja` decimal(18,2) NOT NULL,
  `pendidikan` decimal(18,2) NOT NULL,
  `beban_kerja` decimal(18,2) NOT NULL,
  `pemotongan` decimal(18,2) NOT NULL,
  `status_pembayaran` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `payment_reference` varchar(255) DEFAULT NULL,
  `snap_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id`, `tanggal`, `id_pegawai`, `gaji_pokok`, `insentif`, `bobot_masa_kerja`, `pendidikan`, `beban_kerja`, `pemotongan`, `status_pembayaran`, `payment_reference`, `snap_token`) VALUES
(20, '2025-07-04', 15, '10000000.00', '5000000.00', '1104000.00', '200000.00', '0.00', '0.00', 'paid', 'GJ-20', 'b75df7d9-4149-405d-ac0f-d1f3eeaeaf25'),
(21, '2025-07-04', 19, '3286000.00', '1100000.00', '165000.00', '200000.00', '0.00', '0.00', 'paid', 'GJ-21-1751622200', 'a38edb2f-bddd-46bb-a7d4-5fb9298c05d8'),
(22, '2025-07-03', 17, '7500000.00', '4000000.00', '1024000.00', '400000.00', '0.00', '0.00', 'paid', 'GJ-22', '541e875b-2d2e-4ddc-9aa9-ca70421caac0'),
(31, '2025-08-01', 15, '5000000.00', '0.00', '1112000.00', '200000.00', '0.00', '0.00', 'paid', 'GJ-31-1751899439', 'e45fec6c-9325-43f0-adbd-1e93dd1e0355'),
(32, '2025-07-05', 20, '3286000.00', '800000.00', '148500.00', '200000.00', '0.00', '0.00', 'pending', 'GJ-32-1753285025', 'adaf6688-156f-44e2-a184-db05d7e3898e'),
(33, '2025-07-04', 16, '7500000.00', '4000000.00', '136000.00', '200000.00', '2000000.00', '1000000.00', 'paid', 'GJ-33-1751701655', '122424e6-d64f-473b-b46c-ffdae6a0117b'),
(34, '2025-07-07', 18, '3286000.00', '2000000.00', '379500.00', '400000.00', '0.00', '0.00', 'pending', NULL, NULL),
(35, '2025-08-01', 16, '7500000.00', '4000000.00', '144000.00', '200000.00', '20000.00', '0.00', 'pending', NULL, NULL),
(38, '2025-07-01', 24, '5400000.00', '250000.00', '357500.00', '400000.00', '50000.00', '100000.00', 'paid', 'GJ-38-1752583295', '00bce659-15ca-46c0-82be-46adad35d9a8');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_bidang`
--

CREATE TABLE `jabatan_bidang` (
  `id` int NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan_bidang`
--

INSERT INTO `jabatan_bidang` (`id`, `jabatan`, `nama_bidang`) VALUES
(11, 'Direktur', '-'),
(12, 'Wakil Direktur I', 'Akademik dan Perencanaan Program dan Keuangan'),
(13, 'Wakil Direktur II', 'Kemahasiswaan dan PKL'),
(14, 'Wakil Direktur III', 'Kepegawaian (SDM) dan Humas'),
(15, 'Kabag Kemahasiswaan', 'Kemahasiswaan, Statistik Mahasiswa, PKL dan Tracer Study, Potensi Non Akademik dan Kegiatan Kemahasiswaan'),
(16, 'Kabag Kepegawaian', 'Kepegawaian (SDM) dan Umum'),
(17, 'Kabag Sarpras dan Kemitraan', 'Sarana Prasarana dan Humas (Kemitraan)'),
(18, '-', 'Sarana Prasarana dan Kemitraan Antar Lembaga'),
(19, 'Asisten Direktur', 'Reproduksi Administrasi, Arsip Direktur, dan Dokumentasi'),
(20, 'Kabag Kepegawaian dan Humas', 'Tata Laksana dan Layanan Administrasi Kampus'),
(21, 'Kepala', 'SPMI'),
(22, 'Sekretaris', 'SPMI'),
(23, 'Kepala', 'LPPM'),
(24, 'Kepala', 'Workshop'),
(25, 'UPT', 'Unit Pengelola Teknis Layanan PPKS'),
(26, 'UPT', 'Unit Pengelola Teknis Layanan Kesehatan Kampus'),
(27, 'Kepala Perpustakaan', '-'),
(28, 'Ketua Program Studi', 'Teknik Manufaktur'),
(29, 'Ketua Program Studi', 'Teknik Alat Berat'),
(30, 'Ketua Program Studi', 'Teknik Pertambangan'),
(31, 'Ketua Program Studi', 'Teknik Perkapalan'),
(32, 'Sekretaris Program Studi', 'Teknik Manufaktur'),
(33, 'Sekretaris Program Studi', 'Teknik Alat Berat'),
(34, 'Sekretaris Program Studi', 'Teknik Pertambangan'),
(35, 'Sekretaris Program Studi', 'Teknik Perkapalan'),
(36, 'Dosen', 'Teknik Manufaktur'),
(37, 'Dosen', 'Teknik Alat Berat'),
(38, 'Dosen', 'Teknik Perkapalan'),
(39, 'Subag', 'Dokumentasi dan Administrasi Sarana Prasarana dan Humas (Kemitraan)'),
(40, 'Ketua', 'Layanan Beasiswa'),
(41, 'Staf Khusus Wadir I', 'Bidang Perencanaan, Program dan Pengembangan  Akademik'),
(42, 'Subag MAK', 'Pengesahan Dokumen Mak, Administrasi Bidang, Distribusi Surat, dan Membantu Administrasi Surat'),
(43, 'Staf', 'LPPM'),
(44, 'Sistem Informasi Kampus', 'Bidang TI (Teknologi dan Informatika)'),
(45, 'Subag Akademik', 'Reproduksi Administrasi Akademik dan Perencanaan'),
(46, 'Sekretaris', 'Layanan Beasiswa'),
(47, 'Subag Kemahasiswaan', 'Potensi Non Akademik dan Kegiatan Kemahasiswaan'),
(48, 'Subag SDM dan Umum', 'Reproduksi Administrasi dan Kearsipan SDM (Kepegawaian), dan Umum'),
(49, 'Staf Perpustakaan', 'Dokumentasi, Reproduksi dan Administrasi Perpustakaan'),
(50, 'Toolman', 'Tenaga Layanan Administrasi Alat Praktik'),
(51, 'Resepsionis dan Layanan Korespondensi', 'Resepsionis dan Layanan Korespondensi'),
(52, 'Layanan Sosial, Bisnis dan Keamanan', 'Koperasi dan Kebersihan Utama (Ruang Direktur dan Ruang Wadir)'),
(53, 'Layanan Sosial, Bisnis dan Keamanan', 'Keamanan dan Pembantu Umum'),
(54, 'Layanan Sosial, Bisnis dan Keamanan', 'Kebersihan Ruang Kuliah, Ruang Tendik, dan Ruang Pendukung Perkuliahan'),
(55, 'Kabag Program dan Keuangan', '-'),
(56, 'Ketua Yayasan WII', '-'),
(57, 'Sekretaris Yayasan WII', '-'),
(58, 'Bendahara Yayasan WII', '-'),
(59, 'Subag Keuangan', '-'),
(60, 'Dosen', 'Teknik Pertambangan');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pajak`
--

CREATE TABLE `jenis_pajak` (
  `id` int NOT NULL,
  `tarif_pajak` decimal(18,2) NOT NULL,
  `tipe` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_pajak`
--

INSERT INTO `jenis_pajak` (`id`, `tarif_pajak`, `tipe`) VALUES
(1, '5.00', 'PPN'),
(2, '21.00', 'PPh21'),
(4, '12.00', 'PPh21'),
(5, '9.00', 'Pph4(2)Final'),
(6, '3.00', 'PPh22');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `tipe_kategori` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `tipe_kategori`) VALUES
(33, 'SPP', 'Pengeluaran'),
(34, 'Pendaftaran Formulir PMB', 'Pemasukan'),
(35, 'Registrasi Ulang', 'Pemasukan'),
(36, 'Magang', 'Pemasukan'),
(37, 'Tugas Akhir', 'Pemasukan'),
(38, 'Iuran Wisuda Wisuda', 'Pemasukan'),
(39, 'Biaya ATK', 'Pengeluaran'),
(41, 'Biaya Gaji', 'Pengeluaran'),
(42, 'Biaya Konsumsi', 'Pengeluaran'),
(43, 'Biaya Operasional', 'Pengeluaran'),
(44, 'Biaya Internet dan Telepon', 'Pengeluaran'),
(45, 'Biaya Peralatan/Perlengkapan', 'Pengeluaran'),
(46, 'Biaya Ongkos Kirim', 'Pengeluaran'),
(47, 'Gaji', 'Pemasukan'),
(48, 'Langganan Sistem Informasi Akademik (SI AKAD)', 'Pengeluaran'),
(49, 'Langganan Internet', 'Pengeluaran'),
(50, 'Pengembangan IT', 'Pengeluaran'),
(51, 'Pergeseran uang di bank', 'Pengeluaran'),
(52, 'Uang kas masuk', 'Pemasukan'),
(53, 'Perjalanan dinas manajemen', 'Pengeluaran'),
(54, 'Insentif kegiatan', 'Pengeluaran'),
(55, 'dana talangan', 'Pengeluaran'),
(56, 'BBM mobil operasional Direktur', 'Pengeluaran'),
(57, 'BBM', 'Pengeluaran'),
(58, 'Insentif tambahan manajemen', 'Pengeluaran'),
(59, 'Belanja Workshop', 'Pengeluaran'),
(60, 'Belanja Alat dan Bahan Prodi Teknik Manufaktur', 'Pengeluaran'),
(61, 'Belanja Alat dan Bahan Prodi Teknik Pertambangan', 'Pengeluaran'),
(62, 'Belanja Alat dan Bahan Prodi Teknik Teknik Alat Berat', 'Pengeluaran'),
(63, 'Belanja Alat dan Bahan Prodi Teknik Perkapalan', 'Pengeluaran'),
(64, 'Belanja Kegiatan Kemahasiswaan', 'Pengeluaran'),
(65, 'Perjalanan dinas dosen', 'Pengeluaran'),
(66, 'Perjalanan dinas tendik', 'Pengeluaran'),
(67, 'Insentif media publikasi', 'Pengeluaran'),
(68, 'Belanja sarpras', 'Pengeluaran'),
(69, 'Biaya Promosi', 'Pengeluaran'),
(70, 'Biaya perbaikan dan perawatan sarpras', 'Pengeluaran'),
(71, 'Insentif dosen LB ', 'Pengeluaran'),
(72, 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran'),
(73, 'Insentif mengajar dosen dan operator kelas karyawan semester ganjil ', 'Pengeluaran'),
(74, 'pindah buku kas ke bank', 'Pemasukan'),
(75, 'Biaya admin bank', 'Pengeluaran'),
(76, 'Biaya Pajak Bank', 'Pengeluaran'),
(77, 'Bunga Bank', 'Pemasukan'),
(78, 'Pembayaran PKM', 'Pengeluaran'),
(79, 'Pajak', 'Pemasukan'),
(80, 'Pajak', 'Pengeluaran'),
(88, 'tes', 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `master_bobot_masa_kerja`
--

CREATE TABLE `master_bobot_masa_kerja` (
  `id` int NOT NULL,
  `klasifikasi` varchar(100) NOT NULL,
  `bobot` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_bobot_masa_kerja`
--

INSERT INTO `master_bobot_masa_kerja` (`id`, `klasifikasi`, `bobot`) VALUES
(3, 'Tenaga Kependidikan', '5500.00'),
(4, 'Manajemen', '8000.00'),
(5, 'Dosen', '6000.00');

-- --------------------------------------------------------

--
-- Table structure for table `master_tunjangan_pendidikan`
--

CREATE TABLE `master_tunjangan_pendidikan` (
  `id` int NOT NULL,
  `jenjang` varchar(100) NOT NULL,
  `nominal` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_tunjangan_pendidikan`
--

INSERT INTO `master_tunjangan_pendidikan` (`id`, `jenjang`, `nominal`) VALUES
(6, 'SD/SMP', '50000.00'),
(7, 'SMA', '75000.00'),
(8, 'D3', '150000.00'),
(9, 'S1', '200000.00'),
(10, 'S2', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nipy` varchar(100) DEFAULT NULL,
  `sk_pengangkatan` varchar(100) DEFAULT NULL,
  `tmt` varchar(100) DEFAULT NULL,
  `nomor_induk` varchar(100) DEFAULT NULL,
  `jenis_nomor_induk` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `no_hp` varchar(100) DEFAULT NULL,
  `agama` varchar(100) DEFAULT NULL,
  `status_perkawinan` varchar(100) DEFAULT NULL,
  `alamat_pegawai` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `spk` varchar(100) DEFAULT NULL,
  `no_rekening` varchar(100) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') NOT NULL,
  `id_klasifikasi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `nipy`, `sk_pengangkatan`, `tmt`, `nomor_induk`, `jenis_nomor_induk`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `no_hp`, `agama`, `status_perkawinan`, `alamat_pegawai`, `keterangan`, `email`, `spk`, `no_rekening`, `bank`, `status_aktif`, `id_klasifikasi`) VALUES
(15, 'Sahnuri', '12313', '12/adw/', '2014-01-01', '1115038301', 'NUPTK', 'Simpang Empat', '1999-02-01', 'Laki-laki', '1231', 'Islam', 'Menikah', 'adwa', 'awd', 'sanhurimuhammad02@gmail.com', '12/aw/23', '213123', 'KALSEL', 'aktif', 4),
(16, 'Hasnia', '123123', '12', '2024-01-29', '1231312', 'NIDN', 'awdad', '2005-07-31', 'Laki-laki', '12313', 'Islam', 'Menikah', 'awdawd', 'awdad', 'hasnia@gmail.com', '12/ws/24', '12312', 'kalsel', 'aktif', 4),
(17, 'Ribut Giyono, S.Pd., M.M.', '196612312014101002', '002/KEP/Y-ES/X/2014', '2014-10-21', '8835450017', 'NIDN', 'Magetan', '1966-06-02', 'Laki-laki', '081288934423', 'Islam', 'Menikah', 'Jl. Samporna RT. 008 Desa Barokah Kec. Simpang Empat Kab. Tanah Bumbu', 'Koord Wadir', 'ribut.giyono69@gmail.com', '-', '9030311004754', 'KALSEL', 'aktif', 4),
(18, 'Sugeng Ludiyono, S.E., M.M.', '199309142019101028', '010/KEP/Y-WII/X/2019', '2019-10-01', '1231232', 'NIDN', 'Kotabaru', '1993-09-14', 'Laki-laki', '087821210800', 'Islam', 'Menikah', 'Jl. Poros Sekapuk 2 RT. 009 RW. 003 Desa Sekapuk Kec. Satui Kab. Tanah Bumbu, Kalsel', '-', 'sugengludiyono123@gmail.com', '-', '1370013015710', 'Mandiri', 'aktif', 3),
(19, 'Nurul Hatmah, S.Pd.', '199110272023012050', '020/KEP/Y-WII/VI/2023', '2023-01-02', '312313', 'NIDN', 'Catur Karya', '1991-10-27', 'Perempuan', '081250912681', 'Islam', 'Menikah', 'Jl. Ins-Gub Perumahan Baroqah Indah Rt. 011 Desa Baroqah Kec. Simpang Empat Kab. Tanah Bumbu ', 'TMT Tidak Sesuai SK Yayasan', 'nurulhatmah@gmail.com', '-', '123123123', 'Mandiri', 'aktif', 3),
(20, 'Reza Ramadhan, S.Kom.', '199801052023041053', '002/KEP/Y-ES/X/2016', '2023-04-03', '132123123', 'NIDN', 'Sungai Dua', '1998-01-05', 'Laki-laki', '081234321232', 'Islam', 'Menikah', 'Jl. Raya Serongga KM. 5 Desa Gunung Besar Kec. Simpang Empat Kab. Tanah Bumbu, Kalsel', 'TMT Tidak Sesuai SK Yayasan\r\n\r\n\r\nKoordinator\r\n', 'reza@politeknikbatulicin.ac.id', '-', '0', 'Mandiri', 'aktif', 3),
(21, 'Drs. H. M. Idjra\'i, M.Pd.', '195909042015101003', '002/KEP/Y-ES/X/2014', '2014-10-21', '9911634926', 'NIDN', 'Kotabaru', '1959-09-04', 'Laki-laki', '081234567890', 'Islam', 'Menikah', 'Jalan Mangga No 30', 'Pelindung', 'm.idjrai69@gmail.com', '-', '2313213231', 'KALSEL', 'aktif', 4),
(24, 'nuri', '83221321', '23/aw/23', '2020-02-15', '123211423', 'NIDN', 'simpang empat', '2005-02-02', 'Laki-laki', '081237821371231', 'Islam', 'Menikah', 'gg musyawarah', '', 'sanhurimuhammad@gmail.com', '12/pp/2025', '824621321', 'Mandiri', 'aktif', 3),
(27, 'Ir. Heri Maryadi', '196308302022081046', '016/KEP/Y-WII/VIII/2022', '2021-02-04', '21312', 'NUP', 'Sleman', '1963-08-30', 'Laki-laki', '0834234242', 'Islam', 'Menikah', 'Gg. Mangga no 5', '', 'herimaryadi@gmail.com', '12/Sw/33', '2131231', 'Mandiri', 'aktif', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_jabatan_bidang`
--

CREATE TABLE `pegawai_jabatan_bidang` (
  `id` int NOT NULL,
  `id_pegawai` int DEFAULT NULL,
  `id_jabatan_bidang` int DEFAULT NULL,
  `tanggal_mulai` varchar(50) NOT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai_jabatan_bidang`
--

INSERT INTO `pegawai_jabatan_bidang` (`id`, `id_pegawai`, `id_jabatan_bidang`, `tanggal_mulai`, `tanggal_selesai`) VALUES
(7, 15, 11, '2025-06-29', '2025-07-04'),
(8, 16, 12, '2025-06-29', '2025-07-08'),
(9, 15, 12, '2025-06-30', '2025-06-30'),
(10, 15, 12, '2025-06-30', '2025-06-30'),
(11, 15, 12, '2025-06-30', '2025-06-30'),
(12, 17, 12, '2025-07-02', NULL),
(13, 18, 55, '2025-07-02', '2025-07-08'),
(14, 19, 59, '2025-07-02', '2025-07-08'),
(15, 20, 45, '2025-07-02', NULL),
(16, 15, 37, '2025-07-04', '2025-07-08'),
(17, 15, 18, '2025-07-08', '2025-07-08'),
(18, 21, 11, '2025-07-08', NULL),
(19, 15, 11, '2025-07-08', '2025-07-08'),
(20, 15, 17, '2025-07-08', '2025-07-08'),
(21, 15, 37, '2025-07-08', NULL),
(22, 18, 59, '2025-07-08', '2025-07-08'),
(23, 19, 55, '2025-07-08', '2025-07-08'),
(24, 19, 59, '2025-07-08', NULL),
(25, 18, 55, '2025-07-08', NULL),
(26, 16, 14, '2025-07-08', '2025-07-24'),
(27, 15, 29, '2025-07-08', NULL),
(35, 24, 21, '2025-07-15', NULL),
(36, 24, 22, '2025-07-15', NULL),
(39, 27, 14, '2025-07-23', NULL),
(40, 16, 37, '2025-07-23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_anggaran`
--

CREATE TABLE `pengajuan_anggaran` (
  `id` int NOT NULL,
  `id_pegawai` int DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `file_rab` varchar(255) DEFAULT NULL,
  `total_anggaran` decimal(18,2) DEFAULT NULL,
  `status` enum('diajukan','diterima','ditolak') DEFAULT 'diajukan',
  `catatan_atasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `tanggal_upload` date DEFAULT NULL,
  `tanggal_disetujui` date DEFAULT NULL,
  `id_atasan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengajuan_anggaran`
--

INSERT INTO `pengajuan_anggaran` (`id`, `id_pegawai`, `judul`, `deskripsi`, `file_rab`, `total_anggaran`, `status`, `catatan_atasan`, `tanggal_upload`, `tanggal_disetujui`, `id_atasan`) VALUES
(21, 16, 'Kegiatan Akreditasi Teknik Pertambangan', 'Rab untuk kegiatan yang diselenggarakan untuk pengakreditasian kampus politeknik batulicin yang akan dilaksanakan pada tanggal 12 januari 2026 di hari itu akan dihadiri oleh beberapa petinggi kepentingan untuk melakukan pengakreditasian', '1752162663_9JurnalAsrinadiaKurniati.pdf', '5000000.00', 'diterima', '', '2025-07-10', '2025-07-27', 17),
(22, 20, 'kegiatan akreditasi', 'kegiatan akreditasi', '1752581989_87579-362413-2-PB.pdf', '5000000.00', 'diterima', '', '2025-07-15', '2025-07-27', 17),
(24, 18, 'Kegiatan Seminar ', 'kegiata seminar', '1753280424_Laporan_Buku_Kas.pdf', '2000000.00', 'diterima', '', '2025-07-23', '2025-07-27', 17),
(25, 18, 'Pembelian Perlengkapan Praktek', 'untuk keperluan pembelian perlengkapan praktek', '1753280506_Laporan_Buku_Kas_Umum.pdf', '1500000.00', 'diajukan', '', '2025-07-23', NULL, NULL),
(26, 18, 'Pembelian Buku', 'buku', '1753280859_1800-ArticleText-2906-1-10-202208012.pdf', '500000.00', 'diajukan', '', '2025-07-23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pendidikan_pegawai`
--

CREATE TABLE `riwayat_pendidikan_pegawai` (
  `id` int NOT NULL,
  `id_pegawai` int DEFAULT NULL,
  `id_jenjang` int DEFAULT NULL,
  `gelar` varchar(100) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `nama_kampus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `riwayat_pendidikan_pegawai`
--

INSERT INTO `riwayat_pendidikan_pegawai` (`id`, `id_pegawai`, `id_jenjang`, `gelar`, `program_studi`, `nama_kampus`) VALUES
(9, 15, 9, 'S.Kom', 'Teknik Informatika', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari'),
(12, 15, 9, 'S.H', 'Ilmu Hukum', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari'),
(13, 17, 9, 'Sarjana Pendidikan (S.Pd.)', 'Bimbingan Dan Konseling', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari Banjamasin'),
(14, 17, 10, 'Magister Manajemen (M.M.)', 'Manajemen Sumber Daya Manusia', 'Sekolah Tinggi Ilmu Ekonomi Pancasetie Banjarmasin'),
(15, 18, 9, 'Sarjana Ekonomi (S.E.)', 'Manajemen', 'Universitas Pembangunan Nasional \"Veteran\" Yogyakarta'),
(16, 18, 10, 'Magister Manajemen (M.M.)', 'Manajemen', 'Universitas Pembangunan Nasional \"Veteran\" Yogyakarta  Universitas Islam Indonesia'),
(17, 19, 9, 'Sarjana Pendidikan (S.Pd.)', 'Pendidikan Bahasa Inggris', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari Banjarmasin'),
(18, 20, 9, 'Sarjana Komputer(S.Kom)', 'Teknologi Informatika', 'Universitas'),
(19, 16, 9, 'S.Kom', 'Teknik Informatika', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari'),
(20, 21, 9, 'Doktorandus (Drs.)', 'Pendidikan Bahasa Inggris', 'Universitas Lambung Mangkurat'),
(21, 21, 10, 'Magister Pendidikan (M.Pd.)', 'Teknologi Pembelajaran', 'Universitas PGRI Adi Buana Surabaya'),
(26, 24, 9, 'S.Kom', 'TI', 'UNISKA'),
(27, 24, 10, 'M.Kom', 'Komputer', 'UNISKA');

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int NOT NULL,
  `tipe_buku` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `saldo_awal` decimal(18,2) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `tanggal` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `tipe_buku`, `saldo_awal`, `keterangan`, `tanggal`) VALUES
(53, 'Bank', '10000000.00', 'Sisa Uang di Bank bulan lalu', '2025-07-01'),
(54, 'Kas', '7000000.00', 'Sisa Kas Tunai bulan lalu', '2025-07-01'),
(55, 'Pajak', '5000000.00', 'Pajak yang belum terbayarkan bulan lalu', '2025-07-01'),
(59, 'Kas', '500000.00', 'Sisa Kas Tunai bulan lalu', '2025-06-01'),
(60, 'Bank', '14145000.00', 'Sisa Uang di Bank bulan lalu', '2025-08-01'),
(61, 'Kas', '12080000.00', 'Sisa Kas Tunai bulan lalu', '2025-08-01'),
(62, 'Pajak', '5345000.00', 'Pajak yang belum terbayarkan bulan lalu', '2025-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `template_gaji_jabatan`
--

CREATE TABLE `template_gaji_jabatan` (
  `id` int NOT NULL,
  `id_jabatan_bidang` int NOT NULL,
  `gaji_pokok` decimal(18,2) NOT NULL,
  `insentif` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `template_gaji_jabatan`
--

INSERT INTO `template_gaji_jabatan` (`id`, `id_jabatan_bidang`, `gaji_pokok`, `insentif`) VALUES
(1, 11, '5000000.00', '3000000.00'),
(2, 12, '500000.00', '4000000.00'),
(3, 13, '4000000.00', '0.00'),
(5, 14, '5000000.00', '0.00'),
(6, 55, '3286000.00', '2000000.00'),
(7, 56, '0.00', '5000000.00'),
(8, 57, '0.00', '2500000.00'),
(9, 27, '3286000.00', '600000.00'),
(10, 45, '3286000.00', '800000.00'),
(11, 59, '3286000.00', '1100000.00'),
(12, 28, '0.00', '750000.00'),
(13, 36, '5000000.00', '0.00'),
(14, 37, '5000000.00', '0.00'),
(15, 38, '5000000.00', '0.00'),
(16, 60, '5000000.00', '0.00'),
(17, 21, '3400000.00', '200000.00'),
(18, 22, '2000000.00', '50000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `tipe_buku` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `tanggal` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `no_bukti` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `id_kategori` int NOT NULL,
  `tipe_kategori` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `nominal_transaksi` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tipe_buku`, `tanggal`, `no_bukti`, `keterangan`, `id_kategori`, `tipe_kategori`, `nominal_transaksi`) VALUES
(313, 'Kas', '2025-07-01', 'BPK1', 'Pemasukan pembayaran Magang Mahasiswaaa', 36, 'Pemasukan', '50000.00'),
(314, 'Kas', '2025-07-02', 'BPK2', 'Pemasukan registrasi ulang Mahasiswa', 35, 'Pemasukan', '6000000.00'),
(315, 'Kas', '2025-07-04', 'BPK3', 'Dibayarkan Pembelian Konsumsi Rapat Prodi Manufaktur', 42, 'Pengeluaran', '800000.00'),
(316, 'Kas', '2025-07-09', 'BPK4', 'Pemasukan Pendaftaran PMB ', 34, 'Pemasukan', '700000.00'),
(317, 'Kas', '2025-07-10', 'BPK5', 'Magang Mahasiswa Semester 5', 36, 'Pemasukan', '800000.00'),
(318, 'Kas', '2025-07-09', 'BPK6', 'Pembelian ATK kantor ', 39, 'Pengeluaran', '80000.00'),
(319, 'Kas', '2025-07-11', 'BPK7', 'Biaya Pengembangan IT POLITEKNIK', 50, 'Pengeluaran', '600000.00'),
(320, 'Kas', '2025-07-11', 'BPK8', 'Dibayarkan Holo 2x4 120 btg', 45, 'Pengeluaran', '700000.00'),
(321, 'Kas', '2025-07-18', 'BPK9', 'Dibayarkan Pasir sebanyak 5 ret', 45, 'Pengeluaran', '250000.00'),
(322, 'Kas', '2025-07-11', 'BPK10', 'Dibayarkan Batu Split sebanyak 1 ret', 45, 'Pengeluaran', '500000.00'),
(323, 'Bank', '2025-07-01', 'BPB1', 'Dana Masuk Hibah dari Perusahaan ( Gaji Ketua Yayasan WII )', 47, 'Pemasukan', '7000000.00'),
(324, 'Bank', '2025-07-03', 'BPB2', 'Dibayarkan SIAKAD POLIBALI', 48, 'Pengeluaran', '3000000.00'),
(325, 'Bank', '2025-07-05', 'BPB3', 'Dibayarkan Kepada REZA RAMADHAN (Pembayaran Domain Website Polibali)', 50, 'Pengeluaran', '500000.00'),
(326, 'Bank', '2025-07-09', 'BPB4', 'Dibayarkan kepada Wadir I pak Ribut Giyono (Uang Harian SPPD ke Bandung)', 53, 'Pengeluaran', '3000000.00'),
(327, 'Bank', '2025-07-09', 'BPB5', 'Dana masuk dari I KHANIF AZHAR - 2421413029- Teknik Alat Berat 2024 ( Cicil Registrasi )', 35, 'Pemasukan', '4500000.00'),
(328, 'Bank', '2025-07-08', 'BPB6', 'Dana masuk dari RIZKY NUR FAUZI - 2431401004- Teknik Pertambangan 2024 ( Bayar SPP Semester 1 )', 33, 'Pemasukan', '2500000.00'),
(329, 'Bank', '2025-07-18', 'BPB7', 'Dibayarkan Kalsibut 120 lembar', 45, 'Pengeluaran', '4000000.00'),
(330, 'Bank', '2025-07-09', 'BPB8', 'Dibayarkan Semen 50 sak', 45, 'Pengeluaran', '3000000.00'),
(331, 'Bank', '2025-07-20', 'BPB9', 'Dana masuk dari YEF ANSYARI AHAR - 2334431011- Non Reg-Teknik Perkapalan 2023 (Bayar SPP Semester 3)', 33, 'Pemasukan', '4500000.00'),
(332, 'Bank', '2025-07-16', 'BPB10', 'dibayarkan biaya internet dan telepon politeknik', 44, 'Pengeluaran', '1200000.00'),
(333, 'Kas', '2025-07-11', 'BPJ1', 'Diterimakan pajak PPh 22 3% pembelian Holo 2x4 120 btg', 79, 'Pemasukan', '21000.00'),
(334, 'Kas', '2025-07-14', 'BPJ2', 'Dibayarkan pajak PPh 22 3% pembelian Holo 2x4 120 btg', 80, 'Pengeluaran', '21000.00'),
(335, 'Kas', '2025-07-11', 'BPJ3', 'Diterimakan Pajak Batu Split PPh22 3%', 79, 'Pemasukan', '15000.00'),
(336, 'Kas', '2025-07-11', 'BPJ4', 'Dibayarkan Pajak Batu Split PPh22 3%', 80, 'Pengeluaran', '15000.00'),
(337, 'Bank', '2025-07-09', 'BPJ5', 'Diterimakan Pajak Semen 50 Sak PPh22 3%', 79, 'Pemasukan', '90000.00'),
(338, 'Bank', '2025-07-19', 'BPJ6', 'Dibayarkan Pajak Semen 50 sak PPh22 3%', 80, 'Pengeluaran', '90000.00'),
(339, 'Bank', '2025-07-18', 'BPJ7', 'Diterimakan Pajak Kalsibut 120 Lembar PPh22 3%', 79, 'Pemasukan', '120000.00'),
(340, 'Bank', '2025-07-11', 'BPJ8', 'awdadawdawda', 79, 'Pemasukan', '225000.00'),
(341, 'Kas', '2025-08-02', 'BPK1', 'Pembayaran SPP', 33, 'Pemasukan', '5000000.00'),
(342, 'Bank', '2025-08-01', 'BPB1', 'Pemasukan Gaji dari yayasan', 47, 'Pemasukan', '600000.00'),
(343, 'Kas', '2025-08-01', 'BPJ1', 'Diterimakan Pajak', 79, 'Pemasukan', '300.00'),
(344, 'Bank', '2025-08-01', 'BPJ2', 'Diterimakan Pajak PPh22', 79, 'Pemasukan', '180.00'),
(345, 'Kas', '2025-06-06', 'BPK1', 'tes', 34, 'Pemasukan', '12000000.00'),
(346, 'Kas', '2025-05-01', 'BPK1', 'w', 79, 'Pemasukan', '1.00'),
(347, 'Kas', '2025-04-01', 'BPK1', 'aw', 52, 'Pemasukan', '5000.00'),
(348, 'Kas', '2025-03-01', 'BPK1', 'awd', 37, 'Pemasukan', '9000000.00'),
(349, 'Kas', '2025-02-07', 'BPK1', 'awda', 47, 'Pemasukan', '15000000.00'),
(350, 'Kas', '2025-01-10', 'BPK1', 'awdaw', 34, 'Pemasukan', '50000.00'),
(351, 'Kas', '2026-01-10', 'BPK1', 'awd', 47, 'Pemasukan', '6000000.00'),
(352, 'Kas', '2026-01-15', 'BPK2', 'pengeluaran', 39, 'Pengeluaran', '50000.00'),
(353, 'Kas', '2025-07-17', 'BPK11', 'pemasukan spp', 33, 'Pemasukan', '9000000.00'),
(354, 'Bank', '2025-07-02', 'BPB11', 'pengeluaran', 43, 'Pengeluaran', '300000.00'),
(355, 'Kas', '2025-07-01', 'BPJ9', 'dibayarkan pajak ', 33, 'Pemasukan', '2500.00'),
(356, 'Kas', '2025-08-02', 'BPK2', 'Pembayaran Mahasiswa Untuk Tugas Akhir Semester 5', 37, 'Pemasukan', '800000.00'),
(357, 'Kas', '2025-08-06', 'BPK3', 'Pembayaran Registrasi Ulang Mahasiswa Semester 3', 35, 'Pemasukan', '1200000.00'),
(358, 'Bank', '2025-08-21', 'BPB3', 'Pembelian Perlengkapan Kantor Tenaga Kependidikan', 39, 'Pengeluaran', '500000.00'),
(359, 'Bank', '2025-08-06', 'BPB4', 'Pemasukan Pendaftaran Mahasiswa Baru', 34, 'Pemasukan', '5000000.00'),
(360, 'Bank', '2025-08-09', 'BPB5', 'Dibayarkan Hosting untuk Website Kampus', 50, 'Pengeluaran', '8000000.00'),
(361, 'Kas', '2025-08-01', 'BPJ3', 'Diterimakan Pajak ppn 5% untuk holo 2x4 120 batang', 79, 'Pemasukan', '35000.00'),
(362, 'Kas', '2025-07-01', 'BPK12', 'Pemasukan', 37, 'Pemasukan', '500000.00'),
(363, 'Kas', '2024-12-27', 'BPK1', 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB', 47, 'Pemasukan', '500000.00'),
(364, 'Kas', '2026-01-16', 'BPK3', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 34, 'Pemasukan', '30000.00'),
(365, 'Kas', '2025-07-27', 'BPJ10', 'diterimakan pajak ppn 5%', 79, 'Pemasukan', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pajak`
--

CREATE TABLE `transaksi_pajak` (
  `id` int NOT NULL,
  `id_transaksi_sumber` int NOT NULL,
  `id_transaksi_pembayaran` int NOT NULL,
  `id_jenis_pajak` int NOT NULL,
  `tipe_buku` varchar(50) NOT NULL,
  `nominal_transaksi` decimal(18,2) NOT NULL,
  `nilai_pajak` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_pajak`
--

INSERT INTO `transaksi_pajak` (`id`, `id_transaksi_sumber`, `id_transaksi_pembayaran`, `id_jenis_pajak`, `tipe_buku`, `nominal_transaksi`, `nilai_pajak`) VALUES
(62, 320, 333, 6, 'Pajak', '700000.00', '21000.00'),
(63, 320, 334, 6, 'Pajak', '700000.00', '21000.00'),
(64, 322, 335, 6, 'Pajak', '500000.00', '15000.00'),
(65, 322, 336, 6, 'Pajak', '500000.00', '15000.00'),
(66, 330, 337, 6, 'Pajak', '3000000.00', '90000.00'),
(67, 330, 338, 6, 'Pajak', '3000000.00', '90000.00'),
(68, 329, 339, 6, 'Pajak', '4000000.00', '120000.00'),
(69, 331, 340, 1, 'Pajak', '4500000.00', '225000.00'),
(70, 342, 343, 1, 'Pajak', '6000.00', '300.00'),
(71, 342, 344, 6, 'Pajak', '6000.00', '180.00'),
(72, 352, 355, 1, 'Pajak', '50000.00', '2500.00'),
(73, 320, 361, 1, 'Pajak', '700000.00', '35000.00'),
(74, 360, 365, 1, 'Pajak', '8000000.00', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `id_pegawai` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `id_pegawai`) VALUES
(13, 'admin', '$2y$10$5emk1XArBQtRgayRTE2yhuKi1knZPqUcUDfKJx5kdTwWCjzckhUqS', 'Admin', 19),
(14, 'sahnuri', '$2y$10$3f45p5jIbvKFKLeQxwETceym5kXf1hFmDPHc1JdqVnEqzJ/Rkt1Vq', 'Admin', 15),
(15, 'pimpinan', '$2y$10$rwxwZWGBcgbeqGKKwbxv2e5iU83LDCYg0JnQVnTPyGSJKacno7Gge', 'Pimpinan', 17),
(16, 'petugas', '$2y$10$hzA8nW1B72R2TGj7a.KYrOMnhv3lwH4AYsP1Edq541qh0/JMvQ7P2', 'Petugas', 18),
(17, 'pegawai', '$2y$10$PiRHhIaBQX/OuKOq./EFW.gZ1oJYn548p22w7NyuEUXcfOv8re.Aq', 'Pegawai', 20),
(18, 'hasnia', '$2y$10$w26A61b62Y8lTDTcTnKUx.VDwePKQcqVTf.r0jba/o6162ULbVxhy', 'Pegawai', 16),
(19, 'nuri', '$2y$10$OXaYHrIsf4XvOlOjJSY6Du94FsF236/eXkj/ioL6YTyPvrj2Qez4S', 'Pegawai', 24),
(21, 'pimpinan1', '$2y$10$lsUSK.4IIp2K5x1YD/ABruRFVapiyvb/ykyZYD9rxyl72/B3Y4hjS', 'Pimpinan', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan_bidang`
--
ALTER TABLE `jabatan_bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pajak`
--
ALTER TABLE `jenis_pajak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_bobot_masa_kerja`
--
ALTER TABLE `master_bobot_masa_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_tunjangan_pendidikan`
--
ALTER TABLE `master_tunjangan_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai_jabatan_bidang`
--
ALTER TABLE `pegawai_jabatan_bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_anggaran`
--
ALTER TABLE `pengajuan_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pendidikan_pegawai`
--
ALTER TABLE `riwayat_pendidikan_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_gaji_jabatan`
--
ALTER TABLE `template_gaji_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_pajak`
--
ALTER TABLE `transaksi_pajak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jabatan_bidang`
--
ALTER TABLE `jabatan_bidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `jenis_pajak`
--
ALTER TABLE `jenis_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `master_bobot_masa_kerja`
--
ALTER TABLE `master_bobot_masa_kerja`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_tunjangan_pendidikan`
--
ALTER TABLE `master_tunjangan_pendidikan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pegawai_jabatan_bidang`
--
ALTER TABLE `pegawai_jabatan_bidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `pengajuan_anggaran`
--
ALTER TABLE `pengajuan_anggaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `riwayat_pendidikan_pegawai`
--
ALTER TABLE `riwayat_pendidikan_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `template_gaji_jabatan`
--
ALTER TABLE `template_gaji_jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT for table `transaksi_pajak`
--
ALTER TABLE `transaksi_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
