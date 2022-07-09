-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jul 2022 pada 09.48
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_stockbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`iduser`, `email`, `password`) VALUES
(1, 'admintoko@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `idbarangkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `pembeli` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barangkeluar`
--

INSERT INTO `barangkeluar` (`idbarangkeluar`, `idbarang`, `tanggal`, `pembeli`, `jumlah`) VALUES
(1, 17, '2022-06-22 15:45:11', 'Aldi', 1),
(2, 13, '2022-06-22 15:45:11', 'Aldi', 2),
(8, 6, '2022-06-22 15:51:42', 'Zakky', 5),
(9, 16, '2022-06-22 15:51:42', 'Zakky', 2),
(10, 18, '2022-06-22 15:51:42', 'Zakky', 3),
(12, 5, '2022-06-28 08:01:30', 'Ramadhan', 7),
(13, 15, '2022-06-28 08:01:30', 'Ramadhan', 3),
(14, 0, '2022-06-28 08:01:30', 'Ramadhan', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `idbarangmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stockbarang`
--

CREATE TABLE `stockbarang` (
  `idbarang` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `merk` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stockbarang`
--

INSERT INTO `stockbarang` (`idbarang`, `kategori`, `jenis`, `merk`, `stock`) VALUES
(5, 'Pulpen', 'Hitam', 'Snowman', 23),
(6, 'Pulpen', 'Biru', 'Standard', 25),
(7, 'Pulpen', 'Merah', 'Standard', 25),
(10, 'Pensil', '2B', 'Handy', 29),
(11, 'Pensil', '2B', 'Stadler', 12),
(12, 'Pensil', '2B', 'Faber-Castell', 7),
(13, 'Pensil', 'HB', 'Stadler', 5),
(14, 'Pensil', 'HB', 'Faber-Castell', 10),
(15, 'Stipo', 'Cair', 'Joyko', 4),
(16, 'Stipo', 'Kertas', 'Joyko', 3),
(17, 'Isolasi', 'Bening Kecil', 'Nachi Tape', 8),
(18, 'Isolasi', 'Hitam Kecil', 'Unibell', 4);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`idbarangkeluar`);

--
-- Indeks untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`idbarangmasuk`);

--
-- Indeks untuk tabel `stockbarang`
--
ALTER TABLE `stockbarang`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  MODIFY `idbarangkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `idbarangmasuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stockbarang`
--
ALTER TABLE `stockbarang`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
