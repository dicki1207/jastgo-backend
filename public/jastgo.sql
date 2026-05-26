-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Bulan Mei 2026 pada 04.18
-- Versi server: 8.0.30
-- Versi PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jastgo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alur_dana`
--

CREATE TABLE `alur_dana` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `biaya_admin` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Biaya administrasi yang dibebankan',
  `jenis_transaksi` enum('PEMBAYARAN_USER','PELEPASAN_DANA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_dana` decimal(12,2) NOT NULL,
  `bukti_tf_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_konfirmasi` enum('MENUNGGU_CEK','DIKONFIRMASI','DITOLAK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENUNGGU_CEK',
  `konfirmator_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_transfer` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alur_dana`
--

INSERT INTO `alur_dana` (`id`, `pesanan_id`, `biaya_admin`, `jenis_transaksi`, `jumlah_dana`, `bukti_tf_path`, `status_konfirmasi`, `konfirmator_id`, `tanggal_transfer`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 'PEMBAYARAN_USER', 1440000.00, 'bukti_transfer/user/AOYzWpVZp2Z4URWdMA5WAvILB9ABcLiBYSvmvvpz.png', 'DIKONFIRMASI', 1, '2025-12-13 07:56:23', '2025-12-13 07:56:23', '2025-12-13 09:07:34'),
(2, 2, 0.00, 'PEMBAYARAN_USER', 12000.00, 'bukti_transfer/user/OYFIan0ld3jmaRWXJ0xScl1f6GC22Po1qpxwdTkP.png', 'DITOLAK', 1, '2025-12-13 09:05:14', '2025-12-13 09:05:14', '2025-12-13 09:06:46'),
(3, 1, 72000.00, 'PELEPASAN_DANA', 1368000.00, 'bukti_transfer/admin/Tx0J49V9w2FiYrK6Ku2aRHMoCKWpfTg9TbXrJjpw.png', 'DIKONFIRMASI', 1, '2025-12-13 09:25:43', '2025-12-13 09:25:43', '2025-12-13 09:25:43'),
(4, 5, 0.00, 'PEMBAYARAN_USER', 146546544.00, 'bukti_transfer/user/Il58vn5e877oispCiYdMtPweg6mIlNYHEJjc1dnj.png', 'DIKONFIRMASI', 1, '2025-12-13 18:20:24', '2025-12-13 18:20:24', '2025-12-13 18:22:33'),
(5, 6, 0.00, 'PEMBAYARAN_USER', 240000.00, 'bukti_transfer/user/a2UClfNHJ1wr6kxsBTomWjojj5jjUWo51hnxBqhY.png', 'DIKONFIRMASI', 1, '2025-12-13 19:18:19', '2025-12-13 19:18:19', '2025-12-13 19:19:20'),
(6, 7, 0.00, 'PEMBAYARAN_USER', 240000.00, 'bukti_transfer/user/ul2tsXSSorV0fauFPjQJKRnhDFw9HiHHV9CxolFb.png', 'DIKONFIRMASI', 1, '2025-12-13 19:34:36', '2025-12-13 19:34:36', '2025-12-13 19:37:29'),
(7, 6, 12000.00, 'PELEPASAN_DANA', 228000.00, 'bukti_transfer/admin/PW5G6ZVPqqkcYhE0IHKSgDSGohgnl91At7qmwkae.png', 'DIKONFIRMASI', 1, '2025-12-13 19:35:27', '2025-12-13 19:35:27', '2025-12-13 19:35:27'),
(8, 7, 12000.00, 'PELEPASAN_DANA', 228000.00, 'bukti_transfer/admin/5w2qKkUFydjBjWFvkOSFXl6U4wjwqeOyb5W1nhLN.png', 'DIKONFIRMASI', 1, '2025-12-13 19:39:14', '2025-12-13 19:39:14', '2025-12-13 19:39:14'),
(9, 8, 0.00, 'PEMBAYARAN_USER', 360000.00, 'bukti_transfer/user/TdmnEzZO6URCvBQFXA5bz6gyCCxPDo2Vn49b0jrA.png', 'DIKONFIRMASI', 1, '2025-12-13 19:53:55', '2025-12-13 19:53:55', '2025-12-13 20:39:59'),
(10, 9, 0.00, 'PEMBAYARAN_USER', 240000.00, 'bukti_transfer/user/viRdk9WKJzkeEohZz09hxO0TswAKDVubAmDFVcBx.png', 'DIKONFIRMASI', 1, '2025-12-13 20:43:29', '2025-12-13 20:43:29', '2025-12-13 20:45:15'),
(11, 10, 0.00, 'PEMBAYARAN_USER', 840000.00, 'bukti_transfer/user/eiOmNZzP2q5UdLeTi8YCpqamHQAV7j1uDAU1VX4g.png', 'DIKONFIRMASI', 1, '2025-12-13 20:49:38', '2025-12-13 20:49:38', '2025-12-13 20:50:36'),
(12, 10, 42000.00, 'PELEPASAN_DANA', 798000.00, 'bukti_transfer/admin/ooQgvfkvUlcj2qRu5YeBnVOiJ7fegDRY7ZfCsgt7.png', 'DIKONFIRMASI', 1, '2025-12-13 20:59:55', '2025-12-13 20:59:55', '2025-12-13 20:59:55'),
(13, 9, 12000.00, 'PELEPASAN_DANA', 228000.00, 'bukti_transfer/admin/rBcWurxwddrhqF0R9xHnfmz1MJoa6STH9Ka8QOCl.png', 'DIKONFIRMASI', 1, '2025-12-13 21:00:22', '2025-12-13 21:00:22', '2025-12-13 21:00:22'),
(14, 11, 0.00, 'PEMBAYARAN_USER', 132000.00, 'bukti_transfer/user/6SBXeS8iaAvhd5iAkSAIeuigPcyugs2JqIP2Puvk.png', 'DIKONFIRMASI', 1, '2025-12-13 21:06:39', '2025-12-13 21:06:39', '2025-12-13 21:08:13'),
(15, 8, 18000.00, 'PELEPASAN_DANA', 342000.00, 'bukti_transfer/admin/u7suBnXv7PxUSuDA5cNDhJy6z4F0I8TjOIYInMZK.png', 'DIKONFIRMASI', 1, '2025-12-13 21:08:20', '2025-12-13 21:08:20', '2025-12-13 21:08:20'),
(16, 11, 6600.00, 'PELEPASAN_DANA', 125400.00, 'bukti_transfer/admin/T82KNk3vdBcWSse51E8lM6KbbgVF6CfYiuBOQwrE.png', 'DIKONFIRMASI', 1, '2025-12-13 21:10:29', '2025-12-13 21:10:29', '2025-12-13 21:10:29'),
(17, 13, 0.00, 'PEMBAYARAN_USER', 24000.00, 'bukti_transfer/user/RuA940N7VHZLXwKTh2KB4dyeDdK1D6NAFBWIn5UU.png', 'DIKONFIRMASI', 1, '2025-12-13 21:16:25', '2025-12-13 21:16:25', '2025-12-13 21:22:58'),
(18, 14, 0.00, 'PEMBAYARAN_USER', 24000.00, 'bukti_transfer/user/Y9EJeZk4b0wmCgagOYTixdn4v3D9WCo1NYZKi5LN.png', 'DIKONFIRMASI', 1, '2025-12-13 21:17:27', '2025-12-13 21:17:27', '2025-12-13 21:22:55'),
(19, 13, 1200.00, 'PELEPASAN_DANA', 22800.00, 'bukti_transfer/admin/lhiOmGRZoxmLF3XacTcIZe0XHfUtGc3ZlPHP50Oq.png', 'DIKONFIRMASI', 1, '2025-12-13 21:26:32', '2025-12-13 21:26:32', '2025-12-13 21:26:32'),
(20, 14, 1200.00, 'PELEPASAN_DANA', 22800.00, 'bukti_transfer/admin/GtfH4QTjwp6KJO6XB5dC95Br53liEkCpd47gUnep.png', 'DIKONFIRMASI', 1, '2025-12-13 21:26:48', '2025-12-13 21:26:48', '2025-12-13 21:26:48'),
(21, 15, 0.00, 'PEMBAYARAN_USER', 24000.00, 'bukti_transfer/user/oJ0PFFVnVyRR4NS28exJ9M8wEp6Gk1QpeFhDrhQR.png', 'DIKONFIRMASI', 1, '2025-12-13 22:36:27', '2025-12-13 22:36:27', '2025-12-13 22:36:55'),
(22, 15, 1200.00, 'PELEPASAN_DANA', 22800.00, 'bukti_transfer/admin/hxlxRoUCGrCmDTk6pfOYRr9V9B2qcxiCBqVpjy2l.png', 'DIKONFIRMASI', 1, '2025-12-13 22:39:00', '2025-12-13 22:39:00', '2025-12-13 22:39:00'),
(23, 16, 0.00, 'PEMBAYARAN_USER', 24000.00, 'bukti_transfer/user/Nxza7BiZoiq0VqRrjlwVgzTHGpjFmHDrwCgJp2Ll.png', 'DIKONFIRMASI', 1, '2025-12-14 01:12:22', '2025-12-14 01:12:22', '2025-12-14 01:14:03'),
(24, 28, 0.00, 'PEMBAYARAN_USER', 240000.00, 'bukti_transfer/user/eeiS6n2M5hcRsqgIItF42CYl10gPHyQVLbP5F6RN.png', 'DIKONFIRMASI', 1, '2025-12-26 02:11:41', '2025-12-26 02:11:41', '2025-12-26 02:14:31'),
(25, 29, 0.00, 'PEMBAYARAN_USER', 12000.00, 'bukti_transfer/user/0scjfYNAcYTXl3XeLxg3YaeCvrqUTioKJ6x3FZnw.png', 'DIKONFIRMASI', 1, '2025-12-26 02:18:06', '2025-12-26 02:18:06', '2025-12-26 02:19:11'),
(26, 30, 0.00, 'PEMBAYARAN_USER', 120000.00, 'bukti_transfer/user/0scjfYNAcYTXl3XeLxg3YaeCvrqUTioKJ6x3FZnw.png', 'DIKONFIRMASI', 1, '2025-12-26 02:18:06', '2025-12-26 02:18:06', '2025-12-26 02:19:17'),
(27, 31, 0.00, 'PEMBAYARAN_USER', 240000.00, 'bukti_transfer/user/96kSpGg4NCNug6RYDPCY1ISDftXd0RNBF3P9XXpC.png', 'MENUNGGU_CEK', NULL, '2025-12-26 02:21:57', '2025-12-26 02:21:57', '2025-12-26 02:21:57'),
(28, 33, 0.00, 'PEMBAYARAN_USER', 600000.00, 'bukti_transfer/user/jzESpzoNsQusYXFmdTwp4vqNsfXVvZBxXYFmVwQI.png', 'MENUNGGU_CEK', NULL, '2025-12-26 02:23:08', '2025-12-26 02:23:08', '2025-12-26 02:23:08'),
(29, 34, 0.00, 'PEMBAYARAN_USER', 360000.00, 'bukti_transfer/user/M2HciS2KSJSIG553GYmpb5IIYgMwAN36RvKpLKRG.png', 'MENUNGGU_CEK', NULL, '2025-12-26 02:30:44', '2025-12-26 02:30:44', '2025-12-26 02:30:44'),
(30, 35, 0.00, 'PEMBAYARAN_USER', 10000.00, 'bukti_transfer/user/aPgzKwWmOhhppyPNgN1EgNPNMoDUOPtcnikxjgCW.png', 'MENUNGGU_CEK', NULL, '2026-05-25 09:17:11', '2026-05-25 09:17:11', '2026-05-25 09:17:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `jastiper_id` bigint UNSIGNED DEFAULT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `nama_barang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL DEFAULT '0',
  `is_available` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `foto_barang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_input` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `jastiper_id`, `kategori_id`, `admin_id`, `nama_barang`, `deskripsi`, `harga`, `stok`, `is_available`, `foto_barang`, `tanggal_input`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, 'donut', 'kAIKAKASiaI', 1200000.00, 12, 'yes', 'barangs/MlJReLQ68a06Q8Ap1lTbxcB7aBH6cBCjfKzyjM5c.png', '2025-12-13 14:44:00', '2025-12-13 07:44:29', '2025-12-13 07:44:13', '2025-12-13 07:44:29'),
(2, 1, 3, NULL, 'donut', 'KAwsjAKJS', 120000.00, 11, 'yes', 'barangs/Q7QcMue5hw2csORoyrmVOyYNr0zGlhVbnYBoPP5C.png', '2025-12-13 14:45:00', NULL, '2025-12-13 07:45:27', '2025-12-13 21:08:13'),
(3, 1, 5, NULL, 'MOTOR', 'zazzzx', 12212212.00, 0, 'no', 'barangs/fC7cVdAQmq7JzHK1VB4tCwoCOM8Gkk12Or2mEDad.png', '2025-12-13 14:45:00', '2025-12-13 19:39:44', '2025-12-13 07:45:54', '2025-12-13 19:39:44'),
(4, 1, 2, NULL, 'KEMEJA', 'SANGAT BERGAYA', 120000.00, 11, 'yes', 'barangs/xFKhWojOMHjc8fDBIHciSaF3Dm8mbigTrht5OoKU.png', '2025-12-13 14:47:00', NULL, '2025-12-13 07:47:23', '2025-12-26 02:14:31'),
(5, 1, 7, NULL, 'GAYUNG', 'ASDASAD', 120000.00, 119999, 'yes', 'barangs/LPDl5NPMZnWh4BPnbtGGSjrhECC24DOMjjeG3Mp4.png', '2025-12-13 14:47:00', NULL, '2025-12-13 07:47:59', '2025-12-26 02:19:17'),
(6, 1, 6, NULL, 'dakimura', 'jujur kasian', 120000.00, 119999, 'yes', 'barangs/1m5G887wBcoDdDcD8N4X3JdSPHfYipw73BdTyJRn.png', '2025-12-13 14:49:00', NULL, '2025-12-13 07:49:45', '2025-12-26 02:14:31'),
(7, 1, 8, NULL, 'minuman', 'sangat enak', 12000.00, 12, 'yes', 'barangs/yiCN3vcpfx6UY7RRP0jQDvcEJKFkFx82ZuFaJpNr.png', '2025-12-13 14:50:00', NULL, '2025-12-13 07:50:32', '2025-12-13 07:50:32'),
(8, 1, 4, NULL, 'kosmetik', 'sangat bergaya', 120000.00, 0, 'yes', 'barangs/TuJ9dbPP3VwUyQCcEt9NFhU7Ia6rvuSJM5d2CvRZ.png', '2025-12-13 14:51:00', NULL, '2025-12-13 07:51:16', '2025-12-13 20:50:36'),
(9, 1, 1, NULL, 'lolol', 'kokok', 12000.00, 9, 'yes', 'barangs/8N9tFzQOUt1IywC1afowf2czcJ9VXXIhgwPjaZdo.png', '2025-12-13 14:51:00', '2025-12-14 19:09:46', '2025-12-13 07:51:48', '2025-12-14 19:09:46'),
(10, 1, NULL, NULL, 'lololol', 'saaaas', 12000.00, 122331, 'yes', 'barangs/j16sZZPUQwS1jGlCt24v18Z0keGdinXSyycv1dSw.png', '2025-12-13 14:52:00', '2025-12-14 18:54:08', '2025-12-13 07:52:18', '2025-12-14 18:54:08'),
(11, 2, 1, NULL, 'hp', 'murah', 12000.00, 8, 'yes', 'barangs/eAfbi167xlMcc9cUzVVjSPggczg8VuIY9hf9bXgS.png', '2025-12-14 04:14:00', NULL, '2025-12-13 21:14:19', '2025-12-26 02:19:11'),
(12, 4, 6, NULL, 'singkong', 'makanan', 10000.00, 20, 'yes', 'barangs/cfA6iGT4VBI804qiEJOliVlYJmxBYsZWJvNEVw0R.png', '2026-05-25 14:02:00', NULL, '2026-05-25 07:02:44', '2026-05-25 07:02:44'),
(13, 4, 6, NULL, 'donut', 'fetch(\'http://192.168.100.92/jastiplocal4/public/notifikasi/read-all\', {\r\n    method: \'POST\',\r\n    headers: {\r\n        \'X-CSRF-TOKEN\': document.querySelector(\'meta[name=\"csrf-token\"]\').getAttribute(\'content\')\r\n    }\r\n}).then(r => r.text()).then(console.log);', 10.00, 1000, 'yes', 'barangs/tm6R66QCOtnbs5Rv8ykQFRX5r6xyUTWYcOEKKp65.png', '2026-05-25 14:29:00', NULL, '2026-05-25 07:29:21', '2026-05-25 07:29:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1767017348),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1767017348;', 1767017348),
('laravel-cache-login:127.0.0.1|diki@gmail.com', 'i:1;', 1766740687),
('laravel-cache-login:127.0.0.1|diki@gmail.com:timer', 'i:1766740687;', 1766740687),
('laravel-cache-login:127.0.0.1|wahyu@gmail.com', 'i:2;', 1766740927),
('laravel-cache-login:127.0.0.1|wahyu@gmail.com:timer', 'i:1766740927;', 1766740927),
('laravel-cache-login:192.168.100.217|diki@gmail.com', 'i:1;', 1779725962),
('laravel-cache-login:192.168.100.217|diki@gmail.com:timer', 'i:1779725962;', 1779725962),
('laravel-cache-login:192.168.100.217|jastiper@gmail.com', 'i:1;', 1779711213),
('laravel-cache-login:192.168.100.217|jastiper@gmail.com:timer', 'i:1779711213;', 1779711213),
('laravel-cache-login:192.168.100.217|rembo12@gmail.com', 'i:1;', 1779711460),
('laravel-cache-login:192.168.100.217|rembo12@gmail.com:timer', 'i:1779711460;', 1779711460);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanans`
--

CREATE TABLE `detail_pesanans` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_pesanans`
--

INSERT INTO `detail_pesanans` (`id`, `pesanan_id`, `barang_id`, `jumlah`, `subtotal`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 12, 1440000.00, NULL, '2025-12-13 07:56:14', '2025-12-13 07:56:14'),
(2, 2, 9, 1, 12000.00, NULL, '2025-12-13 09:05:06', '2025-12-13 09:05:06'),
(3, 3, 4, 1, 120000.00, NULL, '2025-12-13 09:19:08', '2025-12-13 09:19:08'),
(4, 4, 4, 1, 120000.00, NULL, '2025-12-13 09:20:25', '2025-12-13 09:20:25'),
(5, 5, 3, 12, 146546544.00, NULL, '2025-12-13 18:20:16', '2025-12-13 18:20:16'),
(6, 6, 8, 2, 240000.00, NULL, '2025-12-13 19:18:14', '2025-12-13 19:18:14'),
(7, 7, 8, 2, 240000.00, NULL, '2025-12-13 19:34:31', '2025-12-13 19:34:31'),
(8, 8, 8, 3, 360000.00, NULL, '2025-12-13 19:53:39', '2025-12-13 19:53:39'),
(9, 9, 8, 2, 240000.00, NULL, '2025-12-13 20:43:14', '2025-12-13 20:43:14'),
(10, 10, 8, 7, 840000.00, NULL, '2025-12-13 20:49:16', '2025-12-13 20:49:16'),
(11, 11, 9, 1, 12000.00, NULL, '2025-12-13 21:06:06', '2025-12-13 21:06:06'),
(12, 11, 2, 1, 120000.00, NULL, '2025-12-13 21:06:06', '2025-12-13 21:06:06'),
(13, 12, 11, 1, 12000.00, NULL, '2025-12-13 21:15:47', '2025-12-13 21:15:47'),
(14, 12, 10, 1, 12000.00, NULL, '2025-12-13 21:15:47', '2025-12-13 21:15:47'),
(15, 13, 11, 1, 12000.00, NULL, '2025-12-13 21:16:06', '2025-12-13 21:16:06'),
(16, 13, 10, 1, 12000.00, NULL, '2025-12-13 21:16:06', '2025-12-13 21:16:06'),
(17, 14, 11, 1, 12000.00, NULL, '2025-12-13 21:17:07', '2025-12-13 21:17:07'),
(18, 14, 9, 1, 12000.00, NULL, '2025-12-13 21:17:07', '2025-12-13 21:17:07'),
(19, 15, 11, 1, 12000.00, NULL, '2025-12-13 22:36:21', '2025-12-13 22:36:21'),
(20, 15, 10, 1, 12000.00, NULL, '2025-12-13 22:36:21', '2025-12-13 22:36:21'),
(21, 16, 10, 1, 12000.00, NULL, '2025-12-14 01:12:10', '2025-12-14 01:12:10'),
(22, 16, 9, 1, 12000.00, NULL, '2025-12-14 01:12:10', '2025-12-14 01:12:10'),
(23, 17, 6, 1, 120000.00, NULL, '2025-12-24 23:12:41', '2025-12-24 23:12:41'),
(24, 18, 11, 1, 12000.00, NULL, '2025-12-24 23:12:41', '2025-12-24 23:12:41'),
(25, 19, 6, 1, 120000.00, NULL, '2025-12-24 23:12:47', '2025-12-24 23:12:47'),
(26, 20, 11, 1, 12000.00, NULL, '2025-12-24 23:12:47', '2025-12-24 23:12:47'),
(27, 21, 6, 1, 120000.00, NULL, '2025-12-24 23:12:56', '2025-12-24 23:12:56'),
(28, 22, 11, 1, 12000.00, NULL, '2025-12-24 23:12:56', '2025-12-24 23:12:56'),
(29, 23, 6, 1, 120000.00, NULL, '2025-12-24 23:13:26', '2025-12-24 23:13:26'),
(30, 24, 11, 1, 12000.00, NULL, '2025-12-24 23:13:26', '2025-12-24 23:13:26'),
(31, 25, 6, 1, 120000.00, NULL, '2025-12-24 23:27:18', '2025-12-24 23:27:18'),
(32, 26, 11, 1, 12000.00, NULL, '2025-12-24 23:27:18', '2025-12-24 23:27:18'),
(33, 27, 6, 1, 120000.00, NULL, '2025-12-26 02:08:00', '2025-12-26 02:08:00'),
(34, 27, 4, 1, 120000.00, NULL, '2025-12-26 02:08:00', '2025-12-26 02:08:00'),
(35, 28, 6, 1, 120000.00, NULL, '2025-12-26 02:11:31', '2025-12-26 02:11:31'),
(36, 28, 4, 1, 120000.00, NULL, '2025-12-26 02:11:31', '2025-12-26 02:11:31'),
(37, 29, 11, 1, 12000.00, NULL, '2025-12-26 02:18:00', '2025-12-26 02:18:00'),
(38, 30, 5, 1, 120000.00, NULL, '2025-12-26 02:18:00', '2025-12-26 02:18:00'),
(39, 31, 6, 2, 240000.00, NULL, '2025-12-26 02:21:52', '2025-12-26 02:21:52'),
(40, 32, 6, 5, 600000.00, NULL, '2025-12-26 02:22:49', '2025-12-26 02:22:49'),
(41, 33, 6, 5, 600000.00, NULL, '2025-12-26 02:23:03', '2025-12-26 02:23:03'),
(42, 34, 6, 3, 360000.00, NULL, '2025-12-26 02:30:39', '2025-12-26 02:30:39'),
(43, 35, 12, 1, 10000.00, NULL, '2026-05-25 09:17:02', '2026-05-25 09:17:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jastipers`
--

CREATE TABLE `jastipers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `profile_toko` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_toko` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jangkauan` text COLLATE utf8mb4_unicode_ci,
  `rating` decimal(2,1) NOT NULL DEFAULT '0.0',
  `tanggal_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rekening_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jastipers`
--

INSERT INTO `jastipers` (`id`, `user_id`, `profile_toko`, `nama_toko`, `no_hp`, `jangkauan`, `rating`, `tanggal_daftar`, `deleted_at`, `created_at`, `updated_at`, `rekening_id`) VALUES
(1, 3, 'jastipers/profile/KocY8k6OgRUh7fk5uD8UUuPRci5LN8tEeHt8E6ao.png', 'Toko Jastiper', '081268433470', 'Seluruh Indonesia', 4.5, '2025-12-11 02:12:51', NULL, '2025-12-11 02:12:51', '2025-12-14 00:31:41', 1),
(2, 6, 'jastipers/profile/LkRC6S7qy4xucPyg2sdx8B1eog87iIHrS3eapUDr.png', 'firefly', '081298765432', 'Seluruh Indonesia', 0.0, '2025-12-14 04:13:21', NULL, '2025-12-13 21:13:21', '2025-12-13 21:13:43', 4),
(3, 8, 'jastipers/profile/yeI8lgZ1NUIGR0pxR4EIiTF6cqyIvShAsTZU3Y5V', 'jastip terpecaya', '08282828221', 'riau', 0.0, '2026-05-25 10:28:20', NULL, '2026-05-25 03:28:20', '2026-05-25 08:16:28', 5),
(4, 9, NULL, 'jastip terpecaya', '08122928112', 'riau', 0.0, '2026-05-25 13:55:25', NULL, '2026-05-25 06:55:25', '2026-05-25 08:17:34', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jastiper_followers`
--

CREATE TABLE `jastiper_followers` (
  `id` bigint UNSIGNED NOT NULL,
  `jastiper_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(2, 'Pakaian (Fashion)', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(3, 'Makanan & Minuman', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(4, 'Kesehatan & Kecantikan', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(5, 'Otomotif', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(6, 'Mainan & Hobi', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(7, 'Perlengkapan Rumah', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(8, 'Lain-lain', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelola_danas`
--

CREATE TABLE `kelola_danas` (
  `id` bigint UNSIGNED NOT NULL,
  `pembayaran_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `status_dana` enum('ditahan','dilepaskan','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditahan',
  `tanggal_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `aksi` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `aksi`, `deskripsi`, `waktu`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'login', 'User logged in', '2025-12-11 19:36:06', NULL, '2025-12-11 19:36:06', '2025-12-11 19:36:06'),
(2, 3, 'login', 'User logged in', '2025-12-13 07:42:04', NULL, '2025-12-13 07:42:04', '2025-12-13 07:42:04'),
(3, 3, 'logout', 'User logged out', '2025-12-13 07:52:25', NULL, '2025-12-13 07:52:25', '2025-12-13 07:52:25'),
(4, 5, 'login', 'User logged in', '2025-12-13 07:55:12', NULL, '2025-12-13 07:55:12', '2025-12-13 07:55:12'),
(5, 5, 'logout', 'User logged out', '2025-12-13 07:56:32', NULL, '2025-12-13 07:56:32', '2025-12-13 07:56:32'),
(6, 3, 'login', 'User logged in', '2025-12-13 07:56:43', NULL, '2025-12-13 07:56:43', '2025-12-13 07:56:43'),
(7, 3, 'logout', 'User logged out', '2025-12-13 07:56:58', NULL, '2025-12-13 07:56:58', '2025-12-13 07:56:58'),
(8, 1, 'login', 'User logged in', '2025-12-13 07:57:10', NULL, '2025-12-13 07:57:10', '2025-12-13 07:57:10'),
(9, 1, 'logout', 'User logged out', '2025-12-13 07:59:49', NULL, '2025-12-13 07:59:49', '2025-12-13 07:59:49'),
(10, 3, 'login', 'User logged in', '2025-12-13 08:00:53', NULL, '2025-12-13 08:00:53', '2025-12-13 08:00:53'),
(11, 3, 'logout', 'User logged out', '2025-12-13 08:01:30', NULL, '2025-12-13 08:01:30', '2025-12-13 08:01:30'),
(12, 5, 'login', 'User logged in', '2025-12-13 08:01:39', NULL, '2025-12-13 08:01:39', '2025-12-13 08:01:39'),
(13, 5, 'logout', 'User logged out', '2025-12-13 08:45:52', NULL, '2025-12-13 08:45:52', '2025-12-13 08:45:52'),
(14, 1, 'login', 'User logged in', '2025-12-13 08:46:38', NULL, '2025-12-13 08:46:38', '2025-12-13 08:46:38'),
(15, 1, 'logout', 'User logged out', '2025-12-13 09:04:33', NULL, '2025-12-13 09:04:33', '2025-12-13 09:04:33'),
(16, 5, 'login', 'User logged in', '2025-12-13 09:04:48', NULL, '2025-12-13 09:04:48', '2025-12-13 09:04:48'),
(17, 5, 'logout', 'User logged out', '2025-12-13 09:05:30', NULL, '2025-12-13 09:05:30', '2025-12-13 09:05:30'),
(18, 1, 'login', 'User logged in', '2025-12-13 09:05:58', NULL, '2025-12-13 09:05:58', '2025-12-13 09:05:58'),
(19, 1, 'logout', 'User logged out', '2025-12-13 09:07:37', NULL, '2025-12-13 09:07:37', '2025-12-13 09:07:37'),
(20, 5, 'login', 'User logged in', '2025-12-13 09:07:54', NULL, '2025-12-13 09:07:54', '2025-12-13 09:07:54'),
(21, 5, 'logout', 'User logged out', '2025-12-13 09:10:37', NULL, '2025-12-13 09:10:37', '2025-12-13 09:10:37'),
(22, 3, 'login', 'User logged in', '2025-12-13 09:10:56', NULL, '2025-12-13 09:10:56', '2025-12-13 09:10:56'),
(23, 3, 'logout', 'User logged out', '2025-12-13 09:11:34', NULL, '2025-12-13 09:11:34', '2025-12-13 09:11:34'),
(24, 5, 'login', 'User logged in', '2025-12-13 09:11:53', NULL, '2025-12-13 09:11:53', '2025-12-13 09:11:53'),
(25, 5, 'logout', 'User logged out', '2025-12-13 09:12:55', NULL, '2025-12-13 09:12:55', '2025-12-13 09:12:55'),
(26, 3, 'login', 'User logged in', '2025-12-13 09:13:07', NULL, '2025-12-13 09:13:07', '2025-12-13 09:13:07'),
(27, 3, 'logout', 'User logged out', '2025-12-13 09:17:15', NULL, '2025-12-13 09:17:15', '2025-12-13 09:17:15'),
(28, 5, 'login', 'User logged in', '2025-12-13 09:18:41', NULL, '2025-12-13 09:18:41', '2025-12-13 09:18:41'),
(29, 5, 'logout', 'User logged out', '2025-12-13 09:20:38', NULL, '2025-12-13 09:20:38', '2025-12-13 09:20:38'),
(30, 1, 'login', 'User logged in', '2025-12-13 09:23:46', NULL, '2025-12-13 09:23:46', '2025-12-13 09:23:46'),
(31, 1, 'logout', 'User logged out', '2025-12-13 09:26:22', NULL, '2025-12-13 09:26:22', '2025-12-13 09:26:22'),
(32, 3, 'login', 'User logged in', '2025-12-13 09:26:41', NULL, '2025-12-13 09:26:41', '2025-12-13 09:26:41'),
(33, 3, 'logout', 'User logged out', '2025-12-13 09:28:28', NULL, '2025-12-13 09:28:28', '2025-12-13 09:28:28'),
(34, 3, 'login', 'User logged in', '2025-12-13 09:36:57', NULL, '2025-12-13 09:36:57', '2025-12-13 09:36:57'),
(35, 1, 'login', 'User logged in', '2025-12-13 18:09:49', NULL, '2025-12-13 18:09:49', '2025-12-13 18:09:49'),
(36, 1, 'logout', 'User logged out', '2025-12-13 18:13:12', NULL, '2025-12-13 18:13:12', '2025-12-13 18:13:12'),
(37, 3, 'login', 'User logged in', '2025-12-13 18:13:23', NULL, '2025-12-13 18:13:23', '2025-12-13 18:13:23'),
(38, 3, 'logout', 'User logged out', '2025-12-13 18:15:01', NULL, '2025-12-13 18:15:01', '2025-12-13 18:15:01'),
(39, 5, 'login', 'User logged in', '2025-12-13 18:15:20', NULL, '2025-12-13 18:15:20', '2025-12-13 18:15:20'),
(40, 5, 'logout', 'User logged out', '2025-12-13 18:15:40', NULL, '2025-12-13 18:15:40', '2025-12-13 18:15:40'),
(41, 3, 'login', 'User logged in', '2025-12-13 18:15:52', NULL, '2025-12-13 18:15:52', '2025-12-13 18:15:52'),
(42, 3, 'logout', 'User logged out', '2025-12-13 18:16:40', NULL, '2025-12-13 18:16:40', '2025-12-13 18:16:40'),
(43, 5, 'login', 'User logged in', '2025-12-13 18:16:50', NULL, '2025-12-13 18:16:50', '2025-12-13 18:16:50'),
(44, 5, 'logout', 'User logged out', '2025-12-13 18:20:54', NULL, '2025-12-13 18:20:54', '2025-12-13 18:20:54'),
(45, 1, 'login', 'User logged in', '2025-12-13 18:21:14', NULL, '2025-12-13 18:21:14', '2025-12-13 18:21:14'),
(46, 1, 'logout', 'User logged out', '2025-12-13 18:21:29', NULL, '2025-12-13 18:21:29', '2025-12-13 18:21:29'),
(47, 3, 'login', 'User logged in', '2025-12-13 18:21:40', NULL, '2025-12-13 18:21:40', '2025-12-13 18:21:40'),
(48, 3, 'logout', 'User logged out', '2025-12-13 18:21:48', NULL, '2025-12-13 18:21:48', '2025-12-13 18:21:48'),
(49, 3, 'login', 'User logged in', '2025-12-13 18:22:04', NULL, '2025-12-13 18:22:04', '2025-12-13 18:22:04'),
(50, 3, 'logout', 'User logged out', '2025-12-13 18:22:07', NULL, '2025-12-13 18:22:07', '2025-12-13 18:22:07'),
(51, 1, 'login', 'User logged in', '2025-12-13 18:22:20', NULL, '2025-12-13 18:22:20', '2025-12-13 18:22:20'),
(52, 1, 'logout', 'User logged out', '2025-12-13 18:22:39', NULL, '2025-12-13 18:22:39', '2025-12-13 18:22:39'),
(53, 5, 'login', 'User logged in', '2025-12-13 18:23:00', NULL, '2025-12-13 18:23:00', '2025-12-13 18:23:00'),
(54, 5, 'logout', 'User logged out', '2025-12-13 18:23:19', NULL, '2025-12-13 18:23:19', '2025-12-13 18:23:19'),
(55, 3, 'login', 'User logged in', '2025-12-13 18:23:35', NULL, '2025-12-13 18:23:35', '2025-12-13 18:23:35'),
(56, 3, 'logout', 'User logged out', '2025-12-13 18:24:27', NULL, '2025-12-13 18:24:27', '2025-12-13 18:24:27'),
(57, 5, 'login', 'User logged in', '2025-12-13 18:24:45', NULL, '2025-12-13 18:24:45', '2025-12-13 18:24:45'),
(58, 5, 'logout', 'User logged out', '2025-12-13 18:25:19', NULL, '2025-12-13 18:25:19', '2025-12-13 18:25:19'),
(59, 3, 'login', 'User logged in', '2025-12-13 18:25:33', NULL, '2025-12-13 18:25:33', '2025-12-13 18:25:33'),
(60, 3, 'logout', 'User logged out', '2025-12-13 18:26:03', NULL, '2025-12-13 18:26:03', '2025-12-13 18:26:03'),
(61, 5, 'login', 'User logged in', '2025-12-13 18:26:13', NULL, '2025-12-13 18:26:13', '2025-12-13 18:26:13'),
(62, 5, 'logout', 'User logged out', '2025-12-13 18:26:56', NULL, '2025-12-13 18:26:56', '2025-12-13 18:26:56'),
(63, 1, 'login', 'User logged in', '2025-12-13 18:27:26', NULL, '2025-12-13 18:27:26', '2025-12-13 18:27:26'),
(64, 1, 'logout', 'User logged out', '2025-12-13 18:27:43', NULL, '2025-12-13 18:27:43', '2025-12-13 18:27:43'),
(65, 5, 'login', 'User logged in', '2025-12-13 19:17:56', NULL, '2025-12-13 19:17:56', '2025-12-13 19:17:56'),
(66, 5, 'logout', 'User logged out', '2025-12-13 19:18:45', NULL, '2025-12-13 19:18:45', '2025-12-13 19:18:45'),
(67, 1, 'login', 'User logged in', '2025-12-13 19:19:11', NULL, '2025-12-13 19:19:11', '2025-12-13 19:19:11'),
(68, 1, 'logout', 'User logged out', '2025-12-13 19:19:27', NULL, '2025-12-13 19:19:27', '2025-12-13 19:19:27'),
(69, 3, 'login', 'User logged in', '2025-12-13 19:19:41', NULL, '2025-12-13 19:19:41', '2025-12-13 19:19:41'),
(70, 3, 'logout', 'User logged out', '2025-12-13 19:19:53', NULL, '2025-12-13 19:19:53', '2025-12-13 19:19:53'),
(71, 5, 'login', 'User logged in', '2025-12-13 19:20:14', NULL, '2025-12-13 19:20:14', '2025-12-13 19:20:14'),
(72, 5, 'logout', 'User logged out', '2025-12-13 19:34:45', NULL, '2025-12-13 19:34:45', '2025-12-13 19:34:45'),
(73, 1, 'login', 'User logged in', '2025-12-13 19:35:15', NULL, '2025-12-13 19:35:15', '2025-12-13 19:35:15'),
(74, 1, 'logout', 'User logged out', '2025-12-13 19:35:31', NULL, '2025-12-13 19:35:31', '2025-12-13 19:35:31'),
(75, 5, 'login', 'User logged in', '2025-12-13 19:35:45', NULL, '2025-12-13 19:35:45', '2025-12-13 19:35:45'),
(76, 5, 'logout', 'User logged out', '2025-12-13 19:36:23', NULL, '2025-12-13 19:36:23', '2025-12-13 19:36:23'),
(77, 3, 'login', 'User logged in', '2025-12-13 19:36:39', NULL, '2025-12-13 19:36:39', '2025-12-13 19:36:39'),
(78, 3, 'logout', 'User logged out', '2025-12-13 19:37:02', NULL, '2025-12-13 19:37:02', '2025-12-13 19:37:02'),
(79, 1, 'login', 'User logged in', '2025-12-13 19:37:20', NULL, '2025-12-13 19:37:20', '2025-12-13 19:37:20'),
(80, 1, 'logout', 'User logged out', '2025-12-13 19:37:31', NULL, '2025-12-13 19:37:31', '2025-12-13 19:37:31'),
(81, 3, 'login', 'User logged in', '2025-12-13 19:37:45', NULL, '2025-12-13 19:37:45', '2025-12-13 19:37:45'),
(82, 3, 'logout', 'User logged out', '2025-12-13 19:38:03', NULL, '2025-12-13 19:38:03', '2025-12-13 19:38:03'),
(83, 5, 'login', 'User logged in', '2025-12-13 19:38:17', NULL, '2025-12-13 19:38:17', '2025-12-13 19:38:17'),
(84, 5, 'logout', 'User logged out', '2025-12-13 19:38:52', NULL, '2025-12-13 19:38:52', '2025-12-13 19:38:52'),
(85, 1, 'login', 'User logged in', '2025-12-13 19:39:06', NULL, '2025-12-13 19:39:06', '2025-12-13 19:39:06'),
(86, 1, 'logout', 'User logged out', '2025-12-13 19:39:16', NULL, '2025-12-13 19:39:16', '2025-12-13 19:39:16'),
(87, 3, 'login', 'User logged in', '2025-12-13 19:39:27', NULL, '2025-12-13 19:39:27', '2025-12-13 19:39:27'),
(88, 3, 'logout', 'User logged out', '2025-12-13 19:41:27', NULL, '2025-12-13 19:41:27', '2025-12-13 19:41:27'),
(89, 5, 'login', 'User logged in', '2025-12-13 19:50:00', NULL, '2025-12-13 19:50:00', '2025-12-13 19:50:00'),
(90, 5, 'logout', 'User logged out', '2025-12-13 19:54:09', NULL, '2025-12-13 19:54:09', '2025-12-13 19:54:09'),
(91, 1, 'login', 'User logged in', '2025-12-13 19:54:21', NULL, '2025-12-13 19:54:21', '2025-12-13 19:54:21'),
(92, 1, 'logout', 'User logged out', '2025-12-13 20:30:20', NULL, '2025-12-13 20:30:20', '2025-12-13 20:30:20'),
(93, 1, 'login', 'User logged in', '2025-12-13 20:39:09', NULL, '2025-12-13 20:39:09', '2025-12-13 20:39:09'),
(94, 1, 'logout', 'User logged out', '2025-12-13 20:40:15', NULL, '2025-12-13 20:40:15', '2025-12-13 20:40:15'),
(95, 3, 'login', 'User logged in', '2025-12-13 20:40:50', NULL, '2025-12-13 20:40:50', '2025-12-13 20:40:50'),
(96, 3, 'logout', 'User logged out', '2025-12-13 20:41:49', NULL, '2025-12-13 20:41:49', '2025-12-13 20:41:49'),
(97, 5, 'login', 'User logged in', '2025-12-13 20:41:58', NULL, '2025-12-13 20:41:58', '2025-12-13 20:41:58'),
(98, 5, 'logout', 'User logged out', '2025-12-13 20:44:17', NULL, '2025-12-13 20:44:17', '2025-12-13 20:44:17'),
(99, 1, 'login', 'User logged in', '2025-12-13 20:44:46', NULL, '2025-12-13 20:44:46', '2025-12-13 20:44:46'),
(100, 1, 'logout', 'User logged out', '2025-12-13 20:45:28', NULL, '2025-12-13 20:45:28', '2025-12-13 20:45:28'),
(101, 5, 'login', 'User logged in', '2025-12-13 20:45:38', NULL, '2025-12-13 20:45:38', '2025-12-13 20:45:38'),
(102, 5, 'logout', 'User logged out', '2025-12-13 20:50:02', NULL, '2025-12-13 20:50:02', '2025-12-13 20:50:02'),
(103, 1, 'login', 'User logged in', '2025-12-13 20:50:17', NULL, '2025-12-13 20:50:17', '2025-12-13 20:50:17'),
(104, 1, 'logout', 'User logged out', '2025-12-13 20:50:51', NULL, '2025-12-13 20:50:51', '2025-12-13 20:50:51'),
(105, 5, 'login', 'User logged in', '2025-12-13 20:51:15', NULL, '2025-12-13 20:51:15', '2025-12-13 20:51:15'),
(106, 5, 'logout', 'User logged out', '2025-12-13 20:52:02', NULL, '2025-12-13 20:52:02', '2025-12-13 20:52:02'),
(107, 3, 'login', 'User logged in', '2025-12-13 20:52:14', NULL, '2025-12-13 20:52:14', '2025-12-13 20:52:14'),
(108, 3, 'logout', 'User logged out', '2025-12-13 20:52:52', NULL, '2025-12-13 20:52:52', '2025-12-13 20:52:52'),
(109, 3, 'login', 'User logged in', '2025-12-13 20:53:06', NULL, '2025-12-13 20:53:06', '2025-12-13 20:53:06'),
(110, 3, 'logout', 'User logged out', '2025-12-13 20:53:25', NULL, '2025-12-13 20:53:25', '2025-12-13 20:53:25'),
(111, 5, 'login', 'User logged in', '2025-12-13 20:54:19', NULL, '2025-12-13 20:54:19', '2025-12-13 20:54:19'),
(112, 5, 'logout', 'User logged out', '2025-12-13 20:55:39', NULL, '2025-12-13 20:55:39', '2025-12-13 20:55:39'),
(113, 1, 'login', 'User logged in', '2025-12-13 20:55:57', NULL, '2025-12-13 20:55:57', '2025-12-13 20:55:57'),
(114, 1, 'logout', 'User logged out', '2025-12-13 21:01:57', NULL, '2025-12-13 21:01:57', '2025-12-13 21:01:57'),
(115, 5, 'login', 'User logged in', '2025-12-13 21:02:04', NULL, '2025-12-13 21:02:04', '2025-12-13 21:02:04'),
(116, 5, 'logout', 'User logged out', '2025-12-13 21:06:51', NULL, '2025-12-13 21:06:51', '2025-12-13 21:06:51'),
(117, 1, 'login', 'User logged in', '2025-12-13 21:08:03', NULL, '2025-12-13 21:08:03', '2025-12-13 21:08:03'),
(118, 1, 'logout', 'User logged out', '2025-12-13 21:08:22', NULL, '2025-12-13 21:08:22', '2025-12-13 21:08:22'),
(119, 3, 'login', 'User logged in', '2025-12-13 21:08:49', NULL, '2025-12-13 21:08:49', '2025-12-13 21:08:49'),
(120, 3, 'logout', 'User logged out', '2025-12-13 21:09:24', NULL, '2025-12-13 21:09:24', '2025-12-13 21:09:24'),
(121, 5, 'login', 'User logged in', '2025-12-13 21:09:31', NULL, '2025-12-13 21:09:31', '2025-12-13 21:09:31'),
(122, 5, 'logout', 'User logged out', '2025-12-13 21:10:01', NULL, '2025-12-13 21:10:01', '2025-12-13 21:10:01'),
(123, 1, 'login', 'User logged in', '2025-12-13 21:10:11', NULL, '2025-12-13 21:10:11', '2025-12-13 21:10:11'),
(124, 1, 'logout', 'User logged out', '2025-12-13 21:10:41', NULL, '2025-12-13 21:10:41', '2025-12-13 21:10:41'),
(125, 3, 'login', 'User logged in', '2025-12-13 21:10:55', NULL, '2025-12-13 21:10:55', '2025-12-13 21:10:55'),
(126, 3, 'logout', 'User logged out', '2025-12-13 21:11:16', NULL, '2025-12-13 21:11:16', '2025-12-13 21:11:16'),
(127, 2, 'login', 'User logged in', '2025-12-13 21:11:30', NULL, '2025-12-13 21:11:30', '2025-12-13 21:11:30'),
(128, 2, 'logout', 'User logged out', '2025-12-13 21:11:43', NULL, '2025-12-13 21:11:43', '2025-12-13 21:11:43'),
(129, 6, 'login', 'User logged in', '2025-12-13 21:12:34', NULL, '2025-12-13 21:12:34', '2025-12-13 21:12:34'),
(130, 6, 'logout', 'User logged out', '2025-12-13 21:13:21', NULL, '2025-12-13 21:13:21', '2025-12-13 21:13:21'),
(131, 6, 'login', 'User logged in', '2025-12-13 21:13:30', NULL, '2025-12-13 21:13:30', '2025-12-13 21:13:30'),
(132, 6, 'logout', 'User logged out', '2025-12-13 21:14:29', NULL, '2025-12-13 21:14:29', '2025-12-13 21:14:29'),
(133, 5, 'login', 'User logged in', '2025-12-13 21:15:08', NULL, '2025-12-13 21:15:08', '2025-12-13 21:15:08'),
(134, 5, 'logout', 'User logged out', '2025-12-13 21:17:45', NULL, '2025-12-13 21:17:45', '2025-12-13 21:17:45'),
(135, 1, 'login', 'User logged in', '2025-12-13 21:17:57', NULL, '2025-12-13 21:17:57', '2025-12-13 21:17:57'),
(136, 1, 'logout', 'User logged out', '2025-12-13 21:23:09', NULL, '2025-12-13 21:23:09', '2025-12-13 21:23:09'),
(137, 3, 'login', 'User logged in', '2025-12-13 21:23:24', NULL, '2025-12-13 21:23:24', '2025-12-13 21:23:24'),
(138, 3, 'logout', 'User logged out', '2025-12-13 21:24:40', NULL, '2025-12-13 21:24:40', '2025-12-13 21:24:40'),
(139, 6, 'login', 'User logged in', '2025-12-13 21:24:48', NULL, '2025-12-13 21:24:48', '2025-12-13 21:24:48'),
(140, 6, 'logout', 'User logged out', '2025-12-13 21:25:30', NULL, '2025-12-13 21:25:30', '2025-12-13 21:25:30'),
(141, 5, 'login', 'User logged in', '2025-12-13 21:25:38', NULL, '2025-12-13 21:25:38', '2025-12-13 21:25:38'),
(142, 5, 'logout', 'User logged out', '2025-12-13 21:25:59', NULL, '2025-12-13 21:25:59', '2025-12-13 21:25:59'),
(143, 1, 'login', 'User logged in', '2025-12-13 21:26:12', NULL, '2025-12-13 21:26:12', '2025-12-13 21:26:12'),
(144, 1, 'logout', 'User logged out', '2025-12-13 21:26:49', NULL, '2025-12-13 21:26:49', '2025-12-13 21:26:49'),
(145, 3, 'login', 'User logged in', '2025-12-13 21:27:01', NULL, '2025-12-13 21:27:01', '2025-12-13 21:27:01'),
(146, 3, 'logout', 'User logged out', '2025-12-13 21:27:27', NULL, '2025-12-13 21:27:27', '2025-12-13 21:27:27'),
(147, 6, 'login', 'User logged in', '2025-12-13 21:27:40', NULL, '2025-12-13 21:27:40', '2025-12-13 21:27:40'),
(148, 6, 'logout', 'User logged out', '2025-12-13 22:35:24', NULL, '2025-12-13 22:35:24', '2025-12-13 22:35:24'),
(149, 5, 'login', 'User logged in', '2025-12-13 22:35:42', NULL, '2025-12-13 22:35:42', '2025-12-13 22:35:42'),
(150, 5, 'logout', 'User logged out', '2025-12-13 22:36:37', NULL, '2025-12-13 22:36:37', '2025-12-13 22:36:37'),
(151, 1, 'login', 'User logged in', '2025-12-13 22:36:47', NULL, '2025-12-13 22:36:47', '2025-12-13 22:36:47'),
(152, 1, 'logout', 'User logged out', '2025-12-13 22:36:58', NULL, '2025-12-13 22:36:58', '2025-12-13 22:36:58'),
(153, 3, 'login', 'User logged in', '2025-12-13 22:37:08', NULL, '2025-12-13 22:37:08', '2025-12-13 22:37:08'),
(154, 3, 'logout', 'User logged out', '2025-12-13 22:37:26', NULL, '2025-12-13 22:37:26', '2025-12-13 22:37:26'),
(155, 6, 'login', 'User logged in', '2025-12-13 22:37:39', NULL, '2025-12-13 22:37:39', '2025-12-13 22:37:39'),
(156, 6, 'logout', 'User logged out', '2025-12-13 22:38:07', NULL, '2025-12-13 22:38:07', '2025-12-13 22:38:07'),
(157, 5, 'login', 'User logged in', '2025-12-13 22:38:18', NULL, '2025-12-13 22:38:18', '2025-12-13 22:38:18'),
(158, 5, 'logout', 'User logged out', '2025-12-13 22:38:36', NULL, '2025-12-13 22:38:36', '2025-12-13 22:38:36'),
(159, 1, 'login', 'User logged in', '2025-12-13 22:38:48', NULL, '2025-12-13 22:38:48', '2025-12-13 22:38:48'),
(160, 1, 'logout', 'User logged out', '2025-12-13 22:39:03', NULL, '2025-12-13 22:39:03', '2025-12-13 22:39:03'),
(161, 3, 'login', 'User logged in', '2025-12-13 22:39:13', NULL, '2025-12-13 22:39:13', '2025-12-13 22:39:13'),
(162, 3, 'logout', 'User logged out', '2025-12-13 22:39:32', NULL, '2025-12-13 22:39:32', '2025-12-13 22:39:32'),
(163, 3, 'login', 'User logged in', '2025-12-13 22:39:43', NULL, '2025-12-13 22:39:43', '2025-12-13 22:39:43'),
(164, 3, 'logout', 'User logged out', '2025-12-13 22:39:52', NULL, '2025-12-13 22:39:52', '2025-12-13 22:39:52'),
(165, 6, 'login', 'User logged in', '2025-12-13 22:40:04', NULL, '2025-12-13 22:40:04', '2025-12-13 22:40:04'),
(166, 6, 'logout', 'User logged out', '2025-12-13 22:56:46', NULL, '2025-12-13 22:56:46', '2025-12-13 22:56:46'),
(167, 5, 'login', 'User logged in', '2025-12-13 22:57:00', NULL, '2025-12-13 22:57:00', '2025-12-13 22:57:00'),
(168, 5, 'logout', 'User logged out', '2025-12-14 00:25:54', NULL, '2025-12-14 00:25:54', '2025-12-14 00:25:54'),
(169, 3, 'login', 'User logged in', '2025-12-14 00:27:35', NULL, '2025-12-14 00:27:35', '2025-12-14 00:27:35'),
(170, 3, 'logout', 'User logged out', '2025-12-14 00:31:46', NULL, '2025-12-14 00:31:46', '2025-12-14 00:31:46'),
(171, 5, 'login', 'User logged in', '2025-12-14 01:08:17', NULL, '2025-12-14 01:08:17', '2025-12-14 01:08:17'),
(172, 5, 'logout', 'User logged out', '2025-12-14 01:13:26', NULL, '2025-12-14 01:13:26', '2025-12-14 01:13:26'),
(173, 1, 'login', 'User logged in', '2025-12-14 01:13:37', NULL, '2025-12-14 01:13:37', '2025-12-14 01:13:37'),
(174, 1, 'logout', 'User logged out', '2025-12-14 01:14:19', NULL, '2025-12-14 01:14:19', '2025-12-14 01:14:19'),
(175, 3, 'login', 'User logged in', '2025-12-14 01:14:31', NULL, '2025-12-14 01:14:31', '2025-12-14 01:14:31'),
(176, 3, 'logout', 'User logged out', '2025-12-14 01:15:48', NULL, '2025-12-14 01:15:48', '2025-12-14 01:15:48'),
(177, 5, 'login', 'User logged in', '2025-12-14 01:15:56', NULL, '2025-12-14 01:15:56', '2025-12-14 01:15:56'),
(178, 5, 'logout', 'User logged out', '2025-12-14 01:18:36', NULL, '2025-12-14 01:18:36', '2025-12-14 01:18:36'),
(179, 5, 'login', 'User logged in', '2025-12-14 01:19:29', NULL, '2025-12-14 01:19:29', '2025-12-14 01:19:29'),
(180, 3, 'login', 'User logged in', '2025-12-14 18:52:25', NULL, '2025-12-14 18:52:25', '2025-12-14 18:52:25'),
(181, 3, 'login', 'User logged in', '2025-12-14 23:46:26', NULL, '2025-12-14 23:46:26', '2025-12-14 23:46:26'),
(182, 1, 'login', 'User logged in', '2025-12-16 01:12:52', NULL, '2025-12-16 01:12:52', '2025-12-16 01:12:52'),
(183, 1, 'logout', 'User logged out', '2025-12-16 02:31:55', NULL, '2025-12-16 02:31:55', '2025-12-16 02:31:55'),
(184, 5, 'login', 'User logged in', '2025-12-24 23:11:30', NULL, '2025-12-24 23:11:30', '2025-12-24 23:11:30'),
(185, 5, 'login', 'User logged in', '2025-12-26 02:02:24', NULL, '2025-12-26 02:02:24', '2025-12-26 02:02:24'),
(186, 5, 'logout', 'User logged out', '2025-12-26 02:14:01', NULL, '2025-12-26 02:14:01', '2025-12-26 02:14:01'),
(187, 1, 'login', 'User logged in', '2025-12-26 02:14:15', NULL, '2025-12-26 02:14:15', '2025-12-26 02:14:15'),
(188, 1, 'logout', 'User logged out', '2025-12-26 02:14:33', NULL, '2025-12-26 02:14:33', '2025-12-26 02:14:33'),
(189, 6, 'login', 'User logged in', '2025-12-26 02:16:42', NULL, '2025-12-26 02:16:42', '2025-12-26 02:16:42'),
(190, 6, 'logout', 'User logged out', '2025-12-26 02:16:56', NULL, '2025-12-26 02:16:56', '2025-12-26 02:16:56'),
(191, 5, 'login', 'User logged in', '2025-12-26 02:17:38', NULL, '2025-12-26 02:17:38', '2025-12-26 02:17:38'),
(192, 5, 'logout', 'User logged out', '2025-12-26 02:18:30', NULL, '2025-12-26 02:18:30', '2025-12-26 02:18:30'),
(193, 1, 'login', 'User logged in', '2025-12-26 02:18:44', NULL, '2025-12-26 02:18:44', '2025-12-26 02:18:44'),
(194, 1, 'logout', 'User logged out', '2025-12-26 02:19:20', NULL, '2025-12-26 02:19:20', '2025-12-26 02:19:20'),
(195, 5, 'login', 'User logged in', '2025-12-26 02:19:34', NULL, '2025-12-26 02:19:34', '2025-12-26 02:19:34'),
(196, 5, 'logout', 'User logged out', '2025-12-26 02:19:42', NULL, '2025-12-26 02:19:42', '2025-12-26 02:19:42'),
(197, 6, 'login', 'User logged in', '2025-12-26 02:20:00', NULL, '2025-12-26 02:20:00', '2025-12-26 02:20:00'),
(198, 6, 'logout', 'User logged out', '2025-12-26 02:20:07', NULL, '2025-12-26 02:20:07', '2025-12-26 02:20:07'),
(199, 3, 'login', 'User logged in', '2025-12-26 02:20:16', NULL, '2025-12-26 02:20:16', '2025-12-26 02:20:16'),
(200, 3, 'logout', 'User logged out', '2025-12-26 02:20:28', NULL, '2025-12-26 02:20:28', '2025-12-26 02:20:28'),
(201, 6, 'login', 'User logged in', '2025-12-26 02:20:38', NULL, '2025-12-26 02:20:38', '2025-12-26 02:20:38'),
(202, 6, 'logout', 'User logged out', '2025-12-26 02:20:50', NULL, '2025-12-26 02:20:50', '2025-12-26 02:20:50'),
(203, 5, 'login', 'User logged in', '2025-12-26 02:21:28', NULL, '2025-12-26 02:21:28', '2025-12-26 02:21:28'),
(204, 5, 'login', 'User logged in', '2025-12-29 07:04:33', NULL, '2025-12-29 07:04:33', '2025-12-29 07:04:33'),
(205, 5, 'logout', 'User logged out', '2025-12-29 07:06:07', NULL, '2025-12-29 07:06:07', '2025-12-29 07:06:07'),
(206, 6, 'login', 'User logged in', '2025-12-29 07:08:24', NULL, '2025-12-29 07:08:24', '2025-12-29 07:08:24'),
(207, 6, 'logout', 'User logged out', '2025-12-29 07:09:44', NULL, '2025-12-29 07:09:44', '2025-12-29 07:09:44'),
(208, 6, 'login', 'User logged in', '2025-12-29 07:14:30', NULL, '2025-12-29 07:14:30', '2025-12-29 07:14:30'),
(209, 2, 'login', 'User logged in', '2026-01-11 06:39:35', NULL, '2026-01-11 06:39:35', '2026-01-11 06:39:35'),
(210, 2, 'login', 'User logged in', '2026-01-22 19:11:03', NULL, '2026-01-22 19:11:03', '2026-01-22 19:11:03'),
(211, 8, 'login', 'User logged in', '2026-05-25 03:17:57', NULL, '2026-05-25 03:17:57', '2026-05-25 03:17:57'),
(212, 8, 'logout', 'User logged out', '2026-05-25 03:28:21', NULL, '2026-05-25 03:28:21', '2026-05-25 03:28:21'),
(213, 8, 'login', 'User logged in', '2026-05-25 03:54:10', NULL, '2026-05-25 03:54:10', '2026-05-25 03:54:10'),
(214, 8, 'login', 'User logged in', '2026-05-25 04:58:39', NULL, '2026-05-25 04:58:39', '2026-05-25 04:58:39'),
(215, 8, 'logout', 'User logged out', '2026-05-25 05:11:55', NULL, '2026-05-25 05:11:55', '2026-05-25 05:11:55'),
(216, 3, 'login', 'User logged in', '2026-05-25 05:19:26', NULL, '2026-05-25 05:19:26', '2026-05-25 05:19:26'),
(217, 3, 'logout', 'User logged out', '2026-05-25 05:47:06', NULL, '2026-05-25 05:47:06', '2026-05-25 05:47:06'),
(218, 9, 'login', 'User logged in', '2026-05-25 06:51:17', NULL, '2026-05-25 06:51:17', '2026-05-25 06:51:17'),
(219, 9, 'logout', 'User logged out', '2026-05-25 06:55:25', NULL, '2026-05-25 06:55:25', '2026-05-25 06:55:25'),
(220, 9, 'login', 'User logged in', '2026-05-25 07:00:54', NULL, '2026-05-25 07:00:54', '2026-05-25 07:00:54'),
(221, 9, 'logout', 'User logged out', '2026-05-25 07:03:21', NULL, '2026-05-25 07:03:21', '2026-05-25 07:03:21'),
(222, 9, 'login', 'User logged in', '2026-05-25 07:28:27', NULL, '2026-05-25 07:28:27', '2026-05-25 07:28:27'),
(223, 9, 'logout', 'User logged out', '2026-05-25 07:29:24', NULL, '2026-05-25 07:29:24', '2026-05-25 07:29:24'),
(224, 2, 'login', 'User logged in', '2026-05-25 07:30:09', NULL, '2026-05-25 07:30:09', '2026-05-25 07:30:09'),
(225, 2, 'logout', 'User logged out', '2026-05-25 07:30:36', NULL, '2026-05-25 07:30:36', '2026-05-25 07:30:36'),
(226, 8, 'login', 'User logged in', '2026-05-25 08:15:25', NULL, '2026-05-25 08:15:25', '2026-05-25 08:15:25'),
(227, 8, 'logout', 'User logged out', '2026-05-25 08:16:31', NULL, '2026-05-25 08:16:31', '2026-05-25 08:16:31'),
(228, 9, 'login', 'User logged in', '2026-05-25 08:16:59', NULL, '2026-05-25 08:16:59', '2026-05-25 08:16:59'),
(229, 9, 'logout', 'User logged out', '2026-05-25 08:18:04', NULL, '2026-05-25 08:18:04', '2026-05-25 08:18:04'),
(230, 8, 'login', 'User logged in', '2026-05-25 08:18:34', NULL, '2026-05-25 08:18:34', '2026-05-25 08:18:34'),
(231, 8, 'logout', 'User logged out', '2026-05-25 08:24:19', NULL, '2026-05-25 08:24:19', '2026-05-25 08:24:19'),
(232, 2, 'login', 'User logged in', '2026-05-25 09:15:16', NULL, '2026-05-25 09:15:16', '2026-05-25 09:15:16'),
(233, 2, 'logout', 'User logged out', '2026-05-25 09:17:37', NULL, '2026-05-25 09:17:37', '2026-05-25 09:17:37'),
(234, 9, 'login', 'User logged in', '2026-05-25 09:18:40', NULL, '2026-05-25 09:18:40', '2026-05-25 09:18:40'),
(235, 9, 'logout', 'User logged out', '2026-05-25 09:19:04', NULL, '2026-05-25 09:19:04', '2026-05-25 09:19:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_14_084700_create_jastipers_table', 1),
(5, '2025_11_14_084710_create_kategoris_table', 1),
(6, '2025_11_14_084843_create_barangs_table', 1),
(7, '2025_11_14_084844_create_pesanans_table', 1),
(8, '2025_11_14_084855_create_detail_pesanans_table', 1),
(9, '2025_11_14_090753_create_pembayarans_table', 1),
(10, '2025_11_14_090755_create_rekenings_table', 1),
(11, '2025_11_14_090766_create_kelola_danas_table', 1),
(12, '2025_11_14_090927_create_log_aktivitas_table', 1),
(13, '2025_11_14_092055_create_ulasans_table', 1),
(14, '2025_11_15_072824_update_users_add_profile_fields', 1),
(15, '2025_12_03_133539_update_jastipers_table', 1),
(16, '2025_12_04_160956_create_alur_dana_table', 1),
(17, '2025_12_05_163243_add_profile_toko_to_jastipers_table', 1),
(18, '2025_12_06_173335_add_has_reviewed_to_pesanans_table', 1),
(19, '2025_12_07_094427_create_notifications_table', 1),
(20, '2025_12_10_085508_add_catatan_to_pesanans_table', 1),
(21, '2026_01_11_132538_create_jastiper_followers_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0b94c239-7dbf-42b7-a252-ac46d6c60b23', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#6** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":6}', NULL, '2025-12-13 19:19:20', '2025-12-13 19:19:20'),
('0bcf7353-c892-4bbc-9f40-ce3dc7b4a799', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 1.440.000) telah diunggah untuk Pesanan ID #1. Mohon konfirmasi segera.\",\"pesanan_id\":1,\"user_pembeli_id\":5}', '2025-12-13 18:11:30', '2025-12-13 07:56:25', '2025-12-13 18:11:30'),
('0bf50623-b914-4d4b-a54c-70871503c0b6', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 12.000) telah diunggah untuk Pesanan ID #2. Mohon konfirmasi segera.\",\"pesanan_id\":2,\"user_pembeli_id\":5}', '2025-12-13 18:11:17', '2025-12-13 09:05:16', '2025-12-13 18:11:17'),
('0f9ab504-44ef-454f-9144-5dafcee1fa15', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 132.000) telah diunggah untuk Pesanan ID #11. Mohon konfirmasi segera.\",\"pesanan_id\":11,\"user_pembeli_id\":5}', NULL, '2025-12-13 21:06:39', '2025-12-13 21:06:39'),
('146f46dd-e983-4a51-bc76-5ae54a880863', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#10** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":10}', NULL, '2025-12-13 20:50:37', '2025-12-13 20:50:37'),
('1cd8e86c-e8f0-4098-a0b8-e0f24fe6a568', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 24.000) telah diunggah untuk Pesanan ID #15. Mohon konfirmasi segera.\",\"pesanan_id\":15,\"user_pembeli_id\":5}', NULL, '2025-12-13 22:36:27', '2025-12-13 22:36:27'),
('1f12e0cb-5084-4302-9e76-912d05c56a49', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#9** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":9}', NULL, '2025-12-13 20:45:15', '2025-12-13 20:45:15'),
('22648598-f526-4564-a76c-c1388f23cf62', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#14**. Silakan cek status pencairan dana.\",\"pesanan_id\":14}', NULL, '2025-12-13 21:25:53', '2025-12-13 21:25:53'),
('242d6504-505a-4d9f-ac2a-a83301e68a5a', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#8**. Silakan cek status pencairan dana.\",\"pesanan_id\":8}', NULL, '2025-12-13 21:03:41', '2025-12-13 21:03:41'),
('25234bb2-93ed-49e3-b019-373af477ef20', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#16** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":16}', NULL, '2025-12-14 01:14:03', '2025-12-14 01:14:03'),
('2860d13b-f8fb-4e4b-946f-d53952e31dad', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 22.800** (Pesanan ID #15) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 1.200).\",\"pesanan_id\":15,\"jumlah_bersih\":22800,\"biaya_admin\":1200}', NULL, '2025-12-13 22:39:00', '2025-12-13 22:39:00'),
('2bad0ced-3bf0-49b0-8aef-74fe23afdf7d', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 10.000) telah diunggah untuk Pesanan ID #35. Mohon konfirmasi segera.\",\"pesanan_id\":35,\"user_pembeli_id\":2}', NULL, '2026-05-25 09:17:13', '2026-05-25 09:17:13'),
('2c84ea29-1f99-43e9-a6aa-519ec62a9aca', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 12.000) telah diunggah untuk Pesanan ID #29. Mohon konfirmasi segera.\",\"pesanan_id\":29,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:18:06', '2025-12-26 02:18:06'),
('32d245ef-0385-491d-8dce-9dcae5c542c6', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#29** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":29}', NULL, '2025-12-26 02:21:35', '2025-12-26 02:21:35'),
('33f947ae-d320-4800-b6e4-d52aece6c1ba', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#11** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":11}', NULL, '2025-12-13 21:09:39', '2025-12-13 21:09:39'),
('3713d253-de62-4de8-99ff-e8af0148689e', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 342.000** (Pesanan ID #8) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 18.000).\",\"pesanan_id\":8,\"jumlah_bersih\":342000,\"biaya_admin\":18000}', NULL, '2025-12-13 21:08:20', '2025-12-13 21:08:20'),
('3cc9b554-4f52-4ac1-afd4-5e3213f7e656', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 360.000) telah diunggah untuk Pesanan ID #8. Mohon konfirmasi segera.\",\"pesanan_id\":8,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 19:53:55', '2025-12-13 21:01:13'),
('3fbf8816-81e4-493d-ad59-e4dd85afc1b2', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #6 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":6}', NULL, '2025-12-13 19:19:20', '2025-12-13 19:19:20'),
('41f029ab-9182-4d44-a98f-742ff001b7b0', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#30**. Silakan cek status pencairan dana.\",\"pesanan_id\":30}', NULL, '2025-12-26 02:21:38', '2025-12-26 02:21:38'),
('42e223fb-e83e-4115-ac27-1efd0fdf09ae', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#11** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":11}', NULL, '2025-12-13 21:08:13', '2025-12-13 21:08:13'),
('478e0b74-0068-4f04-af67-3186fada227e', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#1** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":1}', NULL, '2025-12-13 09:11:16', '2025-12-13 09:11:16'),
('4b342222-7c74-4792-adc3-e93114a49ee5', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#15**. Silakan cek status pencairan dana.\",\"pesanan_id\":15}', NULL, '2025-12-13 22:38:29', '2025-12-13 22:38:29'),
('4bead5c8-4dac-45a4-8fc1-a5e0b1790728', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#1** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":1}', NULL, '2025-12-13 09:12:14', '2025-12-13 09:12:14'),
('4e0ac351-dd7a-4cd9-a464-4b99181d7b34', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#1** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":1}', NULL, '2025-12-13 09:07:34', '2025-12-13 09:07:34'),
('4f43c083-cf84-4533-8392-b0f4824ee382', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #1 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":1}', NULL, '2025-12-13 09:07:34', '2025-12-13 09:07:34'),
('52a96627-c2eb-4294-be9b-3e02c3149135', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 240.000) telah diunggah untuk Pesanan ID #7. Mohon konfirmasi segera.\",\"pesanan_id\":7,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 19:34:36', '2025-12-13 21:01:13'),
('54927e0d-cbc4-4ab1-9fbe-23f2a69c4eff', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #30 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":30}', NULL, '2025-12-26 02:19:17', '2025-12-26 02:19:17'),
('5587bb1f-3516-43ed-9566-0cda517b1ddb', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 228.000** (Pesanan ID #6) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 12.000).\",\"pesanan_id\":6,\"jumlah_bersih\":228000,\"biaya_admin\":12000}', NULL, '2025-12-13 19:35:27', '2025-12-13 19:35:27'),
('561bb103-b4bd-4331-990f-66c5299c9494', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#16** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":16}', NULL, '2025-12-14 01:19:52', '2025-12-14 01:19:52'),
('589d0f46-09a3-4728-88bb-d1f41789ac60', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#6** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":6}', NULL, '2025-12-13 19:20:28', '2025-12-13 19:20:28'),
('592bfd49-c13f-4fa2-9a1e-33ea460e9e8e', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#16**. Silakan cek status pencairan dana.\",\"pesanan_id\":16}', NULL, '2025-12-14 01:19:52', '2025-12-14 01:19:52'),
('5c4022b9-8fad-4a31-b850-25671a9221f1', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#7**. Silakan cek status pencairan dana.\",\"pesanan_id\":7}', '2025-12-13 21:01:13', '2025-12-13 19:38:27', '2025-12-13 21:01:13'),
('5ce22484-f2cc-4193-9dce-c4624c6cd9ba', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 240.000) telah diunggah untuk Pesanan ID #31. Mohon konfirmasi segera.\",\"pesanan_id\":31,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:21:57', '2025-12-26 02:21:57'),
('5d78756a-1232-446a-8f08-f1c2bb614ad3', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#8** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":8}', NULL, '2025-12-13 21:03:41', '2025-12-13 21:03:41'),
('5df74cd0-4e28-40b0-9edb-979cdc896fbd', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#16** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":16}', NULL, '2025-12-14 01:15:04', '2025-12-14 01:15:04'),
('62ed5f14-5bbf-4eb7-8142-0a6bfdd07710', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#28** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":28}', NULL, '2025-12-26 02:20:23', '2025-12-26 02:20:23'),
('634ddd46-0644-4838-a74e-dd7eea273343', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#13** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":13}', NULL, '2025-12-13 21:25:28', '2025-12-13 21:25:28'),
('6355b5dd-7fa9-43ee-a574-5461bb2f8d38', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#30** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":30}', NULL, '2025-12-26 02:19:17', '2025-12-26 02:19:17'),
('66e547cd-506a-4957-8ba1-4fa16c743705', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #9 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":9}', NULL, '2025-12-13 20:45:15', '2025-12-13 20:45:15'),
('69a97bf6-1a8d-4d58-a8e0-2d749d4f90b8', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#15** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":15}', NULL, '2025-12-13 22:36:55', '2025-12-13 22:36:55'),
('6a037c8b-f954-44c7-89f7-ae1fb79583f0', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 600.000) telah diunggah untuk Pesanan ID #33. Mohon konfirmasi segera.\",\"pesanan_id\":33,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:23:08', '2025-12-26 02:23:08'),
('6fae5c8b-e098-449e-9e4f-d15c0e66ea28', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#8** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":8}', NULL, '2025-12-13 20:41:46', '2025-12-13 20:41:46'),
('7405b702-b922-4b39-8d6d-c1d4dbff0f38', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#29** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":29}', NULL, '2025-12-26 02:19:11', '2025-12-26 02:19:11'),
('7439c6db-211e-4e09-9ad4-e8210ddc59f9', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#7** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":7}', NULL, '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
('760ccc4b-b368-4d6e-bd5f-b7755feb481a', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#7** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":7}', NULL, '2025-12-13 19:37:29', '2025-12-13 19:37:29'),
('7e886c9b-b8aa-41dc-9f4e-eef116e8b30f', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#8** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":8}', NULL, '2025-12-13 20:39:59', '2025-12-13 20:39:59'),
('8425dc38-ec31-4f21-98db-5822890bf73e', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#5** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":5}', NULL, '2025-12-13 18:23:48', '2025-12-13 18:23:48'),
('847bde75-1552-48cf-8099-76de4c598725', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#13**. Silakan cek status pencairan dana.\",\"pesanan_id\":13}', NULL, '2025-12-13 21:25:56', '2025-12-13 21:25:56'),
('865f05ab-d6d4-4291-b430-9b9d7ae24e64', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 228.000** (Pesanan ID #9) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 12.000).\",\"pesanan_id\":9,\"jumlah_bersih\":228000,\"biaya_admin\":12000}', NULL, '2025-12-13 21:00:22', '2025-12-13 21:00:22'),
('8d674a7f-33ab-4fb3-89e7-80f20b07425b', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#14** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":14}', NULL, '2025-12-13 21:25:53', '2025-12-13 21:25:53'),
('8f90d1fc-383a-4163-b801-22b23cacb12e', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#13** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":13}', NULL, '2025-12-13 21:22:58', '2025-12-13 21:22:58'),
('921a1a85-69d0-4f92-bbff-2ca844f5cc3c', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#15** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":15}', NULL, '2025-12-13 22:38:29', '2025-12-13 22:38:29'),
('9289491b-9025-43e3-8965-ba9893fda1d1', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #11 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":11}', NULL, '2025-12-13 21:08:13', '2025-12-13 21:08:13'),
('94abdffa-99eb-4f89-be53-d29fa74c8d56', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #10 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":10}', NULL, '2025-12-13 20:50:37', '2025-12-13 20:50:37'),
('9631730c-f8a4-42f0-beeb-3a9bab7ab6d7', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #5 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":5}', NULL, '2025-12-13 18:22:33', '2025-12-13 18:22:33'),
('969e35c7-ed90-4419-9c61-08d44c6dbab5', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#14** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":14}', NULL, '2025-12-13 21:22:55', '2025-12-13 21:22:55'),
('9c0aa199-25c8-48dd-873a-c459a69914f9', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#15** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":15}', NULL, '2025-12-13 22:38:04', '2025-12-13 22:38:04'),
('9c833f7c-8e35-431f-b24a-7dbc4ec1d0ba', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 240.000) telah diunggah untuk Pesanan ID #28. Mohon konfirmasi segera.\",\"pesanan_id\":28,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:13:47', '2025-12-26 02:13:47'),
('a0f9ed77-b58c-4d87-8707-45e581796842', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#5** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":5}', NULL, '2025-12-13 18:22:33', '2025-12-13 18:22:33'),
('a163a649-0440-457f-85cd-e86a0a44c0c4', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#13** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":13}', NULL, '2025-12-13 21:25:56', '2025-12-13 21:25:56'),
('a2c13011-5d7b-4893-919f-137a27817177', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 120.000) telah diunggah untuk Pesanan ID #30. Mohon konfirmasi segera.\",\"pesanan_id\":30,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:18:06', '2025-12-26 02:18:06'),
('a3fe30ac-5ad6-4e06-8483-28d07f144a48', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#14** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":14}', NULL, '2025-12-13 21:25:26', '2025-12-13 21:25:26'),
('a5bcbd1b-e580-4033-a21f-42a0a7d4a96a', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 24.000) telah diunggah untuk Pesanan ID #16. Mohon konfirmasi segera.\",\"pesanan_id\":16,\"user_pembeli_id\":5}', NULL, '2025-12-14 01:12:24', '2025-12-14 01:12:24'),
('a7682cda-a7b8-4533-b0e6-aebb918ac53d', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #7 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":7}', NULL, '2025-12-13 19:37:29', '2025-12-13 19:37:29'),
('a77e4e53-bde8-4ebd-95d8-e0861c106c57', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#6**. Silakan cek status pencairan dana.\",\"pesanan_id\":6}', '2025-12-13 21:01:13', '2025-12-13 19:20:28', '2025-12-13 21:01:13'),
('aacd5c8f-092f-4951-a4a9-f263b5de21e6', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 798.000** (Pesanan ID #10) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 42.000).\",\"pesanan_id\":10,\"jumlah_bersih\":798000,\"biaya_admin\":42000}', NULL, '2025-12-13 20:59:55', '2025-12-13 20:59:55'),
('ac83dfab-7645-4dbd-9b2b-b5f525a80d28', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 240.000) telah diunggah untuk Pesanan ID #9. Mohon konfirmasi segera.\",\"pesanan_id\":9,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 20:43:29', '2025-12-13 21:01:13'),
('ad575c6b-f370-4b6f-a0e6-307498546cbd', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 840.000) telah diunggah untuk Pesanan ID #10. Mohon konfirmasi segera.\",\"pesanan_id\":10,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 20:49:38', '2025-12-13 21:01:13'),
('ae7b33c1-62b4-4de0-9001-eb2b4621657d', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #29 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":29}', NULL, '2025-12-26 02:19:11', '2025-12-26 02:19:11'),
('aed3965c-93b6-41f1-b93d-21978050ea6a', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 1.368.000** (Pesanan ID #1) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 72.000).\",\"pesanan_id\":1,\"jumlah_bersih\":1368000,\"biaya_admin\":72000}', NULL, '2025-12-13 09:25:45', '2025-12-13 09:25:45'),
('af141f90-645d-4351-8d7d-69231122086f', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#6** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":6}', NULL, '2025-12-13 19:19:48', '2025-12-13 19:19:48'),
('b54b651b-2f1f-49cd-8071-ba147994dfe6', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#9** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":9}', NULL, '2025-12-13 20:54:29', '2025-12-13 20:54:29'),
('b6a690bb-a589-480c-aa45-993a7dad49b9', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #8 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":8}', NULL, '2025-12-13 20:39:59', '2025-12-13 20:39:59'),
('b6fe935b-e254-428d-9db5-9de719d44e55', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#29** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":29}', NULL, '2025-12-26 02:20:42', '2025-12-26 02:20:42'),
('b72ec9f9-50d8-4692-9d9f-023b36e0f715', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 360.000) telah diunggah untuk Pesanan ID #34. Mohon konfirmasi segera.\",\"pesanan_id\":34,\"user_pembeli_id\":5}', NULL, '2025-12-26 02:30:44', '2025-12-26 02:30:44'),
('bb50bb3e-07b3-4157-96d2-e45165b2a880', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 228.000** (Pesanan ID #7) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 12.000).\",\"pesanan_id\":7,\"jumlah_bersih\":228000,\"biaya_admin\":12000}', NULL, '2025-12-13 19:39:14', '2025-12-13 19:39:14'),
('bdc6589d-a9fc-41fe-87e8-fd3f263f0f2e', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#29**. Silakan cek status pencairan dana.\",\"pesanan_id\":29}', NULL, '2025-12-26 02:21:35', '2025-12-26 02:21:35'),
('bdc91d76-826d-4e46-886f-7b5f6be3645c', 'App\\Notifications\\PembayaranBerhasilDikonfirmasi', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Konfirmasi Pembayaran\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#28** telah **DIKONFIRMASI** oleh Admin. Pesanan Anda kini berstatus **DIPROSES**.\",\"pesanan_id\":28}', NULL, '2025-12-26 02:14:31', '2025-12-26 02:14:31'),
('bdf4a2f1-5754-441d-bf2b-b5cc4525d82b', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 240.000) telah diunggah untuk Pesanan ID #6. Mohon konfirmasi segera.\",\"pesanan_id\":6,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 19:18:20', '2025-12-13 21:01:13'),
('be19b760-1191-44dd-b7ba-3fc2e78ca778', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#9**. Silakan cek status pencairan dana.\",\"pesanan_id\":9}', '2025-12-13 21:01:13', '2025-12-13 20:54:29', '2025-12-13 21:01:13'),
('bf639271-64a4-48ed-9138-084eeb855cbd', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 24.000) telah diunggah untuk Pesanan ID #13. Mohon konfirmasi segera.\",\"pesanan_id\":13,\"user_pembeli_id\":5}', NULL, '2025-12-13 21:16:25', '2025-12-13 21:16:25'),
('c6b8f278-49c1-4169-9c16-e7d0576d49c7', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 125.400** (Pesanan ID #11) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 6.600).\",\"pesanan_id\":11,\"jumlah_bersih\":125400,\"biaya_admin\":6600}', NULL, '2025-12-13 21:10:29', '2025-12-13 21:10:29'),
('ca241abb-4253-483e-a188-68c92bb5c326', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#9** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":9}', NULL, '2025-12-13 20:52:31', '2025-12-13 20:52:31'),
('cf55449e-b46f-470f-81e4-6845157bc986', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #13 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":13}', NULL, '2025-12-13 21:22:58', '2025-12-13 21:22:58'),
('d13d0ec9-23e5-4549-ab04-50ca69c7929e', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#30** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":30}', NULL, '2025-12-26 02:21:38', '2025-12-26 02:21:38'),
('d1ea5b15-8a59-47bf-ac61-ddb8deeb7de9', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#11** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":11}', NULL, '2025-12-13 21:09:17', '2025-12-13 21:09:17'),
('d4ce11e6-f00b-4ef1-a6fd-4033083de1c7', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #28 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":28}', NULL, '2025-12-26 02:14:31', '2025-12-26 02:14:31'),
('daa776d0-3272-49b5-bc5c-dd399641f9ae', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#30** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":30}', NULL, '2025-12-26 02:20:27', '2025-12-26 02:20:27'),
('dd9341ac-171b-4aba-a90a-3b38dc8f7ed1', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 24.000) telah diunggah untuk Pesanan ID #14. Mohon konfirmasi segera.\",\"pesanan_id\":14,\"user_pembeli_id\":5}', NULL, '2025-12-13 21:17:27', '2025-12-13 21:17:27'),
('ddabe140-0377-485e-8e67-a622f3c7ce9d', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 22.800** (Pesanan ID #13) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 1.200).\",\"pesanan_id\":13,\"jumlah_bersih\":22800,\"biaya_admin\":1200}', NULL, '2025-12-13 21:26:32', '2025-12-13 21:26:32'),
('dfad98c5-623b-41e6-8363-8efabf597b83', 'App\\Notifications\\PesananSelesaiAdmin', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"User **yudi** telah menyelesaikan Pesanan ID **#11**. Silakan cek status pencairan dana.\",\"pesanan_id\":11}', NULL, '2025-12-13 21:09:39', '2025-12-13 21:09:39'),
('e466c310-488e-4954-9727-ac3b775eed92', 'App\\Notifications\\PembayaranUserBaru', 'App\\Models\\User', 1, '{\"jenis_notifikasi\":\"Pembayaran Baru\",\"pesan\":\"Pembayaran baru (Rp 146.546.544) telah diunggah untuk Pesanan ID #5. Mohon konfirmasi segera.\",\"pesanan_id\":5,\"user_pembeli_id\":5}', '2025-12-13 21:01:13', '2025-12-13 18:20:27', '2025-12-13 21:01:13'),
('e4a5bc83-a165-4d47-8261-0d0b6eacaa32', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #14 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":14}', NULL, '2025-12-13 21:22:55', '2025-12-13 21:22:55'),
('e8041064-b2d2-4b5c-bc23-bd971be31475', 'App\\Notifications\\PesananSelesaiJastiper', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pesanan Selesai\",\"pesan\":\"Selamat! Pesanan ID **#10** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.\",\"pesanan_id\":10}', NULL, '2025-12-13 20:55:05', '2025-12-13 20:55:05'),
('ea95b14d-8ca1-4860-af0e-2ee7e00e339e', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #15 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":15}', NULL, '2025-12-13 22:36:55', '2025-12-13 22:36:55'),
('eca22b4d-15cc-483f-95cb-cf36ca612459', 'App\\Notifications\\DanaDilepaskan', 'App\\Models\\Jastiper', 2, '{\"jenis_notifikasi\":\"Pelepasan Dana\",\"pesan\":\"Dana sebesar **Rp 22.800** (Pesanan ID #14) telah ditransfer ke rekeningmu setelah dipotong biaya admin (Rp 1.200).\",\"pesanan_id\":14,\"jumlah_bersih\":22800,\"biaya_admin\":1200}', NULL, '2025-12-13 21:26:48', '2025-12-13 21:26:48'),
('ecd6e35a-211f-4af0-8262-f27e907aca05', 'App\\Notifications\\PembayaranDitolak', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Pembayaran Ditolak\",\"pesan\":\"Pembayaran Anda untuk pesanan ID **#2** telah **DITOLAK** (Nominal tidak sesuai\\/Bukti tidak valid). Pesanan Anda kini berstatus **DIBATALKAN**.\",\"pesanan_id\":2}', NULL, '2025-12-13 09:06:46', '2025-12-13 09:06:46'),
('f509d71a-dc5a-400b-99ba-549b15e3e517', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#10** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":10}', NULL, '2025-12-13 20:52:49', '2025-12-13 20:52:49'),
('f733e6a0-d0f4-4c53-8d24-a2c1a3b80221', 'App\\Notifications\\PembayaranDikonfirmasi', 'App\\Models\\Jastiper', 1, '{\"jenis_notifikasi\":\"Pembayaran Masuk\",\"pesan\":\"Pembayaran untuk pesanan ID #16 telah dikonfirmasi Admin. Pesanan siap kamu proses!\",\"pesanan_id\":16}', NULL, '2025-12-14 01:14:03', '2025-12-14 01:14:03'),
('f74c8b28-4547-41f9-abd0-8034c63d37f9', 'App\\Notifications\\PesananSiapDikirim', 'App\\Models\\User', 5, '{\"jenis_notifikasi\":\"Update Status Pesanan\",\"pesan\":\"Hore! Pesanan ID **#7** sedngan **DIKIRIM**. Jastiper akan segera mengirimkan paket ke alamat Anda.\",\"pesanan_id\":7}', NULL, '2025-12-13 19:38:01', '2025-12-13 19:38:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `metode_pembayaran` enum('transfer','e-wallet','cod') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('menunggu','valid','tidak_valid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `tanggal_bayar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jastiper_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status_pesanan` enum('MENUNGGU_PEMBAYARAN','MENUNGGU_KONFIRMASI_ADMIN','DIPROSES','SIAP_DIKIRIM','SELESAI','DIBATALKAN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENUNGGU_PEMBAYARAN',
  `has_reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `status_dana_jastiper` enum('TERTAHAN','MENUNGGU_PELEPASAN','DILEPASKAN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TERTAHAN',
  `alamat_pengiriman` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanans`
--

INSERT INTO `pesanans` (`id`, `user_id`, `jastiper_id`, `tanggal_pesan`, `total_harga`, `status_pesanan`, `has_reviewed`, `status_dana_jastiper`, `alamat_pengiriman`, `no_hp`, `catatan`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2025-12-13 14:56:14', 1440000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 07:56:14', '2025-12-13 09:25:43'),
(2, 5, 1, '2025-12-13 16:05:06', 12000.00, 'DIBATALKAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 09:05:06', '2025-12-13 09:06:46'),
(3, 5, 1, '2025-12-13 16:19:08', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 09:19:08', '2025-12-13 09:19:08'),
(4, 5, 1, '2025-12-13 16:20:25', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 09:20:25', '2025-12-13 09:20:25'),
(5, 5, 1, '2025-12-14 01:20:16', 146546544.00, 'SIAP_DIKIRIM', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 18:20:16', '2025-12-13 18:23:48'),
(6, 5, 1, '2025-12-14 02:18:14', 240000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 19:18:14', '2025-12-13 19:35:27'),
(7, 5, 1, '2025-12-14 02:34:31', 240000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 19:34:31', '2025-12-13 19:39:14'),
(8, 5, 1, '2025-12-14 02:53:39', 360000.00, 'SELESAI', 0, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 19:53:38', '2025-12-13 21:08:20'),
(9, 5, 1, '2025-12-14 03:43:14', 240000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 20:43:14', '2025-12-13 21:00:22'),
(10, 5, 1, '2025-12-14 03:49:16', 840000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 20:49:16', '2025-12-13 20:59:55'),
(11, 5, 1, '2025-12-14 04:06:06', 132000.00, 'SELESAI', 0, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 21:06:06', '2025-12-13 21:10:29'),
(12, 5, 2, '2025-12-14 04:15:47', 24000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 21:15:47', '2025-12-13 21:15:47'),
(13, 5, 2, '2025-12-14 04:16:06', 24000.00, 'SELESAI', 0, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 21:16:06', '2025-12-13 21:26:32'),
(14, 5, 2, '2025-12-14 04:17:07', 24000.00, 'SELESAI', 0, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 21:17:07', '2025-12-13 21:26:48'),
(15, 5, 2, '2025-12-14 05:36:21', 24000.00, 'SELESAI', 1, 'DILEPASKAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-13 22:36:21', '2025-12-13 22:39:00'),
(16, 5, 1, '2025-12-14 08:12:10', 24000.00, 'SELESAI', 1, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-14 01:12:10', '2025-12-14 01:19:58'),
(17, 5, 1, '2025-12-25 06:12:41', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:41', '2025-12-24 23:12:41'),
(18, 5, 2, '2025-12-25 06:12:41', 12000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:41', '2025-12-24 23:12:41'),
(19, 5, 1, '2025-12-25 06:12:47', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:47', '2025-12-24 23:12:47'),
(20, 5, 2, '2025-12-25 06:12:47', 12000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:47', '2025-12-24 23:12:47'),
(21, 5, 1, '2025-12-25 06:12:56', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:56', '2025-12-24 23:12:56'),
(22, 5, 2, '2025-12-25 06:12:56', 12000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:12:56', '2025-12-24 23:12:56'),
(23, 5, 1, '2025-12-25 06:13:26', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:13:26', '2025-12-24 23:13:26'),
(24, 5, 2, '2025-12-25 06:13:26', 12000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:13:26', '2025-12-24 23:13:26'),
(25, 5, 1, '2025-12-25 06:27:18', 120000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:27:18', '2025-12-24 23:27:18'),
(26, 5, 2, '2025-12-25 06:27:18', 12000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-24 23:27:18', '2025-12-24 23:27:18'),
(27, 5, 1, '2025-12-26 09:08:00', 240000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:08:00', '2025-12-26 02:08:00'),
(28, 5, 1, '2025-12-26 09:11:31', 240000.00, 'SIAP_DIKIRIM', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:11:31', '2025-12-26 02:20:23'),
(29, 5, 2, '2025-12-26 09:18:00', 12000.00, 'SELESAI', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:18:00', '2025-12-26 02:21:35'),
(30, 5, 1, '2025-12-26 09:18:00', 120000.00, 'SELESAI', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:18:00', '2025-12-26 02:21:38'),
(31, 5, 1, '2025-12-26 09:21:52', 240000.00, 'MENUNGGU_KONFIRMASI_ADMIN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:21:52', '2025-12-26 02:21:57'),
(32, 5, 1, '2025-12-26 09:22:49', 600000.00, 'MENUNGGU_PEMBAYARAN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:22:49', '2025-12-26 02:22:49'),
(33, 5, 1, '2025-12-26 09:23:03', 600000.00, 'MENUNGGU_KONFIRMASI_ADMIN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:23:03', '2025-12-26 02:23:08'),
(34, 5, 1, '2025-12-26 09:30:39', 360000.00, 'MENUNGGU_KONFIRMASI_ADMIN', 0, 'TERTAHAN', 'jalan haji usman zein, rohul, riau (459895)', '0829292929', NULL, NULL, '2025-12-26 02:30:39', '2025-12-26 02:30:44'),
(35, 2, 4, '2026-05-25 16:17:02', 10000.00, 'MENUNGGU_KONFIRMASI_ADMIN', 0, 'TERTAHAN', 'jalan haji, 5, riau (5)', '081234567890', NULL, NULL, '2026-05-25 09:17:02', '2026-05-25 09:17:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekenings`
--

CREATE TABLE `rekenings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tipe_rekening` enum('bank','e-wallet') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_penyedia` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pemilik` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_akun` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekenings`
--

INSERT INTO `rekenings` (`id`, `user_id`, `tipe_rekening`, `nama_penyedia`, `nama_pemilik`, `nomor_akun`, `status_aktif`, `tanggal_input`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'e-wallet', 'bca', 'diki', '982338924', 'aktif', '2025-12-13 14:43:09', NULL, '2025-12-13 07:43:09', '2025-12-13 18:14:02'),
(2, 1, 'bank', 'BCA', 'diki', '928289129219', 'aktif', '2025-12-13 07:57:42', '2025-12-13 07:58:39', '2025-12-13 07:57:42', '2025-12-13 07:58:39'),
(3, 1, 'bank', 'BCA', 'ASAS', '021990120', 'aktif', '2025-12-13 07:58:54', NULL, '2025-12-13 07:58:54', '2025-12-13 07:59:02'),
(4, 6, 'bank', 'BCA', 'diki', '928398172', 'aktif', '2025-12-14 04:13:21', NULL, '2025-12-13 21:13:21', '2025-12-13 21:13:21'),
(5, 8, 'bank', 'bca', 'diki', '1292838893828', 'aktif', '2026-05-25 10:28:20', NULL, '2026-05-25 03:28:20', '2026-05-25 03:28:20'),
(6, 9, 'bank', 'dfgd', 'dfgdg', '012991239823', 'aktif', '2026-05-25 13:55:25', NULL, '2026-05-25 06:55:25', '2026-05-25 06:55:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5nd0bP2odm2dlmFYpXBd8eFlTWIdB42D1R2lxCcn', NULL, '192.168.100.217', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.6282.50 Safari/537.36 OPR/104.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGtrQThNWDdpVkFzVHlYTUZWblUzNXc1aXJHNWVLSE56RnpDMHFZZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xOTIuMTY4LjEwMC45Mi9qYXN0aXBsb2NhbDQvcHVibGljIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1779722928),
('DGRMDXP5IqyklpPJfKXoTVtx5ZUHSuN9p2yV0vsJ', NULL, '192.168.100.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUdKUUxpU2VpYnlxWlFVbm9pckRnSXA3aVdkNG4zdnF1aldGYnRQZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xOTIuMTY4LjEwMC45Mi9qYXN0aXBsb2NhbDQvcHVibGljIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO319', 1779719364),
('SghNNL5X9QohCP9Owx3akq3ELVlz7dKvKmCCrs9V', NULL, '192.168.100.217', 'Mozilla/5.0 (Linux; Android 15; Pixel 8 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.6286.11 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUFGWGFadmE0U2s3alMxVmVkZTFoRDdqWlFLc3NuYlRJeGg1QzVCSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xOTIuMTY4LjEwMC45Mi9qYXN0aXBsb2NhbDQvcHVibGljIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1779722651),
('zCmBbtyALLszgsXhgEwfOArQlu2E98IZ1iByulGy', NULL, '192.168.100.217', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmJGRFhSWGE0VXZGMUpSaUVyOWxUYjZWN3J2eUppRFczdElFa2lERyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xOTIuMTY4LjEwMC45Mi9qYXN0aXBsb2NhbDQvcHVibGljL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1779725947);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasans`
--

CREATE TABLE `ulasans` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jastiper_id` bigint UNSIGNED DEFAULT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci,
  `tanggal_ulasan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ulasans`
--

INSERT INTO `ulasans` (`id`, `pesanan_id`, `user_id`, `jastiper_id`, `rating`, `komentar`, `tanggal_ulasan`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, 5, 'sangat enak', '2025-12-13 09:12:37', NULL, '2025-12-13 09:12:37', '2025-12-13 09:12:37'),
(2, 6, 5, 1, 5, NULL, '2025-12-13 19:20:31', NULL, '2025-12-13 19:20:31', '2025-12-13 19:20:31'),
(3, 7, 5, 1, 5, 'sangat menarik', '2025-12-13 19:38:36', NULL, '2025-12-13 19:38:36', '2025-12-13 19:38:36'),
(4, 9, 5, 1, 5, NULL, '2025-12-13 20:54:35', NULL, '2025-12-13 20:54:35', '2025-12-13 20:54:35'),
(5, 10, 5, 1, 5, NULL, '2025-12-13 20:55:10', NULL, '2025-12-13 20:55:10', '2025-12-13 20:55:10'),
(6, 15, 5, 2, 5, NULL, '2025-12-13 22:38:34', NULL, '2025-12-13 22:38:34', '2025-12-13 22:38:34'),
(7, 16, 5, 1, 5, NULL, '2025-12-14 01:19:58', NULL, '2025-12-14 01:19:58', '2025-12-14 01:19:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `role` enum('pengguna','admin','jastiper') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pengguna',
  `tanggal_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nama_lengkap`, `username`, `no_hp`, `alamat`, `role`, `tanggal_daftar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', 'Administrator', 'admin123', '081234567890', 'Jl. Admin No. 1', 'admin', '2025-12-11 02:12:51', NULL, '$2y$12$iz2eMNF9//.hEE6D2wercuEV.L.TJH6bqejt5zPEiU0tilpvEEmme', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(2, 'User', 'user@example.com', 'User Biasa', 'User01', '081234567890', 'Jl. User No. 1', 'pengguna', '2025-12-11 02:12:51', NULL, '$2y$12$V/D8oqzdKC9DXuECLpr5CeO4OmUoCIfbZ.xi.yvLW6Zz/PnSdbYbm', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(3, 'Jastiper User', 'jastiper@example.com', 'Jasa Titip User', 'jastiper01', '081298765432', 'Jl. Jastiper No. 2', 'jastiper', '2025-12-11 02:12:51', NULL, '$2y$12$jPk5Su8efs6Fyaqiy63g4er0Y5XAIyZrq7eg.CTbnWAxHeGgLxzxu', NULL, '2025-12-11 02:12:51', '2025-12-11 02:12:51'),
(4, 'kiki', 'kiki@gmail.com', 'wahyudi', 'kiki', '081268433470', 'tandun', 'pengguna', '2025-12-12 10:34:09', NULL, '$2y$12$ngoUqbS7jiYsRupybJgGmehWm8cBtUqduDfTgf14caSSFQd9LqMa6', NULL, '2025-12-12 03:34:09', '2025-12-12 03:34:09'),
(5, 'yudi', 'yudi@gmail.com', 'wahyu', 'yudi', '0829292929', 'tandun', 'pengguna', '2025-12-13 14:55:00', NULL, '$2y$12$9F59T2P1eLUSQuuSlgJXZO/m0hsEafLk8TiiAmRrjmLOLJuHucoSG', NULL, '2025-12-13 07:55:00', '2025-12-29 07:04:27'),
(6, 'asd', 'koko@gmail.com', NULL, 'asd', NULL, NULL, 'jastiper', '2025-12-13 16:22:03', NULL, '$2y$12$7GmA0bxuJVvlAd3BxjvZnuaCEOh3yr474KuWci/tqPzdrh9Bc1gEy', NULL, '2025-12-13 09:22:03', '2025-12-29 07:08:08'),
(7, 'diki', 'lolo@gmail.com', 'wahyudi', 'diki', '081268433470', 'jalan haji usman zein', 'pengguna', '2025-12-14 04:12:26', NULL, '$2y$12$c595J684Sobw1RgFLdyBrO0U0axF4ljYNfR6iemUCMBnAERtbj1fW', NULL, '2025-12-13 21:12:26', '2025-12-13 21:12:26'),
(8, 'dicki', 'diki@gmail.com', 'wahyudi', 'dicki', '08282828221', 'tandun', 'jastiper', '2026-05-25 10:17:43', NULL, '$2y$12$37/pBxCxcFsF7qGoDrsFPObgetWv1/LW.fdXYIpm75ga25M4/sTua', NULL, '2026-05-25 03:17:43', '2026-05-25 03:28:20'),
(9, 'ahyu', 'xss@gmail.com', 'yudi', 'ahyu', '08122928112', 'tandun', 'jastiper', '2026-05-25 13:51:03', NULL, '$2y$12$BvVIxf9yCH9tT1I4594QiO8ZZzK676giRmQEZbj9kJdOomrGsdxya', NULL, '2026-05-25 06:51:03', '2026-05-25 06:55:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alur_dana`
--
ALTER TABLE `alur_dana`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alur_dana_pesanan_id_foreign` (`pesanan_id`);

--
-- Indeks untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_jastiper_id_foreign` (`jastiper_id`),
  ADD KEY `barangs_kategori_id_foreign` (`kategori_id`),
  ADD KEY `barangs_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pesanans_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `detail_pesanans_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jastipers`
--
ALTER TABLE `jastipers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jastipers_user_id_foreign` (`user_id`),
  ADD KEY `jastipers_rekening_id_foreign` (`rekening_id`);

--
-- Indeks untuk tabel `jastiper_followers`
--
ALTER TABLE `jastiper_followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jastiper_followers_jastiper_id_user_id_unique` (`jastiper_id`,`user_id`),
  ADD KEY `jastiper_followers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelola_danas`
--
ALTER TABLE `kelola_danas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelola_danas_pembayaran_id_foreign` (`pembayaran_id`),
  ADD KEY `kelola_danas_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_aktivitas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_pesanan_id_foreign` (`pesanan_id`);

--
-- Indeks untuk tabel `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanans_user_id_foreign` (`user_id`),
  ADD KEY `pesanans_jastiper_id_foreign` (`jastiper_id`);

--
-- Indeks untuk tabel `rekenings`
--
ALTER TABLE `rekenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekenings_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `ulasans`
--
ALTER TABLE `ulasans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulasans_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `ulasans_user_id_foreign` (`user_id`),
  ADD KEY `ulasans_jastiper_id_foreign` (`jastiper_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alur_dana`
--
ALTER TABLE `alur_dana`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jastipers`
--
ALTER TABLE `jastipers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jastiper_followers`
--
ALTER TABLE `jastiper_followers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kelola_danas`
--
ALTER TABLE `kelola_danas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `rekenings`
--
ALTER TABLE `rekenings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `ulasans`
--
ALTER TABLE `ulasans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alur_dana`
--
ALTER TABLE `alur_dana`
  ADD CONSTRAINT `alur_dana_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`);

--
-- Ketidakleluasaan untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `barangs_jastiper_id_foreign` FOREIGN KEY (`jastiper_id`) REFERENCES `jastipers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `detail_pesanans`
--
ALTER TABLE `detail_pesanans`
  ADD CONSTRAINT `detail_pesanans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `detail_pesanans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jastipers`
--
ALTER TABLE `jastipers`
  ADD CONSTRAINT `jastipers_rekening_id_foreign` FOREIGN KEY (`rekening_id`) REFERENCES `rekenings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jastipers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `jastiper_followers`
--
ALTER TABLE `jastiper_followers`
  ADD CONSTRAINT `jastiper_followers_jastiper_id_foreign` FOREIGN KEY (`jastiper_id`) REFERENCES `jastipers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jastiper_followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelola_danas`
--
ALTER TABLE `kelola_danas`
  ADD CONSTRAINT `kelola_danas_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kelola_danas_pembayaran_id_foreign` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayarans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanans`
--
ALTER TABLE `pesanans`
  ADD CONSTRAINT `pesanans_jastiper_id_foreign` FOREIGN KEY (`jastiper_id`) REFERENCES `jastipers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekenings`
--
ALTER TABLE `rekenings`
  ADD CONSTRAINT `rekenings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `ulasans`
--
ALTER TABLE `ulasans`
  ADD CONSTRAINT `ulasans_jastiper_id_foreign` FOREIGN KEY (`jastiper_id`) REFERENCES `jastipers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ulasans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
