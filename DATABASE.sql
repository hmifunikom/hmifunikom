-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2014 at 01:13 AM
-- Server version: 5.5.16
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hmif`
--
CREATE DATABASE IF NOT EXISTS `hmif` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hmif`;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_02_14_183541_create_tb_divisi', 1),
('2014_02_14_183542_create_tb_acara', 1),
('2014_02_14_183543_create_tb_anggota', 1),
('2014_02_14_183544_create_tb_div_acara', 1),
('2014_02_14_183545_create_tb_kas', 1),
('2014_02_14_183546_create_tb_panitia', 1),
('2014_02_14_183547_create_tb_hp', 1),
('2014_02_14_183548_create_tb_email', 1),
('2014_02_14_183549_create_waktu_acara', 1),
('2014_02_14_183550_create_peserta', 1),
('2014_02_15_145136_create_tb_jenis_user', 1),
('2014_02_15_145215_create_jenis_hak_akses', 1),
('2014_02_15_145238_create_tb_hak_akses', 1),
('2014_02_15_145302_create_tb_user_umum', 1),
('2014_02_15_151008_create_tb_user', 1),
('2013_04_08_175033_create_roles_table', 2),
('2013_04_08_175107_create_permissions_table', 2),
('2013_04_08_175152_create_role_user_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `permissions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE IF NOT EXISTS `peserta` (
  `id_peserta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_peserta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kategori` enum('unikom','luar') COLLATE utf8_unicode_ci NOT NULL,
  `kd_acara` int(10) unsigned DEFAULT NULL,
  `id_user_umum` int(10) unsigned DEFAULT NULL,
  `tgl_daftar` date NOT NULL,
  `nim` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_hp` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ticket` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_peserta`),
  KEY `peserta_kd_acara_foreign` (`kd_acara`),
  KEY `peserta_id_user_umum_foreign` (`id_user_umum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `nama_peserta`, `alamat`, `kategori`, `kd_acara`, `id_user_umum`, `tgl_daftar`, `nim`, `no_hp`, `ticket`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Resna Rizki Pratama', 'JL. Dipati Ukur No. 96E Bandung', 'unikom', 1, NULL, '2014-03-15', '10112335', '082172933394', 'DYiCJek5yZNPXhMbIuggoD8V6zaiDCaondxFcL4G', 'resnarizki29@gmail.com', '2014-02-26 10:11:10', '2014-02-26 10:38:36'),
(7, 'Asmunanda Imam Rasyid', 'JL. Dipati Ukur No. 96E Bandung', 'unikom', 1, NULL, '2014-02-27', '10112335', '082172933394', 'HOGbHm3dOu4s7qgR0zKPSSfXdpejMb4MRzZAPjXZciyl7Uncxx', '', '2014-02-27 07:09:51', '2014-02-27 07:09:51'),
(9, 'test', 'test', 'unikom', 1, NULL, '2014-02-27', '10112335', '082172933394', 'HxS8vQu24E1XE7IbI0PpmQnhDHai2IFVG9ghJti184z1a1uVct', '', '2014-02-27 07:20:56', '2014-02-27 07:20:56'),
(10, 'Iqbal', 'BDG', 'unikom', 5, NULL, '2014-02-28', '10111429', '082172933394', 'AK4mt5LKqi14QPJuz7igu57qNpGAKsoob0hIuM3qNEwk', 'resnarizki29@gmail.com', '2014-02-27 21:05:16', '2014-02-27 21:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2014-02-23 13:29:20', '2014-02-23 13:29:20'),
(2, 'inti', '2014-02-24 17:09:08', '2014-02-24 17:09:08'),
(3, 'koord', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(4, 'sekredivisi', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(5, 'bendaharadivisi', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(6, 'anggota', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(7, 'intiacara', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(8, 'koordpanitia', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(9, 'panitia', '2014-02-24 17:10:18', '2014-02-24 17:10:18'),
(10, 'publik', '2014-02-24 17:10:40', '2014-02-24 17:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_acara`
--

CREATE TABLE IF NOT EXISTS `tb_acara` (
  `kd_acara` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_acara` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tgl` date NOT NULL,
  `tempat` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `pj` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tgl_selesai_LPJ` date NOT NULL DEFAULT '1901-01-01',
  `tema` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kd_acara`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_acara`
--

INSERT INTO `tb_acara` (`kd_acara`, `nama_acara`, `tgl`, `tempat`, `info`, `pj`, `tgl_selesai_LPJ`, `tema`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Seminar Augmented Reality', '2014-03-15', 'Auditorium Miracle UNIKOM', '### Introduction\r\n**Lorem ipsum** dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco *laboris* nisi ut aliquip ex ea commodo consequat. \r\n\r\n- Unikom : Rp. 45.000,00\r\n- Umum : Rp. 50.000,00\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \r\n\r\nMore info: [Google](http://google.com)', 'Angkatan Muda', '1901-12-13', 'Bring Print to Life', 'seminar-augmented-reality', '2014-02-20 11:31:59', '2014-02-27 04:53:27'),
(4, 'Cakrawala - Bazaar', '2014-02-28', 'Parkir UNIKOM', 'Lorem Ipsum', 'Global', '1901-01-01', 'Lorem Ipsum', 'cakrawala-bazaar', '2014-02-26 10:27:43', '2014-02-26 10:32:43'),
(5, 'Bazaar', '2014-02-05', 'Bandungj', 'TEs', 'Humas', '1901-01-01', 'Juara', 'bazaar', '2014-02-27 21:02:32', '2014-02-27 21:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE IF NOT EXISTS `tb_anggota` (
  `id_anggota` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asal` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `jabatan` enum('ketua','sekretaris','bendahara','anggota') COLLATE utf8_unicode_ci NOT NULL,
  `id_divisi` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_anggota`),
  UNIQUE KEY `tb_anggota_nim_unique` (`nim`),
  KEY `tb_anggota_id_divisi_foreign` (`id_divisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_anggota`, `nim`, `nama`, `alamat`, `asal`, `jabatan`, `id_divisi`, `created_at`, `updated_at`) VALUES
(1, '10112335', 'Muhammad Resna Rizki Pratama', 'JL. Dipati Ukur No. 96E Bandung', 'Pekanbaru', 'ketua', 2, '2014-02-27 13:12:44', '2014-02-27 13:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_divisi`
--

CREATE TABLE IF NOT EXISTS `tb_divisi` (
  `id_divisi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `divisi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_divisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tb_divisi`
--

INSERT INTO `tb_divisi` (`id_divisi`, `divisi`) VALUES
(1, 'Inti'),
(2, 'ADM'),
(3, 'Humas'),
(4, 'Litbang'),
(5, 'PWTI'),
(6, 'Kerohanian'),
(7, 'Olahraga');

-- --------------------------------------------------------

--
-- Table structure for table `tb_div_acara`
--

CREATE TABLE IF NOT EXISTS `tb_div_acara` (
  `id_div` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_div` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kd_acara` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_div`),
  KEY `tb_div_acara_kd_acara_foreign` (`kd_acara`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_div_acara`
--

INSERT INTO `tb_div_acara` (`id_div`, `nama_div`, `kd_acara`, `created_at`, `updated_at`) VALUES
(1, 'Inti Acara', 1, '2014-02-26 08:56:57', '2014-02-26 08:56:57'),
(2, 'Acara', 1, '2014-02-26 08:57:26', '2014-02-26 08:57:26'),
(3, 'ADM', 1, '2014-02-26 08:58:31', '2014-02-26 09:00:21'),
(4, 'PubDekDok', 1, '2014-02-26 08:59:17', '2014-02-26 08:59:17'),
(5, 'Humas', 1, '2014-02-26 08:59:30', '2014-02-26 08:59:30'),
(6, 'Konsumsi', 1, '2014-02-26 08:59:42', '2014-02-26 08:59:42'),
(7, 'Keamanan', 1, '2014-02-26 08:59:54', '2014-02-26 08:59:54'),
(8, 'Logistik', 1, '2014-02-26 09:00:00', '2014-02-26 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_email`
--

CREATE TABLE IF NOT EXISTS `tb_email` (
  `kd_email` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_anggota` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kd_email`),
  KEY `tb_email_id_anggota_foreign` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tb_email`
--

INSERT INTO `tb_email` (`kd_email`, `id_anggota`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 'resnarizki29@gmail.com', '2014-02-27 14:23:32', '2014-02-27 14:23:32'),
(2, 1, 'resna_rizki@yahoo.co.id', '2014-02-27 14:25:01', '2014-02-27 14:25:01'),
(3, 1, 'resna_rizki@hotmail.com', '2014-02-27 14:25:12', '2014-02-27 14:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hp`
--

CREATE TABLE IF NOT EXISTS `tb_hp` (
  `kd_hp` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_anggota` int(10) unsigned NOT NULL,
  `no_hp` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kd_hp`),
  KEY `tb_hp_id_anggota_foreign` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_hp`
--

INSERT INTO `tb_hp` (`kd_hp`, `id_anggota`, `no_hp`, `created_at`, `updated_at`) VALUES
(2, 1, '082172933394', '2014-02-27 14:13:29', '2014-02-27 14:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kas`
--

CREATE TABLE IF NOT EXISTS `tb_kas` (
  `kd_kas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_anggota` int(10) unsigned DEFAULT NULL,
  `bulan` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kd_kas`),
  KEY `tb_kas_bulan_index` (`bulan`),
  KEY `tb_kas_id_anggota_foreign` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_kas`
--

INSERT INTO `tb_kas` (`kd_kas`, `id_anggota`, `bulan`, `created_at`, `updated_at`) VALUES
(1, 1, '2014-02-01', '2014-02-27 14:42:05', '2014-02-27 14:42:05'),
(2, 1, '2013-11-01', '2014-02-27 14:45:13', '2014-02-27 14:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_panitia`
--

CREATE TABLE IF NOT EXISTS `tb_panitia` (
  `id_panitia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_anggota` int(10) unsigned NOT NULL,
  `kd_acara` int(10) unsigned NOT NULL,
  `id_div` int(10) unsigned DEFAULT NULL,
  `jabatan` enum('koor','angg') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_panitia`),
  KEY `tb_panitia_id_anggota_foreign` (`id_anggota`),
  KEY `tb_panitia_kd_acara_foreign` (`kd_acara`),
  KEY `tb_panitia_id_div_foreign` (`id_div`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_anggota` int(10) unsigned DEFAULT NULL,
  `id_user_umum` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  KEY `tb_user_id_anggota_foreign` (`id_anggota`),
  KEY `tb_user_id_user_umum_foreign` (`id_user_umum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `id_anggota`, `id_user_umum`, `created_at`, `updated_at`) VALUES
(5, 'admin', '$2y$10$mBlZqZ8/bIToM7CkmLLm6eHqeruEJvoWIUFDRzW.cvw0GFA8kgsLq', NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_umum`
--

CREATE TABLE IF NOT EXISTS `tb_user_umum` (
  `id_user_umum` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nim` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_hp` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_user_umum`),
  UNIQUE KEY `tb_user_umum_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_user_umum`
--

INSERT INTO `tb_user_umum` (`id_user_umum`, `nama`, `nim`, `alamat`, `no_hp`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '000000', 'Sekretariat HMIF UNIKOM', '08xxxxxxxxxx', 'admin@hmifunikom.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_acara`
--

CREATE TABLE IF NOT EXISTS `waktu_acara` (
  `id_waktu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_acara` int(10) unsigned NOT NULL,
  `waktu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_waktu`),
  KEY `waktu_acara_kd_acara_foreign` (`kd_acara`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `waktu_acara`
--

INSERT INTO `waktu_acara` (`id_waktu`, `kd_acara`, `waktu`, `created_at`, `updated_at`) VALUES
(2, 1, '08.00 - 13.00', '2014-02-26 08:26:39', '2014-02-26 08:26:39'),
(5, 4, '08.00 - 18.00', '2014-02-26 10:28:04', '2014-02-26 10:28:04');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_id_user_umum_foreign` FOREIGN KEY (`id_user_umum`) REFERENCES `tb_user_umum` (`id_user_umum`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `peserta_kd_acara_foreign` FOREIGN KEY (`kd_acara`) REFERENCES `tb_acara` (`kd_acara`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD CONSTRAINT `tb_anggota_id_divisi_foreign` FOREIGN KEY (`id_divisi`) REFERENCES `tb_divisi` (`id_divisi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_div_acara`
--
ALTER TABLE `tb_div_acara`
  ADD CONSTRAINT `tb_div_acara_kd_acara_foreign` FOREIGN KEY (`kd_acara`) REFERENCES `tb_acara` (`kd_acara`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_email`
--
ALTER TABLE `tb_email`
  ADD CONSTRAINT `tb_email_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_hp`
--
ALTER TABLE `tb_hp`
  ADD CONSTRAINT `tb_hp_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kas`
--
ALTER TABLE `tb_kas`
  ADD CONSTRAINT `tb_kas_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_panitia`
--
ALTER TABLE `tb_panitia`
  ADD CONSTRAINT `tb_panitia_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_panitia_id_div_foreign` FOREIGN KEY (`id_div`) REFERENCES `tb_div_acara` (`id_div`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_panitia_kd_acara_foreign` FOREIGN KEY (`kd_acara`) REFERENCES `tb_acara` (`kd_acara`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_user_id_user_umum_foreign` FOREIGN KEY (`id_user_umum`) REFERENCES `tb_user_umum` (`id_user_umum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waktu_acara`
--
ALTER TABLE `waktu_acara`
  ADD CONSTRAINT `waktu_acara_kd_acara_foreign` FOREIGN KEY (`kd_acara`) REFERENCES `tb_acara` (`kd_acara`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
