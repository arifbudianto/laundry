-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2022 at 05:30 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(3) NOT NULL,
  `nama_barang` varchar(40) NOT NULL,
  `harga_barang` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `harga_barang`) VALUES
('B01', 'Boneka Besar', 20000),
('B02', 'Selimut', 15000),
('B03', 'Selimut', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` char(3) NOT NULL,
  `nama_paket` varchar(30) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `nama_paket`, `harga`) VALUES
('B1', 'Boneka Kecil', 25000),
('B10', 'Sajadah', 4000),
('B2', 'Boneka Besar', 30000),
('B3', 'Seprei  Kecil', 4000),
('B4', 'Seprei Sedang', 6000),
('B5', 'Seprei Besar', 10000),
('B6', 'Selimut Kecil', 4000),
('B7', 'Selimut Sedang', 6000),
('B8', 'Selimut Besar', 10000),
('B9', 'Mukenah', 4000),
('CB4', 'Cuci Basah', 4000),
('CK4', 'Cuci Kering', 4500),
('K1', 'Komplit-2 Hari', 5000),
('K2', 'Komplit-1 Hari', 10000),
('K3', 'Komplit-12Jam', 15000),
('K4', 'Komplit-3 Jam', 25000),
('S1', 'Setrika-2 Hari', 4500),
('S2', 'Setrika-1 Hari', 8000);

-- --------------------------------------------------------

--
-- Table structure for table `parfum`
--

CREATE TABLE `parfum` (
  `kode_parfum` int(3) NOT NULL,
  `id_parfum` int(3) NOT NULL,
  `jenis_parfum` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parfum`
--

INSERT INTO `parfum` (`kode_parfum`, `id_parfum`, `jenis_parfum`) VALUES
(1, 4, 'Fresh'),
(2, 5, 'Aqua'),
(3, 3, 'Sakura'),
(4, 1, 'Lily'),
(5, 2, 'Vanila');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_member` int(6) NOT NULL,
  `nohp` varchar(13) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_member`, `nohp`, `nama`) VALUES
(1, '085974123852', 'Faya'),
(2, '089213412122', 'Aminah'),
(3, '0812245124897', 'Tara');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` char(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `id_member` int(6) NOT NULL,
  `nohp` varchar(13) NOT NULL,
  `id_paket` char(3) NOT NULL,
  `jenis_parfum` varchar(20) NOT NULL,
  `berat` double NOT NULL,
  `total_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_masuk`, `tgl_keluar`, `id_member`, `nohp`, `id_paket`, `jenis_parfum`, `berat`, `total_bayar`) VALUES
('20220602001', '2022-06-02', NULL, 2, '089213412122', 'K1', 'Lily', 4, 20000),
('20220703001', '2022-07-03', NULL, 1, '085974123852', 'K1', 'Aqua', 4, 20000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `parfum`
--
ALTER TABLE `parfum`
  ADD PRIMARY KEY (`kode_parfum`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_paket` (`id_paket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parfum`
--
ALTER TABLE `parfum`
  MODIFY `kode_parfum` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_member` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id_paket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
