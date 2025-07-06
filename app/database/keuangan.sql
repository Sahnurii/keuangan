-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2025 at 09:24 AM
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
(31, '2025-08-01', 15, '5000000.00', '0.00', '1112000.00', '200000.00', '0.00', '0.00', 'pending', NULL, NULL),
(32, '2025-07-05', 20, '3286000.00', '800000.00', '148500.00', '200000.00', '0.00', '0.00', 'pending', 'GJ-32-1751700956', '44d5e0df-14c3-4eb9-b8a9-33b4fd577c67'),
(33, '2025-07-04', 16, '7500000.00', '4000000.00', '136000.00', '200000.00', '2000000.00', '1000000.00', 'paid', 'GJ-33-1751701655', '122424e6-d64f-473b-b46c-ffdae6a0117b');

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
(5, '9.00', 'Pph4(2)Final');

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
(33, 'SPP', 'Pemasukan'),
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
(82, 'awda', 'Pemasukan');

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
(15, 'Sahnuri', '12313', '12/adw/', '2014-01-01', '21312', 'NIDK', 'Simpang Empat', '1999-02-01', 'Laki-laki', '1231', 'Islam', 'Menikah', 'adwa', 'awd', 'sanhurimuhammad02@gmail.com', '12/aw/23', '213123', 'KALSEL', 'aktif', 4),
(16, 'Hasnia', '123123', '12', '2024-01-29', '1231312', 'NIDN', 'awdad', '2005-07-31', 'Laki-laki', '12313', 'Islam', 'Menikah', 'awdawd', 'awdad', 'hasnia@gmail.com', '12/ws/24', '12312', 'kalsel', 'aktif', 4),
(17, 'Ribut Giyono, S.Pd., M.M.', '196612312014101002', '002/KEP/Y-ES/X/2014', '2014-10-21', '8835450017', 'NIDN', 'Magetan', '1966-06-02', 'Laki-laki', '081288934423', 'Islam', 'Menikah', 'Jl. Samporna RT. 008 Desa Barokah Kec. Simpang Empat Kab. Tanah Bumbu', 'Koord Wadir', 'ribut.giyono69@gmail.com', '-', '9030311004754', 'KALSEL', 'aktif', 4),
(18, 'Sugeng Ludiyono, S.E., M.M.', '199309142019101028', '010/KEP/Y-WII/X/2019', '2019-10-01', '0', 'NIDN', 'Kotabaru', '1993-09-14', 'Laki-laki', '087821210800', 'Islam', 'Menikah', 'Jl. Poros Sekapuk 2 RT. 009 RW. 003 Desa Sekapuk Kec. Satui Kab. Tanah Bumbu, Kalsel', '-', 'sugengludiyono123@gmail.com', '-', '1370013015710', 'Mandiri', 'aktif', 3),
(19, 'Nurul Hatmah, S.Pd.', '199110272023012050', '020/KEP/Y-WII/VI/2023', '2023-01-02', '0', 'NIDN', 'Catur Karya', '1991-10-27', 'Perempuan', '081250912681', 'Islam', 'Menikah', 'Jl. Ins-Gub Perumahan Baroqah Indah Rt. 011 Desa Baroqah Kec. Simpang Empat Kab. Tanah Bumbu ', 'TMT Tidak Sesuai SK Yayasan', 'nurulhatmah@gmail.com', '-', '0', 'Mandiri', 'aktif', 3),
(20, 'Reza Ramadhan, S.Kom.', '199801052023041053', '002/KEP/Y-ES/X/2016', '2023-04-03', '0', 'NIDN', 'Sungai Dua', '1998-01-05', 'Laki-laki', '081234321232', 'Islam', 'Menikah', 'Jl. Raya Serongga KM. 5 Desa Gunung Besar Kec. Simpang Empat Kab. Tanah Bumbu, Kalsel', 'TMT Tidak Sesuai SK Yayasan\r\n\r\n\r\nKoordinator\r\n', 'reza@politeknikbatulicin.ac.id', '-', '0', 'Mandiri', 'aktif', 3);

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
(8, 16, 12, '2025-06-29', NULL),
(9, 15, 12, '2025-06-30', '2025-06-30'),
(10, 15, 12, '2025-06-30', '2025-06-30'),
(11, 15, 12, '2025-06-30', '2025-06-30'),
(12, 17, 12, '2025-07-02', NULL),
(13, 18, 55, '2025-07-02', NULL),
(14, 19, 59, '2025-07-02', NULL),
(15, 20, 45, '2025-07-02', NULL),
(16, 15, 37, '2025-07-04', NULL);

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
(16, 16, 'PERANG DUNIA KE 2', 'perang nuklir', '1751789544_50-FirstManuscript-473-1-10-20211128.pdf', '90000000000.00', 'diterima', 'AWDOJAWODJWAOP JDAWOPJDOAWPJDOPAWJDOPAWJDAJOWAJDPO WJDOWAJDOAWJD ASJDSKPAOJD AOSJDSPAOJDSPAO JDSAPOJD SAPOJDAOSJDAISPOJ DASPIO JDSAIOJ DASIPO JDSAPOJ ASPIOJ ASPIOJD ASIO JASO JDASO JDASPO JDSAPO JDOPASJ DPOASDJ OASJD IOASJD POASJD IOASD A', '2025-07-06', '2025-07-06', 17);

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
(19, 16, 9, 'S.Kom', 'Teknik Informatika', 'Universitas Islam Kalimantan Muhammad Arsyad Al Banjari');

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
(50, 'Pajak', '6000000.00', 'Pajak yang belum terbayarkan bulan lalu', '2025-06-01'),
(51, 'Kas', '10000000.00', 'Sisa Kas Tunai bulan lalu', '2025-06-01'),
(52, 'Bank', '5000000.00', 'Sisa Uang di Bank bulan lalu', '2025-06-01');

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
(1, 11, '10000000.00', '5000000.00'),
(2, 12, '7500000.00', '4000000.00'),
(3, 13, '4000000.00', '0.00'),
(5, 14, '7500000.00', '0.00'),
(6, 55, '3286000.00', '2000000.00'),
(7, 56, '0.00', '7500000.00'),
(8, 57, '0.00', '2500000.00'),
(9, 27, '3286000.00', '600000.00'),
(10, 45, '3286000.00', '800000.00'),
(11, 59, '3286000.00', '1100000.00'),
(12, 28, '0.00', '750000.00'),
(13, 36, '5000000.00', '0.00'),
(14, 37, '5000000.00', '0.00'),
(15, 38, '5000000.00', '0.00'),
(16, 60, '5000000.00', '0.00');

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
(266, 'Bank', '2025-06-02', 'BPB2', 'RAWWWWWWWW', 52, 'Pemasukan', '760000.45'),
(267, 'Bank', '2025-06-03', 'BPB3', 'awdadawd', 34, 'Pemasukan', '500000.00'),
(268, 'Bank', '2025-06-10', 'BPB4', 'awdwa', 36, 'Pemasukan', '50300.25'),
(269, 'Kas', '2025-06-01', 'BPK1', 'adwad', 39, 'Pengeluaran', '60000.00'),
(270, 'Kas', '2025-06-03', 'BPK2', 'awdaw', 74, 'Pemasukan', '60000.00'),
(272, 'Kas', '2025-06-24', 'BPK4', 'pengeluaran lihhhh', 43, 'Pengeluaran', '700000.00'),
(277, 'Kas', '2025-06-01', 'BPK5', 'DAW', 57, 'Pengeluaran', '5000.00'),
(281, 'Kas', '2025-06-01', 'BPK7', 'RRRRRRRRRRRRRRRR', 55, 'Pengeluaran', '6000.00'),
(309, 'Kas', '2025-06-01', 'BPJ1', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 79, 'Pemasukan', '35000.00'),
(310, 'Bank', '2025-06-02', 'BPJ2', 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB', 79, 'Pemasukan', '45000.00'),
(311, 'Kas', '2025-07-01', 'BPJ1', 'CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', 80, 'Pengeluaran', '7200.00'),
(312, 'Bank', '2025-07-02', 'BPJ2', 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD', 79, 'Pemasukan', '159600.09');

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
(58, 272, 309, 1, 'Pajak', '700000.00', '35000.00'),
(59, 267, 310, 5, 'Pajak', '500000.00', '45000.00'),
(60, 270, 311, 4, 'Pajak', '60000.00', '7200.00'),
(61, 266, 312, 2, 'Pajak', '760000.45', '159600.09');

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
(18, 'hasnia', '$2y$10$w26A61b62Y8lTDTcTnKUx.VDwePKQcqVTf.r0jba/o6162ULbVxhy', 'Pegawai', 16);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `jabatan_bidang`
--
ALTER TABLE `jabatan_bidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `jenis_pajak`
--
ALTER TABLE `jenis_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pegawai_jabatan_bidang`
--
ALTER TABLE `pegawai_jabatan_bidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengajuan_anggaran`
--
ALTER TABLE `pengajuan_anggaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `riwayat_pendidikan_pegawai`
--
ALTER TABLE `riwayat_pendidikan_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `template_gaji_jabatan`
--
ALTER TABLE `template_gaji_jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `transaksi_pajak`
--
ALTER TABLE `transaksi_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
