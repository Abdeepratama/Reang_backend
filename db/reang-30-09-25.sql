-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 02:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

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
  `role` enum('superadmin','admindinas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `role`, `dinas`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$V5KWwvSTp5W0F7oyPmE3bOazRoE0NXGtGEOgZy45bgX1xjGlPDFI2', 'superadmin', NULL, NULL, '2025-07-01 23:21:50', '2025-07-01 23:21:50'),
(2, 'abdee', '$2y$12$sv18I47t8En5TPDnQ.tBVOsHD9eGbpEBzr9UJekgfXEEj5QjgnGSu', 'superadmin', NULL, NULL, '2025-09-12 00:27:34', '2025-09-12 00:27:34'),
(3, 'kesehatan', '$2y$12$HCpenKV37wec4FbQeP2kuOd9nRs8IdrBJmVg/dIUxu7TB5HCn6Zr2', 'admindinas', 'kesehatan', NULL, '2025-09-14 06:03:20', '2025-09-14 06:11:41'),
(4, 'pendidikan', '$2y$12$0YE3sgn4O7w4cOMbf0lZnevKhrxFazg7fHoC0SZDaAsc5bM3BgpgO', 'admindinas', 'pendidikan', NULL, '2025-09-15 18:55:09', '2025-09-15 18:55:09'),
(5, 'bapenda', '$2y$12$9GD3DvTeiHf1Vs5ZvOZsVeCxKuEdPtuisU0LVkV9LxzF0pTTDbjcS', 'admindinas', 'perpajakan', NULL, '2025-09-16 00:43:32', '2025-09-16 00:43:32'),
(7, 'perdagangan', '$2y$12$655lGxsYeELsngzXY44QiO73YTQBVWEGgvfXSkl77b5dqFXzHEnCG', 'admindinas', 'perdagangan', NULL, '2025-09-16 19:28:06', '2025-09-16 19:28:06'),
(8, 'disnaker', '$2y$12$QZHoBApUykgPPS2IlBgbxu8Er7QNrYM79YSP4n7myM55M5k6YSgCu', 'admindinas', 'kerja', NULL, '2025-09-16 19:55:32', '2025-09-16 19:55:32'),
(9, 'pariwisata', '$2y$12$aVS6YKj77deU/t3CY9X34.HBCefXHZ9Sn.gpACnjFg7e4UgiH/CT2', 'admindinas', 'pariwisata', NULL, '2025-09-17 00:42:09', '2025-09-17 00:42:09'),
(10, 'keagamaan', '$2y$12$qf3IgbrrIcy601EUWSp0EeKY/rwe3I0BhWPngSwgPX8HftbtSsAU.', 'admindinas', 'keagamaan', NULL, '2025-09-17 18:48:09', '2025-09-17 18:48:09'),
(11, 'adminduk', '$2y$12$L7LyLOhZ7HJBhsI/tWfFGeTZ/bq2iJJOioTHfioxyeZ0zN..Txcfu', 'admindinas', 'kependudukan', NULL, '2025-09-17 20:08:23', '2025-09-17 20:15:58'),
(12, 'renbang', '$2y$12$W5m3lPX3up1/RXNaCQedu.K.mzz9SLW9Me/c6HW8yhTPMRDydNt6S', 'admindinas', 'pembangunan', NULL, '2025-09-17 20:36:20', '2025-09-17 20:36:20'),
(13, 'perizinan', '$2y$12$16QdWnlaUXTcZmVbGLdx6evKGyBQ3GiKyKd0IQnWN9Xa.uKzd9tsW', 'admindinas', 'perizinan', NULL, '2025-09-17 23:15:29', '2025-09-17 23:15:29'),
(14, 'raul', '$2y$12$/L/n/ftxUgNdcsMN4tE0yOrl6QpjoA45uVPdNur/6UK6.C1Fdn0oy', 'admindinas', 'kesehatan', NULL, '2025-09-28 19:05:20', '2025-09-28 19:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `aktivitas` (`id`, `keterangan`, `role`, `dinas`, `url`, `item_id`, `tipe`, `dibaca`, `created_at`, `updated_at`) VALUES
(1, 'Menambahkan Tempat Ibadah: ', NULL, NULL, NULL, NULL, 'ibadah', 1, '2025-07-04 18:30:34', '2025-07-08 20:27:43'),
(2, 'Menambahkan Aduan Masyarakat ', NULL, NULL, NULL, NULL, 'Pengaduan', 1, '2025-07-07 18:56:58', '2025-07-07 20:17:12'),
(3, 'Sistem menerima pengaduan baru dari masyarakat', NULL, NULL, NULL, NULL, 'Pengaduan', 1, '2025-07-07 19:15:55', '2025-07-08 20:27:35'),
(4, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:22:02', '2025-07-07 20:22:11'),
(5, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:27:25', '2025-07-07 20:27:32'),
(6, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:29:44', '2025-07-08 20:27:48'),
(7, 'Tempat ibadah baru ditambahkan', NULL, NULL, NULL, NULL, 'Ibadah', 1, '2025-07-07 20:31:07', '2025-07-08 20:28:28'),
(8, 'Tempat ibadah baru ditambahkan', NULL, NULL, 'http://127.0.0.1:8000/admin/ibadah?8', NULL, 'Ibadah', 1, '2025-07-08 02:03:49', '2025-07-08 02:04:03'),
(9, 'Menambahkan Lokasi Rumah Sakit ', NULL, NULL, NULL, NULL, 'sehat', 1, '2025-07-08 02:04:46', '2025-07-08 02:04:53'),
(10, 'Lokasi Pasar telah ditambahkan', NULL, NULL, 'http://127.0.0.1:8000/admin/pasar?2', NULL, 'Pasar', 1, '2025-07-08 19:08:11', '2025-07-08 19:37:00'),
(11, 'Lokasi Pasar telah ditambahkan', NULL, NULL, 'http://127.0.0.1:8000/admin/pasar?3', NULL, 'Pasar', 1, '2025-07-08 19:10:05', '2025-07-08 20:07:33'),
(12, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:19:53', '2025-07-08 20:19:53'),
(13, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:24:50', '2025-07-08 20:24:50'),
(14, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:26:26', '2025-07-08 20:26:26'),
(15, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:07', '2025-07-08 20:27:07'),
(16, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:10', '2025-07-08 20:27:10'),
(17, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:14', '2025-07-08 20:27:14'),
(18, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:17', '2025-07-08 20:27:17'),
(19, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:27:21', '2025-07-08 20:27:21'),
(20, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:28:12', '2025-07-08 20:28:12'),
(21, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:33:11', '2025-07-08 20:33:11'),
(22, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:33:32', '2025-07-08 20:33:32'),
(23, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:39:20', '2025-07-08 20:39:20'),
(24, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-08 20:39:44', '2025-07-08 20:39:44'),
(25, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 20:46:22', '2025-07-08 20:46:22'),
(26, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 20:57:38', '2025-07-08 20:57:38'),
(27, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:06', '2025-07-08 21:00:06'),
(28, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:35', '2025-07-08 21:00:35'),
(29, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:00:59', '2025-07-08 21:00:59'),
(30, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:02:53', '2025-07-08 21:02:53'),
(31, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:46', '2025-07-08 21:03:46'),
(32, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:51', '2025-07-08 21:03:51'),
(33, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:03:57', '2025-07-08 21:03:57'),
(34, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:04:01', '2025-07-08 21:04:01'),
(35, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 21:04:06', '2025-07-08 21:04:06'),
(36, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-08 23:59:07', '2025-07-08 23:59:07'),
(37, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 00:36:05', '2025-07-09 00:36:05'),
(38, 'Menambahkan Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 00:43:41', '2025-07-09 00:43:41'),
(39, 'Menambahkan Rumah Sakit', NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 00:54:05', '2025-07-09 00:54:05'),
(40, 'Mengubah Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 01:06:02', '2025-07-09 01:06:02'),
(41, 'Menghapus Pengaduan Masyarakat', NULL, NULL, NULL, NULL, 'Pengaduan Masyarakat', 0, '2025-07-09 01:06:23', '2025-07-09 01:06:23'),
(42, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-09 19:45:28', '2025-07-09 19:45:28'),
(43, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 19:45:47', '2025-07-09 19:45:47'),
(44, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-07-09 19:45:52', '2025-07-09 19:45:52'),
(45, 'Menghapus Rumah Sakit', NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 19:46:04', '2025-07-09 19:46:04'),
(46, 'Menghapus Rumah Sakit', NULL, NULL, NULL, NULL, 'Rumah Sakit', 0, '2025-07-09 19:46:09', '2025-07-09 19:46:09'),
(47, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:27:57', '2025-07-10 19:27:57'),
(48, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:28:32', '2025-07-10 19:28:32'),
(49, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:30:06', '2025-07-10 19:30:06'),
(50, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:30:13', '2025-07-10 19:30:13'),
(51, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:36:53', '2025-07-10 19:36:53'),
(52, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:39:42', '2025-07-10 19:39:42'),
(53, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:43:37', '2025-07-10 19:43:37'),
(54, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:47:28', '2025-07-10 19:47:28'),
(55, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:49:25', '2025-07-10 19:49:25'),
(56, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:51:22', '2025-07-10 19:51:22'),
(57, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 19:57:39', '2025-07-10 19:57:39'),
(58, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:01:08', '2025-07-10 20:01:08'),
(59, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:03:54', '2025-07-10 20:03:54'),
(60, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:06:30', '2025-07-10 20:06:30'),
(61, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:06:36', '2025-07-10 20:06:36'),
(62, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:07:47', '2025-07-10 20:07:47'),
(63, 'Menambahkan Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:16:05', '2025-07-10 20:16:05'),
(64, 'Menghapus Sehat', NULL, NULL, NULL, NULL, 'Sehat', 0, '2025-07-10 20:16:15', '2025-07-10 20:16:15'),
(65, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:14:00', '2025-07-15 00:14:00'),
(66, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:15:08', '2025-07-15 00:15:08'),
(67, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:25:03', '2025-07-15 00:25:03'),
(68, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 00:44:25', '2025-07-15 00:44:25'),
(69, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 19:28:15', '2025-07-15 19:28:15'),
(70, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 19:28:55', '2025-07-15 19:28:55'),
(71, 'Menghapus Aduan Sekolah', NULL, NULL, NULL, NULL, 'Aduan Sekolah', 0, '2025-07-15 23:29:08', '2025-07-15 23:29:08'),
(72, 'Menambahkan Renbang', NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 18:55:56', '2025-07-17 18:55:56'),
(73, 'Menambahkan Renbang', NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:07:49', '2025-07-17 19:07:49'),
(74, 'Mengubah Renbang', NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:14:35', '2025-07-17 19:14:35'),
(75, 'Mengubah Renbang', NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-17 19:14:55', '2025-07-17 19:14:55'),
(76, 'Menghapus Renbang', NULL, NULL, NULL, NULL, 'Renbang', 0, '2025-07-20 18:37:16', '2025-07-20 18:37:16'),
(77, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:23:47', '2025-07-23 21:23:47'),
(78, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:49:50', '2025-07-23 21:49:50'),
(79, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 21:51:00', '2025-07-23 21:51:00'),
(80, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 23:28:53', '2025-07-23 23:28:53'),
(81, 'Menambahkan Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-23 23:35:51', '2025-07-23 23:35:51'),
(82, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:24:58', '2025-07-24 01:24:58'),
(83, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:25:04', '2025-07-24 01:25:04'),
(84, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:36:19', '2025-07-24 01:36:19'),
(85, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-24 01:36:26', '2025-07-24 01:36:26'),
(86, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-27 20:41:45', '2025-07-27 20:41:45'),
(87, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-27 20:41:52', '2025-07-27 20:41:52'),
(88, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-28 00:23:01', '2025-07-28 00:23:01'),
(89, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-30 21:34:41', '2025-07-30 21:34:41'),
(90, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-07-30 21:36:13', '2025-07-30 21:36:13'),
(91, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-01 01:06:04', '2025-08-01 01:06:04'),
(92, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-01 01:09:16', '2025-08-01 01:09:16'),
(93, 'Menghapus Plesir', NULL, NULL, NULL, NULL, 'Plesir', 0, '2025-08-07 18:25:35', '2025-08-07 18:25:35'),
(94, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-18 21:06:31', '2025-08-18 21:06:31'),
(95, 'Info keagamaan baru ditambahkan: Pengajian rock n dut', NULL, NULL, 'InfoKeagamaan', NULL, 'create', 0, '2025-08-18 21:21:10', '2025-08-18 21:21:10'),
(96, 'Info keagamaan baru ditambahkan: Pengajian rock n roll', NULL, NULL, 'create', NULL, 'InfoKeagamaan', 0, '2025-08-18 21:28:56', '2025-08-18 21:28:56'),
(97, 'Info keagamaan baru ditambahkan: ', NULL, NULL, 'create', NULL, 'InfoKeagamaan', 0, '2025-08-19 00:09:54', '2025-08-19 00:09:54'),
(98, 'Info keagamaan diperbarui ', NULL, NULL, 'update', 11, 'InfoKeagamaan', 0, '2025-08-19 00:13:37', '2025-08-19 00:13:37'),
(99, 'Info keagamaan dihapus ', NULL, NULL, 'delete', 10, 'InfoKeagamaan', 0, '2025-08-19 00:16:33', '2025-08-19 00:16:33'),
(100, 'create', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:23:35', '2025-08-19 00:23:35'),
(101, 'InfoKeagamaan', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:34:37', '2025-08-19 00:34:37'),
(102, 'Tempat ibadah telah ditambahkanGereja Babadan', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 00:37:50', '2025-08-19 00:37:50'),
(103, 'Tempat ibadah diperbarui: Gereja Santo Babadan 1', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 18:57:25', '2025-08-19 18:57:25'),
(104, 'Menghapus Ibadah', NULL, NULL, NULL, NULL, 'Ibadah', 0, '2025-08-19 18:59:47', '2025-08-19 18:59:47'),
(105, 'Menghapus Tempat ibadah', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:01:24', '2025-08-19 19:01:24'),
(106, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:09:38', '2025-08-19 19:09:38'),
(107, 'Info keagamaan telah diperbarui', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:12:08', '2025-08-19 19:12:08'),
(108, 'Info keagamaan telah dihapus', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-19 19:13:49', '2025-08-19 19:13:49'),
(109, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 19:38:46', '2025-08-19 19:38:46'),
(110, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 19:42:47', '2025-08-19 19:42:47'),
(111, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 20:05:55', '2025-08-19 20:05:55'),
(112, 'Menghapus Pasar', NULL, NULL, NULL, NULL, 'Pasar', 0, '2025-08-19 20:07:16', '2025-08-19 20:07:16'),
(113, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:08:21', '2025-08-19 20:08:21'),
(114, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:13:29', '2025-08-19 20:13:29'),
(115, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:15:19', '2025-08-19 20:15:19'),
(116, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:22:50', '2025-08-19 20:22:50'),
(117, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:23:44', '2025-08-19 20:23:44'),
(118, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:20', '2025-08-19 20:27:20'),
(119, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:27', '2025-08-19 20:27:27'),
(120, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:31', '2025-08-19 20:27:31'),
(121, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:27:42', '2025-08-19 20:27:42'),
(122, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:31:00', '2025-08-19 20:31:00'),
(123, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:31:33', '2025-08-19 20:31:33'),
(124, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 20:58:42', '2025-08-19 20:58:42'),
(125, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:09:46', '2025-08-19 21:09:46'),
(126, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:09:59', '2025-08-19 21:09:59'),
(127, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:12:16', '2025-08-19 21:12:16'),
(128, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:12:31', '2025-08-19 21:12:31'),
(129, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-19 21:27:43', '2025-08-19 21:27:43'),
(130, 'Lokasi Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:35:45', '2025-08-19 21:35:45'),
(131, 'Lokasi Plesir telah diupdate', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:36:22', '2025-08-19 21:36:22'),
(132, 'Menghapus Tempat Plesir', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:36:35', '2025-08-19 21:36:35'),
(133, 'Info Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:41:04', '2025-08-19 21:41:04'),
(134, 'Info Plesir telah diupdate', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:42:13', '2025-08-19 21:42:13'),
(135, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-19 21:42:28', '2025-08-19 21:42:28'),
(136, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:47:45', '2025-08-19 21:47:45'),
(137, 'Lokasi Kesehatan telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:49:10', '2025-08-19 21:49:10'),
(138, 'Menghapus Lokasi Kesehatan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:49:23', '2025-08-19 21:49:23'),
(139, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:52:38', '2025-08-19 21:52:38'),
(140, 'Menghapus Lokasi Kesehatan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-19 21:52:42', '2025-08-19 21:52:42'),
(141, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:03:27', '2025-08-19 22:03:27'),
(142, 'Lokasi Sekolah telah diupdate', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:04:02', '2025-08-19 22:04:02'),
(143, 'Lokasi Sekolah telah dihapus', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-19 22:04:11', '2025-08-19 22:04:11'),
(144, 'Info Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:04:24', '2025-08-20 21:04:24'),
(145, 'Info Pasar telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:12:59', '2025-08-20 21:12:59'),
(146, 'Info Pasar telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-08-20 21:15:39', '2025-08-20 21:15:39'),
(147, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 18:59:21', '2025-08-21 18:59:21'),
(148, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 18:59:50', '2025-08-21 18:59:50'),
(149, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 19:00:29', '2025-08-21 19:00:29'),
(150, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-21 19:03:06', '2025-08-21 19:03:06'),
(151, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-08-21 19:05:47', '2025-08-21 19:05:47'),
(152, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:23:52', '2025-08-25 00:23:52'),
(153, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:35:13', '2025-08-25 00:35:13'),
(154, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:41:48', '2025-08-25 00:41:48'),
(155, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-25 00:56:06', '2025-08-25 00:56:06'),
(156, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 20:06:59', '2025-08-26 20:06:59'),
(157, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:03:16', '2025-08-26 21:03:16'),
(158, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:41:48', '2025-08-26 21:41:48'),
(159, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:42:00', '2025-08-26 21:42:00'),
(160, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:51:27', '2025-08-26 21:51:27'),
(161, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:15', '2025-08-26 21:55:15'),
(162, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:29', '2025-08-26 21:55:29'),
(163, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 21:55:39', '2025-08-26 21:55:39'),
(164, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:20', '2025-08-26 23:21:20'),
(165, 'Tempat olahraga telah diperbarui', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:39', '2025-08-26 23:21:39'),
(166, 'Tempat olahraga telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:21:49', '2025-08-26 23:21:49'),
(167, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:30:01', '2025-08-26 23:30:01'),
(168, 'Info Kesehatan telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:35:05', '2025-08-26 23:35:05'),
(169, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-26 23:36:24', '2025-08-26 23:36:24'),
(170, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:21:27', '2025-08-27 00:21:27'),
(171, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:38:47', '2025-08-27 00:38:47'),
(172, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:47:19', '2025-08-27 00:47:19'),
(173, 'Lokasi Kesehatan telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:49:10', '2025-08-27 00:49:10'),
(174, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:49:36', '2025-08-27 00:49:36'),
(175, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:50:04', '2025-08-27 00:50:04'),
(176, 'Lokasi Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 00:57:35', '2025-08-27 00:57:35'),
(177, 'Tempat olahraga telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-08-27 01:04:49', '2025-08-27 01:04:49'),
(178, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 20:35:51', '2025-08-27 20:35:51'),
(179, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 20:49:31', '2025-08-27 20:49:31'),
(180, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:05:03', '2025-08-27 21:05:03'),
(181, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:09:02', '2025-08-27 21:09:02'),
(182, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:11:02', '2025-08-27 21:11:02'),
(183, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:16', '2025-08-27 21:15:16'),
(184, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:37', '2025-08-27 21:15:37'),
(185, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-27 21:15:44', '2025-08-27 21:15:44'),
(186, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-28 00:19:07', '2025-08-28 00:19:07'),
(187, 'Info Pajak telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-08-28 20:47:11', '2025-08-28 20:47:11'),
(188, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-08-29 00:20:22', '2025-08-29 00:20:22'),
(189, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:03:06', '2025-09-01 00:03:06'),
(190, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:09:17', '2025-09-01 00:09:17'),
(191, 'Info Kerja telah diupdate', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 00:31:36', '2025-09-01 00:31:36'),
(192, 'Info keagamaan telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-01 18:57:32', '2025-09-01 18:57:32'),
(193, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:36:52', '2025-09-01 19:36:52'),
(194, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:39:23', '2025-09-01 19:39:23'),
(195, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:48:04', '2025-09-01 19:48:04'),
(196, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:53:16', '2025-09-01 19:53:16'),
(197, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-01 19:57:57', '2025-09-01 19:57:57'),
(198, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 20:27:14', '2025-09-01 20:27:14'),
(199, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 21:12:27', '2025-09-01 21:12:27'),
(200, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 21:28:44', '2025-09-01 21:28:44'),
(201, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 23:25:59', '2025-09-01 23:25:59'),
(202, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-01 23:35:21', '2025-09-01 23:35:21'),
(203, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-02 00:12:09', '2025-09-02 00:12:09'),
(204, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-02 00:14:13', '2025-09-02 00:14:13'),
(205, 'Info Perizinan telah ditambahkan', NULL, NULL, NULL, NULL, 'Info Perizinan', 0, '2025-09-02 01:47:36', '2025-09-02 01:47:36'),
(206, 'Info Kerja telah ditambahkan', NULL, NULL, NULL, NULL, 'kerja', 0, '2025-09-02 18:28:10', '2025-09-02 18:28:10'),
(207, 'Info Kesehatan telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-02 18:57:01', '2025-09-02 18:57:01'),
(208, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 19:31:59', '2025-09-02 19:31:59'),
(209, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:12:26', '2025-09-02 20:12:26'),
(210, 'Info Sekolah telah dihapus', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:12:45', '2025-09-02 20:12:45'),
(211, 'Info Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-02 20:13:23', '2025-09-02 20:13:23'),
(212, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:26:15', '2025-09-02 21:26:15'),
(213, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:26:43', '2025-09-02 21:26:43'),
(214, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:27:28', '2025-09-02 21:27:28'),
(215, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:28:35', '2025-09-02 21:28:35'),
(216, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:29:23', '2025-09-02 21:29:23'),
(217, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-02 21:30:52', '2025-09-02 21:30:52'),
(218, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-03 00:18:10', '2025-09-03 00:18:10'),
(219, 'Info Sekolah telah diupdate', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-03 01:42:53', '2025-09-03 01:42:53'),
(220, 'Info Sekolah telah diupdate', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-03 01:51:19', '2025-09-03 01:51:19'),
(221, 'Menghapus dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-03 02:00:29', '2025-09-03 02:00:29'),
(222, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-08 21:11:18', '2025-09-08 21:11:18'),
(223, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 00:43:54', '2025-09-09 00:43:54'),
(224, 'Tempat ibadah telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 00:45:07', '2025-09-09 00:45:07'),
(225, 'Tempat ibadah diperbarui', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:50:57', '2025-09-09 01:50:57'),
(226, 'Tempat ibadah diperbarui', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:52:11', '2025-09-09 01:52:11'),
(227, 'Menghapus Tempat ibadah', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-09 01:53:59', '2025-09-09 01:53:59'),
(228, 'Menambahkan dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:01:33', '2025-09-18 19:01:33'),
(229, 'Menghapus dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:11:30', '2025-09-18 19:11:30'),
(230, 'Menghapus dumas', NULL, NULL, NULL, NULL, 'dumas', 0, '2025-09-18 19:15:04', '2025-09-18 19:15:04'),
(231, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28'),
(232, 'Lokasi Kesehatan telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28'),
(233, 'Lokasi Kesehatan telah diupdate', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24'),
(234, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24'),
(235, 'Lokasi Kesehatan telah diupdate', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49'),
(236, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49'),
(237, 'Lokasi Kesehatan telah dihapus', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 20:11:56', '2025-09-21 20:11:56'),
(238, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:23:41', '2025-09-21 21:23:41'),
(239, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:24:32', '2025-09-21 21:24:32'),
(240, 'Lokasi Kesehatan telah dihapus', 'admindinas', 'kesehatan', NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-21 21:34:02', '2025-09-21 21:34:02'),
(241, 'Info Adminduk telah ditambahkan', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-21 23:44:06', '2025-09-21 23:44:06'),
(242, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-23 07:28:57', '2025-09-23 07:28:57'),
(243, 'Info Pajak telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-23 18:24:18', '2025-09-23 18:24:18'),
(244, 'Info Pajak telah diupdate', 'admindinas', 'perpajakan', 'http://192.168.255.96:8000/admin/pajak/info', 1, 'info_pajak', 0, '2025-09-23 18:45:41', '2025-09-23 18:45:41'),
(245, 'Lokasi Sekolah telah ditambahkan', NULL, NULL, NULL, NULL, 'sekolah', 0, '2025-09-29 23:40:30', '2025-09-29 23:40:30'),
(246, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:15', '2025-09-30 00:02:15'),
(247, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:22', '2025-09-30 00:02:22'),
(248, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:29', '2025-09-30 00:02:29'),
(249, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:02:40', '2025-09-30 00:02:40'),
(250, 'Lokasi Kesehatan telah diupdate', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:05:57', '2025-09-30 00:05:57'),
(251, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:13:47', '2025-09-30 00:13:47'),
(252, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:13:55', '2025-09-30 00:13:55'),
(253, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:14:02', '2025-09-30 00:14:02'),
(254, 'Lokasi Kesehatan telah dihapus', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:14:36', '2025-09-30 00:14:36'),
(255, 'Tempat olahraga telah ditambahkan', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 00:42:25', '2025-09-30 00:42:25'),
(256, 'Menghapus Lokasi pasar', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:41:11', '2025-09-30 01:41:11'),
(257, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:45:40', '2025-09-30 01:45:40'),
(258, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:45:55', '2025-09-30 01:45:55'),
(259, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:46:00', '2025-09-30 01:46:00'),
(260, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 01:46:28', '2025-09-30 01:46:28'),
(261, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 01:55:04', '2025-09-30 01:55:04'),
(262, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:04:40', '2025-09-30 02:04:40'),
(263, 'Info Plesir telah dihapus', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:05:01', '2025-09-30 02:05:01'),
(264, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 02:06:09', '2025-09-30 02:06:09'),
(265, 'Lokasi Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:28:29', '2025-09-30 03:28:29'),
(266, 'Lokasi Plesir telah diupdate', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:29:19', '2025-09-30 03:29:19'),
(267, 'Lokasi Plesir telah dihapus', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 03:29:32', '2025-09-30 03:29:32'),
(268, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:30:50', '2025-09-30 03:30:50'),
(269, 'Lokasi Pasar telah diupdate', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:31:08', '2025-09-30 03:31:08'),
(270, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:37:17', '2025-09-30 03:37:17'),
(271, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:40:09', '2025-09-30 03:40:09'),
(272, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:41:40', '2025-09-30 03:41:40'),
(273, 'Lokasi Pasar telah ditambahkan', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:47:49', '2025-09-30 03:47:49'),
(274, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:47:56', '2025-09-30 03:47:56'),
(275, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:48:00', '2025-09-30 03:48:00'),
(276, 'Lokasi Pasar telah dihapus', NULL, NULL, NULL, NULL, 'Lokasi pasar', 0, '2025-09-30 03:48:10', '2025-09-30 03:48:10'),
(277, 'Info Plesir telah ditambahkan', NULL, NULL, NULL, NULL, 'Tempat Plesir', 0, '2025-09-30 04:05:51', '2025-09-30 04:05:51'),
(278, 'Tempat olahraga telah diperbarui', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 04:15:04', '2025-09-30 04:15:04'),
(279, 'Tempat olahraga telah diperbarui', 'superadmin', NULL, NULL, NULL, 'Lokasi Kesehatan', 0, '2025-09-30 04:18:43', '2025-09-30 04:18:43'),
(280, 'Info keagamaan telah diperbarui', NULL, NULL, NULL, NULL, 'Tempat ibadah', 0, '2025-09-30 04:37:35', '2025-09-30 04:37:35'),
(281, 'Info Adminduk telah dihapus', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:19', '2025-09-30 04:56:19'),
(282, 'Info Adminduk telah dihapus', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:25', '2025-09-30 04:56:25'),
(283, 'Info Adminduk telah diupdate', NULL, NULL, NULL, NULL, 'adminduk', 0, '2025-09-30 04:56:37', '2025-09-30 04:56:37'),
(284, 'Info Renbang telah diperbarui', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-09-30 05:02:48', '2025-09-30 05:02:48'),
(285, 'Info Renbang telah dihapus', NULL, NULL, NULL, NULL, 'renbang', 0, '2025-09-30 05:04:31', '2025-09-30 05:04:31'),
(286, 'Info Perizinan telah diupdate', NULL, NULL, NULL, NULL, 'Info Perizinan', 0, '2025-09-30 05:11:15', '2025-09-30 05:11:15');

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
(33, 1, 2, 'Kekurangan tenaga kesehatan', 'Rsud Indramayu', 'terdapat jalan berlubang cukup besar dan lumayan parah', 'bukti_laporan/enoA667bADzpUpugbYYqB9oe5ZlHkYXXs8gM9WmX.jpg', 'diproses', NULL, NULL, '2025-09-18 19:31:20', '2025-09-22 23:30:54');

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
(1, 'Pelayanan Penerbitan Surat Keterangan Kelahiran', '<figure class=\"table\"><table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tbody><tr><td><strong>1</strong></td><td><strong>Produk Pelayanan</strong></td><td><strong>Pelayanan Penerbitan Surat Keterangan Kelahiran</strong></td></tr><tr><td><strong>2</strong></td><td><strong>Persyaratan Pelayanan</strong></td><td><ul><li>KK Asli</li><li>Fotocopy KTP-el</li><li>Surat Kelahiran Asli dari Rumah Sakit</li></ul></td></tr><tr><td><strong>3.</strong></td><td><strong>Sistem Mekanisme dan Prosedur</strong></td><td><ul><li>Pemohon datang di tempat pelayanan dengan membawa persyaratan;</li><li>Petugas memeriksa kelengkapan berkas</li><li>Sekretaris Dinas melakukan validasi berkas</li><li>Kasi membubuhkan paraf</li><li>Operator mengentri data pemohon dalam komputer dan mencetak surat keterangan lahir mati</li><li>Kepala Bidang Pelayanan Pendaftaran Penduduk membubuhkan paraf dalam pada surat keterangan lahir mati</li><li>Kepala Dinas menandatangani surat keterangan lahir Petugas menyerahkan surat keterangan lahir kepada pemohon.</li></ul></td></tr><tr><td><strong>4.</strong></td><td><strong>Jangka Waktu Penyelesaian</strong></td><td><ol><li>Pendaftaran : 5 – 15 Menit</li><li>Penyelesaian : 2 (dua) hari kerja</li><li>Pengambilan : 5 – 10 Menit</li></ol></td></tr><tr><td><strong>5.</strong></td><td><strong>Biaya / Tarif</strong></td><td><strong>Tidak Dipungut Biaya / GRATIS</strong></td></tr></tbody></table></figure>', '2025-09-03 00:18:10', '2025-09-30 04:56:37', 'foto_adminduk/BUrCqSdGuwxhmv6RIksclknV7CSVs88jDRtVBVUp.jpg');

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
(4, 'Penyuluh Agama Teritorial Perkuat Program Indramayu Berzakat', '2025-08-08', '19:20:00', 'upaten Indramayu bersama Kantor Kementerian Agama (Kemenag) Indramayu dan BAZNAS Indramayu menggelar acara Pengukuhan Penyuluh Agama Teritorial se-Kabupaten Indramayu berbasis desa binaan, Senin (28/7/2025)\r\n\r\n‎\r\n‎Pengukuhan ini berlangsung di Pendopo Kabupaten Indramayu, menjadi langkah strategis untuk memperkuat peran penyuluh agama di tingkat desa, tidak hanya dalam bidang dakwah, tetapi juga dalam menyosialisasikan pentingnya zakat, infak, dan sedekah kepada masyarakat.\r\n‎\r\n‎Ketua BAZNAS Indramayu, Aspuri, dalam sambutannya menegaskan BAZNAS hadir untuk mendukung penuh pengukuhan ini dan ingin membangun sinergitas. Ke depan, penyuluh agama teritorial bisa menjadi ujung tombak dakwah zakat di desa. Zakat profesi, infak, sedekah yang dikumpulkan akan kembali dimanfaatkan untuk umat.\r\n‎\r\n‎Aspuri juga menyoroti potensi zakat yang besar di Indramayu, namun belum tergali secara maksimal. Dia menyampaikan, dengan adanya 317 desa dan kelurahan, BAZNAS merasa perlu melibatkan penyuluh agama untuk membantu menggali potensi tersebut dan menyampaikannya melalui kegiatan keagamaan yang rutin dilakukan di masyarakat.\r\n‎\r\n‎”Kami harap bapak ibu penyuluh dapat menjadi Amil di UPZ desa. Banyak masyarakat yang belum tahu harus menyalurkan zakat ke mana. Di sinilah peran bapak ibu sebagai penyuluh sekaligus duta zakat untuk meningkatkan literasi zakat di masyarakat,” lanjutnya.\r\n‎\r\n‎Sementara itu, Kepala Kantor Kementerian Agama Indramayu, Aghuts Muhaimin, menyampaikan penyuluh agama memiliki tugas besar dalam membantu pemerintah daerah mencapai visi Indramayu REANG. Menurutnya, penyuluh agama menjadi ujung tombak dalam edukasi agama, pembinaan masyarakat, dan penguatan nilai keislaman.\r\n‎\r\n‎”Penyuluh agama bertugas melakukan edukasi keagamaan, pembinaan pernikahan, pengajian, kepemudaan, hingga pencegahan stunting. Di tingkat desa, mereka adalah garda terdepan yang bersentuhan langsung dengan masyarakat,” jelasnya.\r\n‎\r\n‎Aghuts juga mengapresiasi komitmen Bupati Indramayu yang memberikan perhatian besar terhadap sektor keagamaan, termasuk pemberian hibah untuk guru madrasah dan lahan hibah untuk keperluan pembangunan keagamaan.\r\n‎\r\n‎Dalam sambutannya, Bupati Indramayu Lucky Hakim mengungkapkan rasa bangganya atas keterlibatan penyuluh agama dalam mendukung pembangunan spiritual masyarakat. Bupati berharap, penyuluh agama dapat memberikan penyuluhan keagamaan yang menyentuh hati dan membimbing masyarakat ke arah yang lebih baik.\r\n‎\r\n‎Bupati juga menekankan pentingnya penyuluhan yang berlandaskan pada dalil-dalil sahih dari Al-Qur’an dan Hadits serta menjadikan penyuluh agama sebagai mitra penting dalam pembangunan umat. Pemkab memiliki keterbatasan, tetapi dengan sinergi bersama Kemenag dan para penyuluh, Pemkab bisa mewujudkan Indramayu yang berkah dan religius.\r\n‎\r\n‎”Indramayu termasuk daerah dengan angka kemiskinan tinggi di Jawa Barat. Tugas kita bersama adalah mengangkat derajat masyarakat dan memperkuat akidah mereka. Setiap langkah iman bapak ibu sangat berharga. Selamat bertugas, semoga Allah memberkahi langkah kita semua,” tutupnya.\r\n‎\r\n‎Puncak acara ditandai dengan pengukuhan simbolis penyuluh agama teritorial oleh Bupati Indramayu, Lucky Hakim. Selain dikukuhkan, para penyuluh agama juga dinobatkan sebagai Duta Zakat BAZNAS Indramayu dan menerima surat tugas resmi dalam mendukung program Indramayu Berzakat. (Diskominfo Indramayu)', 'Masjid agung indramayu', 'Masjid Agung Indramayu, Jalan S. Parman, Indramayu, West Java, Java, 45211, Indonesia', 'foto_ibadah/KBMIt4JLLjfDSKOT7Fc9R6jtaTUBM02MJnWXj6Bw.jpg', '2025-07-30 00:20:15', '2025-09-30 04:37:35', 'Pengajian', -6.3271480, 108.3220630);

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
(1, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000.00', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/ah00SWfXliHNTwLkjWeOK0eGoZbqKwwOY5LMSnT7.png', '<p>slkfklwnfkwnlknqklnqlkfnwq</p><figure class=\"image\"><img style=\"aspect-ratio:4726/4726;\" src=\"http://192.168.255.138:8000/storage/uploads/1756780605_PasarYu.png\" width=\"4726\" height=\"4726\"></figure><p>wlkjfnkjnkjf kj</p>', '2025-09-01 19:36:52', '2025-09-01 19:36:52'),
(2, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/4LYdmvgeFYNefm0zt73weua3wxAB1JXNHl68WXcR.png', '<p>lakvlkdkmvldksmlkv</p>', '2025-09-01 19:39:23', '2025-09-01 19:39:23'),
(3, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/ys5TbVsN6iHmYd0y7Dh2LPIViNirqPFQmxcqnBE6.png', '<p>jsknkgnslnlkrklksrlnkrskl\\</p><p>&nbsp;</p>', '2025-09-01 19:48:04', '2025-09-01 19:48:04'),
(4, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/mqlYY9df7tK8WC3A4VPYpLgMarfIA2SYQ4z0o0MI.png', '<p>wjkdkjfbekfnkwkldnwklndkwndkwdnwdnlwkd</p>', '2025-09-01 19:53:16', '2025-09-01 19:53:16'),
(5, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/Qxuu0yBtlaoKoBCRmWfS9yqZY23Z9HKQU59CWRoZ.png', '<p>dkslngklrknklnrsklnkrlnknlr</p>', '2025-09-01 19:57:56', '2025-09-01 19:57:56'),
(6, 'Cv apa aja', 'CRM Operation Handling', 'Jalan Mt Haryono Indramayu', '600000-700000', '087727365758929', '07.00-16.00', 'full time', 'Lowongan', 'foto_kerja/tF7todYt8muCQnXqtRk3hI7nHRZhxBT03GfEdhcM.png', '<p>jkbfejkabfejakejfbeakjbekjabfjkabfkjbkfja</p><figure class=\"image\"><img style=\"aspect-ratio:4726/4726;\" src=\"http://192.168.255.138:8000/storage/uploads/1756862883_RenbangYu.png\" width=\"4726\" height=\"4726\"></figure>', '2025-09-02 18:28:10', '2025-09-02 18:28:10');

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
(2, 'kesehatan', 'foto_kesehatan/fvKzVe0oClXV6MH1L27yyfV3X8XYLGAbsIDY9l3O.png', 'Keseringan begadang bisa picu stroke', 'jkaLBJFLlfblLBLwblfjbvje5tkrgnk3j3k2lnjfjvbjkdvlkLNvjBVljkblvkjbvlHUUQKJBBjlbLVJKNDVJRVUIRHBVRJRBCRFFJFBRHFBRFHBRJFBRFRFBRFHBHBRRTGTNGBVTJVTJNVJBTJTJNRJGG', '2025-08-21 18:41:49', '2025-08-21 19:03:06'),
(5, 'kesehatan', 'foto_kesehatan/O6Lm71giKBX7sgJTbQ4YgVLzmXisMAuGxtWwXbnX.png', 'Keseringan begadang bisa picu stroke ringan', 'alGKHAJLKBGLKJNAKFNQKNQFJK', '2025-08-21 18:59:21', '2025-08-21 18:59:50'),
(6, 'kesehatan', 'foto_kesehatan/e384W7Hi07tbC0ehK6HP7qdsKU1tT9CTEHxABF2B.png', 'Keseringan begadang bisa picu stroke', '<p>KOMPAS.com - Kasus balita meninggal akibat cacingan di Sukabumi, Jawa Barat, menyita perhatian publik. Sekitar satu kilogram cacing dikabarkan keluar dari tubuh Raya, anak berusia empat tahun tersebut.&nbsp; Disebutkan bahwa Raya cacingan karena senang bermain di kolong rumah panggungnya, yang merupakan tanah penuh kotoran ayam. Baca juga: 10 Tanda Anak Cacingan yang Harus Diwaspadai, Berkaca dari Balita yang Meninggal akibat Cacingan Cacingan pada Anak, Jenis, Gejala, dan Pengobatannya Berkaca dari kasus Raya, berikut ragam penyebab cacingan pada anak dan orang dewasa, seperti dituturkan oleh Health Management Specialist Corporate HR Kompas Gramedia dr. Santi. Penyebab cacingan pada anak dan orang dewasa Santi mengatakan, penyebab cacingan pada anak dan orang dewasa lebih kurang sama. “Cacingan bisa terjadi ketika telur atau larva cacing masuk ke dalam tubuh manusia, ketika manusia mengonsumsi makanan atau minuman yang sudah terkontaminasi,” jelas dr. Santi kepada&nbsp;Kompas.com, Rabu (27/8/2025).&nbsp; Kronologi Tindakan Asusila Penyebab Ketua KPU Hasyim Asy’ari Diberhentikan Artikel Kompas.id Kendati demikian, ada perbedaan pada jalur masuk larva cacing ke dalam tubuh anak-anak dan orang dewasa. Larva cacing masuk ke tubuh anak Lihat Foto Kasus balita Sukabumi mengeluarkan 1 kg cacing ramai dibicarakan. Simak penjelasan dokter tentang penyebab cacingan dan langkah pencegahannya.(SHUTTERSTOCK/sumroeng chinnapan) Pada anak-anak, larva cacing lebih sering masuk ke dalam tubuh melalui kontaminasi dari kaki dan tangan ketika mereka bermain di tanah, pasir, atau tempat terbuka lainnya. “Dan bisa juga masuk melalui tangan yang tidak dicuci sebelum makan, dan masuk melalui media mainan yang tercemar,” ujar Santi. Larva cacing masuk ke tubuh orang dewasa Sementara itu, pada orang dewasa, jalur masuk larva cacing lebih beragam. Pertama adalah ketika orang dewasa mengonsumsi makanan yang tidak bersih, tidak matang sepenuhnya, atau makanan mentah, seperti lalapan, sushi, dan sashimi. Paparan larva cacing juga bisa dari lingkungan pekerjaan seperti bertani dan beternak, atau dari feses anak yang terinfeksi cacing ketika orang dewasa merawat mereka. “Misalnya saat membasuh anak setelah buang air besar dan mengganti popok anak,” kata Santi. Larva cacing juga bisa masuk ke tubuh orang dewasa yang sedang melakukan hobi yang melibatkan kontak dengan tanah atau pasir, jajan, dan menggunakan alat makan yang tercemar. “Kemungkinan penularan kepada orang dewasa juga tinggi ketika ada salah satu anggota keluarga, atau orang yang tinggal serumah, menderita infeksi cacing,” pungkas Santi.<br><br>Artikel ini telah tayang di <a href=\"https://www.kompas.com/\">Kompas.com</a> dengan judul \"Berkaca dari Kasus Raya, Ini Penyebab Cacingan pada Anak dan Orang Dewasa\", Klik untuk baca: <a href=\"https://health.kompas.com/read/25H27130500368/berkaca-dari-kasus-raya-ini-penyebab-cacingan-pada-anak-dan-orang-dewasa\">https://health.kompas.com/read/25H27130500368/berkaca-dari-kasus-raya-ini-penyebab-cacingan-pada-anak-dan-orang-dewasa</a>.<br><br><br>Kompascom+ baca berita tanpa iklan: <a href=\"https://kmp.im/plus6\">https://kmp.im/plus6</a><br>Download aplikasi: <a href=\"https://kmp.im/app6\">https://kmp.im/app6</a></p>', '2025-08-25 00:23:52', '2025-08-26 23:35:05');

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
(2, 'foto_pajak/tDi3lVnIArkxaC2Ik9dgHkn2fXJG7BvxO4luwcAn.png', 'Perpajakan makin naik dan salalu naik', '<p>j kejqlkekq elkqbfeklqbflkebqklbfklbqklbfkq</p>', '2025-09-23 18:24:18', '2025-09-23 18:24:18');

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
(1, 'Pasar Penganjang 2', 'Penganjang, Indramayu, West Java, Java, 45222, Indonesia', 'foto_pasar/1755749063_IzinYu.png', 'Pasar', -6.3233600, 108.3173780, '2025-08-20 21:04:23', '2025-08-20 21:15:38');

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
(1, 'foto_perizinan/xUZdgQbsUb7W5gfEVAQYO0dWLdEocnFcmxrRy0qG.jpg', 'Pelaku Usaha di Indramayu Diminta Taat Perizinan Termasuk PBG dan IMB', '<p>Indramayu, InfoPublik - Jajaran Satuan Polisi Pamong Praja (Satpol-PP) Kabupaten Indramayu baru-baru ini telah membuka segel yang terpasang di Hopespace Coffee &amp; Eatery Indramayu setelah pemilik memenuhi persyaratan atau izin usahanya dengan lengkap.</p><p>Seperti dikatakan Kepala Satpol-PP Kabupaten Indramayu Teguh Budiarso, pihaknya melalui Tim Penegakan Peraturan Daerah (Gakda) akan bertindak tegas bilamana terdapat tempat usaha yang masih belum melengkapi izin usaha yang ditetapkan pemerintah daerah.</p><p>Teguh menambahkan, sebagaimana keinginan Bupati Indramayu Nina Agustina Da’i Bachtiar yang membuka lebar-lebar investasi di Kabupaten Indramayu dengan memperhatikan dan mematuhi segala peraturan daerah sebagai legalitas bagi pelaku usaha.</p><p>“Kebijakan Bupati saat ini adalah membuka seluas luasnya investasi di Kabupaten Indramayu, termasuk didalamnya mengajak para pelaku usaha untuk turut meramaikan dunia kuliner, kafe dan lain-lain. Namun tentunya dengan tetap mentaati regulasi perizinan,\" katanya kepada Diskominfo Indramayu, Rabu (20/7/2022).</p><p>Dijelaskan Kasatpol-PP Kabupaten Indramayu Teguh Budiarso, persyaratan atau izin yang harus diperhatikan pelaku usaha adalah terdaftar dalam Online Single Submission (OSS) atau sistem perizinan berusaha terintegrasi secara elektronik, Nomor Induk Berusaha (NIB) dan lainnya.</p><p>\"Tidak hanya OSS atau NIB tetapi juga kelengkapan perizinan lainnya termasuk Persetujuan Bangunan Gedung (PBG) dan Izin Mendirikan Bangunan (IMB). Pelayanan perizinan di Kabupaten Indramayu Insyallah mudah dan cepat,\" jelasnya. (M/MTQ--Tim Publikasi Diskominfo Indramayu)</p>', 'usaha', '2025-09-02 01:47:36', '2025-09-30 05:11:15');

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
(16, 'Pantai Karangsong', 'M9V9+476, Blok Jl. Wanasari, Karangsong, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat', 0.00, '<p>Pantai Karangsong menawarkan keindahan pantai dengan tanaman mangrove yang lebat. Pantai ini memiliki pasir yang hitam, namun begitu halus dan nyaman. Tidak terhalang juga oleh batuan karang sehingga wisatawan dapat memandang lautan lepas. Air laut meskipun tak tampak biru, namun begitu jernih.</p><p>Ombak lautan pun tidak terlalu tinggi, sehingga banyak wisatawan yang bermain di air laut. Ada yang berenang di tepian pantai, ada juga yang membawa pelampung untuk bermain. Tidak hanya itu, ada juga yang membawa perahu karet untuk bermain di tepian pantai. Perahu-perahu pun siap untuk disewa untuk menjelajah wilayah perairan.</p><p>Wilayah pasirnya begitu luas, dan tentunya terjaga kebersihannya. Di bagian belakang tepi pantai, terdapat pepohonan selain pohon mangrove. Sehingga pantai tampak begitu teduh dengan pepohonan tersebut. Wisatawan pun tampak nyaman menikmati waktu di pantai.</p>', 'foto_plesir/1759230351_karangong.jpg', 'wisata', '2025-09-30 04:05:51', '2025-09-30 04:05:51', -6.3056211, 108.3686042);

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
(3, 'foto_sekolah/FmklwlEMnEwNBRX09nFqcrRSRgjreYHkdIPZ87oT.jpg', 'Keseringan begadang bisa picu stroke', '<p>CKJE CKJEBVEVKJWnjkfjke jkenvknekjvejkhgeoihgio</p><figure class=\"image\"><img style=\"aspect-ratio:225/225;\" src=\"http://192.168.254.209:8000/storage/foto_sekolah/1756353892_lawasan.png\" width=\"225\" height=\"225\"></figure><p>hjkNCSJKABCJHBSJABC</p>', '2025-08-27 21:05:02', '2025-08-27 21:05:02'),
(4, 'foto_sekolah/AIQ3pvEs2hu4AUNUSn8Nh4cu4tsVswaquVL9jnRr.jpg', 'Pengajian rock n roll', '<p>kjsvnkjsnvsklvnlksnvlfklnvskvnkslvnsfklvnkvk</p><figure class=\"image\"><img style=\"aspect-ratio:1000/667;\" src=\"http://192.168.254.209:8000/storage/foto_sekolah/1756354128_Gerejasantomekail-Indramayu.jpg\" width=\"1000\" height=\"667\"></figure><p>djkbv lkknvakjkqbjkabjhavcjha</p>', '2025-08-27 21:09:01', '2025-08-27 21:09:01'),
(5, 'foto_sekolah/lyit8oHDIWLYjyv2MAcepAGXa9pnCrpvZdehbA4X.jpg', 'Pengajian rock n roll', '<p>wkjwbfkjwbfkjbjwfbkjwshvhjbejkve</p><figure class=\"image\"><img style=\"aspect-ratio:225/225;\" src=\"http://192.168.254.209:8000/storage/foto_sekolah/1756354253_lawasan.png\" width=\"225\" height=\"225\"></figure><p>dklwbckwkcjw</p>', '2025-08-27 21:11:02', '2025-08-27 21:11:02'),
(6, 'foto_sekolah/s4lp3QSaZb6nDKusxKxlxO3VR1hzz7QoblvugXpq.png', 'Keseringan begadang bisa picu stroke', '<p>s,MFCKDJnkwfjkbwfkjnkjfw kjf kw fwnjfknwkj</p><figure class=\"image\"><img style=\"aspect-ratio:225/225;\" src=\"http://192.168.254.209:8000/storage/foto_sekolah/1756354509_lawasan.png\" width=\"225\" height=\"225\"></figure><p>akfbjkabjkeabjkbfjkaebfjkaf</p>', '2025-08-27 21:15:16', '2025-08-27 21:15:16'),
(7, 'foto_sekolah/RLHDnVpyIWfZ0bzHEh44a5dF9FEzfkq6YQf3qw92.png', 'Pesona Pantai kesambi balongan', '<figure class=\"table\"><table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tbody><tr><td>ejkafkjajkfb</td><td>sjvhfhjvfhe</td><td>fejkfbejf,</td></tr><tr><td>jkefbejkfbe</td><td>femfhejjfme</td><td>fekjbfejkfb</td></tr><tr><td>sjkcbkjfb</td><td>jbdjhwf</td><td>lfhwjkbf</td></tr></tbody></table></figure>', '2025-09-02 19:31:59', '2025-09-02 19:31:59'),
(9, 'foto_sekolah/smjdEmdgTu3STK3huDvdDngRDVUgVn21e1QAV00E.png', 'Pengajian rock n dut', '<figure class=\"table\"><table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tbody><tr><td>jkbkjbkscs</td><td>skcbajcaac</td><td>csjkcjks</td></tr><tr><td>kjscbjs</td><td>c sjkcbsjs</td><td>cjksbcjk</td></tr><tr><td>scbkssc</td><td>c,ms,cm s</td><td>sjcbkjsb</td></tr></tbody></table></figure>', '2025-09-02 20:13:23', '2025-09-03 01:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `nama`, `jenis`) VALUES
(1, 'Dinas komunikasi dan informatika', 'Dinas'),
(2, 'Dinas kesehatan', 'Dinas'),
(3, 'Dinas Pendidikan', 'Dinas');

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
(38, 'Info perizinan', 'usaha', '2025-09-30 05:07:58', '2025-09-30 05:07:58');

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
  `dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi_aktivitas`
--

INSERT INTO `notifikasi_aktivitas` (`id`, `keterangan`, `dibaca`, `created_at`, `updated_at`, `url`, `role`, `dinas`) VALUES
(1, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:26:26', '2025-07-08 20:32:57', NULL, NULL, NULL),
(2, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:07', '2025-07-08 20:32:52', NULL, NULL, NULL),
(3, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:10', '2025-07-08 20:32:42', NULL, NULL, NULL),
(4, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:14', '2025-07-08 20:32:49', NULL, NULL, NULL),
(5, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:17', '2025-07-08 20:32:28', NULL, NULL, NULL),
(6, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:27:21', '2025-07-08 20:32:37', NULL, NULL, NULL),
(7, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:28:12', '2025-07-08 20:32:19', NULL, NULL, NULL),
(8, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:33:11', '2025-07-08 20:37:51', NULL, NULL, NULL),
(9, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:33:32', '2025-07-08 20:33:39', NULL, NULL, NULL),
(10, 'Pasar baru telah dihapus.', 1, '2025-07-08 20:39:20', '2025-07-08 20:39:25', NULL, NULL, NULL),
(11, 'Pasar baru telah ditambahkan.', 1, '2025-07-08 20:39:44', '2025-07-08 20:39:51', NULL, NULL, NULL),
(12, 'Ibadah baru telah dihapus.', 1, '2025-07-08 20:46:22', '2025-07-08 20:46:29', NULL, NULL, NULL),
(13, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 20:57:38', '2025-07-08 23:45:10', NULL, NULL, NULL),
(14, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 21:00:35', '2025-07-08 21:03:27', NULL, NULL, NULL),
(15, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 21:02:54', '2025-07-08 21:03:19', NULL, NULL, NULL),
(16, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:46', '2025-07-08 23:44:59', NULL, NULL, NULL),
(17, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:51', '2025-07-08 23:44:41', NULL, NULL, NULL),
(18, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:03:57', '2025-07-08 21:14:50', NULL, NULL, NULL),
(19, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:04:02', '2025-07-08 21:06:21', NULL, NULL, NULL),
(20, 'Ibadah baru telah dihapus.', 1, '2025-07-08 21:04:06', '2025-07-08 21:06:15', NULL, NULL, NULL),
(21, 'Ibadah baru telah ditambahkan.', 1, '2025-07-08 23:58:03', '2025-07-08 23:58:14', NULL, NULL, NULL),
(22, 'Ibadah baru telah dihapus.', 1, '2025-07-08 23:59:08', '2025-07-08 23:59:19', NULL, NULL, NULL),
(23, 'Ibadah baru telah ditambahkan.', 1, '2025-07-09 00:36:05', '2025-07-09 00:36:13', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(24, 'Pasar baru telah ditambahkan.', 1, '2025-07-09 00:43:41', '2025-07-09 00:43:49', 'http://127.0.0.1:8000/admin/pasar', NULL, NULL),
(25, 'Rumah Sakit baru telah ditambahkan.', 1, '2025-07-09 00:54:05', '2025-07-09 00:54:13', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(26, 'Ibadah baru telah diubah.', 1, '2025-07-09 01:06:02', '2025-07-09 19:44:24', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(27, 'Pengaduan Masyarakat baru telah dihapus.', 1, '2025-07-09 01:06:23', '2025-07-09 19:44:15', 'http://127.0.0.1:8000/admin/pengaduan', NULL, NULL),
(28, 'Ibadah baru telah dihapus.', 1, '2025-07-09 19:45:28', '2025-07-10 01:44:49', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(29, 'Pasar baru telah dihapus.', 1, '2025-07-09 19:45:47', '2025-07-10 01:44:53', 'http://127.0.0.1:8000/admin/pasar', NULL, NULL),
(30, 'Pasar baru telah dihapus.', 1, '2025-07-09 19:45:53', '2025-07-10 01:44:46', 'http://127.0.0.1:8000/admin/pasar', NULL, NULL),
(31, 'Rumah Sakit baru telah dihapus.', 1, '2025-07-09 19:46:04', '2025-07-10 01:44:40', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(32, 'Rumah Sakit baru telah dihapus.', 1, '2025-07-09 19:46:09', '2025-07-10 01:19:34', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(33, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:27:57', '2025-07-10 19:29:37', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(34, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:28:32', '2025-07-10 19:28:45', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(35, 'Sehat baru telah dihapus.', 1, '2025-07-10 19:30:06', '2025-07-10 20:08:24', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(36, 'Sehat baru telah dihapus.', 1, '2025-07-10 19:30:13', '2025-07-10 19:56:13', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(37, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:36:53', '2025-07-10 19:53:41', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(38, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 19:51:22', '2025-07-10 19:53:31', 'http://127.0.0.1:8000/admin/sehat', NULL, NULL),
(39, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:01:08', '2025-07-10 20:08:22', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(40, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:03:54', '2025-07-10 20:08:02', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(41, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:06:30', '2025-07-10 20:08:19', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(42, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:06:36', '2025-07-10 20:08:17', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(43, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:07:48', '2025-07-10 20:07:54', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(44, 'Sehat baru telah ditambahkan.', 1, '2025-07-10 20:16:05', '2025-07-10 20:16:11', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(45, 'Sehat baru telah dihapus.', 1, '2025-07-10 20:16:15', '2025-07-11 02:03:35', 'http://127.0.0.1:8000/admin/admin/sehat/tempat', NULL, NULL),
(46, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:14:00', '2025-07-15 19:20:33', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, NULL),
(47, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:15:08', '2025-07-15 19:06:38', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, NULL),
(48, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:25:03', '2025-07-15 18:58:39', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, NULL),
(49, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 00:44:25', '2025-07-15 18:10:52', 'http://127.0.0.1:8000/admin/sekolah/aduan', NULL, NULL),
(50, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 19:27:32', '2025-07-15 19:28:50', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(51, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 19:27:49', '2025-07-15 19:28:40', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(52, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 19:28:15', '2025-07-15 19:28:33', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(53, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 19:28:56', '2025-07-15 19:31:15', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(54, 'Aduan Sekolah baru telah ditambahkan.', 1, '2025-07-15 23:17:39', '2025-07-15 23:35:11', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(55, 'Aduan Sekolah telah dihapus.', 1, '2025-07-15 23:29:09', '2025-07-15 23:32:08', 'http://127.0.0.1:8000/admin/sekolah', NULL, NULL),
(56, 'Renbang baru telah ditambahkan.', 1, '2025-07-17 18:55:56', '2025-07-23 01:34:55', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, NULL),
(57, 'Renbang baru telah ditambahkan.', 1, '2025-07-17 19:07:49', '2025-07-20 18:34:16', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, NULL),
(58, 'Renbang telah diubah.', 1, '2025-07-17 19:14:35', '2025-07-18 00:48:18', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, NULL),
(59, 'Renbang telah diubah.', 1, '2025-07-17 19:14:55', '2025-07-17 21:07:33', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, NULL),
(60, 'Renbang telah dihapus.', 1, '2025-07-20 18:37:16', '2025-07-20 21:29:09', 'http://127.0.0.1:8000/admin/admin/renbang/deskripsi', NULL, NULL),
(61, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:23:47', '2025-07-29 19:01:01', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(62, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:49:50', '2025-07-30 00:29:48', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(63, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 21:51:00', '2025-07-30 01:00:37', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(64, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 23:28:53', '2025-07-23 23:35:25', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(65, 'Ibadah baru telah ditambahkan.', 1, '2025-07-23 23:35:52', '2025-08-12 01:59:45', 'http://127.0.0.1:8000/admin/ibadah', NULL, NULL),
(66, 'Ibadah telah dihapus.', 1, '2025-07-24 01:24:58', '2025-08-18 21:03:28', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(67, 'Ibadah telah dihapus.', 1, '2025-07-24 01:25:04', '2025-08-18 21:05:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(68, 'Ibadah telah dihapus.', 1, '2025-07-24 01:36:19', '2025-08-18 21:06:05', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(69, 'Ibadah telah dihapus.', 1, '2025-07-24 01:36:26', '2025-07-27 20:39:41', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(70, 'Ibadah telah dihapus.', 1, '2025-07-27 20:41:45', '2025-07-28 21:29:33', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(71, 'Ibadah telah dihapus.', 1, '2025-07-27 20:41:52', '2025-07-28 04:01:37', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(72, 'Ibadah telah dihapus.', 1, '2025-07-28 00:23:01', '2025-07-28 04:01:25', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(73, 'Ibadah telah dihapus.', 1, '2025-07-30 21:34:41', '2025-08-18 21:06:10', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(74, 'Ibadah telah dihapus.', 1, '2025-07-30 21:36:13', '2025-08-18 21:06:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(75, 'Ibadah telah dihapus.', 1, '2025-08-01 01:06:04', '2025-08-18 21:06:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(76, 'Ibadah telah dihapus.', 1, '2025-08-01 01:09:16', '2025-08-18 21:06:20', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(77, 'Plesir telah dihapus.', 1, '2025-08-07 18:25:35', '2025-08-18 21:05:50', 'http://127.0.0.1:8000/admin/admin/plesir/tempat', NULL, NULL),
(78, 'Ibadah telah dihapus.', 1, '2025-08-18 21:06:31', '2025-08-18 21:06:37', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(79, 'Ibadah baru telah ditambahkan.', 0, '2025-08-19 00:23:35', '2025-08-19 00:23:35', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(80, 'Tempat Ibadah telah ditambahkan.', 1, '2025-08-19 00:37:50', '2025-08-19 18:46:07', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(81, 'Tempat Ibadah diperbarui: Gereja Santo Babadan 1', 0, '2025-08-19 18:57:25', '2025-08-19 18:57:25', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(82, 'Ibadah telah dihapus.', 0, '2025-08-19 18:59:47', '2025-08-19 18:59:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(83, 'Tempat ibadah telah dihapus.', 0, '2025-08-19 19:01:24', '2025-08-19 19:01:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(84, 'Info keagamaan telah ditambahkan.', 0, '2025-08-19 19:09:38', '2025-08-19 19:09:38', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(85, 'Info keagamaan telah diperbarui', 0, '2025-08-19 19:12:08', '2025-08-19 19:12:08', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(86, 'Info keagamaan telah dihapus', 0, '2025-08-19 19:13:49', '2025-08-19 19:13:49', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(87, 'Tempat Ibadah telah ditambahkan.', 0, '2025-08-19 19:38:46', '2025-08-19 19:38:46', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(88, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 19:42:47', '2025-08-19 19:42:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(89, 'Pasar telah dihapus.', 0, '2025-08-19 20:05:55', '2025-08-19 20:05:55', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(90, 'Pasar telah dihapus.', 0, '2025-08-19 20:07:16', '2025-08-19 20:07:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(91, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:08:21', '2025-08-19 20:08:21', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(92, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:13:29', '2025-08-19 20:13:29', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(93, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:15:19', '2025-08-19 20:15:19', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(94, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:22:50', '2025-08-19 20:22:50', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(95, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:23:44', '2025-08-19 20:23:44', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(96, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:27:20', '2025-08-19 20:27:20', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(97, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:27', '2025-08-19 20:27:27', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(98, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:31', '2025-08-19 20:27:31', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(99, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:27:42', '2025-08-19 20:27:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(100, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:31:00', '2025-08-19 20:31:00', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(101, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 20:31:33', '2025-08-19 20:31:33', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(102, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 20:58:42', '2025-08-19 20:58:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(103, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 21:09:46', '2025-08-19 21:09:46', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(104, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 21:09:59', '2025-08-19 21:09:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(105, 'Lokasi pasar telah dihapus.', 0, '2025-08-19 21:12:16', '2025-08-19 21:12:16', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(106, 'Lokasi Pasar telah ditambahkan', 0, '2025-08-19 21:12:31', '2025-08-19 21:12:31', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(107, 'Lokasi Pasar telah diupdate', 0, '2025-08-19 21:27:43', '2025-08-19 21:27:43', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(108, 'Lokasi Plesir telah ditambahkan', 0, '2025-08-19 21:35:45', '2025-08-19 21:35:45', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(109, 'Lokasi Plesir telah diupdate', 0, '2025-08-19 21:36:22', '2025-08-19 21:36:22', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(110, 'Tempat Plesir telah dihapus.', 0, '2025-08-19 21:36:35', '2025-08-19 21:36:35', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(111, 'Info Pasar telah ditambahkan', 0, '2025-08-19 21:41:04', '2025-08-19 21:41:04', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(112, 'Info Plesir telah diupdate', 0, '2025-08-19 21:42:13', '2025-08-19 21:42:13', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(113, 'Info Plesir telah dihapus', 0, '2025-08-19 21:42:28', '2025-08-19 21:42:28', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(114, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-19 21:47:45', '2025-08-19 21:47:45', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(115, 'Lokasi Kesehatan telah diupdate', 0, '2025-08-19 21:49:10', '2025-08-19 21:49:10', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(116, 'Lokasi Kesehatan telah dihapus.', 0, '2025-08-19 21:49:23', '2025-08-19 21:49:23', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(117, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-19 21:52:38', '2025-08-19 21:52:38', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(118, 'Lokasi Kesehatan telah dihapus.', 0, '2025-08-19 21:52:42', '2025-08-19 21:52:42', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(119, 'Lokasi Sekolah telah ditambahkan', 0, '2025-08-19 22:03:27', '2025-08-19 22:03:27', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(120, 'Lokasi Sekolah telah diupdate', 0, '2025-08-19 22:04:02', '2025-08-19 22:04:02', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(121, 'Lokasi Sekolah telah dihapus', 0, '2025-08-19 22:04:11', '2025-08-19 22:04:11', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(122, 'Info Pasar telah ditambahkan', 0, '2025-08-20 21:04:24', '2025-08-20 21:04:24', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(123, 'Info Pasar telah diupdate', 0, '2025-08-20 21:12:59', '2025-08-20 21:12:59', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(124, 'Info Pasar telah diupdate', 0, '2025-08-20 21:15:39', '2025-08-20 21:15:39', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(125, 'Info Kesehatan telah ditambahkan', 0, '2025-08-21 18:59:21', '2025-08-21 18:59:21', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(126, 'Info Kesehatan telah diupdate', 0, '2025-08-21 18:59:50', '2025-08-21 18:59:50', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(127, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-21 19:00:29', '2025-08-21 19:00:29', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(128, 'Info Kesehatan telah diupdate', 0, '2025-08-21 19:03:06', '2025-08-21 19:03:06', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(129, 'Info Plesir telah ditambahkan', 0, '2025-08-21 19:05:47', '2025-08-21 19:05:47', 'http://127.0.0.1:8000/admin/ibadah/tempat', NULL, NULL),
(130, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-22 00:27:55', '2025-08-22 00:27:55', 'http://192.168.254.30:8000/admin/sehat/tempat', NULL, NULL),
(131, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:23:52', '2025-08-25 00:23:52', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, NULL),
(132, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:35:13', '2025-08-25 00:35:13', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, NULL),
(133, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:41:48', '2025-08-25 00:41:48', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, NULL),
(134, 'Info Kesehatan telah ditambahkan', 0, '2025-08-25 00:56:06', '2025-08-25 00:56:06', 'http://192.168.254.49:8000/admin/sehat/tempat', NULL, NULL),
(135, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 20:06:59', '2025-08-26 20:06:59', 'http://127.0.0.1:8000/admin/sehat/tempat', NULL, NULL),
(136, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 21:03:16', '2025-08-26 21:03:16', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(137, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 21:41:48', '2025-08-26 21:41:48', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(138, 'Tempat olahraga telah dihapus', 0, '2025-08-26 21:42:00', '2025-08-26 21:42:00', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(139, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 21:51:27', '2025-08-26 21:51:27', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(140, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 21:55:15', '2025-08-26 21:55:15', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(141, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 21:55:29', '2025-08-26 21:55:29', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(142, 'Tempat olahraga telah dihapus', 0, '2025-08-26 21:55:40', '2025-08-26 21:55:40', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(143, 'Tempat olahraga telah ditambahkan', 0, '2025-08-26 23:21:20', '2025-08-26 23:21:20', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(144, 'Tempat olahraga telah diperbarui', 0, '2025-08-26 23:21:40', '2025-08-26 23:21:40', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(145, 'Tempat olahraga telah dihapus', 0, '2025-08-26 23:21:49', '2025-08-26 23:21:49', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(146, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 23:30:01', '2025-08-26 23:30:01', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(147, 'Info Kesehatan telah diupdate', 0, '2025-08-26 23:35:05', '2025-08-26 23:35:05', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(148, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-26 23:36:24', '2025-08-26 23:36:24', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(149, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:21:27', '2025-08-27 00:21:27', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(150, 'Info Kesehatan telah ditambahkan', 0, '2025-08-27 00:38:47', '2025-08-27 00:38:47', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(151, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:47:19', '2025-08-27 00:47:19', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(152, 'Lokasi Kesehatan telah diupdate', 0, '2025-08-27 00:49:10', '2025-08-27 00:49:10', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(153, 'Lokasi Kesehatan telah dihapus', 0, '2025-08-27 00:49:36', '2025-08-27 00:49:36', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(154, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:50:04', '2025-08-27 00:50:04', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(155, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-08-27 00:57:35', '2025-08-27 00:57:35', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(156, 'Tempat olahraga telah ditambahkan', 0, '2025-08-27 01:04:49', '2025-08-27 01:04:49', 'http://192.168.254.209:8000/admin/sehat/tempat', NULL, NULL),
(157, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 20:35:51', '2025-08-27 20:35:51', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(158, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 20:49:31', '2025-08-27 20:49:31', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(159, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:05:03', '2025-08-27 21:05:03', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(160, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:09:02', '2025-08-27 21:09:02', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(161, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:11:02', '2025-08-27 21:11:02', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(162, 'Info Sekolah telah ditambahkan', 0, '2025-08-27 21:15:17', '2025-08-27 21:15:17', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(163, 'Info Sekolah telah dihapus', 0, '2025-08-27 21:15:37', '2025-08-27 21:15:37', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(164, 'Info Sekolah telah dihapus', 0, '2025-08-27 21:15:44', '2025-08-27 21:15:44', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(165, 'Info keagamaan telah ditambahkan', 0, '2025-08-28 00:19:07', '2025-08-28 00:19:07', 'http://192.168.254.209:8000/admin/ibadah/tempat', NULL, NULL),
(166, 'Info Pajak telah ditambahkan', 0, '2025-08-28 20:47:11', '2025-08-28 20:47:11', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(167, 'Info keagamaan telah ditambahkan', 0, '2025-08-29 00:20:22', '2025-08-29 00:20:22', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(168, 'Info Kerja telah ditambahkan', 0, '2025-09-01 00:03:06', '2025-09-01 00:03:06', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(169, 'Info Kerja telah ditambahkan', 0, '2025-09-01 00:09:17', '2025-09-01 00:09:17', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(170, 'Info Kerja telah diupdate', 0, '2025-09-01 00:31:36', '2025-09-01 00:31:36', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(171, 'Info keagamaan telah ditambahkan', 0, '2025-09-01 18:57:32', '2025-09-01 18:57:32', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(172, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:36:52', '2025-09-01 19:36:52', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(173, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:39:23', '2025-09-01 19:39:23', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(174, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:48:04', '2025-09-01 19:48:04', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(175, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:53:16', '2025-09-01 19:53:16', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(176, 'Info Kerja telah ditambahkan', 0, '2025-09-01 19:57:57', '2025-09-01 19:57:57', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(177, 'Info Plesir telah ditambahkan', 0, '2025-09-01 20:27:14', '2025-09-01 20:27:14', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(178, 'Info Plesir telah ditambahkan', 0, '2025-09-01 21:12:27', '2025-09-01 21:12:27', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(179, 'Info Plesir telah ditambahkan', 0, '2025-09-01 21:28:44', '2025-09-01 21:28:44', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(180, 'Info Plesir telah ditambahkan', 0, '2025-09-01 23:26:00', '2025-09-01 23:26:00', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(181, 'Info Plesir telah ditambahkan', 0, '2025-09-01 23:35:21', '2025-09-01 23:35:21', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(182, 'Info Plesir telah ditambahkan', 0, '2025-09-02 00:12:09', '2025-09-02 00:12:09', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(183, 'Info Plesir telah dihapus', 0, '2025-09-02 00:14:13', '2025-09-02 00:14:13', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(184, 'Info Perizinan telah ditambahkan', 0, '2025-09-02 01:47:36', '2025-09-02 01:47:36', 'http://192.168.255.138:8000/admin/izin/info', NULL, NULL),
(185, 'Info Kerja telah ditambahkan', 0, '2025-09-02 18:28:10', '2025-09-02 18:28:10', 'http://192.168.255.138:8000/admin/kerja/index', NULL, NULL),
(186, 'Info Kesehatan telah ditambahkan', 0, '2025-09-02 18:57:01', '2025-09-02 18:57:01', 'http://192.168.255.138:8000/admin/sehat/tempat', NULL, NULL),
(187, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 19:31:59', '2025-09-02 19:31:59', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(188, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 20:12:26', '2025-09-02 20:12:26', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(189, 'Info Sekolah telah dihapus', 0, '2025-09-02 20:12:45', '2025-09-02 20:12:45', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(190, 'Info Sekolah telah ditambahkan', 0, '2025-09-02 20:13:23', '2025-09-02 20:13:23', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(191, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:03:27', '2025-09-02 21:03:27', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(192, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:03:34', '2025-09-02 21:03:34', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(193, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:04:29', '2025-09-02 21:04:29', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(194, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:07:54', '2025-09-02 21:07:54', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(195, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:08:04', '2025-09-02 21:08:04', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(196, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:08:52', '2025-09-02 21:08:52', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(197, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:10:19', '2025-09-02 21:10:19', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(198, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:11:43', '2025-09-02 21:11:43', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(199, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:12:47', '2025-09-02 21:12:47', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(200, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:14:03', '2025-09-02 21:14:03', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(201, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:15:14', '2025-09-02 21:15:14', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(202, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:16:12', '2025-09-02 21:16:12', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(203, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:16:51', '2025-09-02 21:16:51', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(204, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:19:01', '2025-09-02 21:19:01', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(205, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:21:34', '2025-09-02 21:21:34', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(206, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:13', '2025-09-02 21:22:13', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(207, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:31', '2025-09-02 21:22:31', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(208, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:22:53', '2025-09-02 21:22:53', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(209, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:23:08', '2025-09-02 21:23:08', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(210, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:26:15', '2025-09-02 21:26:15', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(211, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:26:43', '2025-09-02 21:26:43', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(212, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:27:28', '2025-09-02 21:27:28', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(213, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:28:35', '2025-09-02 21:28:35', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(214, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:29:23', '2025-09-02 21:29:23', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(215, 'dumas baru telah ditambahkan.', 0, '2025-09-02 21:30:52', '2025-09-02 21:30:52', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(216, 'Info Adminduk telah ditambahkan', 0, '2025-09-03 00:18:10', '2025-09-03 00:18:10', 'http://192.168.255.138:8000/admin/adminduk/index', NULL, NULL),
(217, 'Info Sekolah telah diupdate', 0, '2025-09-03 01:42:53', '2025-09-03 01:42:53', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(218, 'Info Sekolah telah diupdate', 0, '2025-09-03 01:51:19', '2025-09-03 01:51:19', 'http://192.168.255.138:8000/admin/ibadah/tempat', NULL, NULL),
(219, 'dumas telah dihapus.', 0, '2025-09-03 02:00:29', '2025-09-03 02:00:29', 'http://192.168.255.138:8000/admin/dumas/aduan', NULL, NULL),
(220, 'Info Adminduk telah ditambahkan', 0, '2025-09-08 21:11:18', '2025-09-08 21:11:18', 'http://192.168.255.21:8000/admin/adminduk/index', NULL, NULL),
(221, 'Tempat Ibadah telah ditambahkan.', 0, '2025-09-09 00:43:54', '2025-09-09 00:43:54', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, NULL),
(222, 'Tempat Ibadah telah ditambahkan.', 0, '2025-09-09 00:45:07', '2025-09-09 00:45:07', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, NULL),
(223, 'Tempat Ibadah diperbarui', 0, '2025-09-09 01:50:57', '2025-09-09 01:50:57', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, NULL),
(224, 'Tempat Ibadah diperbarui', 0, '2025-09-09 01:52:11', '2025-09-09 01:52:11', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, NULL),
(225, 'Tempat ibadah telah dihapus.', 0, '2025-09-09 01:53:59', '2025-09-09 01:53:59', 'http://192.168.255.21:8000/admin/ibadah/tempat', NULL, NULL),
(226, 'Lokasi Kesehatan telah ditambahkan', 0, '2025-09-09 20:17:05', '2025-09-09 20:17:05', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(227, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:36:12', '2025-09-09 23:36:12', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(228, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:36:49', '2025-09-09 23:36:49', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(229, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-09 23:41:16', '2025-09-09 23:41:16', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(230, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-09 23:55:21', '2025-09-09 23:55:21', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(231, 'Tempat olahraga telah dihapus', 0, '2025-09-09 23:55:45', '2025-09-09 23:55:45', 'http://192.168.255.21:8000/sehat/tempat', NULL, NULL),
(232, 'Info Adminduk telah diupdate', 0, '2025-09-10 00:22:55', '2025-09-10 00:22:55', 'http://192.168.255.21:8000/adminduk/index', NULL, NULL),
(233, 'Deskripsi Renbang telah diperbarui', 0, '2025-09-11 00:36:51', '2025-09-11 00:36:51', 'http://192.168.255.110:8000/renbang/deskripsi', NULL, NULL),
(234, 'Deskripsi Renbang telah ditambahkan', 0, '2025-09-11 00:41:16', '2025-09-11 00:41:16', 'http://192.168.255.110:8000/renbang/deskripsi', NULL, NULL),
(235, 'dumas baru telah ditambahkan.', 0, '2025-09-18 19:01:33', '2025-09-18 19:01:33', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, NULL),
(236, 'dumas telah dihapus.', 0, '2025-09-18 19:11:30', '2025-09-18 19:11:30', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, NULL),
(237, 'dumas telah dihapus.', 0, '2025-09-18 19:15:05', '2025-09-18 19:15:05', 'http://192.168.255.80:8000/admin/dumas/aduan', NULL, NULL),
(238, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 18:53:28', '2025-09-21 18:53:28', 'http://192.168.255.132:8000/admin/sehat/tempat', NULL, NULL),
(239, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(240, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:23:24', '2025-09-21 19:23:24', 'http://192.168.255.132:8000/admin/sehat/tempat', 'superadmin', NULL),
(241, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-21 19:38:49', '2025-09-21 19:38:49', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(242, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 20:11:56', '2025-09-21 20:11:56', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(243, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 0, '2025-09-21 21:23:41', '2025-09-21 21:23:41', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(244, 'Lokasi Kesehatan baru telah ditambahkan: Rumah sakit umum karangmalang', 0, '2025-09-21 21:24:33', '2025-09-21 21:24:33', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(245, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-21 21:34:02', '2025-09-21 21:34:02', 'http://192.168.255.132:8000/admin/sehat/tempat', 'admindinas', 'kesehatan'),
(246, 'Info Adminduk telah ditambahkan', 0, '2025-09-21 23:44:06', '2025-09-21 23:44:06', 'http://192.168.255.132:8000/admin/adminduk/info', NULL, NULL),
(247, 'Lokasi Sekolah telah ditambahkan', 0, '2025-09-23 07:28:57', '2025-09-23 07:28:57', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(248, 'Info Pajak telah ditambahkan', 0, '2025-09-23 18:24:18', '2025-09-23 18:24:18', 'http://192.168.255.96:8000/admin/ibadah/tempat', NULL, NULL),
(249, 'Info Pajak telah diupdate', 0, '2025-09-23 18:45:41', '2025-09-23 18:45:41', 'http://192.168.255.96:8000/admin/pajak/info', 'admindinas', 'perpajakan'),
(250, 'Lokasi Sekolah telah ditambahkan', 0, '2025-09-29 23:40:30', '2025-09-29 23:40:30', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(251, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:15', '2025-09-30 00:02:15', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(252, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:22', '2025-09-30 00:02:22', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(253, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:29', '2025-09-30 00:02:29', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(254, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:02:40', '2025-09-30 00:02:40', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(255, 'Lokasi Kesehatan telah diupdate', 0, '2025-09-30 00:05:57', '2025-09-30 00:05:57', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(256, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:13:47', '2025-09-30 00:13:47', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(257, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:13:55', '2025-09-30 00:13:55', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(258, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:14:02', '2025-09-30 00:14:02', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(259, 'Lokasi Kesehatan telah dihapus', 0, '2025-09-30 00:14:36', '2025-09-30 00:14:36', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(260, 'Tempat olahraga telah ditambahkan', 0, '2025-09-30 00:42:25', '2025-09-30 00:42:25', 'http://192.168.254.242:8000/admin/sehat/tempat', 'superadmin', NULL),
(261, 'Lokasi pasar telah dihapus.', 0, '2025-09-30 01:41:11', '2025-09-30 01:41:11', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(262, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:45:40', '2025-09-30 01:45:40', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(263, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:45:55', '2025-09-30 01:45:55', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(264, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 01:46:00', '2025-09-30 01:46:00', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(265, 'Lokasi Pasar telah diupdate', 0, '2025-09-30 01:46:29', '2025-09-30 01:46:29', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(266, 'Info Plesir telah dihapus', 0, '2025-09-30 01:55:04', '2025-09-30 01:55:04', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(267, 'Info Plesir telah ditambahkan', 0, '2025-09-30 02:04:40', '2025-09-30 02:04:40', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(268, 'Info Plesir telah dihapus', 0, '2025-09-30 02:05:02', '2025-09-30 02:05:02', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(269, 'Info Plesir telah ditambahkan', 0, '2025-09-30 02:06:09', '2025-09-30 02:06:09', 'http://192.168.254.242:8000/admin/ibadah/tempat', NULL, NULL),
(270, 'Lokasi Plesir telah ditambahkan', 0, '2025-09-30 03:28:29', '2025-09-30 03:28:29', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(271, 'Lokasi Plesir telah diupdate', 0, '2025-09-30 03:29:20', '2025-09-30 03:29:20', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(272, 'Lokasi Plesir telah dihapus', 0, '2025-09-30 03:29:32', '2025-09-30 03:29:32', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(273, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:30:50', '2025-09-30 03:30:50', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(274, 'Lokasi Pasar telah diupdate', 0, '2025-09-30 03:31:08', '2025-09-30 03:31:08', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(275, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:37:17', '2025-09-30 03:37:17', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(276, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:40:09', '2025-09-30 03:40:09', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(277, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:41:40', '2025-09-30 03:41:40', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(278, 'Lokasi Pasar telah ditambahkan', 0, '2025-09-30 03:47:49', '2025-09-30 03:47:49', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(279, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:47:56', '2025-09-30 03:47:56', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(280, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:48:00', '2025-09-30 03:48:00', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(281, 'Lokasi Pasar telah dihapus', 0, '2025-09-30 03:48:10', '2025-09-30 03:48:10', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(282, 'Info Plesir telah ditambahkan', 0, '2025-09-30 04:05:51', '2025-09-30 04:05:51', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(283, 'Tempat olahraga telah diperbarui', 0, '2025-09-30 04:15:05', '2025-09-30 04:15:05', 'http://192.168.1.11:8000/admin/sehat/tempat', 'superadmin', NULL),
(284, 'Tempat olahraga telah diperbarui', 0, '2025-09-30 04:18:43', '2025-09-30 04:18:43', 'http://192.168.1.11:8000/admin/sehat/tempat', 'superadmin', NULL),
(285, 'Info keagamaan telah diperbarui', 0, '2025-09-30 04:37:35', '2025-09-30 04:37:35', 'http://192.168.1.11:8000/admin/ibadah/tempat', NULL, NULL),
(286, 'Info Adminduk telah dihapus', 0, '2025-09-30 04:56:19', '2025-09-30 04:56:19', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, NULL),
(287, 'Info Adminduk telah dihapus', 0, '2025-09-30 04:56:25', '2025-09-30 04:56:25', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, NULL),
(288, 'Info Adminduk telah diupdate', 0, '2025-09-30 04:56:37', '2025-09-30 04:56:37', 'http://192.168.1.11:8000/admin/adminduk/info', NULL, NULL),
(289, 'Info Renbang telah diperbarui', 0, '2025-09-30 05:02:48', '2025-09-30 05:02:48', 'http://192.168.1.11:8000/admin/renbang/Renbang/Info', NULL, NULL),
(290, 'Info Renbang telah dihapus', 0, '2025-09-30 05:04:32', '2025-09-30 05:04:32', 'http://192.168.1.11:8000/admin/renbang/Renbang/Info', NULL, NULL),
(291, 'Info Perizinan telah diupdate', 0, '2025-09-30 05:11:15', '2025-09-30 05:11:15', 'http://192.168.1.11:8000/admin/izin/info', NULL, NULL);

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
(18, 'App\\Models\\User', 2, 'auth_token', 'd8d7eefa46e1a0e63e63c6ff88bca7fe8ee737d9a75c71d05f3352f90c26ddaf', '[\"*\"]', '2025-09-28 20:20:14', NULL, '2025-09-28 19:41:50', '2025-09-28 20:20:14');

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
(3, 'Kemenhan Rencanakan Bangun Pangkalan TNI AD di Kawasan Hutan Indramayu', '<p>KORAN-PIKIRAN RAKYAT – Kawasan hutan di Desa Cikawung, Kecamatan Terisi, Kabupaten Indramayu, bakal menjadi lokasi pembangun­an pangkalan besar militer dari kesatuan Tentara ­Nasional Indonesia Angkatan Darat (TNI AD). Kementerian Pertahanan (Kemenhan) Republik Indonesia berencana membangun pangkalan TNI AD di kawasan hutan yang berada di wilayah perbatasan Indramayu, Majalengka, dan Sumedang.<br><br>Kepala Resort Pemangkuan Hutan (KRPH) Indramayu Wawan Gunawan mengungkapkan, rencana Kemenhan untuk membangun pangkalan militer TNI AD di areal hutan Cikawung. ”Ada permintaan dari Kemenhan untuk pangkalan dan fasilitas TNI AD di areal hutan Cikawung,” ujarnya, Sabtu 27 September 2025. Dia menyebutkan, areal hutan yang diminta TNI AD, melalui Kemenhan, berada di petak 16 dan 30 di lingkungan administrasi RPH Cipondoh, BKPH Cikawung, KPH Indramayu. Total luas lahan yang diperlukan sekitar 97-100 hektare. Rencananya, di atas lahan itu akan diba­ngun pangkalan dan fasilitas TNI untuk Brigif TP 34 serta Batalion TP 889. Wawan menyebutkan, karena statusnya kawasan hutan negara maka izin pemanfaatan ada di tangan pemerintah pusat melalui Kementerian Kehutanan (Kemenhut). ”Kita hanya ketempatan,” ucapnya.&nbsp;<br><br>Sumber Artikel berjudul \" Kemenhan Rencanakan Bangun Pangkalan TNI AD di Kawasan Hutan Indramayu \", selengkapnya dengan link: <a href=\"https://koran.pikiran-rakyat.com/jawa-barat/pr-3039680323/kemenhan-rencanakan-bangun-pangkalan-tni-ad-di-kawasan-hutan-indramayu\">https://koran.pikiran-rakyat.com/jawa-barat/pr-3039680323/kemenhan-rencanakan-bangun-pangkalan-tni-ad-di-kawasan-hutan-indramayu</a></p>', 'renbang/w0GHh7efiVuDxsRJf0oq9AWWZty77bZIU0g9R5KT.webp', 'Infrastruktur', '2025-09-11 00:41:16', '2025-09-30 05:02:48', 'Desa Cikawung, Kecamatan Terisi, Kabupaten Indramayu');

-- --------------------------------------------------------

--
-- Table structure for table `sekolahs`
--

CREATE TABLE `sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_laporan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `bukti_laporan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sekolahs`
--

INSERT INTO `sekolahs` (`id`, `jenis_laporan`, `kategori_laporan`, `lokasi_laporan`, `status`, `bukti_laporan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'kekurangan guru', 'sd', 'Sd 1 Dermayu', 'ditolak', 'bukti_sekolah/nhdY2cj5cCKjcT1XLuRDdT8JGk1RDIYLPJkk3vbx.jpg', 'tidak ada guru matematika teknik', '2025-07-14 23:46:09', '2025-07-16 19:43:10'),
(9, 'kekurangan guru', 'smp', 'smp 2 sindang', 'menunggu', 'bukti_sekolah/A1DgMEqHrn2JzdZcK1OS9LETQpTebfoVxr2RLQBn.jpg', 'tidak ada guru matematika teknik', '2025-07-15 23:28:50', '2025-08-11 18:19:33');

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
('1PSVna9JyPItlMpR6JoXQJXk6ihuJ4uWDjyLVN18', 2, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoib3A5bjJEZVAwamV4YzllNG9KeGpNNExoY3pkbktYb014QVNneHdNZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMjoiY2FwdGNoYV9jb2RlIjtzOjU6IjIxNjEyIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cDovLzE5Mi4xNjguMS4xMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjQ6Im5hbWUiO3M6NToiYWJkZWUiO3M6ODoicGFzc3dvcmQiO3M6NjA6IiQyeSQxMiRzdjE4STQ3dDhFbjVUUERuUS50QlZPc0hEOWVHYnBFQnpyOVVKZWtnZlhFRWo1UWpnbkdTdSI7fQ==', 1759234284);

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
(1, 'islam', 'Masjid Agung Indramayu', 'Alun-Alun, Margadadi, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45212', -6.3270090, 108.3220030, '2025-07-03 20:05:16', '2025-08-01 01:44:38', 'ibadah_foto/pBhXmKFfja2Q4gZVr7Chd0H0L2c2LOh2BMmhCa7c.jpg'),
(2, 'Kristen', 'Gereja Katolik Santo Mikael', 'Jalan Veteran, Lemahabang, Indramayu, West Java, Java, 45222, Indonesia', -6.3287007, 108.3224380, '2025-07-04 18:30:34', '2025-08-01 01:48:19', 'ibadah_foto/eKows8thUHMz8CPy8kUANVOadQWxmG6eydLWjmD6.jpg');

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
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tempat_olahraga`
--

INSERT INTO `tempat_olahraga` (`id`, `name`, `latitude`, `longitude`, `created_at`, `updated_at`, `address`, `foto`) VALUES
(4, 'sport center wanantara', -6.3136640, 108.2957540, '2025-08-26 23:21:19', '2025-09-30 04:18:43', 'Wanantara, Indramayu, West Java, Java, 45222, Indonesia', 'tempat_olahraga/XWxTY4MeXk2CNvnSj1XoZ1xLmf8qpJ72Pq9fA5yf.jpg'),
(6, 'Sport Center Indramayu', -6.3371803, 108.3310840, '2025-09-30 00:42:25', '2025-09-30 00:42:25', 'Karanganyar, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45213', 'tempat_olahraga/fYu31YUb1rEleyNcSmf1MmAvmSuJrRphpJZLtxz1.jpg');

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
(1, 'Pasar Baru Indramayu', 'Karangmalang, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45214', -6.34226186, 108.33025744, '2025-07-04 01:42:30', '2025-09-30 01:46:28', 'pasar', 'Pasar_foto/HcjOyhP6TDbGccGrYQXoiJb1RWZWgzOpybC3iscE.jpg');

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
(1, 'Pantai Balongan Kesambi', 'Jl. Raya Balongan No.72, Balongan, Kec. Balongan, Kabupaten Indramayu, Jawa Barat 45217', -6.3669066, 108.3914168, '2025-07-04 16:50:51', '2025-08-07 20:00:22', 'tempat_plesir_foto/cemgdsSSkcofTBqhvQDHlPSbbe3nA6y4ADSEwybr.jpg', 'Wisata');

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
(1, 'Rumah Sakit Umum Daerah Kabupaten Indramayu', 'RSUD Indramayu, 7, Jalan Murah Nara, Indramayu, West Java, Java, 45222, Indonesia', -6.3299214, 108.3214892, '2025-07-04 01:25:11', '2025-09-30 00:05:57', 'rumah sakit', 'foto_kesehatan/Zn3OQo3jAPYRNtyNHRgyZVzqbEDWoHlJTS0KNFLf.jpg');

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
(1, 'Sd Negeri 1 Paoman 1', -6.3206640, 108.3287100, 'Paoman, Indramayu, West Java, Java, 45211, Indonesia', 'Sd', 'sekolah_foto/C7WVQ3oGHeYI3DCM2DOOaoeJE5CRZNwu68P1lM5K.jpg'),
(3, 'Sdn kepandean', -6.3428400, 108.3244040, 'Kepandean, Indramayu, West Java, Java, 45213, Indonesia', 'sekolah dasar', NULL),
(4, 'Sd Negeri 1 Pekandangan jaya', -6.3680960, 108.3240750, 'Pekandangan Jaya, Indramayu, West Java, Java, 45216, Indonesia', 'sekolah dasar', 'sekolah_foto/avjCHuoGhw4zLZYrLSYbYZ4Fe21gKFi9dIyxaChX.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `no_ktp`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Abdee Pratama', 'abdeeprataman@gmail.com', '08123456789', '1234567890123456', NULL, '$2y$12$2uafAeZUqsA0gw6DVwlwKO7edn86/BzIsw8xAFQjjZUUaRbx9BpoG', NULL, '2025-07-01 20:00:39', '2025-07-01 20:00:39', 'user'),
(2, 'Raul', 'Raul@gmail.com', '08123456759', '123456789059398', NULL, '$2y$12$YQ1RIg.pgjn0bYsZ7qHHLOUkU59438qYSKG3Ui/0zXnhAzni07KMC', NULL, '2025-08-21 21:03:42', '2025-08-21 21:03:42', 'user'),
(3, 'Alfa', 'alfa@gmail.com', '08123456859', '1234567890578376', NULL, '$2y$12$TB/7mM35eEg0Saz1pbRxAu68ktec1aNyw0JqTxmjmquRcxk7xoPKC', NULL, '2025-09-14 19:14:03', '2025-09-14 19:14:03', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int NOT NULL,
  `id_admins` int NOT NULL,
  `id_instansi` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `id_admins`, `id_instansi`, `nama`, `email`, `no_hp`) VALUES
(1, 2, 2, 'kebersihan', 'kebersihan', 'kebersihan'),
(2, 3, 2, 'Kesehatan', 'kesehatan@gmail.com', '08337878783'),
(3, 4, 3, 'pendidikan', 'pendidikan@gmail.com', '087847284284728');

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_info_plesir_id_foreign` (`info_plesir_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `renbangs_deskripsi`
--
ALTER TABLE `renbangs_deskripsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekolahs`
--
ALTER TABLE `sekolahs`
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dumas`
--
ALTER TABLE `dumas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_keagamaans`
--
ALTER TABLE `info_keagamaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `info_kerja`
--
ALTER TABLE `info_kerja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `info_kesehatan`
--
ALTER TABLE `info_kesehatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `info_pajak`
--
ALTER TABLE `info_pajak`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `info_pasar`
--
ALTER TABLE `info_pasar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `info_perizinan`
--
ALTER TABLE `info_perizinan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `info_plesir`
--
ALTER TABLE `info_plesir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `info_sekolah`
--
ALTER TABLE `info_sekolah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `kategori_dumas`
--
ALTER TABLE `kategori_dumas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `notifikasi_aktivitas`
--
ALTER TABLE `notifikasi_aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `renbangs_deskripsi`
--
ALTER TABLE `renbangs_deskripsi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sekolahs`
--
ALTER TABLE `sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tempat_ibadah`
--
ALTER TABLE `tempat_ibadah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tempat_olahraga`
--
ALTER TABLE `tempat_olahraga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tempat_pasars`
--
ALTER TABLE `tempat_pasars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tempat_plesirs`
--
ALTER TABLE `tempat_plesirs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tempat_sehats`
--
ALTER TABLE `tempat_sehats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tempat_sekolahs`
--
ALTER TABLE `tempat_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_info_plesir_id_foreign` FOREIGN KEY (`info_plesir_id`) REFERENCES `info_plesir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
