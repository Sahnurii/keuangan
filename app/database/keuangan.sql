-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2025 at 07:35 AM
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
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `tipe_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `tipe_kategori`) VALUES
(1, 'Pendaftaran Formulir PMB 1234', 'Pemasukan'),
(3, 'Biaya ATK', 'Pengeluaran'),
(5, 'amsdakasdas', 'Pemasukan'),
(6, 'Coba', 'Pemasukan'),
(9, 'Testing', 'Pemasukan'),
(10, 'AAAAAAAAAAAAAAAAAAAAAAAA', 'Pemasukan'),
(11, 'bbbbbbbbbbbbbbbbbb', 'Pengeluaran'),
(12, 'ccccccccccccccccccccccc', 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int NOT NULL,
  `tipe_buku` varchar(255) NOT NULL,
  `saldo_awal` decimal(18,2) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tanggal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `tipe_buku`, `saldo_awal`, `keterangan`, `tanggal`) VALUES
(32, 'Kas', '5000000.00', 'Sisa Saldo Bulan November', '2025-01-01'),
(33, 'Kas', '4000000.00', 'Sisa Saldo Bulan Desember', '2024-12-01'),
(34, 'Bank', '9000000.00', 'Sisa Saldo Bulan November', '2024-12-01'),
(35, 'Bank', '10000000.00', 'Sisa Saldo Bulan Desember', '2025-01-01'),
(36, 'Kas', '9000000.00', 'Sisa Saldo Bulan Januari', '2025-02-01'),
(37, 'Bank', '6000000.00', 'Sisa Saldo Bulan Januari', '2025-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `tipe_buku` varchar(50) NOT NULL,
  `tanggal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_bukti` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `tipe_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nominal_transaksi` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tipe_buku`, `tanggal`, `no_bukti`, `keterangan`, `kategori`, `tipe_kategori`, `nominal_transaksi`) VALUES
(7, 'Bank', '2024-12-01', 'BB1', 'Masuk Uang Ni BOSS', 'Testing', 'Pemasukan', '9000000.00'),
(8, 'Bank', '2024-12-02', 'BB2', 'Pengeluaran Dong', 'Biaya ATK', 'Pengeluaran', '300000.00'),
(35, 'Bank', '2025-02-01', 'BPB1', 'awda', 'Pendaftaran Formulir PMB 1234', 'Pemasukan', '22111100.00'),
(36, 'Bank', '2025-02-03', 'BPB2', 'adawda', 'bbbbbbbbbbbbbbbbbb', 'Pengeluaran', '500000.00'),
(37, 'Bank', '2024-12-30', 'BPB1', 'asdad', 'amsdakasdas', 'Pemasukan', '212132132.00'),
(38, 'Kas', '2024-12-30', 'BPK1', 'Pemasukan Dari Dinas', 'Pendaftaran Formulir PMB 1234', 'Pemasukan', '6000000.00'),
(39, 'Kas', '2024-12-30', 'BPK2', 'awdawda', 'amsdakasdas', 'Pemasukan', '5000000.00'),
(40, 'Kas', '2024-12-30', 'BPK3', 'sadawda', 'Biaya ATK', 'Pengeluaran', '900000.00'),
(41, 'Kas', '2025-01-01', 'BPK1', 'pendaftararan mahasiswa', 'Pendaftaran Formulir PMB 1234', 'Pemasukan', '5000000.00'),
(42, 'Kas', '2025-01-01', 'BPK2', 'Pemasukan lagi ', 'Coba', 'Pemasukan', '6000000.00'),
(43, 'Bank', '2025-01-01', 'BPB1', 'Pemasukan y', 'Testing', 'Pemasukan', '2000000.00'),
(44, 'Bank', '2025-01-02', 'BPB2', 'pengeluaran 2', 'bbbbbbbbbbbbbbbbbb', 'Pengeluaran', '500000.00'),
(45, 'Kas', '2025-02-01', 'BPK1', 'Pemas', 'Testing', 'Pemasukan', '600000.00'),
(46, 'Kas', '2025-03-01', 'BPK1', 'asd', 'AAAAAAAAAAAAAAAAAAAAAAAA', 'Pemasukan', '500000.00'),
(47, 'Kas', '2025-01-03', 'BPK3', 'Pengeluaran', 'bbbbbbbbbbbbbbbbbb', 'Pengeluaran', '600000.00'),
(48, 'Kas', '2025-03-05', 'BPK2', 'penge', 'bbbbbbbbbbbbbbbbbb', 'Pengeluaran', '600000.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@gmail.com'),
(2, 'tes', 'tes123', 'testing', 'testing@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
