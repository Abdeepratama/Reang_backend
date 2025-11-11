-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 02:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reang`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `role` enum('superadmin','admindinas','puskesmas','dokter','umkm') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `fcm_token`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$12$V5KWwvSTp5W0F7oyPmE3bOazRoE0NXGtGEOgZy45bgX1xjGlPDFI2', NULL, 'superadmin', NULL, '2025-07-01 23:21:50', '2025-10-07 23:47:49'),
(2, 'abdee', '$2y$12$sv18I47t8En5TPDnQ.tBVOsHD9eGbpEBzr9UJekgfXEEj5QjgnGSu', NULL, 'superadmin', NULL, '2025-09-12 00:27:34', '2025-10-08 20:46:42'),
(3, 'kesehatan', '$2y$12$HCpenKV37wec4FbQeP2kuOd9nRs8IdrBJmVg/dIUxu7TB5HCn6Zr2', NULL, 'admindinas', NULL, '2025-09-14 06:03:20', '2025-10-07 23:49:14'),
(4, 'pendidikan', '$2y$12$0YE3sgn4O7w4cOMbf0lZnevKhrxFazg7fHoC0SZDaAsc5bM3BgpgO', NULL, 'admindinas', NULL, '2025-09-15 18:55:09', '2025-09-15 18:55:09'),
(5, 'bapenda', '$2y$12$9GD3DvTeiHf1Vs5ZvOZsVeCxKuEdPtuisU0LVkV9LxzF0pTTDbjcS', NULL, 'admindinas', NULL, '2025-09-16 00:43:32', '2025-09-16 00:43:32'),
(7, 'perdagangan', '$2y$12$655lGxsYeELsngzXY44QiO73YTQBVWEGgvfXSkl77b5dqFXzHEnCG', NULL, 'admindinas', NULL, '2025-09-16 19:28:06', '2025-09-16 19:28:06'),
(8, 'disnaker', '$2y$12$QZHoBApUykgPPS2IlBgbxu8Er7QNrYM79YSP4n7myM55M5k6YSgCu', NULL, 'admindinas', NULL, '2025-09-16 19:55:32', '2025-09-16 19:55:32'),
(9, 'pariwisata', '$2y$12$aVS6YKj77deU/t3CY9X34.HBCefXHZ9Sn.gpACnjFg7e4UgiH/CT2', NULL, 'admindinas', NULL, '2025-09-17 00:42:09', '2025-09-17 00:42:09'),
(10, 'keagamaan', '$2y$12$qf3IgbrrIcy601EUWSp0EeKY/rwe3I0BhWPngSwgPX8HftbtSsAU.', NULL, 'admindinas', NULL, '2025-09-17 18:48:09', '2025-09-17 18:48:09'),
(11, 'adminduk', '$2y$12$L7LyLOhZ7HJBhsI/tWfFGeTZ/bq2iJJOioTHfioxyeZ0zN..Txcfu', NULL, 'admindinas', NULL, '2025-09-17 20:08:23', '2025-09-17 20:15:58'),
(12, 'renbang', '$2y$12$W5m3lPX3up1/RXNaCQedu.K.mzz9SLW9Me/c6HW8yhTPMRDydNt6S', NULL, 'admindinas', NULL, '2025-09-17 20:36:20', '2025-09-17 20:36:20'),
(13, 'perizinan', '$2y$12$16QdWnlaUXTcZmVbGLdx6evKGyBQ3GiKyKd0IQnWN9Xa.uKzd9tsW', NULL, 'admindinas', NULL, '2025-09-17 23:15:29', '2025-09-17 23:15:29'),
(36, 'pkm.jatibarang', '$2y$12$6Ocbki8QXEN2EZmHlAy2Ge2mAvgoKmBVtCVB5.51Dou9lU121BOVW', NULL, 'puskesmas', NULL, '2025-11-04 18:55:24', '2025-11-04 18:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_instansi` int DEFAULT NULL,
  `id_puskesmas` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `keterangan`, `role`, `id_instansi`, `id_puskesmas`, `url`, `item_id`, `tipe`, `dibaca`, `created_at`, `updated_at`) VALUES
(1, 'Menambahkan Tempat Ibadah: ', NULL, NULL, NULL, NULL, NULL, 'ibadah', 1, '2025-07-04 18:30:34', '2025-07-08 20:27:43'),
(2, 'Menambahkan Aduan Masyarakat ', NULL, NULL, NULL, NULL, NULL, 'Pengaduan', 1, '2025-07-07 18:56:58', '2025-07-07 20:17:12'),
(3, 'Sistem menerima pengaduan baru dari masyarakat', NULL, NULL, NULL, NULL, NULL, 'Pengaduan', 1, '2025-07-07 19:15:55', '2025-07-08 20:27:35'),
(4, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:22:02', '2025-07-07 20:22:11'),
(5, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:27:25', '2025-07-07 20:27:32'),
(6, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:29:44', '2025-07-08 20:27:48'),
(7, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:31:07', '2025-07-08 20:28:28'),
(8, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, 'http://127.0.0.1:8000/admin/ibadah?8', NULL, 'Ibadah', 1, '2025-07-08 02:03:49', '2025-07-08 02:04:03'),
(9, 'Menambahkan Lokasi Rumah Sakit ', 'admindinas', 2, NULL, NULL, NULL, 'sehat', 1, '2025-07-08 02:04:46', '2025-07-08 02:04:53'),
(10, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, 'http://127.0.0.1:8000/admin/pasar?2', NULL, 'Pasar', 1, '2025-07-08 19:08:11', '2025-07-08 19:37:00'),
(11, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, 'http://127.0.0.1:8000/admin/pasar?3', NULL, 'Pasar', 1, '2025-07-08 19:10:05', '2025-07-08 20:07:33'),
(12, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:19:53', '2025-07-08 20:19:53'),
(13, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:24:50', '2025-07-08 20:24:50'),
(14, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:26:26', '2025-07-08 20:26:26'),
(15, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:07', '2025-07-08 20:27:07'),
(16, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:10', '2025-07-08 20:27:10'),
(17, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:14', '2025-07-08 20:27:14'),
(18, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:17', '2025-07-08 20:27:17'),
(19, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:21', '2025-07-08 20:27:21'),
(20, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:28:12', '2025-07-08 20:28:12'),
(21, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:33:11', '2025-07-08 20:33:11'),
(22, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:33:32', '2025-07-08 20:33:32'),
(23, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:39:20', '2025-07-08 20:39:20'),
(24, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:39:44', '2025-07-08 20:39:44'),
(25, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 20:46:22', '2025-07-08 20:46:22'),
(26, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 20:57:38', '2025-07-08 20:57:38'),
(27, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:06', '2025-07-08 21:00:06'),
(28, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:35', '2025-07-08 21:00:35'),
(29, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:59', '2025-07-08 21:00:59'),
(30, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:02:53', '2025-07-08 21:02:53'),
(31, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:46', '2025-07-08 21:03:46'),
(32, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:51', '2025-07-08 21:03:51'),
(33, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:57', '2025-07-08 21:03:57'),
(34, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:04:01', '2025-07-08 21:04:01'),
(35, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:04:06', '2025-07-08 21:04:06'),
(36, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 23:59:07', '2025-07-08 23:59:07'),
(37, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 00:36:05', '2025-07-09 00:36:05'),
(38, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 00:43:41', '2025-07-09 00:43:41'),
(39, 'Menambahkan Rumah Sakit', NULL, NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 00:54:05', '2025-07-09 00:54:05'),
(40, 'Mengubah Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 01:06:02', '2025-07-09 01:06:02'),
(41, 'Menghapus Pengaduan Masyarakat', NULL, NULL, NULL, NULL, NULL, 'Pengaduan Masyarakat', 0, '2025-07-09 01:06:23', '2025-07-09 01:06:23'),
(42, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 19:45:28', '2025-07-09 19:45:28'),
(43, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 19:45:47', '2025-07-09 19:45:47'),
(44, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 19:45:52', '2025-07-09 19:45:52'),
(45, 'Menghapus Rumah Sakit', NULL, NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 19:46:04', '2025-07-09 19:46:04'),
(46, 'Menghapus Rumah Sakit', NULL, NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 19:46:09', '2025-07-09 19:46:09'),
(47, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:27:57', '2025-07-10 19:27:57'),
(48, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:28:32', '2025-07-10 19:28:32'),
(49, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:30:06', '2025-07-10 19:30:06'),
(50, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:30:13', '2025-07-10 19:30:13'),
(51, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:36:53', '2025-07-10 19:36:53'),
(52, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:39:42', '2025-07-10 19:39:42'),
(53, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:43:37', '2025-07-10 19:43:37'),
(54, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:47:28', '2025-07-10 19:47:28'),
(55, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:49:25', '2025-07-10 19:49:25'),
(56, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:51:22', '2025-07-10 19:51:22'),
(57, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:57:39', '2025-07-10 19:57:39'),
(58, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:01:08', '2025-07-10 20:01:08'),
(59, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:03:54', '2025-07-10 20:03:54'),
(60, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:06:30', '2025-07-10 20:06:30'),
(61, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:06:36', '2025-07-10 20:06:36'),
(62, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:07:47', '2025-07-10 20:07:47'),
(63, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:16:05', '2025-07-10 20:16:05'),
(64, 'Menghapus Sehat', NULL, NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:16:15', '2025-07-10 20:16:15'),
(65, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:14:00', '2025-07-15 00:14:00'),
(66, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:15:08', '2025-07-15 00:15:08'),
(67, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:25:03', '2025-07-15 00:25:03'),
(68, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:44:25', '2025-07-15 00:44:25'),
(69, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 19:28:15', '2025-07-15 19:28:15'),
(70, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 19:28:55', '2025-07-15 19:28:55'),
(71, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 23:29:08', '2025-07-15 23:29:08'),
(72, 'Menambahkan Renbang', NULL, NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 18:55:56', '2025-07-17 18:55:56'),
(73, 'Menambahkan Renbang', NULL, NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:07:49', '2025-07-17 19:07:49'),
(74, 'Mengubah Renbang', NULL, NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:14:35', '2025-07-17 19:14:35'),
(75, 'Mengubah Renbang', NULL, NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:14:55', '2025-07-17 19:14:55'),
(76, 'Menghapus Renbang', NULL, NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-20 18:37:16', '2025-07-20 18:37:16'),
(77, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:23:47', '2025-07-23 21:23:47'),
(78, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:49:50', '2025-07-23 21:49:50'),
(79, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:51:00', '2025-07-23 21:51:00'),
(80, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 23:28:53', '2025-07-23 23:28:53'),
(81, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 23:35:51', '2025-07-23 23:35:51'),
(82, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:24:58', '2025-07-24 01:24:58'),
(83, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:25:04', '2025-07-24 01:25:04'),
(84, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:36:19', '2025-07-24 01:36:19'),
(85, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:36:26', '2025-07-24 01:36:26'),
(86, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-27 20:41:45', '2025-07-27 20:41:45'),
(87, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-27 20:41:52', '2025-07-27 20:41:52'),
(88, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-28 00:23:01', '2025-07-28 00:23:01'),
(89, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-30 21:34:41', '2025-07-30 21:34:41'),
(90, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-30 21:36:13', '2025-07-30 21:36:13'),
(91, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-01 01:06:04', '2025-08-01 01:06:04'),
(92, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-01 01:09:16', '2025-08-01 01:09:16'),
(93, 'Menghapus Plesir', NULL, NULL, NULL, NULL, NULL, 'Plesir', 0, '2025-08-07 18:25:35', '2025-08-07 18:25:35'),
(94, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-18 21:06:31', '2025-08-18 21:06:31'),
(95, 'Info keagamaan baru ditambahkan: Pengajian rock n dut', NULL, NULL, NULL, 'InfoKeagamaan', NULL, 'create', 0, '2025-08-18 21:21:10', '2025-08-18 21:21:10'),
(96, 'Info keagamaan baru ditambahkan: Pengajian rock n roll', NULL, NULL, NULL, 'create', NULL, 'InfoKeagamaan', 0, '2025-08-18 21:28:56', '2025-08-18 21:28:56'),
(97, 'Info keagamaan baru ditambahkan: ', NULL, NULL, NULL, 'create', NULL, 'InfoKeagamaan', 0, '2025-08-19 00:09:54', '2025-08-19 00:09:54'),
(98, 'Info keagamaan diperbarui ', NULL, NULL, NULL, 'update', 11, 'InfoKeagamaan', 0, '2025-08-19 00:13:37', '2025-08-19 00:13:37'),
(99, 'Info keagamaan dihapus ', NULL, NULL, NULL, 'delete', 10, 'InfoKeagamaan', 0, '2025-08-19 00:16:33', '2025-08-19 00:16:33'),
(100, 'create', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:23:35', '2025-08-19 00:23:35'),
(101, 'InfoKeagamaan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:34:37', '2025-08-19 00:34:37'),
(102, 'Tempat ibadah telah ditambahkanGereja Babadan', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:37:50', '2025-08-19 00:37:50'),
(103, 'Tempat ibadah diperbarui: Gereja Santo Babadan 1', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 18:57:25', '2025-08-19 18:57:25'),
(104, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 18:59:47', '2025-08-19 18:59:47'),
(105, 'Menghapus Tempat ibadah', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:01:24', '2025-08-19 19:01:24'),
(106, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:09:38', '2025-08-19 19:09:38'),
(107, 'Info keagamaan telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:12:08', '2025-08-19 19:12:08'),
(108, 'Info keagamaan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:13:49', '2025-08-19 19:13:49'),
(109, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 19:38:46', '2025-08-19 19:38:46'),
(110, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 19:42:47', '2025-08-19 19:42:47'),
(111, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 20:05:55', '2025-08-19 20:05:55'),
(112, 'Menghapus Pasar', NULL, NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 20:07:16', '2025-08-19 20:07:16'),
(113, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:08:21', '2025-08-19 20:08:21'),
(114, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:13:29', '2025-08-19 20:13:29'),
(115, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:15:19', '2025-08-19 20:15:19'),
(116, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:22:50', '2025-08-19 20:22:50'),
(117, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:23:44', '2025-08-19 20:23:44'),
(118, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:20', '2025-08-19 20:27:20'),
(119, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:27', '2025-08-19 20:27:27'),
(120, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:31', '2025-08-19 20:27:31'),
(121, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:42', '2025-08-19 20:27:42'),
(122, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:31:00', '2025-08-19 20:31:00'),
(123, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:31:33', '2025-08-19 20:31:33'),
(124, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:58:42', '2025-08-19 20:58:42'),
(125, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:09:46', '2025-08-19 21:09:46'),
(126, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:09:59', '2025-08-19 21:09:59'),
(127, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:12:16', '2025-08-19 21:12:16'),
(128, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:12:31', '2025-08-19 21:12:31'),
(129, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:27:43', '2025-08-19 21:27:43'),
(130, 'Lokasi Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:35:45', '2025-08-19 21:35:45'),
(131, 'Lokasi Plesir telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:36:22', '2025-08-19 21:36:22'),
(132, 'Menghapus Tempat Plesir', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:36:35', '2025-08-19 21:36:35'),
(133, 'Info Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:41:04', '2025-08-19 21:41:04'),
(134, 'Info Plesir telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:42:13', '2025-08-19 21:42:13'),
(135, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:42:28', '2025-08-19 21:42:28'),
(136, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:47:45', '2025-08-19 21:47:45'),
(137, 'Lokasi Kesehatan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:49:10', '2025-08-19 21:49:10'),
(138, 'Menghapus Lokasi Kesehatan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:49:23', '2025-08-19 21:49:23'),
(139, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:52:38', '2025-08-19 21:52:38'),
(140, 'Menghapus Lokasi Kesehatan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:52:42', '2025-08-19 21:52:42'),
(141, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:03:27', '2025-08-19 22:03:27'),
(142, 'Lokasi Sekolah telah diupdate', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:04:02', '2025-08-19 22:04:02'),
(143, 'Lokasi Sekolah telah dihapus', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:04:11', '2025-08-19 22:04:11'),
(144, 'Info Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:04:24', '2025-08-20 21:04:24'),
(145, 'Info Pasar telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:12:59', '2025-08-20 21:12:59'),
(146, 'Info Pasar telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:15:39', '2025-08-20 21:15:39'),
(147, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 18:59:21', '2025-08-21 18:59:21'),
(148, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 18:59:50', '2025-08-21 18:59:50'),
(149, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 19:00:29', '2025-08-21 19:00:29'),
(150, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 19:03:06', '2025-08-21 19:03:06'),
(151, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-21 19:05:47', '2025-08-21 19:05:47'),
(152, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:23:52', '2025-08-25 00:23:52'),
(153, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:35:13', '2025-08-25 00:35:13'),
(154, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:41:48', '2025-08-25 00:41:48'),
(155, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:56:06', '2025-08-25 00:56:06'),
(156, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 20:06:59', '2025-08-26 20:06:59'),
(157, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:03:16', '2025-08-26 21:03:16'),
(158, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:41:48', '2025-08-26 21:41:48'),
(159, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:42:00', '2025-08-26 21:42:00'),
(160, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:51:27', '2025-08-26 21:51:27'),
(161, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:15', '2025-08-26 21:55:15'),
(162, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:29', '2025-08-26 21:55:29'),
(163, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:39', '2025-08-26 21:55:39'),
(164, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:20', '2025-08-26 23:21:20'),
(165, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:39', '2025-08-26 23:21:39'),
(166, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:49', '2025-08-26 23:21:49'),
(167, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:30:01', '2025-08-26 23:30:01'),
(168, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:35:05', '2025-08-26 23:35:05'),
(169, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:36:24', '2025-08-26 23:36:24'),
(170, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:21:27', '2025-08-27 00:21:27'),
(171, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:38:47', '2025-08-27 00:38:47'),
(172, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:47:19', '2025-08-27 00:47:19'),
(173, 'Lokasi Kesehatan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:49:10', '2025-08-27 00:49:10'),
(174, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:49:36', '2025-08-27 00:49:36'),
(175, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:50:04', '2025-08-27 00:50:04'),
(176, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:57:35', '2025-08-27 00:57:35'),
(177, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 01:04:49', '2025-08-27 01:04:49'),
(178, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 20:35:51', '2025-08-27 20:35:51'),
(179, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 20:49:31', '2025-08-27 20:49:31'),
(180, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:05:03', '2025-08-27 21:05:03'),
(181, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:09:02', '2025-08-27 21:09:02'),
(182, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:11:02', '2025-08-27 21:11:02'),
(183, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:16', '2025-08-27 21:15:16'),
(184, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:37', '2025-08-27 21:15:37'),
(185, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:44', '2025-08-27 21:15:44'),
(186, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-28 00:19:07', '2025-08-28 00:19:07'),
(187, 'Info Pajak telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-28 20:47:11', '2025-08-28 20:47:11'),
(188, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-29 00:20:22', '2025-08-29 00:20:22'),
(189, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:03:06', '2025-09-01 00:03:06'),
(190, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:09:17', '2025-09-01 00:09:17'),
(191, 'Info Kerja telah diupdate', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:31:36', '2025-09-01 00:31:36'),
(192, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-01 18:57:32', '2025-09-01 18:57:32'),
(193, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:36:52', '2025-09-01 19:36:52'),
(194, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:39:23', '2025-09-01 19:39:23'),
(195, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:48:04', '2025-09-01 19:48:04'),
(196, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:53:16', '2025-09-01 19:53:16'),
(197, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:57:57', '2025-09-01 19:57:57'),
(198, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 20:27:14', '2025-09-01 20:27:14'),
(199, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 21:12:27', '2025-09-01 21:12:27'),
(200, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 21:28:44', '2025-09-01 21:28:44'),
(201, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 23:25:59', '2025-09-01 23:25:59'),
(202, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 23:35:21', '2025-09-01 23:35:21'),
(203, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-02 00:12:09', '2025-09-02 00:12:09'),
(204, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-02 00:14:13', '2025-09-02 00:14:13'),
(205, 'Info Perizinan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Info Perizinan', 0, '2025-09-02 01:47:36', '2025-09-02 01:47:36'),
(206, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-02 18:28:10', '2025-09-02 18:28:10'),
(207, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-02 18:57:01', '2025-09-02 18:57:01'),
(208, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 19:31:59', '2025-09-02 19:31:59'),
(209, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:12:26', '2025-09-02 20:12:26'),
(210, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:12:45', '2025-09-02 20:12:45'),
(211, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:13:23', '2025-09-02 20:13:23'),
(212, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:26:15', '2025-09-02 21:26:15'),
(213, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:26:43', '2025-09-02 21:26:43'),
(214, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:27:28', '2025-09-02 21:27:28'),
(215, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:28:35', '2025-09-02 21:28:35'),
(216, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:29:23', '2025-09-02 21:29:23'),
(217, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:30:52', '2025-09-02 21:30:52'),
(218, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-03 00:18:10', '2025-09-03 00:18:10'),
(219, 'Info Sekolah telah diupdate', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-03 01:42:53', '2025-09-03 01:42:53'),
(220, 'Info Sekolah telah diupdate', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-03 01:51:19', '2025-09-03 01:51:19'),
(221, 'Menghapus dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-03 02:00:29', '2025-09-03 02:00:29'),
(222, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-08 21:11:18', '2025-09-08 21:11:18'),
(223, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 00:43:54', '2025-09-09 00:43:54'),
(224, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 00:45:07', '2025-09-09 00:45:07'),
(225, 'Tempat ibadah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:50:57', '2025-09-09 01:50:57'),
(226, 'Tempat ibadah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:52:11', '2025-09-09 01:52:11'),
(227, 'Menghapus Tempat ibadah', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:53:59', '2025-09-09 01:53:59'),
(228, 'Menambahkan dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:01:33', '2025-09-18 19:01:33'),
(229, 'Menghapus dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:11:30', '2025-09-18 19:11:30'),
(230, 'Menghapus dumas', NULL, NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:15:04', '2025-09-18 19:15:04'),
(231, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28'),
(232, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28'),
(233, 'Lokasi Kesehatan telah diupdate', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24'),
(234, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24'),
(235, 'Lokasi Kesehatan telah diupdate', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49'),
(236, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49'),
(237, 'Lokasi Kesehatan telah dihapus', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 20:11:56', '2025-09-21 20:11:56'),
(238, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:23:41', '2025-09-21 21:23:41'),
(239, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:24:32', '2025-09-21 21:24:32'),
(240, 'Lokasi Kesehatan telah dihapus', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:34:02', '2025-09-21 21:34:02'),
(241, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-21 23:44:06', '2025-09-21 23:44:06'),
(242, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-23 07:28:57', '2025-09-23 07:28:57'),
(243, 'Info Pajak telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-23 18:24:18', '2025-09-23 18:24:18'),
(244, 'Info Pajak telah diupdate', 'admindinas', NULL, NULL, 'http://192.168.255.96:8000/admin/pajak/info', 1, 'info_pajak', 0, '2025-09-23 18:45:41', '2025-09-23 18:45:41'),
(245, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-29 23:40:30', '2025-09-29 23:40:30'),
(246, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:15', '2025-09-30 00:02:15'),
(247, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:22', '2025-09-30 00:02:22'),
(248, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:29', '2025-09-30 00:02:29'),
(249, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:40', '2025-09-30 00:02:40'),
(250, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:05:57', '2025-09-30 00:05:57'),
(251, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:13:47', '2025-09-30 00:13:47'),
(252, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:13:55', '2025-09-30 00:13:55'),
(253, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:14:02', '2025-09-30 00:14:02'),
(254, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:14:36', '2025-09-30 00:14:36'),
(255, 'Tempat olahraga telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:42:25', '2025-09-30 00:42:25'),
(256, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:41:11', '2025-09-30 01:41:11'),
(257, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:45:40', '2025-09-30 01:45:40'),
(258, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:45:55', '2025-09-30 01:45:55'),
(259, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:46:00', '2025-09-30 01:46:00'),
(260, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:46:28', '2025-09-30 01:46:28'),
(261, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 01:55:04', '2025-09-30 01:55:04'),
(262, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:04:40', '2025-09-30 02:04:40'),
(263, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:05:01', '2025-09-30 02:05:01'),
(264, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:06:09', '2025-09-30 02:06:09'),
(265, 'Lokasi Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:28:29', '2025-09-30 03:28:29'),
(266, 'Lokasi Plesir telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:29:19', '2025-09-30 03:29:19'),
(267, 'Lokasi Plesir telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:29:32', '2025-09-30 03:29:32'),
(268, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:30:50', '2025-09-30 03:30:50'),
(269, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:31:08', '2025-09-30 03:31:08'),
(270, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:37:17', '2025-09-30 03:37:17'),
(271, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:40:09', '2025-09-30 03:40:09'),
(272, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:41:40', '2025-09-30 03:41:40'),
(273, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:47:49', '2025-09-30 03:47:49'),
(274, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:47:56', '2025-09-30 03:47:56'),
(275, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:48:00', '2025-09-30 03:48:00'),
(276, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:48:10', '2025-09-30 03:48:10'),
(277, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 04:05:51', '2025-09-30 04:05:51'),
(278, 'Tempat olahraga telah diperbarui', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 04:15:04', '2025-09-30 04:15:04'),
(279, 'Tempat olahraga telah diperbarui', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 04:18:43', '2025-09-30 04:18:43'),
(280, 'Info keagamaan telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-30 04:37:35', '2025-09-30 04:37:35'),
(281, 'Info Adminduk telah dihapus', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:19', '2025-09-30 04:56:19'),
(282, 'Info Adminduk telah dihapus', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:25', '2025-09-30 04:56:25'),
(283, 'Info Adminduk telah diupdate', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:37', '2025-09-30 04:56:37'),
(284, 'Info Renbang telah diperbarui', NULL, NULL, NULL, NULL, NULL, 'renbang', 0, '2025-09-30 05:02:48', '2025-09-30 05:02:48'),
(285, 'Info Renbang telah dihapus', NULL, NULL, NULL, NULL, NULL, 'renbang', 0, '2025-09-30 05:04:31', '2025-09-30 05:04:31'),
(286, 'Info Perizinan telah diupdate', NULL, NULL, NULL, NULL, NULL, 'Info Perizinan', 0, '2025-09-30 05:11:15', '2025-09-30 05:11:15'),
(287, 'Tempat olahraga telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-01 19:20:31', '2025-10-01 19:20:31'),
(288, 'Tempat olahraga telah diperbarui', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-01 20:24:23', '2025-10-01 20:24:23'),
(289, 'Tempat olahraga telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-01 20:29:44', '2025-10-01 20:29:44'),
(290, 'Tempat olahraga telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-01 20:33:24', '2025-10-01 20:33:24'),
(291, 'Lokasi Kesehatan baru telah ditambahkan', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-08 19:31:31', '2025-10-08 19:31:31'),
(292, 'Lokasi Kesehatan telah diupdate', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-08 20:08:09', '2025-10-08 20:08:09'),
(293, 'Lokasi Kesehatan telah diupdate', 'admindinas', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-08 20:19:47', '2025-10-08 20:19:47'),
(294, 'Lokasi Kesehatan telah diupdate', 'admindinas', 2, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-08 20:25:02', '2025-10-08 20:25:02'),
(295, 'Lokasi Kesehatan telah diupdate', 'admindinas', 2, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-09 00:35:04', '2025-10-09 00:35:04'),
(296, 'Lokasi Kesehatan telah dihapus', 'admindinas', 2, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-09 00:35:33', '2025-10-09 00:35:33'),
(297, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-10-12 19:50:30', '2025-10-12 19:50:30'),
(298, 'Info Sekolah telah dihapus', 'admindinas', 3, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-12 20:24:57', '2025-10-12 20:24:57'),
(299, 'Tempat ibadah diperbarui', 'admindinas', 10, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-12 23:57:52', '2025-10-12 23:57:52'),
(300, 'Info Pajak telah diupdate', 'admindinas', 6, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-13 00:12:03', '2025-10-13 00:12:03'),
(301, 'Lokasi Pasar telah diupdate', 'admindinas', 7, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-10-13 00:22:10', '2025-10-13 00:22:10'),
(302, 'Lokasi Pasar telah diupdate', 'admindinas', 7, NULL, NULL, NULL, 'pasar', 0, '2025-10-13 00:25:25', '2025-10-13 00:25:25'),
(303, 'Info Sekolah telah dihapus', 'admindinas', 3, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-13 00:28:57', '2025-10-13 00:28:57'),
(304, 'Tempat ibadah diperbarui', 'admindinas', 10, NULL, NULL, NULL, 'ibadah', 0, '2025-10-13 00:30:46', '2025-10-13 00:30:46'),
(305, 'Info Kerja telah diupdate', 'admindinas', 8, NULL, NULL, NULL, 'kerja', 0, '2025-10-13 00:34:56', '2025-10-13 00:34:56'),
(306, 'Info Kerja telah diupdate', 'admindinas', 8, NULL, NULL, NULL, 'kerja', 0, '2025-10-13 00:35:33', '2025-10-13 00:35:33'),
(307, 'Info Kerja telah dihapus', 'admindinas', 8, NULL, NULL, NULL, 'kerja', 0, '2025-10-13 00:35:45', '2025-10-13 00:35:45'),
(308, 'Lokasi Plesir telah diupdate', 'admindinas', 9, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-13 01:09:03', '2025-10-13 01:09:03'),
(309, 'Info Kesehatan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-13 01:13:48', '2025-10-13 01:13:48'),
(310, 'Info Kesehatan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-13 18:33:40', '2025-10-13 18:33:40'),
(311, 'Info keagamaan telah diperbarui', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-13 19:17:37', '2025-10-13 19:17:37'),
(312, 'Info keagamaan telah diperbarui', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-13 19:20:55', '2025-10-13 19:20:55'),
(313, 'Info Sekolah telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-13 20:23:25', '2025-10-13 20:23:25'),
(314, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-10-13 23:38:10', '2025-10-13 23:38:10'),
(315, 'Info Adminduk telah diupdate', 'admindinas', 11, NULL, NULL, NULL, 'adminduk', 0, '2025-10-13 23:45:17', '2025-10-13 23:45:17'),
(316, 'Info Renbang telah ditambahkan', 'admindinas', 12, NULL, NULL, NULL, 'renbang', 0, '2025-10-13 23:49:59', '2025-10-13 23:49:59'),
(317, 'Info Perizinan telah ditambahkan', 'admindinas', 13, NULL, NULL, NULL, 'kerja', 0, '2025-10-13 23:55:50', '2025-10-13 23:55:50'),
(318, 'Info keagamaan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-15 00:23:47', '2025-10-15 00:23:47'),
(319, 'Info Sekolah telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-15 00:36:32', '2025-10-15 00:36:32'),
(320, 'Info Pajak telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'pajak', 0, '2025-10-15 00:41:40', '2025-10-15 00:41:40'),
(321, 'Info Kerja telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-10-15 00:42:58', '2025-10-15 00:42:58'),
(322, 'Info Plesir telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-15 01:18:34', '2025-10-15 01:18:34'),
(323, 'Info Adminduk telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-10-15 01:21:13', '2025-10-15 01:21:13'),
(324, 'Info Renbang telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-10-15 01:23:56', '2025-10-15 01:23:56'),
(325, 'Info Perizinan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-10-15 01:24:41', '2025-10-15 01:24:41'),
(326, 'Lokasi Kesehatan telah dihapus', 'admindinas', 2, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-16 23:51:15', '2025-10-16 23:51:15'),
(327, 'Info Pajak telah dihapus', 'admindinas', 6, NULL, NULL, NULL, 'pajak', 0, '2025-10-17 01:51:26', '2025-10-17 01:51:26'),
(328, 'Lokasi Kesehatan telah dihapus', 'admindinas', 2, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-17 01:56:14', '2025-10-17 01:56:14'),
(329, 'Tempat olahraga telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-26 19:47:44', '2025-10-26 19:47:44'),
(330, 'Tempat olahraga telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-10-26 19:48:06', '2025-10-26 19:48:06'),
(331, 'Lokasi Sekolah telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Sekolah', 0, '2025-10-26 19:56:40', '2025-10-26 19:56:40'),
(332, 'Lokasi Pasar telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'pasar', 0, '2025-10-26 20:01:02', '2025-10-26 20:01:02'),
(333, 'Lokasi Pasar telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'pasar', 0, '2025-10-26 20:01:07', '2025-10-26 20:01:07'),
(334, 'Lokasi Pasar telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'pasar', 0, '2025-10-26 20:45:44', '2025-10-26 20:45:44'),
(335, 'Lokasi Pasar telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'pasar', 0, '2025-10-26 20:45:51', '2025-10-26 20:45:51'),
(336, 'Lokasi Pasar telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'pasar', 0, '2025-10-26 20:46:03', '2025-10-26 20:46:03'),
(337, 'Tempat ibadah telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-26 20:50:48', '2025-10-26 20:50:48'),
(338, 'Info keagamaan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-26 20:57:32', '2025-10-26 20:57:32'),
(339, 'Info keagamaan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-26 20:57:42', '2025-10-26 20:57:42'),
(340, 'Umkm telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'umkm', 0, '2025-10-28 20:02:39', '2025-10-28 20:02:39'),
(341, 'Ada Pengaduan baru yang ditambahkan', 'user', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-10-28 20:43:28', '2025-10-28 20:43:28'),
(342, 'Tempat ibadah telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-28 20:59:31', '2025-10-28 20:59:31'),
(343, 'Info keagamaan telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-28 21:04:50', '2025-10-28 21:04:50'),
(344, 'Info keagamaan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-28 21:05:28', '2025-10-28 21:05:28'),
(345, 'Lokasi Plesir telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-28 21:27:25', '2025-10-28 21:27:25'),
(346, 'Lokasi Plesir telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-28 21:32:09', '2025-10-28 21:32:09'),
(347, 'Lokasi Plesir telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-29 00:30:15', '2025-10-29 00:30:15'),
(348, 'Lokasi Plesir telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-29 00:36:53', '2025-10-29 00:36:53'),
(349, 'Lokasi Plesir telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-29 00:40:27', '2025-10-29 00:40:27'),
(350, 'Lokasi Plesir telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-29 00:40:45', '2025-10-29 00:40:45'),
(351, 'Info Plesir telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'plesir', 0, '2025-10-29 00:45:24', '2025-10-29 00:45:24'),
(352, 'Tempat ibadah telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-29 01:23:44', '2025-10-29 01:23:44'),
(353, 'Info keagamaan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-29 01:28:07', '2025-10-29 01:28:07'),
(354, 'Info Keagamaan telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'ibadah', 0, '2025-10-29 01:28:29', '2025-10-29 01:28:29'),
(355, 'Info Renbang telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-10-29 01:32:31', '2025-10-29 01:32:31'),
(356, 'Info Renbang telah dihapus', 'superadmin', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-10-29 01:32:43', '2025-10-29 01:32:43'),
(357, 'Ada Ajuan Renbang baru yang ditambahkan', 'user', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-10-29 01:39:08', '2025-10-29 01:39:08'),
(358, 'Puskesmas telah dihapus', 'admindinas', 2, NULL, NULL, NULL, 'puskesmas', 0, '2025-11-02 23:45:43', '2025-11-02 23:45:43'),
(359, 'Pengaduan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-11-03 19:17:16', '2025-11-03 19:17:16'),
(360, 'Pengaduan telah diupdate', 'superadmin', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-11-04 19:21:44', '2025-11-04 19:21:44'),
(361, 'Lokasi Kesehatan baru telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-11-05 20:55:06', '2025-11-05 20:55:06'),
(362, 'Lokasi Kesehatan baru telah ditambahkan', 'superadmin', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-11-05 21:02:01', '2025-11-05 21:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `judul`, `foto`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'CRM Operation Handling', 'banner/lQMbvvmpjC4SoqyffagwxF0vlBYIcgwLMIofQIKs.png', '<p>uwhuiwb213uihuqhfuihq3uuih</p>', '2025-09-22 20:58:51', '2025-09-28 19:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `no_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_toko` bigint NOT NULL,
  `id_produk` bigint NOT NULL,
  `jumlah` int NOT NULL,
  `harga` bigint NOT NULL,
  `subtotal` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `no_transaksi`, `id_toko`, `id_produk`, `jumlah`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(9, 'TRX690B01FF62EE1', 5, 3, 1, 200000, 200000, '2025-11-05 00:51:27', NULL),
(10, 'TRX690B05252ABDF', 5, 4, 1, 200000, 200000, '2025-11-05 01:04:53', NULL),
(11, 'TRX690B054A816C4', 5, 4, 1, 200000, 200000, '2025-11-05 01:05:30', NULL),
(12, 'TRX690B054A816C4', 5, 3, 2, 200000, 400000, '2025-11-05 01:05:30', NULL),
(13, 'TRX690B054A816C4', 1, 1, 1, 15000, 15000, '2025-11-05 01:05:30', NULL),
(14, 'TRX690B06686BA1C', 5, 4, 1, 200000, 200000, '2025-11-05 01:10:16', NULL),
(15, 'TRX690B06C7AE6BD', 5, 4, 2, 200000, 400000, '2025-11-05 01:11:51', NULL),
(16, 'TRX690B06C7AE6BD', 1, 2, 1, 15000, 15000, '2025-11-05 01:11:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int NOT NULL,
  `id_admin` int NOT NULL,
  `id_puskesmas` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `fitur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `masa_kerja` varchar(255) NOT NULL,
  `nomer` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `id_admin`, `id_puskesmas`, `nama`, `foto`, `pendidikan`, `fitur`, `masa_kerja`, `nomer`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Dr. Ayu', 'dokter_foto/TK6dQOYTa3vPH5qpTXRknqNMHVo692x3tNAISgbF.jpg', 'S1 ilmu kedokteran', 'umum', '24 Tahun', '087776736733', NULL, NULL),
(2, 0, 1, 'Dr.Reza', 'dokter_foto/dCOZH2GL5ho357jR7gFxWf539VxcuOZWIqmRBWGP.png', 'S1 ilmu kedokteran', 'umum', '5 bulan', '087776736733', NULL, NULL),
(3, 0, 2, 'Dr. Abdul', 'dokter_foto/JziYNEDX6oicURonsYfNI4KERRVMDQEe6vGaJeRo.jpg', 'S1 ilmu kedokteran', 'umum', '5 bulan', '4285792879827894', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dumas`
--

CREATE TABLE `dumas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kategori` int NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `jenis_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_laporan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_laporan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci DEFAULT 'menunggu',
  `tanggapan` text COLLATE utf8mb4_unicode_ci,
  `pernyataan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dumas`
--

INSERT INTO `dumas` (`id`, `id_kategori`, `user_id`, `jenis_laporan`, `lokasi_laporan`, `deskripsi`, `bukti_laporan`, `status`, `tanggapan`, `pernyataan`, `created_at`, `updated_at`) VALUES
(33, 1, 2, 'Kekurangan tenaga kesehatan', 'Rsud Indramayu', 'terdapat jalan berlubang cukup besar dan lumayan parah', 'bukti_laporan/enoA667bADzpUpugbYYqB9oe5ZlHkYXXs8gM9WmX.jpg', 'selesai', NULL, NULL, '2025-09-18 19:31:20', '2025-11-03 19:17:15'),
(48, 1, 3, 'pendidikan', 'Sindang,Indramayu', 'kekurangan guru teknik mesin', 'bukti_laporan/1G51WkHUqLzvXCY2pgpMvhh1hrQBEaslEerBSjRh.jpg', 'diproses', NULL, 'benar', '2025-10-28 20:43:28', '2025-11-04 19:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `dumas_ratings`
--

CREATE TABLE `dumas_ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `dumas_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE `infos` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_adminduk`
--

CREATE TABLE `info_adminduk` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_adminduk`
--

INSERT INTO `info_adminduk` (`id`, `judul`, `deskripsi`, `created_at`, `updated_at`, `foto`) VALUES
(1, 'Pelayanan Penerbitan Surat Keterangan Kelahiran seseorang', '<figure class=\"table\"><table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tbody><tr><td><strong>1</strong></td><td><strong>Produk Pelayanan</strong></td><td><strong>Pelayanan Penerbitan Surat Keterangan Kelahiran</strong></td></tr><tr><td><strong>2</strong></td><td><strong>Persyaratan Pelayanan</strong></td><td><ul><li>KK Asli</li><li>Fotocopy KTP-el</li><li>Surat Kelahiran Asli dari Rumah Sakit</li></ul></td></tr><tr><td><strong>3.</strong></td><td><strong>Sistem Mekanisme dan Prosedur</strong></td><td><ul><li>Pemohon datang di tempat pelayanan dengan membawa persyaratan;</li><li>Petugas memeriksa kelengkapan berkas</li><li>Sekretaris Dinas melakukan validasi berkas</li><li>Kasi membubuhkan paraf</li><li>Operator mengentri data pemohon dalam komputer dan mencetak surat keterangan lahir mati</li><li>Kepala Bidang Pelayanan Pendaftaran Penduduk membubuhkan paraf dalam pada surat keterangan lahir mati</li><li>Kepala Dinas menandatangani surat keterangan lahir Petugas menyerahkan surat keterangan lahir kepada pemohon.</li></ul></td></tr><tr><td><strong>4.</strong></td><td><strong>Jangka Waktu Penyelesaian</strong></td><td><ol><li>Pendaftaran : 5 – 15 Menit</li><li>Penyelesaian : 2 (dua) hari kerja</li><li>Pengambilan : 5 – 10 Menit</li></ol></td></tr><tr><td><strong>5.</strong></td><td><strong>Biaya / Tarif</strong></td><td><strong>Tidak Dipungut Biaya / GRATIS</strong></td></tr></tbody></table></figure>', '2025-09-03 00:18:10', '2025-10-13 23:45:17', 'foto_adminduk/BUrCqSdGuwxhmv6RIksclknV7CSVs88jDRtVBVUp.jpg'),
(4, 'Perpajakan makin naik dan salalu saja naik', '<p>dgrqydjjzkyfk</p>', '2025-10-13 23:38:09', '2025-10-13 23:38:09', 'foto_adminduk/1760423888_abdee slank.jpg'),
(5, 'Pelayanan Penerbitan Surat Keterangan Kelahiran seseorang', '<p>skkhddjkabfjdkafnjkeanfkjejkafnkafjkabnjka</p>', '2025-10-15 01:21:13', '2025-10-15 01:21:13', 'foto_adminduk/1760516473_slank1.png');

-- --------------------------------------------------------

--
-- Table structure for table `info_keagamaans`
--

CREATE TABLE `info_keagamaans` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_keagamaans`
--

INSERT INTO `info_keagamaans` (`id`, `judul`, `tanggal`, `waktu`, `deskripsi`, `lokasi`, `alamat`, `foto`, `created_at`, `updated_at`, `fitur`, `latitude`, `longitude`) VALUES
(4, 'Penyuluh Agama Teritorial Perkuat Program Indramayu Berzakat', '2025-08-08', '20:55:00', 'jlkgFLEKJblfjkbeLKJEBFJKA', 'Masjid agung indramayu', 'Masjid Agung Indramayu, Jalan S. Parman, Indramayu, West Java, Java, 45211, Indonesia', 'foto_ibadah/KBMIt4JLLjfDSKOT7Fc9R6jtaTUBM02MJnWXj6Bw.jpg', '2025-07-30 00:20:15', '2025-10-13 19:20:55', 'Pengajian', '-6.3271480', '108.3220630');

-- --------------------------------------------------------

--
-- Table structure for table `info_kerja`
--

CREATE TABLE `info_kerja` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_kerja`
--

INSERT INTO `info_kerja` (`id`, `name`, `judul`, `alamat`, `gaji`, `nomor_telepon`, `waktu_kerja`, `jenis_kerja`, `fitur`, `foto`, `deskripsi`, `created_at`, `updated_at`) VALUES
(2, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/4LYdmvgeFYNefm0zt73weua3wxAB1JXNHl68WXcR.png', '<p>lakvlkdkmvldksmlkv</p>', '2025-09-01 19:39:23', '2025-09-01 19:39:23'),
(3, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/ys5TbVsN6iHmYd0y7Dh2LPIViNirqPFQmxcqnBE6.png', '<p>jsknkgnslnlkrklksrlnkrskl\\</p><p>&nbsp;</p>', '2025-09-01 19:48:04', '2025-09-01 19:48:04'),
(4, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/mqlYY9df7tK8WC3A4VPYpLgMarfIA2SYQ4z0o0MI.png', '<p>wjkdkjfbekfnkwkldnwklndkwndkwdnwdnlwkd</p>', '2025-09-01 19:53:16', '2025-09-01 19:53:16'),
(5, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/Qxuu0yBtlaoKoBCRmWfS9yqZY23Z9HKQU59CWRoZ.png', '<p>dkslngklrknklnrsklnkrlnknlr</p>', '2025-09-01 19:57:56', '2025-09-01 19:57:56'),
(6, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/tF7todYt8muCQnXqtRk3hI7nHRZhxBT03GfEdhcM.png', '<p>jkbfejkabfejakejfbeakjbekjabfjkabfkjbkfja</p><figure class=\"image\"><img style=\"aspect-ratio:4726/4726;\" src=\"http://192.168.255.138:8000/storage/uploads/1756862883_RenbangYu.png\" width=\"4726\" height=\"4726\"></figure>', '2025-09-02 18:28:10', '2025-09-02 18:28:10'),
(7, 'Pt Pratama', 'bek tengah', 'Jalan Mt Haryono Indramayu', '300000', '087774775756', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/YLrE5SNvPaqcmHHVTpxSVU6LDTI6llO5TzZvPpfD.jpg', '<p>dalkfhsjkbhjfbhsjvbbshdjkvbshvbs</p>', '2025-10-15 00:42:58', '2025-10-15 00:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `info_kesehatan`
--

CREATE TABLE `info_kesehatan` (
  `id` bigint UNSIGNED NOT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_kesehatan`
--

INSERT INTO `info_kesehatan` (`id`, `fitur`, `foto`, `judul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(5, 'kesehatan', 'foto_kesehatan/O6Lm71giKBX7sgJTbQ4YgVLzmXisMAuGxtWwXbnX.png', 'Keseringan begadang bisa picu stroke ringan', 'alGKHAJLKBGLKJNAKFNQKNQFJK', '2025-08-21 18:59:21', '2025-08-21 18:59:50'),
(12, 'kesehatan', 'foto_kesehatan/DI9rjDHJ4tQLJjA2Grc0MJF8yd292cKX5aeIyhv6.jpg', 'snamnsam', '<p>mnsmansasnams\'</p><p>mansma</p><p>ansmans</p><p>mansmans</p><p><img src=\"http://192.168.255.154:8000/storage/uploads/1760343220_abdeeslank.jpg\" width=\"670\" height=\"670\"></p>', '2025-10-13 01:13:48', '2025-10-13 01:13:48'),
(13, 'kesehatan', 'foto_kesehatan/8G2ebgUaGkgPsU5hYTBPOAQYLBkDXHS96HM6nkic.jpg', 'CRM Operation Handling', '<p>hfdkdykskyhthsrrdhutjf</p>', '2025-10-13 18:33:40', '2025-10-13 18:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `info_pajak`
--

CREATE TABLE `info_pajak` (
  `id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_pajak`
--

INSERT INTO `info_pajak` (`id`, `foto`, `judul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'foto_pajak/8BjCAmUgBvBTjr1e8AVTrtMm1S1YHerXGSLsKw8Y.png', 'Penerimaan Pajak Ekonomi Digital Tembus Rp40,02 Triliun hingga Akhir Agustus 2025', '<p><a href=\"https://pajak.com/\"><strong>Pajak.com,</strong></a><strong> Jakarta</strong> – Pemerintahan melalui Direktorat Jenderal Pajak (DJP) Kementerian Keuangan (Kemenkeu) melaporkan penerimaan pajak dari sektor usaha ekonomi digital mencapai Rp40,02 triliun hingga 31 Juli 2025.</p><p>Angka tersebut mencakup pemungutan Pajak Pertambahan Nilai (PPN) Perdagangan Melalui Sistem Elektronik (PMSE) sebesar Rp31,06 triliun, pajak atas aset kripto Rp1,55 triliun, pajak <i>fintech</i> (<i>peer to peer lending</i>) Rp3,88 triliun, serta pajak yang dipungut pihak lain melalui Sistem Informasi Pengadaan Pemerintah (Pajak SIPP) Rp3,53 triliun.</p><p>Dari keseluruhan penerimaan, PPN PMSE menjadi penyumbang terbesar. Hingga Juli 2025, pemerintah telah menunjuk 223 perusahaan sebagai pemungut PPN PMSE.</p><p><a href=\"https://www.pajak.com/pajak/pengusaha-usul-insentif-pajak-diberikan-selektif-ke-sektor-dengan-kriteria-ini/\"><strong>Baca Juga&nbsp; Pengusaha Usul Insentif Pajak Diberikan Selektif ke Sektor dengan Kriteria Ini&nbsp;</strong></a></p><p>DJP mencatat terdapat tiga penunjukan baru, yakni Scalable Hosting Solutions OÜ, Express Technologies Limited, dan Finelo Limited. Di sisi lain, pemerintah juga mencabut penunjukan tiga pemungut PPN PMSE, yaitu Evernote GmbH, To The New Singapore Pte. Ltd., dan Epic Games Entertainment International GmbH.</p><p>Direktur Penyuluhan, Pelayanan, dan Hubungan Masyarakat DJP Rosmauli menjelaskan bahwa dari seluruh pemungut yang telah ditunjuk, sebanyak 201 PMSE telah melaksanakan pemungutan dan penyetoran PPN PMSE dengan total Rp31,06 triliun.</p><p>Setoran ini terus menunjukkan kenaikan dari tahun ke tahun. Rinciannya, sebesar Rp731,4 miliar pada 2020, Rp3,90 triliun pada 2021, Rp5,51 triliun pada 2022, Rp6,76 triliun pada 2023, Rp8,44 triliun pada 2024, dan Rp5,72 triliun hingga Juli 2025.</p><p><a href=\"https://www.pajak.com/pajak/bayar-pbb-p2-jakarta-kini-bisa-diangsur-ini-syarat-dan-ketentuannya/\"><strong>Baca Juga&nbsp; Bayar PBB-P2 Jakarta Kini Bisa Diangsur, Ini Syarat dan Ketentuannya</strong></a></p><p>Rosmauli menyampaikan bahwa penerimaan pajak dari sektor ekonomi digital terus bergerak positif. Menurutnya, kontribusi tersebut terlihat dari PPN PMSE, pajak kripto, pajak <i>fintech</i>, hingga pajak SIPP yang tidak hanya memperluas ruang fiskal negara, tetapi juga mendorong terciptanya <i>level playing field</i> antara pelaku usaha konvensional dan digital.</p><p>“Kontribusi pajak dari sektor ekonomi digital menunjukkan tren positif, baik dari PPN PMSE, pajak kripto, pajak <i>fintech</i>, maupun pajak SIPP, sehingga tidak hanya memperkuat ruang fiskal, tetapi juga menciptakan <i>level playing field</i> antara pelaku usaha konvensional dan digital,” ungkap Rosmauli dalam keterangan resminya, dikutip <i>Pajak.com</i> pada Kamis (28/8/25).</p><p>Ia menambahkan, penerapan pajak digital bukan merupakan instrumen baru, melainkan penyempurnaan mekanisme pemungutan agar lebih mudah diterapkan oleh pelaku usaha.</p><figure class=\"image\"><img style=\"aspect-ratio:4726/4726;\" src=\"http://192.168.255.138:8000/storage/foto_pajak/1756439218_PasarYu.png\" width=\"4726\" height=\"4726\"></figure><p>“Penerapan pajak digital ini bukanlah pajak baru, melainkan penyesuaian mekanisme pemungutan agar lebih praktis dan efisien bagi pelaku usaha,” pungkas Rosmauli.</p>', '2025-08-28 20:47:10', '2025-09-23 18:45:41'),
(3, 'foto_pajak/kIZkEXmNDFeQKX0wjfpHJHABCyZNaLYJmFKONpLi.jpg', 'Penyuluh Agama Teritorial Perkuat Program Indramayu Berzakat', '<p>ejkfjdkgsjghcbjdkjcdksjvbjdssvrs</p>', '2025-10-15 00:41:40', '2025-10-15 00:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `info_pasar`
--

CREATE TABLE `info_pasar` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_pasar`
--

INSERT INTO `info_pasar` (`id`, `nama`, `alamat`, `foto`, `fitur`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Pasar Penganjang 2', 'Penganjang, Indramayu, West Java, Java, 45222, Indonesia', 'foto_pasar/1755749063_IzinYu.png', 'Pasar', '-6.3233600', '108.3173780', '2025-08-20 21:04:23', '2025-08-20 21:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `info_perizinan`
--

CREATE TABLE `info_perizinan` (
  `id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_perizinan`
--

INSERT INTO `info_perizinan` (`id`, `foto`, `judul`, `deskripsi`, `fitur`, `created_at`, `updated_at`) VALUES
(1, 'foto_perizinan/xUZdgQbsUb7W5gfEVAQYO0dWLdEocnFcmxrRy0qG.jpg', 'Pelaku Usaha di Indramayu Diminta Taat Perizinan Termasuk PBG dan IMB', '<p>Indramayu, InfoPublik - Jajaran Satuan Polisi Pamong Praja (Satpol-PP) Kabupaten Indramayu baru-baru ini telah membuka segel yang terpasang di Hopespace Coffee &amp; Eatery Indramayu setelah pemilik memenuhi persyaratan atau izin usahanya dengan lengkap.</p><p>Seperti dikatakan Kepala Satpol-PP Kabupaten Indramayu Teguh Budiarso, pihaknya melalui Tim Penegakan Peraturan Daerah (Gakda) akan bertindak tegas bilamana terdapat tempat usaha yang masih belum melengkapi izin usaha yang ditetapkan pemerintah daerah.</p><p>Teguh menambahkan, sebagaimana keinginan Bupati Indramayu Nina Agustina Da’i Bachtiar yang membuka lebar-lebar investasi di Kabupaten Indramayu dengan memperhatikan dan mematuhi segala peraturan daerah sebagai legalitas bagi pelaku usaha.</p><p>“Kebijakan Bupati saat ini adalah membuka seluas luasnya investasi di Kabupaten Indramayu, termasuk didalamnya mengajak para pelaku usaha untuk turut meramaikan dunia kuliner, kafe dan lain-lain. Namun tentunya dengan tetap mentaati regulasi perizinan,\" katanya kepada Diskominfo Indramayu, Rabu (20/7/2022).</p><p>Dijelaskan Kasatpol-PP Kabupaten Indramayu Teguh Budiarso, persyaratan atau izin yang harus diperhatikan pelaku usaha adalah terdaftar dalam Online Single Submission (OSS) atau sistem perizinan berusaha terintegrasi secara elektronik, Nomor Induk Berusaha (NIB) dan lainnya.</p><p>\"Tidak hanya OSS atau NIB tetapi juga kelengkapan perizinan lainnya termasuk Persetujuan Bangunan Gedung (PBG) dan Izin Mendirikan Bangunan (IMB). Pelayanan perizinan di Kabupaten Indramayu Insyallah mudah dan cepat,\" jelasnya. (M/MTQ--Tim Publikasi Diskominfo Indramayu)</p>', 'usaha', '2025-09-02 01:47:36', '2025-09-30 05:11:15'),
(2, 'foto_perizinan/UqvC6Fnr5x59arxeg4MZMXxiF1EaAenuczoGRGOh.jpg', 'Pelayanan Penerbitan Surat Keterangan Kelahiran seseorang', '<p>hgsgfshsjhgjuihjhfhjjhk</p>', 'usaha', '2025-10-13 23:55:50', '2025-10-13 23:55:50'),
(3, 'foto_perizinan/puEEb6ZrOmKfj99OlzsSsMSVlgzXSLCKGX51ikWt.jpg', 'snamnsam', '<p>dkhjkbfkdlanjkbdnkjfabfkja</p>', 'usaha', '2025-10-15 01:24:41', '2025-10-15 01:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `info_plesir`
--

CREATE TABLE `info_plesir` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_plesir`
--

INSERT INTO `info_plesir` (`id`, `judul`, `alamat`, `rating`, `deskripsi`, `foto`, `fitur`, `created_at`, `updated_at`, `latitude`, `longitude`) VALUES
(16, 'Pantai Karangsong', 'M9V9+476, Blok Jl. Wanasari, Karangsong, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat', '0.00', '<p>Pantai Karangsong menawarkan keindahan pantai dengan tanaman mangrove yang lebat. Pantai ini memiliki pasir yang hitam, namun begitu halus dan nyaman. Tidak terhalang juga oleh batuan karang sehingga wisatawan dapat memandang lautan lepas. Air laut meskipun tak tampak biru, namun begitu jernih.</p><p>Ombak lautan pun tidak terlalu tinggi, sehingga banyak wisatawan yang bermain di air laut. Ada yang berenang di tepian pantai, ada juga yang membawa pelampung untuk bermain. Tidak hanya itu, ada juga yang membawa perahu karet untuk bermain di tepian pantai. Perahu-perahu pun siap untuk disewa untuk menjelajah wilayah perairan.</p><p>Wilayah pasirnya begitu luas, dan tentunya terjaga kebersihannya. Di bagian belakang tepi pantai, terdapat pepohonan selain pohon mangrove. Sehingga pantai tampak begitu teduh dengan pepohonan tersebut. Wisatawan pun tampak nyaman menikmati waktu di pantai.</p>', 'foto_plesir/1759230351_karangong.jpg', 'wisata', '2025-09-30 04:05:51', '2025-09-30 04:05:51', '-6.3056211', '108.3686042'),
(17, 'Pelayanan Penerbitan Surat Keterangan Kelahiran seseorang', 'Babadan, Indramayu, West Java, Java, 45211, Indonesia', '0.00', '<p>Dewa19 adalah band&nbsp;</p>', 'foto_plesir/1760516309_dewa19.jpeg', 'wisata', '2025-10-15 01:18:33', '2025-10-29 00:45:23', '-6.3112410', '108.3253700');

-- --------------------------------------------------------

--
-- Table structure for table `info_sekolah`
--

CREATE TABLE `info_sekolah` (
  `id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_sekolah`
--

INSERT INTO `info_sekolah` (`id`, `foto`, `judul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(6, 'foto_sekolah/s4lp3QSaZb6nDKusxKxlxO3VR1hzz7QoblvugXpq.png', 'Keseringan begadang bisa picu stroke', '<p>s,MFCKDJnkwfjkbwfkjnkjfw kjf kw fwnjfknwkj</p><figure class=\"image\"><img style=\"aspect-ratio:225/225;\" src=\"http://192.168.255.154:8000/storage/foto_sekolah/1760412202_logoslank.jpg\" width=\"225\" height=\"225\"></figure><p>akfbjkabjkeabjkbfjkaebfjkaf</p>', '2025-08-27 21:15:16', '2025-10-13 20:23:25'),
(9, 'foto_sekolah/smjdEmdgTu3STK3huDvdDngRDVUgVn21e1QAV00E.png', 'Pengajian rock n dut', '<figure class=\"table\"><table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tbody><tr><td>jkbkjbkscs</td><td>skcbajcaac</td><td>csjkcjks</td></tr><tr><td>kjscbjs</td><td>c sjkcbsjs</td><td>cjksbcjk</td></tr><tr><td>scbkssc</td><td>c,ms,cm s</td><td>sjcbkjsb</td></tr></tbody></table></figure>', '2025-09-02 20:13:23', '2025-09-03 01:51:19'),
(10, 'foto_sekolah/HdTUToFUHJDUHhIVCdE4OcFDI0GlRA7b0tdphGU9.jpg', 'Perpajakan makin naik dan salalu saja naik', '<p>sJFKEKLAFBEILFKkkflnvkfnvlf</p>', '2025-10-15 00:36:32', '2025-10-15 00:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `nama`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'komunikasi dan informatika', 'dinas', NULL, NULL),
(2, 'kesehatan', 'dinas', NULL, NULL),
(3, 'pendidikan', 'dinas', NULL, NULL),
(6, 'pajak', 'dinas', NULL, NULL),
(7, 'perdagangan', 'dinas', NULL, NULL),
(8, 'kerja', 'dinas', NULL, NULL),
(9, 'pariwisata', 'dinas', NULL, NULL),
(10, 'keagamaan', 'dinas', NULL, NULL),
(11, 'adminduk', 'dinas', NULL, NULL),
(12, 'renbang', 'dinas', NULL, NULL),
(13, 'perizinan', 'dinas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"9e79602f-ad71-421c-ad16-1de6902a751b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759477023,\"delay\":null}', 0, NULL, 1759477023, 1759477023),
(2, 'default', '{\"uuid\":\"8834c0de-733e-48a1-a88a-b60d0f41260c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1759587128,\"delay\":null}', 0, NULL, 1759587129, 1759587129);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `fitur`, `nama`, `created_at`, `updated_at`) VALUES
(20, 'Info kerja', 'Lowongan', '2025-09-08 18:58:01', '2025-09-08 18:58:01'),
(24, 'Info plesir', 'kuliner', '2025-09-08 19:19:07', '2025-09-08 19:19:07'),
(26, 'lokasi pasar', 'pasar', '2025-09-08 19:53:36', '2025-09-08 19:53:36'),
(27, 'lokasi ibadah', 'islam', '2025-09-08 20:16:13', '2025-09-08 20:16:13'),
(28, 'lokasi plesir', 'wisata', '2025-09-08 20:17:18', '2025-09-08 20:17:18'),
(29, 'lokasi sekolah', 'sekolah dasar', '2025-09-08 20:18:10', '2025-09-08 20:18:10'),
(30, 'lokasi kesehatan', 'rumah sakit', '2025-09-08 20:18:59', '2025-09-08 20:18:59'),
(31, 'info kesehatan', 'kesehatan', '2025-09-08 20:20:09', '2025-09-08 20:20:09'),
(34, 'info kesehatan', 'pencegahan', '2025-09-15 19:11:56', '2025-09-15 19:11:56'),
(35, 'Info plesir', 'wisata', '2025-09-30 04:03:38', '2025-09-30 04:03:38'),
(36, 'event agama', 'Pengajian', '2025-09-30 04:36:21', '2025-09-30 04:36:21'),
(37, 'Info renbang', 'infrastruktur', '2025-09-30 05:00:08', '2025-09-30 05:00:08'),
(38, 'Info perizinan', 'usaha', '2025-09-30 05:07:58', '2025-09-30 05:07:58'),
(39, 'lokasi olahraga', 'serbaguna', '2025-10-01 20:22:50', '2025-10-01 20:22:50'),
(41, 'Lokasi ibadah', 'kristen', '2025-10-12 23:56:22', '2025-10-12 23:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_dumas`
--

CREATE TABLE `kategori_dumas` (
  `id` int NOT NULL,
  `id_instansi` int NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_dumas`
--

INSERT INTO `kategori_dumas` (`id`, `id_instansi`, `nama_kategori`) VALUES
(1, 2, 'Kesehatan'),
(2, 2, 'kebersihan'),
(3, 3, 'Sekolah dasar'),
(4, 3, 'Sekolah Menengah Pertama');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int NOT NULL,
  `id_toko` int NOT NULL,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `variasi` varchar(255) DEFAULT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `id_toko`, `id_user`, `id_produk`, `variasi`, `harga`, `stok`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 4, NULL, 10000, 10, 1, 10000, '2025-10-26 20:25:32', NULL),
(4, 1, 2, 4, NULL, 10000, 10, 1, 10000, '2025-11-04 23:49:23', NULL),
(5, 5, 2, 5, NULL, 100000, 10, 1, 100000, '2025-11-04 23:50:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `dokter_id` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `admin_id`, `dokter_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 1, 'Halo dok, saya mau konsultasi', 0, '2025-10-03 00:37:00', '2025-10-03 00:37:00'),
(3, 2, NULL, 1, 'Halo dok, saya ingin konsultasi tentang demam.', 0, '2025-10-04 07:12:01', '2025-10-04 07:12:01'),
(6, 2, NULL, 1, 'jadi saya demam udah 2 hari', 0, '2025-10-04 07:55:46', '2025-10-04 07:55:46'),
(8, 2, NULL, 2, 'permisi dok mau nanya', 0, '2025-10-06 19:24:31', '2025-10-06 19:24:31'),
(9, 2, NULL, 1, 'permisi dok mau nanya', 0, '2025-10-06 19:27:36', '2025-10-06 19:27:36'),
(10, 3, NULL, 1, 'yasudah minum paracetamol dulu saja', 0, '2025-10-06 20:10:15', '2025-10-06 20:10:15');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` bigint NOT NULL,
  `id_toko` int NOT NULL,
  `nama_metode` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) DEFAULT NULL,
  `nomor_tujuan` varchar(255) DEFAULT NULL,
  `foto_qris` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `id_toko`, `nama_metode`, `jenis`, `nama_penerima`, `nomor_tujuan`, `foto_qris`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 7, 'Transfer BCA', 'bank', 'UMKM Reang', '1234567890', NULL, 'Rekening utama toko', '2025-11-07 00:49:46', '2025-11-07 00:49:46'),
(2, 7, 'Transfer BCA', 'bank', 'UMKM Reang', '1234567890', 'qris/oMROxZt5rn6Zj9RlAkIZz0O1IF2K2N4H1znkM7mk.jpg', 'Rekening utama toko', '2025-11-07 00:57:11', '2025-11-07 00:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_02_013528_create_personal_access_tokens_table', 1),
(5, '2025_07_02_020629_add_phone_and_noktp_to_users_table', 2),
(6, '2025_07_02_034048_add_role_to_users_table', 3),
(7, '2025_07_02_061541_create_admins_table', 4),
(8, '2025_07_03_064804_create_locations_table', 5),
(9, '2025_07_04_015644_create_tempat_ibadah_table', 6),
(10, '2025_07_04_074413_create_sehats_table', 7),
(11, '2025_07_04_082812_create_pasars_table', 8),
(12, '2025_07_04_233903_create_plesirs_table', 9),
(13, '2025_07_05_010341_create_aktivitas_table', 10),
(14, '2025_07_07_040325_create_pengaduans_table', 11),
(15, '2025_07_07_081225_create_pengaduans_table', 12),
(16, '2025_07_08_022321_add_dibaca_to_aktivitas_table', 13),
(17, '2025_07_08_025048_add_url_to_aktivitas_table', 14),
(18, '2025_07_08_063312_add_item_id_to_aktivitas_table', 15),
(19, '2025_07_09_031318_create_notifikasi_aktivitas_table', 15),
(20, '2025_07_09_033606_add_url_to_notifikasi_aktivitas_table', 16),
(21, '2025_07_10_013238_remove_pernyataan_from_pengaduans_table', 17),
(22, '2025_07_10_014352_rename_pengaduans_to_dumas_table', 17),
(23, '2025_07_11_033648_remove_pernyataan_from_dumas_table', 18),
(24, '2025_07_11_071332_create_sekolahs_table', 19),
(25, '2025_07_13_071241_create_infos_table', 20),
(26, '2025_07_16_074111_create_sliders_table', 21),
(27, '2025_07_17_024057_update_status_enum_on_dumas_table', 22),
(28, '2025_07_17_032015_create_renbangs_table', 23),
(29, '2025_07_21_020233_create_wisata_table', 24),
(30, '2025_07_24_015455_add_kategori_to_tempat_ibadah_table', 24),
(31, '2025_07_24_021641_create_kategori_table', 24),
(32, '2025_07_24_033240_create_kategori_table', 25),
(33, '2025_07_24_040351_create_kategori_table', 26),
(34, '2025_07_24_043638_add_fitur_to_tempat_ibadah_table', 27),
(35, '2025_07_28_024634_add_kategori_id_to_tempat_ibadah_table', 28),
(36, '2025_07_28_025737_remove_kategori_id_from_tempat_ibadah_table', 29),
(37, '2025_07_30_042311_create_info_keagamaans_table', 30),
(38, '2025_07_30_064018_add_fitur_to_info_keagamaans_table', 31),
(39, '2025_07_31_023223_add_foto_to_tempat_ibadah_table', 32),
(40, '2025_07_31_030148_add_foto_to_tempat_ibadah_table', 33),
(41, '2025_08_01_074137_add_foto_to_tempat_ibadah_table', 34),
(42, '2025_08_06_020540_rename_plesirs_to_tempat_plesirs_table', 35),
(43, '2025_08_06_020754_add_foto_to_tempat_plesirs_table', 36),
(44, '2025_08_08_012250_add_fitur_to_tempat_plesirs_table', 37),
(45, '2025_08_08_031525_create_info_plesir_table', 38),
(46, '2025_08_08_073351_rename_pasars_to_tempat_pasars_table', 39),
(47, '2025_08_08_073613_add_fitur_to_tempat_pasars_table', 40),
(48, '2025_08_08_091221_add_foto_to_tempat_pasars_table', 41),
(49, '2025_08_11_010455_rename_sehats_to_tempat_sehats_table', 42),
(50, '2025_08_11_010624_add_fitur_to_tempat_sehats_table', 42),
(51, '2025_08_11_010803_add_foto_to_tempat_sehats_table', 42),
(52, '2025_08_11_014128_add_lat_long_to_info_plesir_table', 43),
(53, '2025_08_12_015430_add_lat_long_to_info_keagamaans_table', 44),
(54, '2025_08_12_041104_create_tempat_sekolah_table', 45),
(55, '2025_08_21_013919_create_info_pasar_table', 46),
(56, '2025_08_21_073538_create_info_kesehatan_table', 47),
(57, '2025_08_21_080955_add_fitur_to_info_kesehatan_table', 48),
(58, '2025_08_22_025324_create_ratings_table', 49),
(59, '2025_08_27_014618_create_tempat_olahraga_table', 50),
(60, '2025_08_27_020536_add_address_to_tempat_olahraga_table', 51),
(61, '2025_08_27_040813_add_foto_to_tempat_olahraga_table', 52),
(62, '2025_08_27_064059_create_info_sekolah_table', 53),
(63, '2025_08_29_030811_create_info_pajak_table', 54),
(64, '2025_09_01_063833_add_name_to_info_kerja_table', 55),
(65, '2025_09_02_021422_create_info_kerja_table', 56),
(66, '2025_09_02_023800_change_gaji_column_type_in_info_kerja_table', 57),
(67, '2025_09_02_075444_create_info_perizinan_table', 58),
(68, '2025_09_03_063827_create_info_adminduk_table', 59),
(69, '2025_09_09_034555_add_foto_to_info_adminduk_table', 60),
(70, '2025_09_11_063909_add_alamat_to_renbangs_deskripsi_table', 61),
(71, '2025_09_11_065606_rename_isi_to_deskripsi_in_renbangs_deskripsi_table', 62),
(72, '2025_09_11_070450_rename_kategori_to_fitur_in_renbangs_deskripsi_table', 63),
(73, '2025_09_12_035911_add_role_to_admins_table', 64),
(74, '2025_09_14_124628_add_dinas_to_admins_table', 65),
(75, '2025_09_16_013935_add_comment_to_ratings_table', 66),
(76, '2025_09_19_023048_add_dinas_to_dumas_table', 67),
(77, '2025_09_19_032501_create_dumas_ratings_table', 68),
(78, '2025_09_19_034105_add_comment_to_dumas_ratings_table', 69),
(79, '2025_09_22_020703_add_role_dinas_to_notifikasi_aktivitas_table', 70),
(80, '2025_09_22_021905_add_role_dinas_to_aktivitas_table', 71),
(81, '2025_09_22_040027_add_pernyataan_to_dumas_table', 72),
(82, '2025_09_23_024720_create_banners_table', 73),
(83, '2025_09_23_064843_add_user_id_to_dumas_table', 74);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_aktivitas`
--

CREATE TABLE `notifikasi_aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_instansi` int DEFAULT NULL,
  `id_puskesmas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi_aktivitas`
--

INSERT INTO `notifikasi_aktivitas` (`id`, `keterangan`, `dibaca`, `created_at`, `updated_at`, `url`, `role`, `id_instansi`, `id_puskesmas`) VALUES
(1, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:26:26', '2025-07-08 20:32:57', NULL, NULL, 0, NULL),
(2, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:07', '2025-07-08 20:32:52', NULL, NULL, 0, NULL),
(3, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:10', '2025-07-08 20:32:42', NULL, NULL, 0, NULL),
(4, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:14', '2025-07-08 20:32:49', NULL, NULL, 0, NULL),
(5, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:17', '2025-07-08 20:32:28', NULL, NULL, 0, NULL),
(6, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:21', '2025-07-08 20:32:37', NULL, NULL, 0, NULL),
(7, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:28:12', '2025-07-08 20:32:19', NULL, NULL, 0, NULL),
(8, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:33:11', '2025-07-08 20:37:51', NULL, NULL, 0, NULL),
(9, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:33:32', '2025-07-08 20:33:39', NULL, NULL, 0, NULL),
(10, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:39:20', '2025-07-08 20:39:25', NULL, NULL, 0, NULL),
(11, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:39:44', '2025-07-08 20:39:51', NULL, NULL, 0, NULL),
(12, 'Ibadah baru telah dihapus.', 1, '2025-07-08 20:46:22', '2025-07-08 20:46:29', NULL, NULL, 0, NULL),
(13, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 20:57:38', '2025-07-08 23:45:10', NULL, NULL, 0, NULL),
(14, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 21:00:35', '2025-07-08 21:03:27', NULL, NULL, 0, NULL),
(15, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 21:02:54', '2025-07-08 21:03:19', NULL, NULL, 0, NULL),
(16, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:46', '2025-07-08 23:44:59', NULL, NULL, 0, NULL),
(17, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:51', '2025-07-08 23:44:41', NULL, NULL, 0, NULL),
(18, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:57', '2025-07-08 21:14:50', NULL, NULL, 0, NULL),
(19, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:04:02', '2025-07-08 21:06:21', NULL, NULL, 0, NULL),
(20, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:04:06', '2025-07-08 21:06:15', NULL, NULL, 0, NULL),
(21, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 23:58:03', '2025-07-08 23:58:14', NULL, NULL, 0, NULL),
(22, 'Ibadah baru telah dihapus.', 1, '2025-07-08 23:59:08', '2025-07-08 23:59:19', NULL, NULL, 0, NULL),
(23, 'Ibadah baru telah ditambahkan.', 1, '2025-07-09 00:36:05', '2025-07-09 00:36:13', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(24, 'Pasar baru telah ditambahkan.', 1, '2025-07-09 00:43:41', '2025-07-09 00:43:49', 'http://127.0.0.1:8000/admin/pasar', NULL, 0, NULL),
(25, 'Rumah Sakit baru telah ditambahkan.', 1, '2025-07-09 00:54:05', '2025-07-09 00:54:13', 'http://127.0.0.1:8000/admin/sehat', 'admindinas', 2, NULL),
(26, 'Ibadah baru telah diubah.', 1, '2025-07-09 01:06:02', '2025-07-09 19:44:24', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(27, 'Pengaduan Masyarakat baru telah dihapus.', 1, '2025-07-09 01:06:23', '2025-07-09 19:44:15', 'http://127.0.0.1:8000/admin/pengaduan', NULL, 0, NULL),
(28, 'Ibadah baru telah dihapus.', 1, '2025-07-09 19:45:28', '2025-07-10 01:44:49', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(29, 'Pasar baru telah dihapus.', 1, '2025-07-09 19:45:47', '2025-07-10 01:44:53', 'http://127.0.0.1:8000/admin/pasar', NULL, 0, NULL),
(30, 'Pasar baru telah dihapus.', 1, '2025-07-09 19:45:53', '2025-07-10 01:44:46', 'http://127.0.0.1:8000/admin/pasar', NULL, 0, NULL),
(31, 'Rumah Sakit baru telah dihapus.', 1, '2025-07-09 19:46:04', '2025-07-10 01:44:40', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(32, 'Rumah Sakit baru telah dihapus.', 1, '2025-07-09 19:46:09', '2025-07-10 01:19:34', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(33, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:27:57', '2025-07-10 19:29:37', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(34, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:28:32', '2025-07-10 19:28:45', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(35, 'Sehat baru telah dihapus.', 1, '2025-07-10 19:30:06', '2025-07-10 20:08:24', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(36, 'Sehat baru telah dihapus.', 1, '2025-07-10 19:30:13', '2025-07-10 19:56:13', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(37, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:36:53', '2025-07-10 19:53:41', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(38, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:51:22', '2025-07-10 19:53:31', 'http://127.0.0.1:8000/admin/sehat', NULL, 0, NULL),
(39, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:01:08', '2025-07-10 20:08:22', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(40, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:03:54', '2025-07-10 20:08:02', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(41, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:06:30', '2025-07-10 20:08:19', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(42, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:06:36', '2025-07-10 20:08:17', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(43, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:07:48', '2025-07-10 20:07:54', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(44, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 20:16:05', '2025-07-10 20:16:11', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(45, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:16:15', '2025-07-11 02:03:35', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, 0, NULL),
(46, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:14:00', '2025-07-15 19:20:33', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, 0, NULL),
(47, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:15:08', '2025-07-15 19:06:38', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, 0, NULL),
(48, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:25:03', '2025-07-15 18:58:39', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, 0, NULL),
(49, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:44:25', '2025-07-15 18:10:52', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, 0, NULL),
(50, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 19:27:32', '2025-07-15 19:28:50', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(51, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 19:27:49', '2025-07-15 19:28:40', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(52, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 19:28:15', '2025-07-15 19:28:33', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(53, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 19:28:56', '2025-07-15 19:31:15', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(54, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 23:17:39', '2025-07-15 23:35:11', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(55, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 23:29:09', '2025-07-15 23:32:08', 'http://127.0.0.1:8000/admin/sekolah', NULL, 0, NULL),
(56, 'Renbang baru telah ditambahkan.', 1, '2025-07-17 18:55:56', '2025-07-23 01:34:55', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, 0, NULL),
(57, 'Renbang baru telah ditambahkan.', 1, '2025-07-17 19:07:49', '2025-07-20 18:34:16', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, 0, NULL),
(58, 'Renbang telah diubah.', 1, '2025-07-17 19:14:35', '2025-07-18 00:48:18', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, 0, NULL),
(59, 'Renbang telah diubah.', 1, '2025-07-17 19:14:55', '2025-07-17 21:07:33', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, 0, NULL),
(60, 'Renbang telah dihapus.', 1, '2025-07-20 18:37:16', '2025-07-20 21:29:09', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, 0, NULL),
(61, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:23:47', '2025-07-29 19:01:01', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(62, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:49:50', '2025-07-30 00:29:48', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(63, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:51:00', '2025-07-30 01:00:37', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(64, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 23:28:53', '2025-07-23 23:35:25', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(65, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 23:35:52', '2025-08-12 01:59:45', 'http://127.0.0.1:8000/admin/ibadah', NULL, 0, NULL),
(66, 'Ibadah telah dihapus.', 1, '2025-07-24 01:24:58', '2025-08-18 21:03:28', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(67, 'Ibadah telah dihapus.', 1, '2025-07-24 01:25:04', '2025-08-18 21:05:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(68, 'Ibadah telah dihapus.', 1, '2025-07-24 01:36:19', '2025-08-18 21:06:05', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(69, 'Ibadah telah dihapus.', 1, '2025-07-24 01:36:26', '2025-07-27 20:39:41', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(70, 'Ibadah telah dihapus.', 1, '2025-07-27 20:41:45', '2025-07-28 21:29:33', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(71, 'Ibadah telah dihapus.', 1, '2025-07-27 20:41:52', '2025-07-28 04:01:37', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(72, 'Ibadah telah dihapus.', 1, '2025-07-28 00:23:01', '2025-07-28 04:01:25', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(73, 'Ibadah telah dihapus.', 1, '2025-07-30 21:34:41', '2025-08-18 21:06:10', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(74, 'Ibadah telah dihapus.', 1, '2025-07-30 21:36:13', '2025-08-18 21:06:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(75, 'Ibadah telah dihapus.', 1, '2025-08-01 01:06:04', '2025-08-18 21:06:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(76, 'Ibadah telah dihapus.', 1, '2025-08-01 01:09:16', '2025-08-18 21:06:20', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(77, 'Plesir telah dihapus.', 1, '2025-08-07 18:25:35', '2025-08-18 21:05:50', 'http://127.0.0.1:8000/admin/admin/plesir/tempat', NULL, 0, NULL),
(78, 'Ibadah telah dihapus.', 1, '2025-08-18 21:06:31', '2025-08-18 21:06:37', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(79, 'Ibadah baru telah ditambahkan.', 0, '2025-08-19 00:23:35', '2025-08-19 00:23:35', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(80, 'Tempat Ibadah telah ditambahkan.', 1, '2025-08-19 00:37:50', '2025-08-19 18:46:07', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(81, 'Tempat Ibadah diperbarui: Gereja Santo Babadan 1', 0, '2025-08-19 18:57:25', '2025-08-19 18:57:25', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(82, 'Ibadah telah dihapus.', 0, '2025-08-19 18:59:47', '2025-08-19 18:59:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(83, 'Tempat ibadah telah dihapus.', 0, '2025-08-19 19:01:24', '2025-08-19 19:01:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(84, 'Info keagamaan telah ditambahkan.', 0, '2025-08-19 19:09:38', '2025-08-19 19:09:38', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(85, 'Info keagamaan telah diperbarui', 0, '2025-08-19 19:12:08', '2025-08-19 19:12:08', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(86, 'Info keagamaan telah dihapus', 0, '2025-08-19 19:13:49', '2025-08-19 19:13:49', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(87, 'Tempat Ibadah telah ditambahkan.', 0, '2025-08-19 19:38:46', '2025-08-19 19:38:46', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(88, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 19:42:47', '2025-08-19 19:42:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(89, 'Pasar telah dihapus.', 0, '2025-08-19 20:05:55', '2025-08-19 20:05:55', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(90, 'Pasar telah dihapus.', 0, '2025-08-19 20:07:16', '2025-08-19 20:07:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(91, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:08:21', '2025-08-19 20:08:21', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(92, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:13:29', '2025-08-19 20:13:29', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(93, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:15:19', '2025-08-19 20:15:19', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(94, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:22:50', '2025-08-19 20:22:50', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(95, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:23:44', '2025-08-19 20:23:44', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(96, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:27:20', '2025-08-19 20:27:20', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(97, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:27', '2025-08-19 20:27:27', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(98, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:31', '2025-08-19 20:27:31', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(99, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:42', '2025-08-19 20:27:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(100, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:31:00', '2025-08-19 20:31:00', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(101, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:31:33', '2025-08-19 20:31:33', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(102, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:58:42', '2025-08-19 20:58:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(103, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 21:09:46', '2025-08-19 21:09:46', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(104, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 21:09:59', '2025-08-19 21:09:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(105, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 21:12:16', '2025-08-19 21:12:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(106, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 21:12:31', '2025-08-19 21:12:31', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(107, 'Lokasi Pasar telah diupdate', 0, '2025-08-19 21:27:43', '2025-08-19 21:27:43', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(108, 'Lokasi Plesir telah ditambahkan', 0, '2025-08-19 21:35:45', '2025-08-19 21:35:45', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(109, 'Lokasi Plesir telah diupdate', 0, '2025-08-19 21:36:22', '2025-08-19 21:36:22', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(110, 'Tempat Plesir telah dihapus.', 0, '2025-08-19 21:36:35', '2025-08-19 21:36:35', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(111, 'Info Pasar telah ditambahkan', 0, '2025-08-19 21:41:04', '2025-08-19 21:41:04', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(112, 'Info Plesir telah diupdate', 0, '2025-08-19 21:42:13', '2025-08-19 21:42:13', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(113, 'Info Plesir telah dihapus', 0, '2025-08-19 21:42:28', '2025-08-19 21:42:28', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(114, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-19 21:47:45', '2025-08-19 21:47:45', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(115, 'Lokasi Kesehatan telah diupdate', 0, '2025-08-19 21:49:10', '2025-08-19 21:49:10', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(116, 'Lokasi Kesehatan telah dihapus.', 0, '2025-08-19 21:49:23', '2025-08-19 21:49:23', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(117, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-19 21:52:38', '2025-08-19 21:52:38', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(118, 'Lokasi Kesehatan telah dihapus.', 0, '2025-08-19 21:52:42', '2025-08-19 21:52:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(119, 'Lokasi Sekolah telah ditambahkan', 0, '2025-08-19 22:03:27', '2025-08-19 22:03:27', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(120, 'Lokasi Sekolah telah diupdate', 0, '2025-08-19 22:04:02', '2025-08-19 22:04:02', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(121, 'Lokasi Sekolah telah dihapus', 0, '2025-08-19 22:04:11', '2025-08-19 22:04:11', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(122, 'Info Pasar telah ditambahkan', 0, '2025-08-20 21:04:24', '2025-08-20 21:04:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(123, 'Info Pasar telah diupdate', 0, '2025-08-20 21:12:59', '2025-08-20 21:12:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(124, 'Info Pasar telah diupdate', 0, '2025-08-20 21:15:39', '2025-08-20 21:15:39', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(125, 'Info Kesehatan telah ditambahkan', 0, '2025-08-21 18:59:21', '2025-08-21 18:59:21', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(126, 'Info Kesehatan telah diupdate', 0, '2025-08-21 18:59:50', '2025-08-21 18:59:50', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(127, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-21 19:00:29', '2025-08-21 19:00:29', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(128, 'Info Kesehatan telah diupdate', 0, '2025-08-21 19:03:06', '2025-08-21 19:03:06', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(129, 'Info Plesir telah ditambahkan', 0, '2025-08-21 19:05:47', '2025-08-21 19:05:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, 0, NULL),
(130, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-22 00:27:55', '2025-08-22 00:27:55', 'http://192.168.254.30:8000/admin/sehat/tempat', NULL, 0, NULL),
(131, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:23:52', '2025-08-25 00:23:52', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, 0, NULL),
(132, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:35:13', '2025-08-25 00:35:13', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, 0, NULL),
(133, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:41:48', '2025-08-25 00:41:48', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, 0, NULL),
(134, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:56:06', '2025-08-25 00:56:06', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, 0, NULL),
(135, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 20:06:59', '2025-08-26 20:06:59', 'http://127.0.0.1:8000/admin/sehat/tempat', NULL, 0, NULL),
(136, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 21:03:16', '2025-08-26 21:03:16', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(137, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 21:41:48', '2025-08-26 21:41:48', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(138, 'Tempat olahraga telah dihapus', 0, '2025-08-26 21:42:00', '2025-08-26 21:42:00', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(139, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 21:51:27', '2025-08-26 21:51:27', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(140, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 21:55:15', '2025-08-26 21:55:15', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(141, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 21:55:29', '2025-08-26 21:55:29', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(142, 'Tempat olahraga telah dihapus', 0, '2025-08-26 21:55:40', '2025-08-26 21:55:40', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(143, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 23:21:20', '2025-08-26 23:21:20', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(144, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 23:21:40', '2025-08-26 23:21:40', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(145, 'Tempat olahraga telah dihapus', 0, '2025-08-26 23:21:49', '2025-08-26 23:21:49', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(146, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 23:30:01', '2025-08-26 23:30:01', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(147, 'Info Kesehatan telah diupdate', 0, '2025-08-26 23:35:05', '2025-08-26 23:35:05', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(148, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 23:36:24', '2025-08-26 23:36:24', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(149, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:21:27', '2025-08-27 00:21:27', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(150, 'Info Kesehatan telah ditambahkan', 0, '2025-08-27 00:38:47', '2025-08-27 00:38:47', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(151, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:47:19', '2025-08-27 00:47:19', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(152, 'Lokasi Kesehatan telah diupdate', 0, '2025-08-27 00:49:10', '2025-08-27 00:49:10', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(153, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-27 00:49:36', '2025-08-27 00:49:36', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(154, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:50:04', '2025-08-27 00:50:04', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(155, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:57:35', '2025-08-27 00:57:35', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(156, 'Tempat olahraga telah ditambahkan', 0, '2025-08-27 01:04:49', '2025-08-27 01:04:49', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, 0, NULL),
(157, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 20:35:51', '2025-08-27 20:35:51', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(158, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 20:49:31', '2025-08-27 20:49:31', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(159, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:05:03', '2025-08-27 21:05:03', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(160, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:09:02', '2025-08-27 21:09:02', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(161, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:11:02', '2025-08-27 21:11:02', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(162, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:15:17', '2025-08-27 21:15:17', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(163, 'Info Sekolah telah dihapus', 0, '2025-08-27 21:15:37', '2025-08-27 21:15:37', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(164, 'Info Sekolah telah dihapus', 0, '2025-08-27 21:15:44', '2025-08-27 21:15:44', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(165, 'Info keagamaan telah ditambahkan', 0, '2025-08-28 00:19:07', '2025-08-28 00:19:07', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, 0, NULL),
(166, 'Info Pajak telah ditambahkan', 0, '2025-08-28 20:47:11', '2025-08-28 20:47:11', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(167, 'Info keagamaan telah ditambahkan', 0, '2025-08-29 00:20:22', '2025-08-29 00:20:22', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(168, 'Info Kerja telah ditambahkan', 0, '2025-09-01 00:03:06', '2025-09-01 00:03:06', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(169, 'Info Kerja telah ditambahkan', 0, '2025-09-01 00:09:17', '2025-09-01 00:09:17', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(170, 'Info Kerja telah diupdate', 0, '2025-09-01 00:31:36', '2025-09-01 00:31:36', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(171, 'Info keagamaan telah ditambahkan', 0, '2025-09-01 18:57:32', '2025-09-01 18:57:32', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(172, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:36:52', '2025-09-01 19:36:52', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(173, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:39:23', '2025-09-01 19:39:23', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(174, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:48:04', '2025-09-01 19:48:04', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(175, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:53:16', '2025-09-01 19:53:16', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(176, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:57:57', '2025-09-01 19:57:57', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(177, 'Info Plesir telah ditambahkan', 0, '2025-09-01 20:27:14', '2025-09-01 20:27:14', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(178, 'Info Plesir telah ditambahkan', 0, '2025-09-01 21:12:27', '2025-09-01 21:12:27', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(179, 'Info Plesir telah ditambahkan', 0, '2025-09-01 21:28:44', '2025-09-01 21:28:44', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(180, 'Info Plesir telah ditambahkan', 0, '2025-09-01 23:26:00', '2025-09-01 23:26:00', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(181, 'Info Plesir telah ditambahkan', 0, '2025-09-01 23:35:21', '2025-09-01 23:35:21', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(182, 'Info Plesir telah ditambahkan', 0, '2025-09-02 00:12:09', '2025-09-02 00:12:09', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(183, 'Info Plesir telah dihapus', 0, '2025-09-02 00:14:13', '2025-09-02 00:14:13', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(184, 'Info Perizinan telah ditambahkan', 0, '2025-09-02 01:47:36', '2025-09-02 01:47:36', 'http://192.168.255.138:8000/admin/izin/info', NULL, 0, NULL),
(185, 'Info Kerja telah ditambahkan', 0, '2025-09-02 18:28:10', '2025-09-02 18:28:10', 'http://192.168.255.138:8000/admin/kerja/index', NULL, 0, NULL),
(186, 'Info Kesehatan telah ditambahkan', 0, '2025-09-02 18:57:01', '2025-09-02 18:57:01', 'http://192.168.255.138:8000/admin/sehat/tempat', NULL, 0, NULL),
(187, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 19:31:59', '2025-09-02 19:31:59', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(188, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 20:12:26', '2025-09-02 20:12:26', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(189, 'Info Sekolah telah dihapus', 0, '2025-09-02 20:12:45', '2025-09-02 20:12:45', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(190, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 20:13:23', '2025-09-02 20:13:23', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(191, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:03:27', '2025-09-02 21:03:27', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(192, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:03:34', '2025-09-02 21:03:34', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(193, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:04:29', '2025-09-02 21:04:29', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(194, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:07:54', '2025-09-02 21:07:54', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(195, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:08:04', '2025-09-02 21:08:04', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(196, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:08:52', '2025-09-02 21:08:52', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(197, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:10:19', '2025-09-02 21:10:19', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(198, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:11:43', '2025-09-02 21:11:43', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(199, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:12:47', '2025-09-02 21:12:47', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(200, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:14:03', '2025-09-02 21:14:03', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(201, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:15:14', '2025-09-02 21:15:14', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(202, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:16:12', '2025-09-02 21:16:12', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(203, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:16:51', '2025-09-02 21:16:51', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(204, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:19:01', '2025-09-02 21:19:01', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(205, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:21:34', '2025-09-02 21:21:34', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(206, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:13', '2025-09-02 21:22:13', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(207, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:31', '2025-09-02 21:22:31', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(208, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:53', '2025-09-02 21:22:53', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(209, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:23:08', '2025-09-02 21:23:08', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(210, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:26:15', '2025-09-02 21:26:15', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(211, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:26:43', '2025-09-02 21:26:43', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(212, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:27:28', '2025-09-02 21:27:28', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(213, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:28:35', '2025-09-02 21:28:35', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(214, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:29:23', '2025-09-02 21:29:23', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(215, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:30:52', '2025-09-02 21:30:52', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(216, 'Info Adminduk telah ditambahkan', 0, '2025-09-03 00:18:10', '2025-09-03 00:18:10', 'http://192.168.255.138:8000/admin/adminduk/index', NULL, 0, NULL),
(217, 'Info Sekolah telah diupdate', 0, '2025-09-03 01:42:53', '2025-09-03 01:42:53', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(218, 'Info Sekolah telah diupdate', 0, '2025-09-03 01:51:19', '2025-09-03 01:51:19', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, 0, NULL),
(219, 'dumas telah dihapus.', 0, '2025-09-03 02:00:29', '2025-09-03 02:00:29', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, 0, NULL),
(220, 'Info Adminduk telah ditambahkan', 0, '2025-09-08 21:11:18', '2025-09-08 21:11:18', 'http://192.168.255.21:8000/admin/adminduk/index', NULL, 0, NULL),
(221, 'Tempat Ibadah telah ditambahkan.', 0, '2025-09-09 00:43:54', '2025-09-09 00:43:54', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, 0, NULL),
(222, 'Tempat Ibadah telah ditambahkan.', 0, '2025-09-09 00:45:07', '2025-09-09 00:45:07', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, 0, NULL),
(223, 'Tempat Ibadah diperbarui', 0, '2025-09-09 01:50:57', '2025-09-09 01:50:57', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, 0, NULL),
(224, 'Tempat Ibadah diperbarui', 0, '2025-09-09 01:52:11', '2025-09-09 01:52:11', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, 0, NULL),
(225, 'Tempat ibadah telah dihapus.', 0, '2025-09-09 01:53:59', '2025-09-09 01:53:59', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, 0, NULL),
(226, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-09-09 20:17:05', '2025-09-09 20:17:05', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(227, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:36:12', '2025-09-09 23:36:12', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(228, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:36:49', '2025-09-09 23:36:49', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(229, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:41:16', '2025-09-09 23:41:16', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(230, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-09 23:55:21', '2025-09-09 23:55:21', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(231, 'Tempat olahraga telah dihapus', 0, '2025-09-09 23:55:45', '2025-09-09 23:55:45', 'http://192.168.255.21:8000/sehat/tempat', NULL, 0, NULL),
(232, 'Info Adminduk telah diupdate', 0, '2025-09-10 00:22:55', '2025-09-10 00:22:55', 'http://192.168.255.21:8000/adminduk/index', NULL, 0, NULL),
(233, 'Deskripsi Renbang telah diperbarui', 0, '2025-09-11 00:36:51', '2025-09-11 00:36:51', 'http://192.168.255.110:8000/renbang/deskripsi', NULL, 0, NULL),
(234, 'Deskripsi Renbang telah ditambahkan', 0, '2025-09-11 00:41:16', '2025-09-11 00:41:16', 'http://192.168.255.110:8000/renbang/deskripsi', NULL, 0, NULL),
(235, 'dumas baru telah ditambahkan.', 0, '2025-09-18 19:01:33', '2025-09-18 19:01:33', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, 0, NULL),
(236, 'dumas telah dihapus.', 0, '2025-09-18 19:11:30', '2025-09-18 19:11:30', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, 0, NULL),
(237, 'dumas telah dihapus.', 0, '2025-09-18 19:15:05', '2025-09-18 19:15:05', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, 0, NULL),
(238, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28', 'http://192.168.255.132:8000/admin/sehat/tempat', NULL, 0, NULL),
(239, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(240, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24', 'http://192.168.255.132:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(241, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(242, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 20:11:56', '2025-09-21 20:11:56', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(243, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 0, '2025-09-21 21:23:41', '2025-09-21 21:23:41', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(244, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 0, '2025-09-21 21:24:33', '2025-09-21 21:24:33', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(245, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 21:34:02', '2025-09-21 21:34:02', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(246, 'Info Adminduk telah ditambahkan', 0, '2025-09-21 23:44:06', '2025-09-21 23:44:06', 'http://192.168.255.132:8000/admin/adminduk/info', NULL, 0, NULL),
(247, 'Lokasi Sekolah telah ditambahkan', 0, '2025-09-23 07:28:57', '2025-09-23 07:28:57', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(248, 'Info Pajak telah ditambahkan', 0, '2025-09-23 18:24:18', '2025-09-23 18:24:18', 'http://192.168.255.96:8000/admin/ibadah/tempat', NULL, 0, NULL),
(249, 'Info Pajak telah diupdate', 0, '2025-09-23 18:45:41', '2025-09-23 18:45:41', 'http://192.168.255.96:8000/admin/pajak/info', 'admindinas', 0, NULL),
(250, 'Lokasi Sekolah telah ditambahkan', 0, '2025-09-29 23:40:30', '2025-09-29 23:40:30', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(251, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:15', '2025-09-30 00:02:15', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(252, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:22', '2025-09-30 00:02:22', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(253, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:29', '2025-09-30 00:02:29', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(254, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:40', '2025-09-30 00:02:40', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(255, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-30 00:05:57', '2025-09-30 00:05:57', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(256, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:13:47', '2025-09-30 00:13:47', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(257, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:13:55', '2025-09-30 00:13:55', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(258, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:14:02', '2025-09-30 00:14:02', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(259, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:14:36', '2025-09-30 00:14:36', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(260, 'Tempat olahraga telah ditambahkan', 0, '2025-09-30 00:42:25', '2025-09-30 00:42:25', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(261, 'Lokasi pasar telah dihapus.', 0, '2025-09-30 01:41:11', '2025-09-30 01:41:11', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(262, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:45:40', '2025-09-30 01:45:40', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(263, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:45:55', '2025-09-30 01:45:55', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(264, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:46:00', '2025-09-30 01:46:00', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(265, 'Lokasi Pasar telah diupdate', 0, '2025-09-30 01:46:29', '2025-09-30 01:46:29', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(266, 'Info Plesir telah dihapus', 0, '2025-09-30 01:55:04', '2025-09-30 01:55:04', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(267, 'Info Plesir telah ditambahkan', 0, '2025-09-30 02:04:40', '2025-09-30 02:04:40', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(268, 'Info Plesir telah dihapus', 0, '2025-09-30 02:05:02', '2025-09-30 02:05:02', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(269, 'Info Plesir telah ditambahkan', 0, '2025-09-30 02:06:09', '2025-09-30 02:06:09', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, 0, NULL),
(270, 'Lokasi Plesir telah ditambahkan', 0, '2025-09-30 03:28:29', '2025-09-30 03:28:29', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(271, 'Lokasi Plesir telah diupdate', 0, '2025-09-30 03:29:20', '2025-09-30 03:29:20', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(272, 'Lokasi Plesir telah dihapus', 0, '2025-09-30 03:29:32', '2025-09-30 03:29:32', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(273, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:30:50', '2025-09-30 03:30:50', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(274, 'Lokasi Pasar telah diupdate', 0, '2025-09-30 03:31:08', '2025-09-30 03:31:08', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(275, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:37:17', '2025-09-30 03:37:17', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(276, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:40:09', '2025-09-30 03:40:09', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(277, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:41:40', '2025-09-30 03:41:40', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(278, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:47:49', '2025-09-30 03:47:49', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(279, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:47:56', '2025-09-30 03:47:56', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(280, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:48:00', '2025-09-30 03:48:00', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(281, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:48:10', '2025-09-30 03:48:10', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(282, 'Info Plesir telah ditambahkan', 0, '2025-09-30 04:05:51', '2025-09-30 04:05:51', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(283, 'Tempat olahraga telah diperbarui', 0, '2025-09-30 04:15:05', '2025-09-30 04:15:05', 'http://192.168.1.11:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(284, 'Tempat olahraga telah diperbarui', 0, '2025-09-30 04:18:43', '2025-09-30 04:18:43', 'http://192.168.1.11:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(285, 'Info keagamaan telah diperbarui', 0, '2025-09-30 04:37:35', '2025-09-30 04:37:35', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, 0, NULL),
(286, 'Info Adminduk telah dihapus', 0, '2025-09-30 04:56:19', '2025-09-30 04:56:19', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, 0, NULL),
(287, 'Info Adminduk telah dihapus', 0, '2025-09-30 04:56:25', '2025-09-30 04:56:25', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, 0, NULL),
(288, 'Info Adminduk telah diupdate', 0, '2025-09-30 04:56:37', '2025-09-30 04:56:37', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, 0, NULL),
(289, 'Info Renbang telah diperbarui', 0, '2025-09-30 05:02:48', '2025-09-30 05:02:48', 'http://192.168.1.11:8000/admin/renbang/Renbang/Info', NULL, 0, NULL),
(290, 'Info Renbang telah dihapus', 0, '2025-09-30 05:04:32', '2025-09-30 05:04:32', 'http://192.168.1.11:8000/admin/renbang/Renbang/Info', NULL, 0, NULL),
(291, 'Info Perizinan telah diupdate', 0, '2025-09-30 05:11:15', '2025-09-30 05:11:15', 'http://192.168.1.11:8000/admin/izin/info', NULL, 0, NULL),
(292, 'Tempat olahraga telah dihapus', 0, '2025-10-01 19:20:31', '2025-10-01 19:20:31', 'http://192.168.255.62:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(293, 'Tempat olahraga telah diperbarui', 0, '2025-10-01 20:24:24', '2025-10-01 20:24:24', 'http://192.168.255.62:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(294, 'Tempat olahraga telah ditambahkan', 0, '2025-10-01 20:29:44', '2025-10-01 20:29:44', 'http://192.168.255.62:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(295, 'Tempat olahraga telah dihapus', 0, '2025-10-01 20:33:24', '2025-10-01 20:33:24', 'http://192.168.255.62:8000/admin/sehat/tempat', 'superadmin', 0, NULL),
(296, 'Lokasi Kesehatan baru telah ditambahkan', 0, '2025-10-08 19:31:31', '2025-10-08 19:31:31', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', 0, NULL),
(297, 'Lokasi Kesehatan telah diupdate', 0, '2025-10-08 20:08:09', '2025-10-08 20:08:09', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', NULL, NULL),
(298, 'Lokasi Kesehatan telah diupdate', 0, '2025-10-08 20:19:48', '2025-10-08 20:19:48', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', NULL, NULL),
(299, 'Lokasi Kesehatan telah diupdate', 0, '2025-10-08 20:25:02', '2025-10-08 20:25:02', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', 2, NULL),
(300, 'Lokasi Kesehatan telah diupdate', 1, '2025-10-09 00:35:04', '2025-10-17 01:54:58', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', 2, NULL),
(301, 'Lokasi Kesehatan telah dihapus', 1, '2025-10-09 00:35:33', '2025-10-17 01:54:15', 'http://192.168.254.176:8000/admin/sehat/tempat', 'admindinas', 2, NULL),
(302, 'Info Sekolah telah dihapus', 0, '2025-10-12 19:50:30', '2025-10-12 19:50:30', 'http://192.168.255.154:8000/admin/ibadah/tempat', NULL, NULL, NULL),
(303, 'Info Sekolah telah dihapus', 0, '2025-10-12 20:24:57', '2025-10-12 20:24:57', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'admindinas', 3, NULL),
(304, 'Tempat Ibadah diperbarui', 0, '2025-10-12 23:57:52', '2025-10-12 23:57:52', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'admindinas', 10, NULL),
(305, 'Info Pajak telah diupdate', 1, '2025-10-13 00:12:03', '2025-10-17 01:49:08', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'admindinas', 6, NULL),
(306, 'Lokasi Pasar telah diupdate', 0, '2025-10-13 00:25:25', '2025-10-13 00:25:25', 'http://192.168.255.154:8000/admin/pasar/tempat', 'admindinas', 7, NULL),
(307, 'Info Sekolah telah dihapus', 0, '2025-10-13 00:28:57', '2025-10-13 00:28:57', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'admindinas', 3, NULL),
(308, 'Tempat Ibadah diperbarui', 0, '2025-10-13 00:30:46', '2025-10-13 00:30:46', 'http://192.168.255.154:8000/admin/ibadah/tempat', 'admindinas', 10, NULL),
(309, 'Info Kerja telah diupdate', 0, '2025-10-13 00:35:33', '2025-10-13 00:35:33', 'http://192.168.255.154:8000/admin/kerja/info', 'admindinas', 8, NULL),
(310, 'Info Kerja telah dihapus', 0, '2025-10-13 00:35:46', '2025-10-13 00:35:46', 'http://192.168.255.154:8000/admin/kerja/info', 'admindinas', 8, NULL),
(311, 'Lokasi Plesir telah diupdate', 0, '2025-10-13 01:09:03', '2025-10-13 01:09:03', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'admindinas', 9, NULL),
(312, 'Info Kesehatan telah ditambahkan', 0, '2025-10-13 01:13:48', '2025-10-13 01:13:48', 'http://192.168.255.154:8000/admin/sehat/tempat', 'superadmin', NULL, NULL),
(313, 'Info Kesehatan telah ditambahkan', 0, '2025-10-13 18:33:40', '2025-10-13 18:33:40', 'http://192.168.255.154:8000/admin/sehat/tempat', 'superadmin', NULL, NULL),
(314, 'Info keagamaan telah diperbarui', 0, '2025-10-13 19:17:37', '2025-10-13 19:17:37', 'http://192.168.255.154:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(315, 'Info keagamaan telah diperbarui', 0, '2025-10-13 19:20:55', '2025-10-13 19:20:55', 'http://192.168.255.154:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(316, 'Info Sekolah telah diupdate', 0, '2025-10-13 20:23:25', '2025-10-13 20:23:25', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'superadmin', NULL, NULL),
(317, 'Info Adminduk telah ditambahkan', 0, '2025-10-13 23:38:10', '2025-10-13 23:38:10', 'http://192.168.255.154:8000/admin/adminduk/info', NULL, NULL, NULL),
(318, 'Info Adminduk telah diupdate', 0, '2025-10-13 23:45:17', '2025-10-13 23:45:17', 'http://192.168.255.154:8000/admin/adminduk/info', 'admindinas', 11, NULL),
(319, 'Info Renbang telah ditambahkan', 0, '2025-10-13 23:49:59', '2025-10-13 23:49:59', 'http://192.168.255.154:8000/admin/renbang/Renbang/Info', 'admindinas', 12, NULL),
(320, 'Info Perizinan telah ditambahkan', 1, '2025-10-13 23:55:51', '2025-10-17 00:28:19', 'http://192.168.255.154:8000/admin/izin/info', 'admindinas', 13, NULL),
(321, 'Info keagamaan telah ditambahkan', 0, '2025-10-15 00:23:47', '2025-10-15 00:23:47', 'http://192.168.255.154:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(322, 'Info Sekolah telah ditambahkan', 0, '2025-10-15 00:36:32', '2025-10-15 00:36:32', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'superadmin', NULL, NULL),
(323, 'Info Pajak telah ditambahkan', 0, '2025-10-15 00:41:41', '2025-10-15 00:41:41', 'http://192.168.255.154:8000/admin/pajak/info', 'superadmin', NULL, NULL),
(324, 'Info Kerja telah ditambahkan', 0, '2025-10-15 00:42:58', '2025-10-15 00:42:58', 'http://192.168.255.154:8000/admin/kerja/info', 'superadmin', NULL, NULL),
(325, 'Info Plesir telah ditambahkan', 1, '2025-10-15 01:18:34', '2025-10-17 01:42:48', 'http://192.168.255.154:8000/admin/sekolah/tempat', 'superadmin', NULL, NULL),
(326, 'Info Adminduk telah ditambahkan', 1, '2025-10-15 01:21:14', '2025-10-16 20:18:25', 'http://192.168.255.154:8000/admin/adminduk/info', 'superadmin', NULL, NULL),
(327, 'Info Renbang telah ditambahkan', 1, '2025-10-15 01:23:56', '2025-10-16 20:18:20', 'http://192.168.255.154:8000/admin/renbang/Renbang/Info', 'superadmin', NULL, NULL),
(328, 'Info Perizinan telah ditambahkan', 1, '2025-10-15 01:24:41', '2025-10-16 20:08:21', 'http://192.168.255.154:8000/admin/izin/info', 'superadmin', NULL, NULL),
(329, 'Lokasi Kesehatan telah dihapus', 1, '2025-10-16 23:51:16', '2025-10-17 00:28:09', 'http://192.168.255.154:8000/admin/sehat/tempat', 'admindinas', 2, NULL),
(330, 'Info Pajak telah dihapus', 1, '2025-10-17 01:51:26', '2025-10-17 01:51:38', 'http://192.168.255.154:8000/admin/pajak/info', 'admindinas', 6, NULL),
(331, 'Lokasi Kesehatan telah dihapus', 1, '2025-10-17 01:56:14', '2025-10-17 01:56:25', 'http://192.168.255.154:8000/admin/sehat/tempat', 'admindinas', 2, NULL),
(332, 'Tempat olahraga telah ditambahkan', 1, '2025-10-26 19:47:44', '2025-10-28 20:51:33', 'http://192.168.255.118:8000/admin/sehat/tempat', 'superadmin', NULL, NULL),
(333, 'Tempat olahraga telah dihapus', 1, '2025-10-26 19:48:06', '2025-10-28 20:51:25', 'http://192.168.255.118:8000/admin/sehat/tempat', 'superadmin', NULL, NULL),
(334, 'Lokasi Sekolah telah ditambahkan', 0, '2025-10-26 19:56:40', '2025-10-26 19:56:40', 'http://192.168.255.118:8000/admin/sekolah/tempat', 'superadmin', NULL, NULL),
(335, 'Lokasi Pasar telah ditambahkan', 0, '2025-10-26 20:01:02', '2025-10-26 20:01:02', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL),
(336, 'Lokasi Pasar telah dihapus', 0, '2025-10-26 20:01:07', '2025-10-26 20:01:07', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL);
INSERT INTO `notifikasi_aktivitas` (`id`, `keterangan`, `dibaca`, `created_at`, `updated_at`, `url`, `role`, `id_instansi`, `id_puskesmas`) VALUES
(337, 'Lokasi Pasar telah ditambahkan', 0, '2025-10-26 20:45:44', '2025-10-26 20:45:44', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL),
(338, 'Lokasi Pasar telah dihapus', 0, '2025-10-26 20:45:51', '2025-10-26 20:45:51', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL),
(339, 'Lokasi Pasar telah diupdate', 0, '2025-10-26 20:46:03', '2025-10-26 20:46:03', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL),
(340, 'Tempat Ibadah telah ditambahkan.', 1, '2025-10-26 20:50:49', '2025-10-28 20:51:18', 'http://192.168.255.118:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(341, 'Info keagamaan telah ditambahkan', 0, '2025-10-26 20:57:32', '2025-10-26 20:57:32', 'http://192.168.255.118:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(342, 'Info keagamaan telah dihapus', 1, '2025-10-26 20:57:43', '2025-10-27 23:45:55', 'http://192.168.255.118:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(343, 'Umkm telah diupdate', 0, '2025-10-28 20:02:39', '2025-10-28 20:02:39', 'http://192.168.255.118:8000/admin/pasar/tempat', 'superadmin', NULL, NULL),
(344, 'Ada Pengaduan baru yang ditambahkan', 0, '2025-10-28 20:43:28', '2025-10-28 20:43:28', 'http://192.168.255.118:8000/admin/dumas/aduan', 'user', NULL, NULL),
(345, 'Tempat ibadah telah ditambahkan', 1, '2025-10-28 20:59:31', '2025-10-28 20:59:56', 'http://192.168.255.118:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(346, 'Info keagamaan telah ditambahkan', 1, '2025-10-28 21:04:50', '2025-10-28 21:05:10', 'http://192.168.255.118:8000/admin/ibadah/info', 'superadmin', NULL, NULL),
(347, 'Info keagamaan telah dihapus', 1, '2025-10-28 21:05:28', '2025-10-29 01:24:47', 'http://192.168.255.118:8000/admin/ibadah/info/17', 'superadmin', NULL, NULL),
(348, 'Lokasi Plesir telah ditambahkan', 1, '2025-10-28 21:27:25', '2025-10-28 21:30:01', 'http://192.168.255.118:8000/admin/plesir/tempat/store', 'superadmin', NULL, NULL),
(349, 'Lokasi Plesir telah diupdate', 1, '2025-10-28 21:32:09', '2025-10-28 21:32:16', 'http://192.168.255.118:8000/admin/plesir/tempat/update/7', 'superadmin', NULL, NULL),
(350, 'Lokasi Plesir telah dihapus', 1, '2025-10-29 00:30:15', '2025-10-29 00:30:29', 'http://192.168.255.118:8000/admin/plesir/tempat/destroy/7', 'superadmin', NULL, NULL),
(351, 'Lokasi Plesir telah ditambahkan', 1, '2025-10-29 00:36:54', '2025-10-29 00:39:50', 'http://192.168.255.118:8000/admin/plesir/tempat', 'superadmin', NULL, NULL),
(352, 'Lokasi Plesir telah diupdate', 1, '2025-10-29 00:40:27', '2025-10-29 00:40:38', 'http://192.168.255.118:8000/admin/plesir/tempat', 'superadmin', NULL, NULL),
(353, 'Lokasi Plesir telah dihapus', 1, '2025-10-29 00:40:45', '2025-10-29 00:40:52', 'http://192.168.255.118:8000/admin/plesir/tempat', 'superadmin', NULL, NULL),
(354, 'Info Plesir telah diupdate', 1, '2025-10-29 00:45:24', '2025-10-29 00:45:39', 'http://192.168.255.118:8000/admin/plesir/info', 'superadmin', NULL, NULL),
(355, 'Tempat ibadah telah diupdate', 1, '2025-10-29 01:23:45', '2025-10-29 01:23:57', 'http://192.168.255.118:8000/admin/ibadah/tempat', 'superadmin', NULL, NULL),
(356, 'Info keagamaan telah diupdate', 1, '2025-10-29 01:28:07', '2025-10-29 01:28:15', 'http://192.168.255.118:8000/admin/ibadah/info', 'superadmin', NULL, NULL),
(357, 'Info Keagamaan telah dihapus', 1, '2025-10-29 01:28:30', '2025-10-29 01:28:39', 'http://192.168.255.118:8000/admin/ibadah/info', 'superadmin', NULL, NULL),
(358, 'Info Renbang telah diupdate', 1, '2025-10-29 01:32:31', '2025-10-29 01:32:39', 'http://192.168.255.118:8000/admin/renbang/Renbang/Info', 'superadmin', NULL, NULL),
(359, 'Info Renbang telah dihapus', 1, '2025-10-29 01:32:43', '2025-10-29 01:32:50', 'http://192.168.255.118:8000/admin/renbang/Renbang/Info', 'superadmin', NULL, NULL),
(360, 'Ada Ajuan Renbang baru yang ditambahkan', 1, '2025-10-29 01:39:08', '2025-10-29 01:39:28', 'http://192.168.255.118:8000/admin/renbang/ajuan', 'user', NULL, NULL),
(361, 'Puskesmas telah dihapus', 0, '2025-11-02 23:45:43', '2025-11-02 23:45:43', 'http://192.168.56.1:8000/admin/puskesmas', 'admindinas', 2, NULL),
(362, 'Pengaduan telah diupdate', 0, '2025-11-03 19:17:16', '2025-11-03 19:17:16', 'http://192.168.56.1:8000/admin/dumas/aduan', 'superadmin', NULL, NULL),
(363, 'Pengaduan telah diupdate', 0, '2025-11-04 19:21:44', '2025-11-04 19:21:44', 'http://192.168.56.1:8000/admin/dumas/aduan', 'superadmin', NULL, NULL),
(364, 'Lokasi Kesehatan baru telah ditambahkan', 0, '2025-11-05 20:55:06', '2025-11-05 20:55:06', 'http://192.168.56.1:8000/admin/sehat/tempat', 'superadmin', NULL, NULL),
(365, 'Lokasi Kesehatan baru telah ditambahkan', 0, '2025-11-05 21:02:01', '2025-11-05 21:02:01', 'http://192.168.56.1:8000/admin/sehat/tempat', 'superadmin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id` int NOT NULL,
  `id_toko` int NOT NULL,
  `daerah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id`, `id_toko`, `daerah`, `harga`, `created_at`, `updated_at`) VALUES
(1, 6, 'Jatibarang', '18000.00', '2025-11-05 19:21:04', '2025-11-05 19:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int NOT NULL,
  `id_umkm` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `id_umkm`, `nama`, `foto`, `no_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 1, 'pratama', 'owner_foto/ErYkBv0y63UCMOOWs18fzFcWNdxZVk2uKRpocGNI.jpg', '08773762678', 'jalan raya sindang kota indramayu', '2025-10-20 20:32:06', '2025-10-20 20:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `panik_button`
--

CREATE TABLE `panik_button` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `nomer` varchar(80) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `panik_button`
--

INSERT INTO `panik_button` (`id`, `name`, `kategori`, `nomer`, `created_at`, `updated_at`) VALUES
(1, 'Pemadam', '', '133', '2025-10-27 00:37:31', '2025-10-27 00:37:31'),
(2, 'Polisi', '', '110', '2025-10-27 00:48:58', '2025-10-27 00:48:58'),
(3, 'Ambulans', '', '119', '2025-10-27 00:49:35', '2025-10-27 00:49:35'),
(5, 'ambulans imkot', 'Ambulans', '110', '2025-10-28 00:05:35', '2025-10-28 00:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int NOT NULL,
  `no_pembayaran` varchar(255) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `tanggal_pembayaran` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `no_pembayaran`, `metode_pembayaran`, `status_pembayaran`, `bukti_pembayaran`, `tanggal_pembayaran`, `created_at`, `updated_at`) VALUES
(1, '32187948', 'bank bni', 'proses', 'belum ada', '28 oktober 2025', NULL, NULL),
(2, 'TRX001', 'Bank BNI', 'proses', 'belum ada', '2025-10-23', '2025-10-23 08:13:01', NULL),
(3, 'TRX001', 'Bank BNI', 'proses', 'belum ada', '2025-10-23', '2025-10-23 08:37:21', NULL),
(4, 'TRX68FAF167E4E71', 'Bank BNI', 'proses', 'belum ada', '2025-10-24', '2025-10-23 20:24:24', NULL),
(5, 'TRX68FAF167E4E71', 'Bank BNI', 'proses', 'belum ada', '2025-10-24', '2025-10-23 20:34:33', '2025-10-23 20:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '52affa7dfe71c42e043851f6d60656decaa07e8e892c668c997c7828a538dd6a', '[\"*\"]', NULL, NULL, '2025-07-01 20:00:39', '2025-07-01 20:00:39'),
(2, 'App\\Models\\User', 1, 'auth_token', 'a3424bee54d542d0812d642a995c94b588882b5861dd3b37c5c0993ad1c7d2d7', '[\"*\"]', NULL, NULL, '2025-07-01 20:05:56', '2025-07-01 20:05:56'),
(3, 'App\\Models\\User', 2, 'auth_token', '3388b6bdeaa0946340ff8c6a9f1ffd92258089884c961f3d353f075221ca3ceb', '[\"*\"]', NULL, NULL, '2025-08-21 21:03:42', '2025-08-21 21:03:42'),
(4, 'App\\Models\\User', 2, 'auth_token', '10cded9f0cfe7b770bf620954a7cbdd59dfecee77f2620e4815d2086800d0f6a', '[\"*\"]', NULL, NULL, '2025-08-21 21:04:55', '2025-08-21 21:04:55'),
(5, 'App\\Models\\User', 2, 'auth_token', 'd9500d45ea44cc3b60a661244dfaa1f1ed227c4e901561f1f1402eed27d3d182', '[\"*\"]', NULL, NULL, '2025-09-02 20:58:17', '2025-09-02 20:58:17'),
(6, 'App\\Models\\User', 2, 'auth_token', 'a7a91883f5a3c0fcdc801936589e9ac093d6011893ff0a049c4ceb5facde9b1b', '[\"*\"]', NULL, NULL, '2025-09-02 21:00:03', '2025-09-02 21:00:03'),
(7, 'App\\Models\\User', 2, 'auth_token', '9bb5f9cf7fd0ffe32c7c30eec39e5f838aaa5774be3e11038fb36facba0bc45b', '[\"*\"]', NULL, NULL, '2025-09-02 21:08:15', '2025-09-02 21:08:15'),
(8, 'App\\Models\\User', 2, 'auth_token', 'acff84087b37c5da44fe6fd05f51832a2c2580e4659491f2202a44dd86db602c', '[\"*\"]', '2025-09-02 21:28:35', NULL, '2025-09-02 21:16:20', '2025-09-02 21:28:35'),
(9, 'App\\Models\\User', 2, 'auth_token', '03da5b4beec7354a297927da31b25c488eea243b6fad21b9ebf6fb9c4f924b78', '[\"*\"]', '2025-09-02 21:30:52', NULL, '2025-09-02 21:28:51', '2025-09-02 21:30:52'),
(10, 'App\\Models\\User', 3, 'auth_token', 'b07c1e88d9f3e9885f6b6ab7ea88f46d7ad661a5b5b2ee1751608723717f7c66', '[\"*\"]', NULL, NULL, '2025-09-14 19:14:04', '2025-09-14 19:14:04'),
(11, 'App\\Models\\User', 2, 'auth_token', '25b4af03d1ad6bbed019daed9bfbb0f5bb3cfc5def752276341fa8af45b43e52', '[\"*\"]', NULL, NULL, '2025-09-14 20:24:13', '2025-09-14 20:24:13'),
(12, 'App\\Models\\User', 2, 'auth_token', '50f8ef9d60fcb84b4612a28525bbc5fcda2c9301152fd662a36ce844ebaf2a17', '[\"*\"]', NULL, NULL, '2025-09-14 21:42:34', '2025-09-14 21:42:34'),
(13, 'App\\Models\\User', 2, 'auth_token', 'ee8e3f5e7ab8a3e8012d6fb9151292f9be4f966370bacd22136239179633a388', '[\"*\"]', '2025-09-18 19:53:06', NULL, '2025-09-18 18:56:15', '2025-09-18 19:53:06'),
(14, 'App\\Models\\User', 2, 'auth_token', '502ccbda8d189746758c4a8531751d8fdba14309aa35b2ac6a721ac79014f9f8', '[\"*\"]', '2025-09-19 00:17:57', NULL, '2025-09-19 00:00:40', '2025-09-19 00:17:57'),
(15, 'App\\Models\\User', 2, 'auth_token', 'd5288f4a4b3ff7cb4a1dac834e691f5a45d89ff714152facf4342cee9ce6c823', '[\"*\"]', '2025-09-21 21:04:47', NULL, '2025-09-21 20:35:16', '2025-09-21 21:04:47'),
(16, 'App\\Models\\User', 2, 'auth_token', '791c49cce25192617e79b5d9edef7f4752db382c2f8df83889472bbc92503a5b', '[\"*\"]', '2025-09-23 07:11:53', NULL, '2025-09-22 23:39:28', '2025-09-23 07:11:53'),
(17, 'App\\Models\\User', 2, 'auth_token', 'e504e1e901f25b7adbd02f1140930c7509f1b33e06fd6bb5308f5e314442b1b4', '[\"*\"]', '2025-09-23 20:24:40', NULL, '2025-09-23 20:24:02', '2025-09-23 20:24:40'),
(18, 'App\\Models\\User', 2, 'auth_token', 'd8d7eefa46e1a0e63e63c6ff88bca7fe8ee737d9a75c71d05f3352f90c26ddaf', '[\"*\"]', '2025-09-28 20:20:14', NULL, '2025-09-28 19:41:50', '2025-09-28 20:20:14'),
(19, 'App\\Models\\User', 2, 'auth_token', '1ebb10ce1294f7db0662950881a26d1f1f36924e2da3aaa4a0827af5d9121437', '[\"*\"]', '2025-10-03 00:37:00', NULL, '2025-10-03 00:01:40', '2025-10-03 00:37:00'),
(20, 'App\\Models\\Admin', 15, 'admin-api-token', '6a29b5f5e876c8e9fa62b77bf252a1ccb59bff0695f595656c93cb549d53a5a7', '[\"*\"]', '2025-10-03 02:09:18', NULL, '2025-10-03 02:05:57', '2025-10-03 02:09:18'),
(21, 'App\\Models\\Admin', 15, 'admin-api-token', '47e508113e7b896be6eeb522fb5a9d943cdbe908fcd78109d3ddc3b9035d4451', '[\"*\"]', '2025-10-04 07:22:43', NULL, '2025-10-04 07:07:51', '2025-10-04 07:22:43'),
(22, 'App\\Models\\User', 2, 'auth_token', '0c682b3bab27b56bf9fe681a4f77c9b58a40267e92c28c5a433c58dbb72aa465', '[\"*\"]', '2025-10-04 07:55:46', NULL, '2025-10-04 07:10:03', '2025-10-04 07:55:46'),
(23, 'App\\Models\\Admin', 15, 'admin-api-token', '49955d9cbfefa78605bf961c50fca8442ce3ff0d64aaffc4aefdea2f3098eb4e', '[\"*\"]', '2025-10-04 07:23:21', NULL, '2025-10-04 07:22:58', '2025-10-04 07:23:21'),
(24, 'App\\Models\\Admin', 15, 'admin-api-token', 'b9ec3747e3c11179131237e64bc1d989ac878fd3bf7457798f4cec4fa5720f7b', '[\"*\"]', '2025-10-04 07:38:35', NULL, '2025-10-04 07:26:13', '2025-10-04 07:38:35'),
(25, 'App\\Models\\Admin', 15, 'admin-api-token', 'c42949ea0864e536d96204ae1ea2541bc00a8852017c738292a56cb5d5b6761d', '[\"*\"]', '2025-10-04 07:42:07', NULL, '2025-10-04 07:39:31', '2025-10-04 07:42:07'),
(26, 'App\\Models\\Admin', 15, 'admin-api-token', 'f89b5f1956a427faa7d1f7fc9e4aeb34f222caf1c2872bc9fc5dfd2dcfb52300', '[\"*\"]', NULL, NULL, '2025-10-04 07:44:27', '2025-10-04 07:44:27'),
(27, 'App\\Models\\Admin', 15, 'admin-api-token', '94a8d64c7d50c27b05acd2886f3469b308b0e1fe307310356ae76a51b770dbd6', '[\"*\"]', '2025-10-04 07:57:23', NULL, '2025-10-04 07:50:00', '2025-10-04 07:57:23'),
(28, 'App\\Models\\Admin', 15, 'AdminToken', '7450935de527c7ce03935df633efca2fd3566dcfea468f703ad3d714e5f2e76a', '[\"*\"]', NULL, NULL, '2025-10-05 19:34:06', '2025-10-05 19:34:06'),
(29, 'App\\Models\\Admin', 15, 'AdminToken', 'ac228940ec1e0aff297369f76fac516c2aaa6bb751997ff59d0bbfa5e0e6da66', '[\"*\"]', NULL, NULL, '2025-10-05 19:37:16', '2025-10-05 19:37:16'),
(30, 'App\\Models\\Admin', 15, 'AdminToken', 'eea9f8b2fdbef255a3e829f87d67746b4f33b57c87fb58b1eba5708598ea9b9d', '[\"*\"]', NULL, NULL, '2025-10-05 19:40:46', '2025-10-05 19:40:46'),
(31, 'App\\Models\\Admin', 15, 'AdminToken', '8f43f8b49e7fcc4fc193aa6919014b31915c9fdf8e04eb9f8b71c3937b807085', '[\"*\"]', NULL, NULL, '2025-10-05 20:29:55', '2025-10-05 20:29:55'),
(32, 'App\\Models\\Admin', 15, 'AdminToken', '226de9e52ed907ba534ce5515e466c247679072ddbb86539a6b7d8fead68a952', '[\"*\"]', NULL, NULL, '2025-10-05 20:46:28', '2025-10-05 20:46:28'),
(33, 'App\\Models\\User', 2, 'auth_token', '488242e00207393eb1b032c478b45bc0ed5282092c3f56c1620b9eb6fc58c483', '[\"*\"]', '2025-10-06 19:41:27', NULL, '2025-10-06 19:13:33', '2025-10-06 19:41:27'),
(34, 'App\\Models\\Admin', 15, 'AdminToken', '70e6361f0acb0dab974b21a9338fc7e42fe5686dff30f320d461f59cb03c6b30', '[\"*\"]', '2025-10-06 20:15:02', NULL, '2025-10-06 19:26:28', '2025-10-06 20:15:02'),
(35, 'App\\Models\\User', 3, 'auth_token', '6a9aec26485a916e579acd587417daf497004834edad27b4fa47d8fef23bd69d', '[\"*\"]', '2025-10-07 00:12:51', NULL, '2025-10-06 20:09:01', '2025-10-07 00:12:51'),
(36, 'App\\Models\\Admin', 15, 'AdminToken', 'b51c6c360e3cbbcfdde20ab5ba39ec882d364df8ca80ac739ab11d1eea4387a0', '[\"*\"]', NULL, NULL, '2025-10-06 20:19:21', '2025-10-06 20:19:21'),
(37, 'App\\Models\\Admin', 15, 'AdminToken', '9f92bcf96e1887c83f06da17ad3ec941d4e239a7697e060bafcaa718f6f86bdf', '[\"*\"]', NULL, NULL, '2025-10-06 20:28:22', '2025-10-06 20:28:22'),
(38, 'App\\Models\\Admin', 15, 'AdminToken', 'a9d5e049ad0d69e10de73e317daf1081d0963ca79611d250e8aaa2daacbfcd32', '[\"*\"]', NULL, NULL, '2025-10-06 20:32:39', '2025-10-06 20:32:39'),
(39, 'App\\Models\\Admin', 15, 'AdminToken', '8be753a8f84bf8fc4c951b973dff8bc2dd69d96369cbbda233c8ef15cc237dd1', '[\"*\"]', '2025-10-07 00:12:37', NULL, '2025-10-06 20:41:21', '2025-10-07 00:12:37'),
(40, 'App\\Models\\User', 3, 'auth_token', '405082286aa4807bda9cd168ea84df78153150482185f6cbf8fa7813de132dbe', '[\"*\"]', NULL, NULL, '2025-10-14 01:53:11', '2025-10-14 01:53:11'),
(41, 'App\\Models\\User', 3, 'auth_token', 'fe8fc3d177dfa91378c36a791b4578bc3f08e77be18e2044cbe31ec5e9f4eb17', '[\"*\"]', '2025-10-14 18:14:37', NULL, '2025-10-14 18:08:05', '2025-10-14 18:14:37'),
(42, 'App\\Models\\User', 3, 'auth_token', '4f7ecf7552451426817cbe8f943801fa57aab5993a0c87d8861f3cbcb085846c', '[\"*\"]', '2025-10-16 20:49:41', NULL, '2025-10-16 20:46:12', '2025-10-16 20:49:41'),
(43, 'App\\Models\\User', 2, 'auth_token', 'f3a7ed002b4a5401a32423317df5cf05186595b241cfa86845389d8072da852c', '[\"*\"]', '2025-10-17 00:45:45', NULL, '2025-10-17 00:42:34', '2025-10-17 00:45:45'),
(44, 'App\\Models\\Admin', 29, 'AdminToken', 'ab49c6f3fbb4cf7f58254cffe2bfc6cb38dcede69a1aec0b518e88b33ec25a3f', '[\"*\"]', '2025-10-22 19:25:39', NULL, '2025-10-22 19:09:18', '2025-10-22 19:25:39'),
(45, 'App\\Models\\User', 2, 'auth_token', '56c00fcb21be88f362b3561a6e09225604ebc78a78cc898aeb9b49d23d36755f', '[\"*\"]', NULL, NULL, '2025-10-23 20:05:20', '2025-10-23 20:05:20'),
(46, 'App\\Models\\Admin', 35, 'AdminToken', '0a8ca106a41c63e74e5b13a7cb82f51972704be33022c6adb57ea56f44388adf', '[\"*\"]', NULL, NULL, '2025-10-24 00:51:37', '2025-10-24 00:51:37'),
(47, 'App\\Models\\User', 3, 'auth_token', '8bca2e50e6a0f3c7e2cfc640b3609ca690434ac66a687f37fb33a920f9febf88', '[\"*\"]', NULL, NULL, '2025-10-26 20:08:24', '2025-10-26 20:08:24'),
(48, 'App\\Models\\User', 3, 'auth_token', 'ab02054f66d621dcc466b060ad62a20f53350536a5fac216a65d66030af9ac01', '[\"*\"]', '2025-10-27 20:30:34', NULL, '2025-10-27 20:09:07', '2025-10-27 20:30:34'),
(49, 'App\\Models\\User', 3, 'auth_token', 'e0e95b2390e0ff3d6f2032fce3dbae96fa9b3c3d631069f4cc97456119bbcff1', '[\"*\"]', '2025-10-29 01:39:06', NULL, '2025-10-28 20:38:34', '2025-10-29 01:39:06'),
(50, 'App\\Models\\Admin', 35, 'AdminToken', '37d38e0157054e9a0baf88b6a090b4aa713884688cfff3ea02b004f986d1b904', '[\"*\"]', NULL, NULL, '2025-10-29 00:15:41', '2025-10-29 00:15:41'),
(51, 'App\\Models\\User', 6, 'auth_token', '3926c557713d941871005e76a53f24adb42c24aa8830b4d97929e93918160ea7', '[\"*\"]', NULL, NULL, '2025-10-29 21:39:05', '2025-10-29 21:39:05'),
(52, 'App\\Models\\User', 3, 'auth_token', '5e701ac4bd294a0308e0f4d8c8405f37a27de513a623f130ef9cba455f644b47', '[\"*\"]', '2025-10-30 20:01:14', NULL, '2025-10-30 00:28:13', '2025-10-30 20:01:14'),
(53, 'App\\Models\\User', 6, 'auth_token', 'a26b40aab800f8eaca0c3b4031c4e51378ad5468042de4e4714c6fd36419052f', '[\"*\"]', '2025-11-03 01:45:18', NULL, '2025-10-30 20:04:17', '2025-11-03 01:45:18'),
(54, 'App\\Models\\User', 6, 'auth_token', '92961456b2e6a5f7937dc6eb933dfdc9f28880812189fdede20848ffcdfac6f3', '[\"*\"]', NULL, NULL, '2025-11-02 19:09:54', '2025-11-02 19:09:54'),
(55, 'App\\Models\\User', 7, 'auth_token', '3e9884c43fdb77382c049baac6920bec97259b3f187b0f91c62bce0ef3b82162', '[\"*\"]', NULL, NULL, '2025-11-02 19:11:48', '2025-11-02 19:11:48'),
(56, 'App\\Models\\User', 7, 'auth_token', '7f8e5835192e85d04d8cd911ab435c6df38cc3c331eafbae52c9de3d3eed3f61', '[\"*\"]', '2025-11-02 19:13:55', NULL, '2025-11-02 19:12:57', '2025-11-02 19:13:55'),
(57, 'App\\Models\\User', 7, 'auth_token', 'b6bfe67b0b669f76a439b66998ae81f4f55a34ccca21f56d4bb384aacb2df59a', '[\"*\"]', NULL, NULL, '2025-11-02 19:14:09', '2025-11-02 19:14:09'),
(58, 'App\\Models\\User', 7, 'auth_token', '63acf277354ea1234375e4bf3f32a152971eac4254b86dd3c60e37393f621f3d', '[\"*\"]', NULL, NULL, '2025-11-02 19:14:32', '2025-11-02 19:14:32'),
(59, 'App\\Models\\User', 8, 'auth_token', '8957d4f75447a65ecd74a6458443df8eaf85abc672c8383fba8965441b837ae5', '[\"*\"]', NULL, NULL, '2025-11-02 19:27:26', '2025-11-02 19:27:26'),
(60, 'App\\Models\\User', 7, 'auth_token', 'e4ecdf9cdd5a22f857a670ed47c3327c553726579e50157bbc319a9be2cd33bc', '[\"*\"]', NULL, NULL, '2025-11-04 20:52:47', '2025-11-04 20:52:47'),
(61, 'App\\Models\\User', 2, 'auth_token', 'e83eefd52d611e0d3f8e124bf84d1ced31192ebe2500e227c3a4bac4202e0a98', '[\"*\"]', '2025-11-05 00:07:37', NULL, '2025-11-04 20:53:46', '2025-11-05 00:07:37'),
(62, 'App\\Models\\User', 2, 'auth_token', '53911d6ef0d60c08f5345c3c75cd9a5708e732514e5f8ad371803a153ca89760', '[\"*\"]', NULL, NULL, '2025-11-05 19:06:03', '2025-11-05 19:06:03'),
(63, 'App\\Models\\User', 7, 'auth_token', '3ad74e295be2f99bb1f9a0acda588218b767a1276fb0c7536f4637960abcda49', '[\"*\"]', '2025-11-05 21:11:04', NULL, '2025-11-05 19:06:46', '2025-11-05 21:11:04'),
(64, 'App\\Models\\User', 6, 'auth_token', 'd1b0b277bfc3993a69893163bceffd778be6f320ad350f1256478545a2dc7128', '[\"*\"]', NULL, NULL, '2025-11-05 19:28:16', '2025-11-05 19:28:16'),
(65, 'App\\Models\\User', 8, 'auth_token', 'e626b24bea61645f21511ca656c427fe97b1cef7501128475b28f40cef79f192', '[\"*\"]', '2025-11-05 19:30:14', NULL, '2025-11-05 19:28:57', '2025-11-05 19:30:14'),
(66, 'App\\Models\\User', 8, 'auth_token', 'a2d02a07ee45633dc22f18a9a2716748d04d53327dc073364534a1537c6df37d', '[\"*\"]', '2025-11-07 02:11:20', NULL, '2025-11-07 00:39:08', '2025-11-07 02:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `id_toko` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `variasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `spesifikasi` varchar(255) NOT NULL,
  `fitur` varchar(255) NOT NULL,
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_toko`, `nama`, `foto`, `harga`, `variasi`, `deskripsi`, `spesifikasi`, `fitur`, `stok`, `created_at`, `updated_at`) VALUES
(1, 1, 'baju peace', NULL, '15000.00', 'XXL', 'baju lembut dengan logo indah', 'baju terbuat dari sutra', 'baju', 20, NULL, NULL),
(3, 1, 'Es Cendol Dawet', 'produk/cendol.jpg', '10000.00', 'Original', 'Minuman tradisional segar', 'Dikemas dalam cup 500ml', 'Minuman', 10, '2025-10-23 23:48:10', '2025-10-23 23:49:54'),
(4, 1, 'Baju muslim', 'produk/muslim.jpg', '10000.00', 'XXL', 'Baju muslim dengan bahan terbaik', 'bahan lembut', 'pakaian', 10, '2025-10-26 20:14:28', '2025-10-26 20:14:28'),
(5, 5, 'Baju sid', 'produk/sid.jpg', '100000.00', 'XXL', 'Baju sid dengan bahan terbaik', 'bahan lembut', 'pakaian', 10, '2025-10-30 20:49:29', '2025-10-30 20:49:29'),
(7, 5, 'baju renang', '[{}]', '20000.00', '[\"hitam\"]', 'baju renang tahan air', 'baju renang super tebal', 'pakaian', 10, '2025-11-03 01:45:19', '2025-11-03 01:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `puskesmas`
--

CREATE TABLE `puskesmas` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jam` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `puskesmas`
--

INSERT INTO `puskesmas` (`id`, `nama`, `alamat`, `jam`, `created_at`, `updated_at`) VALUES
(1, 'Puskesmas Babadan', 'jalan raya babadan blok kenari', '08:00 - 16:00', NULL, NULL),
(3, 'Puskesmas Terusan', 'jalan raya terusan', '08.00 - 16.00', NULL, NULL),
(4, 'Puskesmas Jatibarang', 'Jalan raya jatibarang', '08.00 - 16.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `info_plesir_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `info_plesir_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(5, 16, 3, 5, 'Lumayan oke', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `renbang`
--

CREATE TABLE `renbang` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('menunggu','diproses','selesai','ditolak') DEFAULT 'menunggu',
  `tanggapan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `renbang`
--

INSERT INTO `renbang` (`id`, `user_id`, `judul`, `kategori`, `lokasi`, `deskripsi`, `status`, `tanggapan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Perbaikan Jalan Desa', 'Infrastruktur', 'Desa Sukamaju', 'Jalan rusak parah di sekitar balai desa perlu segera diperbaiki.', 'menunggu', NULL, '2025-10-14 01:56:52', '2025-10-14 01:56:52'),
(2, 3, 'Perbaikan Jalan Raya Sukamaju', 'Infrastruktur', 'Desa Sukamaju', 'Jalan rusak parah di sekitar desa Sukamaju perlu segera diperbaiki.', 'selesai', 'sudah selesai ya', '2025-10-14 18:09:40', '2025-10-14 18:35:14'),
(3, 3, 'Perbaikan Jalan Raya losarang', 'Infrastruktur', 'Desa losarang', 'Jalan rusak parah di sekitar desa losaranng perlu segera diperbaiki.', 'menunggu', NULL, '2025-10-29 01:39:07', '2025-10-29 01:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `renbangs_deskripsi`
--

CREATE TABLE `renbangs_deskripsi` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` enum('Infrastruktur','Pendidikan','Kesehatan','Ekonomi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Infrastruktur',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `renbangs_deskripsi`
--

INSERT INTO `renbangs_deskripsi` (`id`, `judul`, `deskripsi`, `gambar`, `fitur`, `created_at`, `updated_at`, `alamat`) VALUES
(3, 'Kemenhan Rencanakan Bangun Pangkalan TNI AD di Kawasan Hutan Indramayu', '<p>KORAN-PIKIRAN RAKYAT – Kawasan hutan di Desa Cikawung, Kecamatan Terisi, Kabupaten Indramayu, bakal menjadi lokasi pembangun­an pangkalan besar militer dari kesatuan Tentara ­Nasional Indonesia Angkatan Darat (TNI AD). Kementerian Pertahanan (Kemenhan) Republik Indonesia berencana membangun pangkalan TNI AD di kawasan hutan yang berada di wilayah perbatasan Indramayu, Majalengka, dan Sumedang.<br><br>Kepala Resort Pemangkuan Hutan (KRPH) Indramayu Wawan Gunawan mengungkapkan, rencana Kemenhan untuk membangun pangkalan militer TNI AD di areal hutan Cikawung. ”Ada permintaan dari Kemenhan untuk pangkalan dan fasilitas TNI AD di areal hutan Cikawung,” ujarnya, Sabtu 27 September 2025. Dia menyebutkan, areal hutan yang diminta TNI AD, melalui Kemenhan, berada di petak 16 dan 30 di lingkungan administrasi RPH Cipondoh, BKPH Cikawung, KPH Indramayu. Total luas lahan yang diperlukan sekitar 97-100 hektare. Rencananya, di atas lahan itu akan diba­ngun pangkalan dan fasilitas TNI untuk Brigif TP 34 serta Batalion TP 889. Wawan menyebutkan, karena statusnya kawasan hutan negara maka izin pemanfaatan ada di tangan pemerintah pusat melalui Kementerian Kehutanan (Kemenhut). ”Kita hanya ketempatan,” ucapnya.&nbsp;<br><br>Sumber Artikel berjudul \" Kemenhan Rencanakan Bangun Pangkalan TNI AD di Kawasan Hutan Indramayu \", selengkapnya dengan link: <a href=\"https://koran.pikiran-rakyat.com/jawa-barat/pr-3039680323/kemenhan-rencanakan-bangun-pangkalan-tni-ad-di-kawasan-hutan-indramayu\">https://koran.pikiran-rakyat.com/jawa-barat/pr-3039680323/kemenhan-rencanakan-bangun-pangkalan-tni-ad-di-kawasan-hutan-indramayu</a></p>', 'renbang/w0GHh7efiVuDxsRJf0oq9AWWZty77bZIU0g9R5KT.webp', 'Infrastruktur', '2025-09-11 00:41:16', '2025-09-30 05:02:48', 'Desa Cikawung, Kecamatan Terisi, Kabupaten Indramayu'),
(4, 'CRM Operation Handling', '<p>kjsjshjajdnekdjshkjdlajdkekfefg</p>', 'renbang/mpmEI2FnCpSN4bgXAfZ3cxg1fbDzWik8QyiABebh.jpg', 'Infrastruktur', '2025-10-13 23:49:59', '2025-10-13 23:49:59', 'jalan raya ajah');

-- --------------------------------------------------------

--
-- Table structure for table `renbang_like`
--

CREATE TABLE `renbang_like` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_renbang` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `renbang_like`
--

INSERT INTO `renbang_like` (`id`, `id_user`, `id_renbang`, `created_at`, `updated_at`) VALUES
(1, 3, 2, '2025-10-16 20:49:41', '2025-10-16 20:49:41'),
(2, 2, 2, '2025-10-17 00:45:45', '2025-10-17 00:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'user'),
(2, 'umkm'),
(3, 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(6, 1),
(3, 2),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cngp1HJnl2b8LURhy6dJPozaxNwV56u1Zav0tRzj', 1, '192.168.56.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiVzVJeFlkUGp0YjRwQ1QxTTNCMTVwc29FQXlkbVp2R1lhT3d5eEREeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xOTIuMTY4LjU2LjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiJjYXB0Y2hhX2NvZGUiO3M6NToiMTcxREIiO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjg6ImFkbWluX2lkIjtpOjE7czo0OiJuYW1lIjtzOjEwOiJzdXBlcmFkbWluIjtzOjQ6InJvbGUiO3M6MTA6InN1cGVyYWRtaW4iO3M6ODoiaW5zdGFuc2kiO047fQ==', 1762488860),
('dw8Jr7UQVXRAYl5WLvKuLOgfsYUEFvpXFkIychoR', 1, '192.168.56.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiaml0VjFFV2YxYmFJNTNCR1ZmN2dyUFQwYnJ3RHA4amNWNEtnZjVaciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xOTIuMTY4LjU2LjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiJjYXB0Y2hhX2NvZGUiO3M6NToiMjc4NzciO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjg6ImFkbWluX2lkIjtpOjE7czo0OiJuYW1lIjtzOjEwOiJzdXBlcmFkbWluIjtzOjQ6InJvbGUiO3M6MTA6InN1cGVyYWRtaW4iO3M6ODoiaW5zdGFuc2kiO047fQ==', 1762739915),
('DxgCNwr4DnWuYSBh4teKNdr6ghR1deNnmnvQnAST', 1, '192.168.56.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiS0hERVJuVXliRnVUNmdiRGFSMU52bHhQZFo0Z0FHVkZVYWpEZGlWRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xOTIuMTY4LjU2LjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiJjYXB0Y2hhX2NvZGUiO3M6NToiRTc4OEMiO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjg6ImFkbWluX2lkIjtpOjE7czo0OiJuYW1lIjtzOjEwOiJzdXBlcmFkbWluIjtzOjQ6InJvbGUiO3M6MTA6InN1cGVyYWRtaW4iO3M6ODoiaW5zdGFuc2kiO047fQ==', 1762497209),
('jbCRmkjFNbXXNtRjF9ZlJJzXLpIheNK9C2Jtwrla', 1, '192.168.56.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoibmFsT0dCa25oWk1ZdzMzSXQ3OU15c3Q5RFhJeWo4MEZzRDZicFFLWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xOTIuMTY4LjU2LjE6ODAwMC9hZG1pbi9zZWhhdC9pbmZvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMjoiY2FwdGNoYV9jb2RlIjtzOjU6IjQ3RTZBIjtzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo4OiJhZG1pbl9pZCI7aToxO3M6NDoibmFtZSI7czoxMDoic3VwZXJhZG1pbiI7czo0OiJyb2xlIjtzOjEwOiJzdXBlcmFkbWluIjtzOjg6Imluc3RhbnNpIjtOO30=', 1762413247),
('sV68nZVxFoxGRMxf7DdBPkalOVww4LZa4JBhfV9W', 1, '192.168.56.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiTUdvY0lHWWJKWnFxdEdFUFVIbW5WWVZSSWRvZE5weGxWTlVxM0xJMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xOTIuMTY4LjU2LjE6ODAwMC9hZG1pbi9zZWhhdC90ZW1wYXQvMjgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiJjYXB0Y2hhX2NvZGUiO3M6NToiRUQxMjQiO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjg6ImFkbWluX2lkIjtpOjE7czo0OiJuYW1lIjtzOjEwOiJzdXBlcmFkbWluIjtzOjQ6InJvbGUiO3M6MTA6InN1cGVyYWRtaW4iO3M6ODoiaW5zdGFuc2kiO047fQ==', 1762401726);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'slider/cyofrfw8pAKq883uzbopAiFtalq6xSbJuOb7k7O5.jpg', '2025-07-16 01:28:29', '2025-07-16 01:29:21'),
(2, 'slider/vyDMHDUslLV8G1KgR5NfaMRbrMIePQgjBn5noxNU.jpg', '2025-07-16 01:31:05', '2025-07-16 01:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_ibadah`
--

CREATE TABLE `tempat_ibadah` (
  `id` bigint UNSIGNED NOT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_ibadah`
--

INSERT INTO `tempat_ibadah` (`id`, `fitur`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`, `foto`) VALUES
(1, 'islam', 'Masjid Agung Indramayu', 'Alun-Alun, Margadadi, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45212', '-6.3270090', '108.3220030', '2025-07-03 20:05:16', '2025-08-01 01:44:38', 'ibadah_foto/pBhXmKFfja2Q4gZVr7Chd0H0L2c2LOh2BMmhCa7c.jpg'),
(2, 'kristen', 'Gereja Katolik Santo Mikael', 'Jalan Veteran, Lemahabang, Indramayu, West Java, Java, 45222, Indonesia', '-6.3287007', '108.3224380', '2025-07-04 18:30:34', '2025-10-13 00:30:46', 'ibadah_foto/eKows8thUHMz8CPy8kUANVOadQWxmG6eydLWjmD6.jpg'),
(39, 'islam', 'mushola 2', 'Jalan Tanjung Pura, Karangmalang, Indramayu, West Java, Java, 45213, Indonesia', '-6.3424980', '108.3286930', '2025-10-28 20:59:31', '2025-10-29 01:23:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tempat_olahraga`
--

CREATE TABLE `tempat_olahraga` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_olahraga`
--

INSERT INTO `tempat_olahraga` (`id`, `name`, `latitude`, `longitude`, `created_at`, `updated_at`, `address`, `foto`, `fitur`) VALUES
(6, 'Sport Center Indramayu', '-6.3371803', '108.3310840', '2025-09-30 00:42:25', '2025-10-01 20:24:23', 'Karanganyar, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45213', 'tempat_olahraga/fYu31YUb1rEleyNcSmf1MmAvmSuJrRphpJZLtxz1.jpg', 'serbaguna');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_pasars`
--

CREATE TABLE `tempat_pasars` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_pasars`
--

INSERT INTO `tempat_pasars` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`, `fitur`, `foto`) VALUES
(1, 'Pasar Baru Indramayu', 'Karangmalang, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45214', '-6.34226186', '108.33025744', '2025-07-04 01:42:30', '2025-10-26 20:46:03', 'pasar', 'Pasar_foto/HcjOyhP6TDbGccGrYQXoiJb1RWZWgzOpybC3iscE.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_plesirs`
--

CREATE TABLE `tempat_plesirs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_plesirs`
--

INSERT INTO `tempat_plesirs` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`, `foto`, `fitur`) VALUES
(1, 'Pantai Balongan Kesambi 2', 'Jl. Raya Balongan No.72, Balongan, Kec. Balongan, Kabupaten Indramayu, Jawa Barat 45217', '-6.3669066', '108.3914168', '2025-07-04 16:50:51', '2025-10-13 01:09:03', 'tempat_plesir_foto/cemgdsSSkcofTBqhvQDHlPSbbe3nA6y4ADSEwybr.jpg', 'wisata');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_sehats`
--

CREATE TABLE `tempat_sehats` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fitur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_sehats`
--

INSERT INTO `tempat_sehats` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`, `fitur`, `foto`) VALUES
(1, 'Rumah Sakit Umum Daerah Kabupaten Indramayu', 'RSUD Indramayu, 7, Jalan Murah Nara, Indramayu, West Java, Java, 45222, Indonesia', '-6.3299214', '108.3214892', '2025-07-04 01:25:11', '2025-09-30 00:05:57', 'rumah sakit', 'foto_kesehatan/Zn3OQo3jAPYRNtyNHRgyZVzqbEDWoHlJTS0KNFLf.jpg'),
(27, 'Rumah Sakit Mitra Plumbon Indramayu', 'Jl. Pantura, Ujungaris, Kec. Widasari, Kabupaten Indramayu, Jawa Barat 45271', '-6.4600458', '108.2855792', '2025-11-05 20:55:06', '2025-11-05 20:55:06', 'rumah sakit', 'uploads/sehat/dxggSHDGWssSb5qt7qdVY22wNo8p7buCTTllr0Lo.png'),
(28, 'Rumah Sakit MM', 'Jl. Let Jend. Suprapto No.292, Kepandean, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45214', '-6.3439716', '108.3235062', '2025-11-05 21:02:01', '2025-11-05 21:02:01', 'rumah sakit', 'uploads/sehat/ougCr7z2Ef1jzcetJMdedzHAJzz875yzwMGY09dT.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_sekolahs`
--

CREATE TABLE `tempat_sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitur` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_sekolahs`
--

INSERT INTO `tempat_sekolahs` (`id`, `name`, `latitude`, `longitude`, `address`, `fitur`, `foto`) VALUES
(1, 'Sd Negeri 1 Paoman 1', '-6.3206640', '108.3287100', 'Paoman, Indramayu, West Java, Java, 45211, Indonesia', 'Sd', 'sekolah_foto/C7WVQ3oGHeYI3DCM2DOOaoeJE5CRZNwu68P1lM5K.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `id_user`, `nama`, `deskripsi`, `alamat`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 0, 'Pratama shop', 'toko baju dengan kualitas terbaik', 'Jalan raya sindang kota indramayu', '0873573678', 'umkm/MfNZDLplQsR2GSk3sNvUDMiVvcZyZOj6TjKRXdiI.jpg', NULL, '2025-10-28 19:48:25'),
(3, 0, 'Nugraha store', 'Toko baju dengan kualitas terbaik di asia', 'Jalan Mt Haryono Indramayu', '0873573678', 'umkm/E9amngmscdONuSIMtlkeaKQjD6jwgygqpXtQwPdn.jpg', '2025-10-28 19:49:51', '2025-10-28 20:02:39'),
(4, 0, 'Piss Store', 'Toko baju paling laris se-Indonesia', 'Jalan MT Haryono, Indramayu', '08765625637', NULL, '2025-10-30 20:01:15', '2025-10-30 20:01:15'),
(5, 0, 'Plis Store', 'Toko baju paling laris se-Indramayu', 'Jalan MT Haryono blok gor singalodra, Indramayu', '0876562538945', NULL, '2025-10-30 20:05:37', '2025-10-30 20:05:37'),
(6, 7, 'rame Store', 'Toko baju paling laris se-Indramayu', 'Jalan MT Haryono blok gor singalodra, Indramayu', '0876562538945', NULL, '2025-11-02 19:13:55', '2025-11-02 19:13:55'),
(7, 8, 'Empat Store', 'Toko baju paling oke se-Indramayu', 'Jalan MT Haryono no 18', '0876562345', NULL, '2025-11-05 19:30:14', '2025-11-05 19:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `id_toko` int DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_produk` int DEFAULT NULL,
  `no_transaksi` varchar(255) NOT NULL,
  `no_pembayaran` varchar(255) DEFAULT NULL,
  `no_resi` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_ongkir` int DEFAULT NULL,
  `jumlah` int NOT NULL,
  `harga` bigint DEFAULT NULL,
  `total` int NOT NULL,
  `subtotal` int NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `jasa_pengiriman` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_toko`, `id_user`, `id_produk`, `no_transaksi`, `no_pembayaran`, `no_resi`, `alamat`, `id_ongkir`, `jumlah`, `harga`, `total`, `subtotal`, `catatan`, `status`, `jasa_pengiriman`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '32187948', NULL, NULL, 'jl.indomaret blok mangga indramayu', 0, 1, 15000, 15000, 15000, 'berikan nota didalamnya', 'menunggu', 'jnt', NULL, NULL),
(2, 1, 2, 3, 'TRX20251105051324503', NULL, NULL, 'Jl. Merdeka No. 10, Bandung', 1, 2, 200000, 400000, 400000, 'Tolong bungkus dengan rapi', 'pending', 'JNE', '2025-11-04 22:13:24', '2025-11-04 22:13:24'),
(21, NULL, 17, NULL, 'TRX690B06686BA1C', NULL, NULL, 'Jl. Sudirman No. 123 (Dummy)', NULL, 1, NULL, 200000, 200000, 'Tidak ada catatan', 'menunggu', 'JNE REG', '2025-11-05 01:10:16', NULL),
(22, NULL, 17, NULL, 'TRX690B06C7AE6BD', NULL, NULL, 'Jl. Sudirman No. 123 (Dummy)', NULL, 3, NULL, 415000, 415000, 'Tidak ada catatan', 'menunggu', 'JNE REG', '2025-11-05 01:11:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `alamat`, `email`, `phone`, `no_ktp`, `email_verified_at`, `password`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abdee Pratama', 'jalan', 'abdeeprataman@gmail.com', '08123456789', '1234567890123456', NULL, '$2y$12$2uafAeZUqsA0gw6DVwlwKO7edn86/BzIsw8xAFQjjZUUaRbx9BpoG', NULL, NULL, '2025-07-01 20:00:39', '2025-07-01 20:00:39'),
(2, 'Raul', '', 'Raul@gmail.com', '08123456759', '123456789059398', NULL, '$2y$12$YQ1RIg.pgjn0bYsZ7qHHLOUkU59438qYSKG3Ui/0zXnhAzni07KMC', NULL, NULL, '2025-08-21 21:03:42', '2025-08-21 21:03:42'),
(3, 'Alfa', 'jalan raya sliyeg', 'alfa@gmail.com', '08123456790', '1234567890578376', NULL, '$2y$12$TB/7mM35eEg0Saz1pbRxAu68ktec1aNyw0JqTxmjmquRcxk7xoPKC', NULL, NULL, '2025-09-14 19:14:03', '2025-10-27 20:30:35'),
(6, 'saya', NULL, 'saya@gmail.com', '0812347667', '1234567987786989', NULL, '$2y$12$U0Hq4Y.gtDP1.23lQonDQe8AcCFvC8hCamlKkg4hq6f103Ah2Z3iK', NULL, NULL, '2025-10-29 21:38:57', '2025-10-29 21:38:57'),
(7, 'fadil', NULL, 'fadil@gmail.com', '0812347667', '123456798778994895', NULL, '$2y$12$Vp1PgXvYs5k2hrt.a2ariuDCtY8Tin9kOJzAQ6w4x8ZUB1lxdxICe', NULL, NULL, '2025-11-02 19:11:48', '2025-11-02 19:11:48'),
(8, 'arip', NULL, 'arip@gmail.com', '0812347667', '12875846798778994895', NULL, '$2y$12$cgINgVVimA2uxZIC3VNgP.5EFsi3.tdCSnPM7nfC7Nrd0TaRLQ2ui', NULL, NULL, '2025-11-02 19:27:25', '2025-11-02 19:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int NOT NULL,
  `id_admin` int NOT NULL,
  `id_instansi` int DEFAULT NULL,
  `id_puskesmas` int DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `id_admin`, `id_instansi`, `id_puskesmas`, `nama`, `email`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 'abdee', 'abdeeprataman@gmail.com', '08765764774', NULL, NULL),
(2, 3, 2, NULL, 'kesehatan', 'kesehatan@gmail.com', '08337878783', NULL, NULL),
(3, 4, 3, NULL, 'pendidikan', 'pendidikan@gmail.com', '087847284284728', NULL, NULL),
(5, 5, 6, NULL, 'bapenda', 'bapenda@gmail.com', '087778387735', NULL, NULL),
(6, 7, 7, NULL, 'Perdagangan', 'perdagangan@gmail.com', '08656372534', NULL, NULL),
(7, 8, 8, NULL, 'disnaker', 'disnaker@gmail.com', '087562537632', NULL, NULL),
(8, 9, 9, NULL, 'pariwisata', 'pariwisata@gmail.com', '08763625736', NULL, NULL),
(9, 10, 10, NULL, 'keagamaan', 'keagamaan@gmail.com', '0836726835', NULL, NULL),
(10, 11, 11, NULL, 'adminduk', 'adminduk@gmail.com', '08767563763', NULL, NULL),
(11, 12, 12, NULL, 'renbang', 'renbang@gmail.com', '0898738235', NULL, NULL),
(12, 13, 13, NULL, 'perizinan', 'perizinan@gmail.com', '0876763763', NULL, NULL),
(13, 1, NULL, NULL, 'admin', 'admin@gmail.com', '08776577653', NULL, NULL),
(27, 36, NULL, 4, 'pkm.jatibarang', 'jatibarang@gmail.com', '0833787844', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wisata`
--

CREATE TABLE `wisata` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_wisata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `harga` int NOT NULL DEFAULT '0',
  `lokasi_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_no_transaksi` (`no_transaksi`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dumas`
--
ALTER TABLE `dumas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dumas_user_id_foreign` (`user_id`);

--
-- Indexes for table `dumas_ratings`
--
ALTER TABLE `dumas_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dumas_ratings_dumas_id_user_id_unique` (`dumas_id`,`user_id`),
  ADD KEY `dumas_ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_adminduk`
--
ALTER TABLE `info_adminduk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_keagamaans`
--
ALTER TABLE `info_keagamaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_kerja`
--
ALTER TABLE `info_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_kesehatan`
--
ALTER TABLE `info_kesehatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_pajak`
--
ALTER TABLE `info_pajak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_pasar`
--
ALTER TABLE `info_pasar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_perizinan`
--
ALTER TABLE `info_perizinan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_plesir`
--
ALTER TABLE `info_plesir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_sekolah`
--
ALTER TABLE `info_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_dumas`
--
ALTER TABLE `kategori_dumas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender` (`user_id`),
  ADD KEY `dokter_id_index` (`dokter_id`),
  ADD KEY `fk_receiver` (`admin_id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi_aktivitas`
--
ALTER TABLE `notifikasi_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panik_button`
--
ALTER TABLE `panik_button`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_info_plesir_id_foreign` (`info_plesir_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `renbang`
--
ALTER TABLE `renbang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_renbang_user` (`user_id`);

--
-- Indexes for table `renbangs_deskripsi`
--
ALTER TABLE `renbangs_deskripsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renbang_like`
--
ALTER TABLE `renbang_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_ibadah`
--
ALTER TABLE `tempat_ibadah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_olahraga`
--
ALTER TABLE `tempat_olahraga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_pasars`
--
ALTER TABLE `tempat_pasars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_plesirs`
--
ALTER TABLE `tempat_plesirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_sehats`
--
ALTER TABLE `tempat_sehats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_sekolahs`
--
ALTER TABLE `tempat_sekolahs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dumas`
--
ALTER TABLE `dumas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `dumas_ratings`
--
ALTER TABLE `dumas_ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infos`
--
ALTER TABLE `infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_adminduk`
--
ALTER TABLE `info_adminduk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `info_keagamaans`
--
ALTER TABLE `info_keagamaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `info_kerja`
--
ALTER TABLE `info_kerja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `info_kesehatan`
--
ALTER TABLE `info_kesehatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `info_pajak`
--
ALTER TABLE `info_pajak`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_pasar`
--
ALTER TABLE `info_pasar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `info_perizinan`
--
ALTER TABLE `info_perizinan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_plesir`
--
ALTER TABLE `info_plesir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `info_sekolah`
--
ALTER TABLE `info_sekolah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `kategori_dumas`
--
ALTER TABLE `kategori_dumas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `notifikasi_aktivitas`
--
ALTER TABLE `notifikasi_aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `panik_button`
--
ALTER TABLE `panik_button`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `puskesmas`
--
ALTER TABLE `puskesmas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `renbang`
--
ALTER TABLE `renbang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `renbangs_deskripsi`
--
ALTER TABLE `renbangs_deskripsi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `renbang_like`
--
ALTER TABLE `renbang_like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tempat_ibadah`
--
ALTER TABLE `tempat_ibadah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tempat_olahraga`
--
ALTER TABLE `tempat_olahraga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tempat_pasars`
--
ALTER TABLE `tempat_pasars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tempat_plesirs`
--
ALTER TABLE `tempat_plesirs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tempat_sehats`
--
ALTER TABLE `tempat_sehats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tempat_sekolahs`
--
ALTER TABLE `tempat_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dumas`
--
ALTER TABLE `dumas`
  ADD CONSTRAINT `dumas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dumas_ratings`
--
ALTER TABLE `dumas_ratings`
  ADD CONSTRAINT `dumas_ratings_dumas_id_foreign` FOREIGN KEY (`dumas_id`) REFERENCES `dumas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dumas_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_dokter` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_receiver` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sender` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_info_plesir_id_foreign` FOREIGN KEY (`info_plesir_id`) REFERENCES `info_plesir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `renbang`
--
ALTER TABLE `renbang`
  ADD CONSTRAINT `fk_renbang_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_messages` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-08 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM messages WHERE created_at < NOW() - INTERVAL 7 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
