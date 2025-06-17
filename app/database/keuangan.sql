-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2025 at 05:00 AM
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
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id` int NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id`, `jabatan`, `nama_bidang`) VALUES
(11, 'Direktur', '-');

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
  `payment_reference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id`, `tanggal`, `id_pegawai`, `gaji_pokok`, `insentif`, `bobot_masa_kerja`, `pendidikan`, `beban_kerja`, `pemotongan`, `status_pembayaran`, `payment_reference`) VALUES
(1, '2025-05-14', 2, '10000.00', '89000.00', '23800.00', '7000.00', '67000.00', '40000.00', 'pending', NULL),
(3, '2025-05-30', 1, '25000.00', '25000.00', '25000.00', '25000.00', '25000.00', '25000.00', 'pending', NULL),
(4, '2025-04-05', 2, '10000.00', '10000.00', '10000.00', '10000.00', '10000.00', '10000.00', 'pending', NULL),
(6, '2025-06-01', 2, '1000000.00', '500000.00', '50000.00', '25000.00', '70000.00', '90000.00', 'pending', NULL);

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
(80, 'Pajak', 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nipy` varchar(100) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `nipy`, `bidang`, `rekening`, `bank`) VALUES
(1, 'nuriuii', '123321', '2', '19232921031038120382136', 'BNI'),
(2, 'Muhamad Sahnuri', '1233212131', '2', '1927322', 'BNI'),
(4, 'a', '123', '2', '123', 'awd'),
(7, 'Sasa', '2123', '6', '21312', 'cqwcdq'),
(8, '123', '12312', '7', '21', 'awd'),
(9, 'awd', '12431', '6', '212313', 'bni');

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
(42, 'Kas', '25000000.00', 'Sisa kas tunai bulan lalu', '2025-01-01'),
(43, 'Bank', '88000000.00', 'Sisa uang di Bank bulan lalu', '2025-01-01'),
(44, 'Bank', '500000.00', 'Sisa Uang di Bank bulan lalu', '2025-02-01'),
(47, 'Kas', '2000000.00', 'Sisa Kas Tunai bulan lalu', '2025-02-01'),
(48, 'Bank', '5000000.00', 'Sisa Uang di Bank bulan lalu', '2025-05-01'),
(49, 'Kas', '12000000.00', 'Sisa Kas Tunai bulan lalu', '2025-05-01'),
(50, 'Pajak', '6000000.00', 'Pajak yang belum terbayarkan bulan lalu', '2025-06-01');

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
  `kategori` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `tipe_kategori` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `nominal_transaksi` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tipe_buku`, `tanggal`, `no_bukti`, `keterangan`, `kategori`, `tipe_kategori`, `nominal_transaksi`) VALUES
(112, 'Bank', '2025-02-01', 'BPB1', 'Pemasukan 1', 'SPP', 'Pemasukan', '650000.00'),
(113, 'Bank', '2025-02-02', 'BPB2', 'Pemasukan 2', 'Pendaftaran Formulir PMB', 'Pemasukan', '500000.00'),
(115, 'Bank', '2025-02-05', 'BPB4', 'Pemasukan 4', 'Magang', 'Pemasukan', '1000000.00'),
(116, 'Bank', '2025-02-06', 'BPB5', 'Pemasukan 5', 'Tugas Akhir', 'Pemasukan', '800000.00'),
(117, 'Bank', '2025-02-06', 'BPB6', 'Pengeluaran 1', 'Biaya ATK', 'Pengeluaran', '70000.00'),
(118, 'Bank', '2025-02-11', 'BPB7', 'Pengeluaran 2', 'Biaya Bensin', 'Pengeluaran', '80000.00'),
(119, 'Bank', '2025-02-11', 'BPB8', 'Pengeluaran 3', 'Biaya Konsumsi', 'Pengeluaran', '700000.00'),
(122, 'Kas', '2025-02-05', 'BPK1', 'Pemasukan 1', 'SPP', 'Pemasukan', '9000000.00'),
(123, 'Kas', '2025-02-03', 'BPK2', 'Pemasukan 2', 'Pendaftaran Formulir PMB', 'Pemasukan', '800000.00'),
(124, 'Kas', '2025-02-03', 'BPK3', 'Pemasukan ', 'Registrasi Ulang', 'Pemasukan', '500000.00'),
(125, 'Kas', '2025-02-10', 'BPK4', 'Pemasukan 4', 'Magang', 'Pemasukan', '900000.00'),
(126, 'Kas', '2025-02-07', 'BPK5', 'Pemasukan 5', 'Tugas Akhir', 'Pemasukan', '1000000.00'),
(127, 'Kas', '2025-02-11', 'BPK6', 'Pengeluaran 1', 'Biaya ATK', 'Pengeluaran', '90000.00'),
(128, 'Kas', '2025-02-13', 'BPK7', 'Pengeluaran 2', 'Biaya Bensin', 'Pengeluaran', '70000.00'),
(129, 'Kas', '2025-02-12', 'BPK8', 'Pengeluaran 3', 'Biaya Gaji', 'Pengeluaran', '1200000.00'),
(130, 'Kas', '2025-02-05', 'BPK9', 'Pengeluaran 4', 'Biaya Konsumsi', 'Pengeluaran', '200000.00'),
(133, 'Kas', '2025-01-01', 'BPK1', 'Dibayarkan Pembelian Konsumsi Rapat Prodi Manufaktur', 'Biaya Konsumsi', 'Pengeluaran', '150000.00'),
(134, 'Bank', '2025-01-06', 'BPB1', 'Dana Masuk Hibah dari Perusahaan ( Gaji Ketua Yayasan WII )', 'Gaji', 'Pemasukan', '7560000.00'),
(136, 'Bank', '2025-01-07', 'BPB3', 'Dibayarkan SIAKAD POLIBALI', 'Langganan Sistem Informasi Akademik (SI AKAD)', 'Pengeluaran', '3360000.00'),
(137, 'Bank', '2025-01-07', 'BPB4', 'Dibayarkan Kepada REZA RAMADHAN (Pembayaran Domain Website Polibali)', 'Pengembangan IT', 'Pengeluaran', '150000.00'),
(138, 'Bank', '2025-01-07', 'BPB5', 'Pergeseran uang di bank', 'Pergeseran uang di bank', 'Pengeluaran', '6000000.00'),
(139, 'Kas', '2025-01-07', 'BPK2', 'Uang kas masuk', 'Uang kas masuk', 'Pemasukan', '6000000.00'),
(140, 'Bank', '2025-01-08', 'BPB6', 'Dibayarkan Kepada Drs. H. M. Idjra\'i, M.Pd.  (Uang Harian SPPD ke Bandung)', 'Perjalanan dinas manajemen', 'Pengeluaran', '6500000.00'),
(141, 'Bank', '2025-01-08', 'BPB7', 'Biaya Admin Transfer Antar Bank', 'Perjalanan dinas manajemen', 'Pengeluaran', '2500.00'),
(142, 'Bank', '2025-01-08', 'BPB8', 'Dibayarkan kepada Wadir I pak Ribut Giyono (Uang Harian SPPD ke Bandung)', 'Perjalanan dinas manajemen', 'Pengeluaran', '4200000.00'),
(143, 'Bank', '2025-01-08', 'BPB9', 'Dana masuk dari RIZKY NUR FAUZI - 2431401004- Teknik Pertambangan 2024 ( Bayar SPP Semester 1 )', 'SPP', 'Pemasukan', '2500000.00'),
(144, 'Bank', '2025-01-10', 'BPB10', 'Dana masuk dari YOSEF ANSYARI AZHAR - 2336401011- Non Reg-Teknik Perkapalan 2023 (Bayar SPP Semester 3)', 'SPP', 'Pemasukan', '4000000.00'),
(145, 'Bank', '2025-01-11', 'BPB11', 'Dana masuk dari I KHANIF AZHAR - 2421413029- Teknik Alat Berat 2024 ( Cicil Registrasi  )', 'Registrasi Ulang', 'Pemasukan', '2000000.00'),
(146, 'Bank', '2025-01-13', 'BPB12', 'Dibayarkan kepada Ibu Nurul Hatmah Kabag Program dan Keuangan (Konsumsi Rapat bersama PT. PPA) ', 'Biaya Konsumsi', 'Pengeluaran', '956000.00'),
(147, 'Bank', '2025-01-13', 'BPB13', 'Dana masuk dari DIJI PURNAWAN- 2421413014 -NON REG Teknik Alat Berat 2024 ( Bayar SPP Semester 1 )', 'SPP', 'Pemasukan', '4000000.00'),
(148, 'Bank', '2025-01-14', 'BPB14', 'Dibayarkan kepada Stephanie Cornelia - Staf Direktur (Insentif Lembur) ', 'Insentif kegiatan', 'Pengeluaran', '1000000.00'),
(149, 'Bank', '2025-01-15', 'BPB15', 'Dibayarkan kepada Silvester Duli Payon, S.Pd - Kabag Kepegawaian dan Humas (Dana Talangan) ', 'dana talangan', 'Pengeluaran', '6500000.00'),
(150, 'Bank', '2025-01-15', 'BPB16', 'Pergeseran uang di bank', 'Pergeseran uang di bank', 'Pengeluaran', '56880000.00'),
(151, 'Kas', '2025-01-15', 'BPK3', 'Uang kas masuk', 'Uang kas masuk', 'Pemasukan', '56880000.00'),
(152, 'Bank', '2025-01-16', 'BPB17', 'Dana masuk dari MUHAMMAD ZAKIE PRATAMA -2431401006- Teknik Pertambangan 2024 (Bayar SPP Semester 1)', 'SPP', 'Pemasukan', '2500000.00'),
(153, 'Bank', '2025-01-16', 'BPB18', 'admin internet', 'Langganan Internet', 'Pengeluaran', '2800.00'),
(154, 'Bank', '2025-01-16', 'BPB19', 'Dibayarkan Internet Indihome Politeknik Batulicin', 'Langganan Internet', 'Pengeluaran', '1485180.00'),
(155, 'Bank', '2025-01-16', 'BPB20', 'Pergeseran uang di bank', 'Pergeseran uang di bank', 'Pengeluaran', '10000000.00'),
(156, 'Kas', '2025-01-16', 'BPK4', 'Uang kas masuk', 'Uang kas masuk', 'Pemasukan', '10000000.00'),
(157, 'Bank', '2025-01-16', 'BPB21', 'spp', 'SPP', 'Pemasukan', '2500000.00'),
(158, 'Bank', '2025-01-17', 'BPB22', 'spp', 'SPP', 'Pemasukan', '2500000.00'),
(159, 'Bank', '2025-01-18', 'BPB23', 'talangan', 'dana talangan', 'Pengeluaran', '5000000.00'),
(160, 'Bank', '2025-01-18', 'BPB24', 'spp', 'SPP', 'Pemasukan', '2500000.00'),
(161, 'Bank', '2025-01-19', 'BPB25', 'spp', 'SPP', 'Pemasukan', '2500000.00'),
(162, 'Bank', '2025-01-20', 'BPB26', 'spp', 'SPP', 'Pemasukan', '2500000.00'),
(163, 'Bank', '2025-01-11', 'BPB27', 'Dana masuk dari I KHANIF AZHAR - 2421413029- Teknik Alat Berat 2024 (Bayar SPP Semester 1)', 'SPP', 'Pemasukan', '4000000.00'),
(164, 'Kas', '2025-01-02', 'BPK5', 'Dibayarkan Pembeliann BBM Operasional Direktur Bulan Januari 2025', 'BBM mobil operasional Direktur', 'Pengeluaran', '1000000.00'),
(165, 'Kas', '2025-01-02', 'BPK6', 'Dibayarkan Kepada Drs. H. M. Idjra\'i, M.Pd.  (Insentif Tambahan Direktur September 2024)', 'Insentif tambahan manajemen', 'Pengeluaran', '3000000.00'),
(166, 'Kas', '2025-01-02', 'BPK7', 'Dibayarkan kepada Muhammad Khairil Anam, S.Kom.  (Dana Konsumsi Manajemen)', 'Biaya Konsumsi', 'Pengeluaran', '500000.00'),
(167, 'Kas', '2025-01-03', 'BPK8', 'Dibayarkan pembelian ATK dan Stempel ', 'Biaya ATK', 'Pengeluaran', '167000.00'),
(168, 'Kas', '2025-01-06', 'BPK9', 'Dibayarkan BBM kompresor untuk kegiatan praktik mahaasiswa', 'Belanja Workshop', 'Pengeluaran', '25000.00'),
(169, 'Kas', '2025-01-06', 'BPK10', 'Dibayarkan insentif media publikasi bulan desember 2024', 'Insentif media publikasi', 'Pengeluaran', '1500000.00'),
(170, 'Kas', '2025-01-07', 'BPK11', 'Dibayarkan pembelian perlengkapan rumah dinas untuk dosen', 'Belanja sarpras', 'Pengeluaran', '2950000.00'),
(171, 'Kas', '2025-01-07', 'BPK12', 'Dibayarkan pembelian minman untuk kegiatan kampus', 'Biaya Konsumsi', 'Pengeluaran', '124000.00'),
(172, 'Kas', '2025-01-07', 'BPK13', 'Dibayarkan pembelian ATK', 'Biaya ATK', 'Pengeluaran', '992000.00'),
(173, 'Kas', '2025-01-07', 'BPK14', 'Dibayarkan pembelian pel, sapu, dan serok', 'Belanja sarpras', 'Pengeluaran', '105400.00'),
(174, 'Kas', '2025-01-07', 'BPK15', 'Dibayarkan pembelian iuran sampah bulan Desember', 'Biaya Operasional', 'Pengeluaran', '100000.00'),
(175, 'Kas', '2025-01-07', 'BPK16', 'Dibayarkan Jasa jilid laporan keuangan', 'Biaya ATK', 'Pengeluaran', '100000.00'),
(176, 'Kas', '2025-01-07', 'BPK17', 'Dibayarkan jasa jilid berkas manajemen', 'Biaya ATK', 'Pengeluaran', '120000.00'),
(177, 'Kas', '2025-01-07', 'BPK18', 'Dibayarkan pembelian bbm untuk keg. jilid berkas manajemen', 'BBM', 'Pengeluaran', '80000.00'),
(178, 'Kas', '2025-01-07', 'BPK19', 'Dibayarkan pembelian konsumsi rapat prodi teknik manufaktur', 'Biaya Konsumsi', 'Pengeluaran', '100000.00'),
(179, 'Kas', '2025-01-07', 'BPK20', 'Dibayarkan Kepada REZA RAMADHAN (Pembayaran Biaya Cetak Ijazah)', 'Biaya Operasional', 'Pengeluaran', '50000.00'),
(180, 'Bank', '2025-01-07', 'BPB28', 'Dibayarkan Kepada REZA RAMADHAN (Pembayaran Biaya Cetak Ijazah)', 'Biaya Operasional', 'Pengeluaran', '2500000.00'),
(181, 'Kas', '2025-01-09', 'BPK21', 'Dibayarkan pembelian bingkai foto, plakat, dan baterai mouse', 'Belanja sarpras', 'Pengeluaran', '301000.00'),
(182, 'Kas', '2025-01-09', 'BPK22', 'Dibayarkan pembelian bbm', 'BBM', 'Pengeluaran', '30000.00'),
(183, 'Kas', '2025-01-12', 'BPK23', 'Dibayarkan cetak spanduk pada kegiatan rakor bersama PT. PPA', 'Biaya Promosi', 'Pengeluaran', '130000.00'),
(185, 'Kas', '2025-01-13', 'BPK24', 'Dana masuk dari MUHAMMAD ADRIAN 2231401011 - Teknik Pertambangan 2022 ( Bayar SPP Semester 2 )', 'SPP', 'Pemasukan', '2500000.00'),
(186, 'Kas', '2025-01-13', 'BPK25', 'Dana masuk dari DHEA FAIQOTUL HIKMAH 2231401004 - Teknik Pertambangan 2022 ( Bayar SPP Semester 5 )', 'SPP', 'Pemasukan', '2500000.00'),
(187, 'Kas', '2025-01-14', 'BPK26', 'Dibayarkan jasa pembersihan AC 24 ruangan ', 'Biaya perbaikan dan perawatan sarpras', 'Pengeluaran', '2040000.00'),
(188, 'Kas', '2025-01-16', 'BPK27', 'Dibayarkan insentif mengajar dosen  luar biasa PAI', 'Insentif dosen LB ', 'Pengeluaran', '4760000.00'),
(189, 'Kas', '2025-01-16', 'BPK28', 'Dibayarkan Insentif kelebihan mengajar dosen 5 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '2975000.00'),
(190, 'Kas', '2025-01-16', 'BPK29', 'Dibayarkan Insentif kelebihan mengajar dosen 3 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '1785000.00'),
(191, 'Kas', '2025-01-16', 'BPK30', 'Dibayarkan Insentif kelebihan mengajar dosen 6 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '3570000.00'),
(192, 'Kas', '2025-01-16', 'BPK31', 'Dibayarkan Insentif kelebihan mengajar dosen 4 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '2380000.00'),
(193, 'Kas', '2025-01-16', 'BPK32', 'Dibayarkan Insentif kelebihan mengajar dosen 4 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '2380000.00'),
(194, 'Kas', '2025-01-16', 'BPK33', 'Dibayarkan Insentif kelebihan mengajar dosen 4 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '2380000.00'),
(195, 'Kas', '2025-01-16', 'BPK34', 'Dibayarkan Insentif kelebihan mengajar dosen 2 sks TA. 2024/2025 semester ganjil', 'Insentif mengajar kelebihan sks dosen', 'Pengeluaran', '1190000.00'),
(196, 'Kas', '2025-01-16', 'BPK35', 'Dibayarkan Insentif mengajar dosen kelas karyawan TA. 2024/2025 semester 1', 'Insentif mengajar dosen dan operator kelas karyawan semester ganjil ', 'Pengeluaran', '10800000.00'),
(197, 'Kas', '2025-01-16', 'BPK36', 'Dibayarkan Insentif mengajar dosen kelas karyawan dan kelas lapas semester 3', 'Insentif mengajar dosen dan operator kelas karyawan semester ganjil ', 'Pengeluaran', '33600000.00'),
(198, 'Kas', '2025-01-16', 'BPK37', 'Dibayarkan insentif operator kelas lapas TA. 2024/2025 semester ganjil', 'Insentif mengajar dosen dan operator kelas karyawan semester ganjil ', 'Pengeluaran', '690000.00'),
(199, 'Kas', '2025-01-16', 'BPK38', 'Dibayarkan pembelian kursi kerja Direktur POLIBALI', 'Belanja sarpras', 'Pengeluaran', '3200000.00'),
(200, 'Kas', '2025-01-17', 'BPK39', 'Dibayarkan insentif kegiatan tim penerima mesin percetakan spanduk', 'Insentif kegiatan', 'Pengeluaran', '525000.00'),
(201, 'Kas', '2025-01-01', 'BPK40', 'Diterimakan pembayaran cicilan dana talangan Silvester Duli Payon', 'Uang kas masuk', 'Pemasukan', '400000.00'),
(202, 'Kas', '2025-01-20', 'BPK41', 'Dibayarkan kepada Eka  ( Pembelian Tiket Pesawat Direktur dan Wadir I ke Bandung)', 'Perjalanan dinas manajemen', 'Pengeluaran', '6080512.00'),
(203, 'Kas', '2025-01-20', 'BPK42', 'Dana masuk dari IDAHNIYAH - 2431401027 - Teknik Pertambangan 2024 ( Bayar SPP Semester 1 )', 'SPP', 'Pemasukan', '2500000.00'),
(204, 'Kas', '2025-01-20', 'BPK43', 'Dana masuk dari MUHAMMAD SALMAN HIDAYAH PUTRA - 2431401030 - Teknik Pertambangan 2024 ( Bayar SPP Semester 1 )', 'SPP', 'Pemasukan', '2500000.00'),
(205, 'Kas', '2025-01-20', 'BPK44', 'Dana masuk dari MUHAMMAD RIKO KURNIAWAN - 2421413006 - Teknik Alat Berat 2024 ( Bayar SPP Semester 1 )', 'SPP', 'Pemasukan', '2500000.00'),
(206, 'Kas', '2025-01-23', 'BPK45', 'Dibayarkan kepada Ahmad Suhaili (Pembelian Nasi Rapat Manajemen) ', 'Biaya Konsumsi', 'Pengeluaran', '500000.00'),
(207, 'Kas', '2025-01-23', 'BPK46', 'Dana masuk dari FATHUR RAHMAN - 2321413013 - Teknik Alat Berat 2023 ( Bayar SPP Semester 3 )', 'SPP', 'Pemasukan', '2500000.00'),
(208, 'Kas', '2025-01-23', 'BPK47', 'Dana masuk dari ARIEF SYAHIDAN - 2331401008 - Teknik Pertambangan 2023 ( Bayar SPP Semester 3 )', 'SPP', 'Pemasukan', '2500000.00'),
(209, 'Kas', '2025-01-23', 'BPK48', 'Dibayarkan pembelian konsumsi rapat TIM SPMI tindak lanjut monev', 'Biaya Konsumsi', 'Pengeluaran', '50000.00'),
(210, 'Kas', '2025-01-24', 'BPK49', 'Dibayarkan SPPD Kabag. Kemitraan  pada keg. program pemberdayaan masyarakat di PT. Arutmin', 'Perjalanan dinas manajemen', 'Pengeluaran', '200000.00'),
(211, 'Kas', '2025-01-30', 'BPK50', 'Dibayarkan Jasa Service dan Pemasangan instalasi mesin bubut', 'Belanja Workshop', 'Pengeluaran', '1660000.00'),
(212, 'Bank', '2025-01-21', 'BPB29', 'Dana masuk dari MUSDALIFAH - 2231401010 - Teknik Pertambangan 2022 (Bayar SPP Semester 4)', 'SPP', 'Pemasukan', '2500000.00'),
(213, 'Bank', '2025-01-21', 'BPB30', 'Dana masuk dari MUSDALIFAH - 2231401010 - Teknik Pertambangan 2022 (Bayar SPP Semester 5)', 'SPP', 'Pemasukan', '2500000.00'),
(214, 'Bank', '2025-01-21', 'BPB31', 'Dibayarkan kepada Indah Merlati Suci, S.T., M.T. - Kaprodi Teknik Perkapalan (Dana Kuliah Lapangan) ', 'Belanja Alat dan Bahan Prodi Teknik Perkapalan', 'Pengeluaran', '955000.00'),
(215, 'Bank', '2025-01-22', 'BPB32', 'Dibayarkan kepada Ahya - Wadir 1 pak Ribut Giyono (Dana Operasional)', 'dana talangan', 'Pengeluaran', '300000.00'),
(216, 'Bank', '2025-01-22', 'BPB33', 'Dibayarkan kepada Muhammad Khairil Anam, S.Kom.  (Dana Konsumsi Manajemen)', 'Biaya Konsumsi', 'Pengeluaran', '500000.00'),
(217, 'Bank', '2025-01-22', 'BPB34', 'Pergeseran uang di bank', 'Insentif kegiatan', 'Pengeluaran', '9000000.00'),
(218, 'Kas', '2025-01-22', 'BPK51', 'Uang kas masuk', 'Uang kas masuk', 'Pemasukan', '9000000.00'),
(219, 'Bank', '2025-01-22', 'BPB35', 'Dibayarkan kepada Rochmat Aldy Purnomo (Biaya Pendaftaran HAKI logo UBM) ', 'Biaya Operasional', 'Pengeluaran', '4000000.00'),
(220, 'Bank', '2025-01-22', 'BPB36', 'Dibayarkan biaya admin bank pada keg.  Biaya Pendaftaran HAKI logo UBM', 'Biaya Operasional', 'Pengeluaran', '2500.00'),
(221, 'Bank', '2024-12-23', 'BPB37', 'Dibayarkan kepada SITI MUDRIKA - 2331401018 (Dana Rapat Kerja BEM )', 'Belanja Kegiatan Kemahasiswaan', 'Pengeluaran', '2110000.00'),
(222, 'Bank', '2025-01-23', 'BPB37', 'Dibayarkan kepada SITI MUDRIKA - 2331401018 (Dana Rapat Kerja BEM )', 'Belanja Kegiatan Kemahasiswaan', 'Pengeluaran', '2110000.00'),
(223, 'Bank', '2025-01-23', 'BPB38', 'Biaya Admin Transfer Antar Bank pada keg. Rapat Kerja BEM ', 'Biaya Operasional', 'Pengeluaran', '2500.00'),
(224, 'Bank', '2025-01-26', 'BPB39', 'Dibayarkan kepada Siti Halimah, S.S -Sekretaris Yayasan WII (Dana SPPD TTD akte UBM)', 'Perjalanan dinas manajemen', 'Pengeluaran', '2700000.00'),
(225, 'Bank', '2025-01-26', 'BPB40', 'Dibayarkan kepada Wadir 1 pak Ribut Giyono (Dana SPPD TTD akte UBM)', 'Perjalanan dinas manajemen', 'Pengeluaran', '2700000.00'),
(226, 'Bank', '2025-01-03', 'BPB41', 'Biaya Admin Transfer Antar Bank Kepada Drs. H. M. Idjra\'i, M.Pd.  (Dana SPPD TTD akte UBM)', 'Perjalanan dinas manajemen', 'Pengeluaran', '2500.00'),
(227, 'Bank', '2025-01-26', 'BPB42', 'Kepada Drs. H. M. Idjra\'i, M.Pd.  (Dana SPPD TTD akte UBM)', 'Perjalanan dinas manajemen', 'Pengeluaran', '3900000.00'),
(228, 'Bank', '2025-01-26', 'BPB43', 'Biaya Admin Transfer Antar Bank Kepada Drs. H. M. Idjra\'i, M.Pd.  (Dana SPPD TTD akte UBM)', 'Perjalanan dinas manajemen', 'Pengeluaran', '2500.00'),
(229, 'Bank', '2025-01-27', 'BPB44', 'Pergeseran uang di bank', 'Pergeseran uang di bank', 'Pengeluaran', '365000.00'),
(230, 'Bank', '2025-01-27', 'BPB45', 'Dana masuk dari Sugeng Ludiyono - SETOR TUNAI DARI DANA KAS', 'pindah buku kas ke bank', 'Pemasukan', '6800000.00'),
(231, 'Kas', '2025-01-27', 'BPK52', 'Uang kas masuk', 'Uang kas masuk', 'Pemasukan', '365000.00'),
(232, 'Kas', '2025-01-27', 'BPK53', 'Dibayarkan kepada Ibu Ahmad Suhaili Dana Perbaikan MES dosen dan upah perbaikan', 'Belanja sarpras', 'Pengeluaran', '400000.00'),
(233, 'Bank', '2025-01-28', 'BPB46', 'Dibayarkan kepada Wadir 1 pak Ribut Giyono (Biaya Pendaftaran HAKI) ', 'Biaya Operasional', 'Pengeluaran', '3000000.00'),
(234, 'Bank', '2025-01-28', 'BPB47', 'Dibayarkan kepada Wadir 1 pak Ribut Giyono (Biaya Pendaftaran HAKI) ', 'Biaya Operasional', 'Pengeluaran', '1500000.00'),
(235, 'Bank', '2025-01-30', 'BPB48', 'Dana masuk dari Sugeng Ludiyono - SETOR TUNAI DARI DANA KAS', 'pindah buku kas ke bank', 'Pemasukan', '600000.00'),
(236, 'Bank', '2025-01-30', 'BPB49', 'Pergeseran uang di bank', 'Pergeseran uang di bank', 'Pengeluaran', '3700000.00'),
(237, 'Bank', '2025-01-30', 'BPB50', 'Dana Masuk dari Muhammad Azhar (NON REG Sistem Informasi 2023) Pelunasan SPP Semester 2', 'SPP', 'Pemasukan', '200000.00'),
(238, 'Bank', '2025-01-31', 'BPB51', 'Dana masuk dari Sugeng Ludiyono - SETOR TUNAI DARI DANA KAS', 'pindah buku kas ke bank', 'Pemasukan', '2000000.00'),
(239, 'Bank', '2025-01-31', 'BPB52', 'Dibayarkan Kepada M Hariz Dedy Sayogi, S.T., M.T. (perbaikan mesin bubut dan upah)', 'Belanja Workshop', 'Pengeluaran', '1660000.00'),
(240, 'Bank', '2025-01-31', 'BPB53', 'Biaya Admin', 'Biaya admin bank', 'Pengeluaran', '25000.00'),
(241, 'Bank', '2025-01-31', 'BPB54', 'Biaya Saldo Minimal', 'Biaya admin bank', 'Pengeluaran', '25000.00'),
(242, 'Bank', '2025-01-31', 'BPB55', 'Bunga', 'Bunga Bank', 'Pemasukan', '9539.32'),
(243, 'Bank', '2025-01-31', 'BPB56', 'Pajak', 'Biaya Pajak Bank', 'Pengeluaran', '1907.86'),
(244, 'Bank', '2025-02-01', 'BPB9', 'Pemasukan', 'Magang', 'Pemasukan', '500000.00'),
(246, 'Bank', '2025-02-03', 'BPB10', 'Pembiayaan PKM', 'Pembayaran PKM', 'Pengeluaran', '500000.00'),
(247, 'Bank', '2025-03-12', 'BPB1', 'Pemasukannn', 'Magang', 'Pemasukan', '6000000.00'),
(250, 'Bank', '2025-05-14', 'BPB1', 'da', 'Pendaftaran Formulir PMB', 'Pemasukan', '500000.00'),
(251, 'Bank', '2024-12-06', 'BPB38', 'dada', 'SPP', 'Pemasukan', '60000.00'),
(255, 'Bank', '2025-05-26', 'BPB2', '112', 'Pendaftaran Formulir PMB', 'Pemasukan', '500000.00'),
(261, 'Bank', '2025-01-24', 'BPB57', 'awda', '', 'Pemasukan', '60000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pajak`
--

CREATE TABLE `transaksi_pajak` (
  `id` int NOT NULL,
  `id_Transaksi` int NOT NULL,
  `id_jenis_pajak` int NOT NULL,
  `tipe_buku` varchar(50) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `no_bukti` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tipe_kategori` varchar(255) NOT NULL,
  `nominal_transaksi` decimal(18,2) NOT NULL,
  `nilai_pajak` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_pajak`
--

INSERT INTO `transaksi_pajak` (`id`, `id_Transaksi`, `id_jenis_pajak`, `tipe_buku`, `tanggal`, `no_bukti`, `keterangan`, `tipe_kategori`, `nominal_transaksi`, `nilai_pajak`) VALUES
(25, 119, 1, 'Pajak', '2025-06-01', 'BPJ1', 'dibayarkan', 'Pemasukan', '700000.00', '35000.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`, `role`) VALUES
(1, 'sahnuri', '$2y$10$D7hZ7oOa3AnX.wG9W37gHuqB2SWShdUuSMgd5bl7gcLV6ReZUpD0.', 'Muhamad Sahnuri', 'Sahnuri@gmail.com', 'Admin'),
(2, 'admin', '$2y$10$yiiFW6lzaDOcBsglv1POAOCmIpGAgHL1djnYer4mA4HfuJSGAKHyW', 'Nurul Hatmah', 'admin@gmail.com', 'Admin'),
(8, 'pimpinan', '$2y$10$zxW.VHLebarlj5159AfnBOk2e2VpgjO4vdgZ8idOWWjm2CS3kRlue', 'pimpinan', 'pimpinan@gmail.com', 'Pimpinan'),
(9, 'petugas', '$2y$10$4LDp5GlRSAG4oeyJ1ZuIouMYppGDxicYfup7M/Tf1UJibWTXy/avm', 'petugas', 'petugas@gmail.com', 'Petugas'),
(10, 'pegawai', '$2y$10$VegyK5WS/1Dn5Vc7MeKVIuA5qL9TDBE9O12AerozEF77Sy.ddgoDq', 'pegawai', 'pegawai@gmail.com', 'Pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
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
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
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
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jenis_pajak`
--
ALTER TABLE `jenis_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `transaksi_pajak`
--
ALTER TABLE `transaksi_pajak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
