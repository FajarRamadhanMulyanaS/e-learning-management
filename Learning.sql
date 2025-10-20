-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 08:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `balasan_pesan`
--

CREATE TABLE `balasan_pesan` (
  `id` int(11) NOT NULL,
  `pesan_id` int(11) DEFAULT NULL,
  `pengirim_id` int(11) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balasan_pesan`
--

INSERT INTO `balasan_pesan` (`id`, `pesan_id`, `pengirim_id`, `isi`, `created_at`, `updated_at`) VALUES
(1, 3, 195, 'baiki', '2024-11-16 07:52:13', '2024-11-16 07:52:13'),
(4, 3, 195, 'kapan selesai', '2024-11-16 08:04:41', '2024-11-16 08:04:41'),
(6, 3, 195, 'halo gauy', '2024-11-16 08:08:37', '2024-11-16 08:08:37'),
(7, 5, 195, 'lanjutkan', '2024-11-16 09:16:15', '2024-11-16 09:16:15'),
(8, 5, 201, 'baik bu', '2024-11-17 07:05:51', '2024-11-17 07:05:51'),
(9, 6, 195, 'baik sudah dijawab', '2024-11-17 08:19:11', '2024-11-17 08:19:11'),
(10, 7, 203, 'siang bu ada apa nggeh', '2024-12-11 06:34:11', '2024-12-11 06:34:11'),
(11, 4, 196, 'iya silahkan melanjutkan besok y absennya', '2024-12-14 00:51:37', '2024-12-14 00:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `thread_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 203, 'bagaiman cah', '2024-12-14 01:32:48', '2024-12-14 01:32:48'),
(2, 2, 201, 'wah bagus juga tu bagai\r\nmana', '2024-12-14 01:35:44', '2024-12-14 01:35:44'),
(3, 2, 196, 'benarkah begitu ?', '2024-12-14 01:47:02', '2024-12-14 01:47:02');

-- --------------------------------------------------------

--
-- Table structure for table `essay`
--

CREATE TABLE `essay` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) DEFAULT NULL,
  `soal` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `essay`
--

INSERT INTO `essay` (`id`, `ujian_id`, `soal`, `created_at`, `updated_at`) VALUES
(1, 4, 'Jadi sudah berapa lama kamu sekolah di smp jekulo kudus?', '2024-10-19 23:16:57', '2024-10-19 23:53:13'),
(4, 4, 'dataang lah hujan ?', '2024-10-19 23:49:45', '2024-10-19 23:49:45'),
(5, 7, 'Berapa jumlah 20 + 65 + 45 ?', '2024-10-21 05:32:54', '2024-10-21 05:32:54'),
(6, 8, 'Berapa jumlah kaki kucing ?', '2024-10-24 06:00:01', '2024-10-24 06:00:01'),
(7, 8, 'Berapa sepuluh Kali Sepuluh ?', '2024-10-24 06:00:33', '2024-10-24 06:00:33'),
(8, 9, 'Apa nama lambang Indonesia ?', '2024-10-25 01:24:10', '2024-10-25 01:24:10'),
(9, 9, 'Apa semboyan negara indonesia kita ?', '2024-10-25 01:24:39', '2024-10-25 01:24:52'),
(10, 12, 'Selamat mengerjakan', '2024-10-28 22:55:05', '2024-10-28 22:55:05'),
(11, 10, '1 ditambah 1 sama dengan berapa ?', '2024-10-31 07:20:32', '2024-10-31 07:20:32'),
(12, 10, 'berapa kaki hewan kucing', '2024-10-31 07:20:51', '2024-10-31 07:20:51'),
(13, 15, 'kerjakan dengan Benar berapa 20 + 19 ?', '2024-12-14 00:47:43', '2024-12-14 00:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `grade` int(11) NOT NULL CHECK (`grade` >= 0 and `grade` <= 100),
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tgl_lahir` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `alamat`, `tgl_lahir`, `telepon`, `gender`, `jabatan`, `created_at`, `updated_at`) VALUES
(53, 195, '19650525 198703 2 010', 'Hadipolo Rt 01 Rw 04 Jekulo Kudus', '1970-01-01', '13658321321', 'Perempuan', 'Guru', '2024-10-10 06:28:29', '2024-11-08 23:24:03'),
(54, 196, '19630917 198501 2 002', 'Bulungcangkring Rt 1 Rw 06 Jekulo Kudus', '1970-01-01', '085640449608', 'Perempuan', 'Guru', '2024-10-10 06:28:30', '2024-10-10 06:28:30'),
(55, 206, '19640915 198601 1 003', 'T Rejo Rt 05 RW 06 Jekulo Kudus', '1970-01-01', '085784963062', 'Laki-laki', 'Guru', '2024-11-06 08:17:42', '2024-11-06 08:17:42'),
(56, 207, '19640322 198703 1 004', 'T Rejo Rt 04 RW 03 Jekulo Kudus', '1970-01-01', '081575994113', 'Laki-laki', 'Guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(57, 208, '19640412 198703 1 015', 'Klaling Rt.03 Rw. II  Jekulo, Kudus', '1970-01-01', '085640963668', 'Laki-laki', 'Guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(58, 209, '19640122 198803 2 004', 'T Rejo Rt 06 RW 03 Jekulo Kudus', '1970-01-01', '087833985286', 'Perempuan', 'Guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(59, 210, '19650603 199201 2 001', 'T Rejo Rt 04 RW 03 Jekulo Kudus', '1970-01-01', '085740257113', 'Perempuan', 'Guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(60, 211, '19670701 199003 1 008', 'T Rejo Rt 02 RW 05 Jekulo Kudus', '1970-01-01', '081325609203', 'Laki-laki', 'Guru', '2024-11-06 08:17:45', '2024-11-06 08:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapels`
--

CREATE TABLE `guru_mapels` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mapel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelas_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_mapels`
--

INSERT INTO `guru_mapels` (`id`, `user_id`, `mapel_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(3, 196, 2, 1, '2024-10-11 09:47:42', '2024-10-11 09:47:42'),
(4, 195, 2, 2, '2024-10-11 09:48:53', '2024-10-11 09:48:53'),
(5, 196, 1, 8, '2024-10-24 22:51:30', '2024-10-24 22:51:30'),
(6, 195, 6, 1, '2024-11-03 06:01:22', '2024-11-03 06:01:22'),
(7, 195, 10, 1, '2024-11-03 06:10:44', '2024-11-03 06:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `total_nilai_essay` int(100) DEFAULT NULL,
  `total_nilai_pilgan` decimal(5,2) DEFAULT 0.00,
  `total_nilai` decimal(5,2) GENERATED ALWAYS AS (`total_nilai_essay` + `total_nilai_pilgan`) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_ujian`
--

INSERT INTO `hasil_ujian` (`id`, `siswa_id`, `ujian_id`, `total_nilai_essay`, `total_nilai_pilgan`, `created_at`, `updated_at`) VALUES
(1, 135, 7, 37, 0.00, '2024-10-26 02:16:05', '2024-10-26 02:16:05'),
(2, 135, 8, 70, 0.00, '2024-10-26 02:17:37', '2024-10-26 02:17:46'),
(3, 136, 8, 194, 0.00, '2024-10-26 02:18:37', '2024-10-26 02:18:44'),
(4, 137, 9, 100, 0.00, '2024-10-28 22:56:33', '2024-10-28 22:57:04'),
(5, 137, 10, 90, 0.00, '2024-10-31 07:24:20', '2024-10-31 08:13:31');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_siswa_essay`
--

CREATE TABLE `jawaban_siswa_essay` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `essay_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_siswa` text NOT NULL,
  `nilai_essay` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawaban_siswa_essay`
--

INSERT INTO `jawaban_siswa_essay` (`id`, `siswa_id`, `ujian_id`, `essay_id`, `jawaban_siswa`, `nilai_essay`, `created_at`, `updated_at`) VALUES
(17, 136, 8, 6, '4', 94, '2024-10-24 22:17:49', '2024-10-26 02:18:37'),
(18, 136, 8, 7, '100', 100, '2024-10-24 22:17:49', '2024-10-26 02:18:44'),
(19, 135, 8, 6, 'empat', 50, '2024-10-24 22:22:20', '2024-10-26 00:53:43'),
(20, 135, 8, 7, 'seratus', 20, '2024-10-24 22:22:20', '2024-10-26 02:17:46'),
(21, 135, 7, 5, '130', 37, '2024-10-25 01:13:46', '2024-10-26 02:16:05'),
(22, 137, 9, 8, 'Garuda', 50, '2024-10-25 01:31:02', '2024-10-28 22:56:33'),
(23, 137, 9, 9, 'Berbeda beda tapi tetap satu jua', 50, '2024-10-25 01:31:02', '2024-10-28 22:57:04'),
(24, 136, 12, 10, 'anjay', NULL, '2024-10-29 04:57:51', '2024-10-29 04:57:51'),
(25, 137, 10, 11, '10', 40, '2024-10-31 07:23:07', '2024-10-31 08:13:31'),
(26, 137, 10, 12, 'empat', 50, '2024-10-31 07:23:07', '2024-10-31 07:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_siswa_pilgan`
--

CREATE TABLE `jawaban_siswa_pilgan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `pilihan_ganda_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_siswa` char(1) NOT NULL,
  `nilai_pg` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawaban_siswa_pilgan`
--

INSERT INTO `jawaban_siswa_pilgan` (`id`, `siswa_id`, `ujian_id`, `pilihan_ganda_id`, `jawaban_siswa`, `nilai_pg`, `created_at`, `updated_at`) VALUES
(19, 135, 8, 6, 'A', 100, '2024-10-24 21:54:38', '2024-10-25 04:54:38'),
(20, 135, 8, 7, 'D', 100, '2024-10-24 21:54:38', '2024-10-25 04:54:38'),
(21, 135, 8, 8, 'D', 100, '2024-10-24 21:54:38', '2024-10-25 04:54:38'),
(22, 136, 8, 6, 'A', 67, '2024-10-24 21:55:24', '2024-10-25 04:55:24'),
(23, 136, 8, 7, 'E', 67, '2024-10-24 21:55:24', '2024-10-25 04:55:24'),
(24, 136, 8, 8, 'D', 67, '2024-10-24 21:55:24', '2024-10-25 04:55:24'),
(25, 135, 7, 4, 'D', 100, '2024-10-25 01:13:07', '2024-10-25 08:13:07'),
(26, 135, 7, 5, 'E', 100, '2024-10-25 01:13:07', '2024-10-25 08:13:07'),
(27, 137, 9, 9, 'D', 100, '2024-10-25 01:30:13', '2024-10-25 08:30:13'),
(28, 137, 9, 10, 'B', 100, '2024-10-25 01:30:13', '2024-10-25 08:30:13'),
(29, 137, 9, 11, 'D', 100, '2024-10-25 01:30:13', '2024-10-25 08:30:13'),
(30, 136, 12, 12, 'A', 50, '2024-10-29 04:55:50', '2024-10-29 11:55:50'),
(31, 136, 12, 13, 'C', 50, '2024-10-29 04:55:50', '2024-10-29 11:55:50'),
(32, 137, 10, 14, 'E', 50, '2024-10-31 07:22:34', '2024-10-31 14:22:35'),
(33, 137, 10, 15, 'D', 50, '2024-10-31 07:22:34', '2024-10-31 14:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, '7A', 'VII A', '2024-10-10 08:30:06', '2024-10-10 08:30:06'),
(2, '7 B', 'VII B', '2024-10-11 09:48:38', '2024-10-24 22:45:30'),
(5, '7 C', 'VII C', '2024-10-24 22:46:24', '2024-10-24 22:46:24'),
(6, '7 D', 'VII D', '2024-10-24 22:47:05', '2024-10-24 22:47:05'),
(7, '7 E', 'VII E', '2024-10-24 22:47:20', '2024-10-24 22:47:20'),
(8, '8 A', 'VIII A', '2024-10-24 22:47:48', '2024-10-24 22:47:48'),
(9, '8 B', 'VIII B', '2024-10-24 22:48:03', '2024-10-24 22:48:03'),
(10, '8 C', 'VIII C', '2024-10-24 22:48:17', '2024-10-24 22:48:17'),
(11, '8 D', 'VIII D', '2024-10-24 22:48:30', '2024-10-24 22:48:30'),
(12, '8 E', 'VIII E', '2024-10-24 22:48:45', '2024-10-24 22:48:45'),
(13, '9 A', 'IX A', '2024-10-24 22:48:57', '2024-10-24 22:48:57'),
(14, '9 B', 'IX B', '2024-10-24 22:49:09', '2024-10-24 22:49:09'),
(15, '9 C', 'IX C', '2024-10-24 22:49:24', '2024-10-24 22:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `mapels`
--

CREATE TABLE `mapels` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `kode_mapel` varchar(255) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapels`
--

INSERT INTO `mapels` (`id`, `kode_mapel`, `nama_mapel`, `created_at`, `updated_at`) VALUES
(1, 'BI', 'Bahasa Indonesia', '2024-10-10 08:07:14', '2024-10-20 00:07:11'),
(2, 'MTK', 'Matematika', '2024-10-11 09:47:28', '2024-10-20 00:07:55'),
(3, 'PAI', 'Agama', '2024-10-20 00:07:42', '2024-10-20 00:07:42'),
(4, 'pjok', 'PJOK', '2024-10-20 00:08:46', '2024-10-20 00:08:46'),
(5, 'ipa', 'Ilmu Pengetahuan Alam', '2024-10-28 23:58:05', '2024-10-28 23:58:05'),
(6, 'ips', 'Ilmu Pengetahuan Sosial', '2024-10-28 23:58:34', '2024-10-28 23:58:34'),
(7, 'ppkn', 'PPKN', '2024-10-29 00:00:59', '2024-10-29 00:00:59'),
(8, 'B Ing', 'Bahasa Inggris', '2024-10-29 00:01:41', '2024-10-29 00:01:49'),
(9, 'Sn Budaya', 'Seni Budaya', '2024-10-29 00:02:27', '2024-10-29 00:02:27'),
(10, 'imk', 'Informatika', '2024-10-29 00:03:51', '2024-10-29 00:03:51'),
(11, 'bhs Jawa', 'Bahasa Jawa', '2024-10-29 00:04:26', '2024-10-29 00:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `mapel_id` bigint(11) UNSIGNED NOT NULL,
  `kelas_id` int(11) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `user_id` bigint(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `judul`, `mapel_id`, `kelas_id`, `file_path`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'belajar membaca', 2, 2, 'uploads/materi/1728913967_lembar pengesahan.pdf', 195, '2024-10-14 06:52:47', '2024-11-02 06:00:28'),
(7, 'GIAT BELAJJAR', 2, 2, 'uploads/materi/1730206881_bop mei 23 ok.pdf', 195, '2024-10-29 06:01:23', '2024-10-29 06:01:23'),
(8, 'GIAT BELAJJAR', 2, 1, 'uploads/materi/1730552676_MODUL AJAR B IND KLS 3 fase B.docx', 196, '2024-11-02 06:04:37', '2024-11-02 06:04:47'),
(9, 'tugas pertamana', 2, 2, 'uploads/materi/1730553771_RPP K3 T7 ST1 P6.PMM.doc', 195, '2024-11-02 06:22:51', '2024-11-02 06:22:51'),
(10, 'Tugas mengerjakan soal 1', 2, 2, 'uploads/materi/1730554592_bop mei 23 ok.pdf', 195, '2024-11-02 06:36:33', '2024-11-02 06:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `file_tugas` varchar(255) NOT NULL,
  `nilai` int(100) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumpulan_tugas`
--

INSERT INTO `pengumpulan_tugas` (`id`, `tugas_id`, `siswa_id`, `file_tugas`, `nilai`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 2, 201, 'tugas_pengumpulan/5V0XjTZQWZsLw5diKkSPVW07xWSuDB9hM3sIfhBP.jpg', 100, 'sudah selesai', '2024-10-30 01:54:34', '2024-11-03 05:51:13'),
(2, 7, 201, 'tugas_pengumpulan/iIowEEIw9Z7h5D0siwWah26zOtDI947DaZ2Drbdn.jpg', 92, NULL, '2024-11-03 08:44:59', '2024-11-17 09:17:31'),
(3, 8, 201, 'tugas_pengumpulan/ZtcDT6TvNYtZlNyklVTD0EatyrS0n4M8N5UhOn3g.jpg', 100, 'selesai bu silahkan dilihat', '2024-12-05 08:04:28', '2024-12-14 08:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `pesans`
--

CREATE TABLE `pesans` (
  `id` int(11) NOT NULL,
  `pengirim_id` bigint(20) UNSIGNED NOT NULL,
  `penerima_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi_pesan` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesans`
--

INSERT INTO `pesans` (`id`, `pengirim_id`, `penerima_id`, `judul`, `isi_pesan`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 203, 195, NULL, 'absen tgl 19/agustus/2024', 1, '2024-11-13 05:58:26', '2024-11-13 08:33:50'),
(3, 203, 195, 'Absen Tanggal 15 April 2024', 'ok', 1, '2024-11-16 06:40:32', '2024-11-16 07:30:55'),
(4, 203, 196, 'Absen Tanggal 16 April 2024', 'absen bu', 1, '2024-11-16 06:41:36', '2024-12-14 00:50:56'),
(5, 195, 201, 'tgl 16 April 2024', '65', 1, '2024-11-16 09:10:04', '2024-11-16 09:15:15'),
(6, 201, 195, 'Absen tangggal 21 April', 'tolong dijawab bu', 1, '2024-11-17 07:46:48', '2024-11-17 08:15:36'),
(7, 196, 203, 'siang', 'siang siswa aprilia', 1, '2024-11-25 08:11:57', '2024-12-11 06:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_ganda`
--

CREATE TABLE `pilihan_ganda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` int(10) UNSIGNED NOT NULL,
  `soal` text NOT NULL,
  `pilihan_a` varchar(255) NOT NULL,
  `pilihan_b` varchar(255) NOT NULL,
  `pilihan_c` varchar(255) NOT NULL,
  `pilihan_d` varchar(255) DEFAULT NULL,
  `pilihan_e` varchar(255) DEFAULT NULL,
  `kunci_jawaban` char(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pilihan_ganda`
--

INSERT INTO `pilihan_ganda` (`id`, `ujian_id`, `soal`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `pilihan_e`, `kunci_jawaban`, `created_at`, `updated_at`) VALUES
(1, 4, 'apa saya sudah mandi ?', 'sudah', 'belum', 'Tidak tahu', 'kurang tahu', 'kelihatannya sudah', 'A', '2024-10-18 23:33:47', '2024-10-18 23:33:47'),
(2, 4, 'Warna Apa yang Terlihat?', 'Merah', 'Biru', 'Kuning', 'Hijau', 'semua', 'D', '2024-10-19 01:14:13', '2024-10-20 00:01:14'),
(3, 4, 'Jam Berapa saya pergi ke luar?', 'jam 5', 'Jam 6', 'Jam 9', 'Jam 8', 'Jam 10', 'B', '2024-10-20 00:00:43', '2024-10-20 00:00:43'),
(4, 7, 'berapa 2 + 30 ?', '5', '98', '52', '32', '45', 'D', '2024-10-21 05:31:25', '2024-10-21 05:31:25'),
(5, 7, '15 + 65 = ....', '456', '98', '321', '87', '80', 'E', '2024-10-21 05:32:15', '2024-10-21 05:32:15'),
(6, 8, 'Berapa jumlah 2 + 3 ?', '5', '9', '8', '4', '4', 'A', '2024-10-24 06:04:04', '2024-10-24 06:25:28'),
(7, 8, 'berapa jumlah hewan kaki sapi ?', '5', '2', '3', '4', '8', 'D', '2024-10-24 06:11:11', '2024-10-24 06:11:11'),
(8, 8, 'berapa jumalhj 45 + 55', '50', '60', '60', '100', NULL, 'D', '2024-10-24 06:42:54', '2024-10-24 06:42:54'),
(9, 9, 'apa bahasa indonesianya dog?', 'rebird', 'fish', 'Tidak tahu', 'anjing', NULL, 'D', '2024-10-25 01:20:00', '2024-10-25 01:20:00'),
(10, 9, 'apa nama suku di indonesia', 'papua nugini', 'dayak', 'amborigin', 'ajak', NULL, 'B', '2024-10-25 01:21:36', '2024-10-25 01:21:36'),
(11, 9, 'Masakan khas indonesia adalah ?', 'Pasta', 'Ratatui', 'Sushi', 'Padang', 'Rebung', 'D', '2024-10-25 01:23:18', '2024-10-25 01:23:18'),
(12, 12, 'welcome to mobile .........', 'Legend', 'EPEP', 'BURIK', 'ANJAY', 'wkwkw', 'A', '2024-10-28 22:53:37', '2024-10-28 22:53:37'),
(13, 12, 'satruane mong koyo', 'anging', 'as', 'burung', 'selamt', NULL, 'A', '2024-10-28 22:54:35', '2024-10-28 22:54:35'),
(14, 10, 'ilham ada berapa', '1', '2', '3', '4', '5', 'C', '2024-10-31 07:18:52', '2024-10-31 07:18:52'),
(15, 10, 'ada berapa warna pelangi?', '2', '5', '6', '7', '10', 'D', '2024-10-31 07:19:42', '2024-10-31 07:19:42'),
(16, 15, 'Berpara solanya', '1', '2', '3', '4', '5', 'A', '2024-12-14 09:39:51', '2024-12-14 09:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BahLdfLU4gfe3fB97fsOOsL6bfenZSJ3x1DLgepq', 196, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRm40VGFpYWJ4U0NQQkNqdEpYU3NnQU1qMEN3MktEZ2JSQ1VvYmFDYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1L21hbmFqZW1lbi11amlhbi9waWxpaGFuLWdhbmRhLzE1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk2O30=', 1734194392),
('utyLl5GkwaLcl1EcaGtmFtmHstoksnglMWdIGXle', 201, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaUdQUW9ldGRYNVZpS0JCMTFMWTA5ZnFHY3ZKS1JvNElCbFZLYXlhMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaXN3YS91amlhbi9rZXJqYWthbi8xNSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIwMTt9', 1734194400),
('yqfmKRElmYb9XmK3kxEvBjdcYF5i2oCOHWzpDVjp', 195, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmJBendiMGF0bkZTYmtmOGUxVFV4OVZmaWVYZ2c3VE5hOTZDWTFxRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1L3ZpZGVvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk1O30=', 1734251359);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tgl_lahir` text DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nisn`, `telepon`, `alamat`, `tgl_lahir`, `gender`, `created_at`, `updated_at`) VALUES
(135, 201, '9184', '51515151515155', '085277525581', 'Ds Kutoharjo Dk Karangdowo, Jalan Guyub Rukun II, RT.5/RW.1, Kutoharjo, Pati, KAB. PATI, PATI, JAWA TENGAH, ID, 59118', '2020-02-20', 'Laki-laki', '2024-10-14 23:24:31', '2024-11-11 06:31:08'),
(136, 202, '9153', '12346578', '08156124759', 'kudus jekulo', '0800-05-12', 'Laki-laki', '2024-10-16 00:18:15', '2024-10-16 00:18:15'),
(137, 203, '9156', '63546541', '08156124759', 'kudus jekulo', '2002-05-12', 'Perempuan', '2024-10-24 22:50:32', '2024-10-24 22:50:32'),
(138, 204, '9174', '3104452536', '088806029157', 'Tanjungrejo Rt/Rw 004/006 Kel. Tanjungrejo Kec.Jekulo Kab.Kudus', '2010-01-07', 'Perempuan', '2024-11-06 06:09:46', '2024-11-06 06:09:46'),
(139, 205, '8993', '0101838003', '085878626616', 'Tanjungrejo, Rt. 1, Rw. 5, Kel. Tanjung Rejo, Kec. Jekulo', '2010-09-08', 'Perempuan', '2024-11-06 08:10:28', '2024-11-06 08:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `submission_text` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 203, 'Bagaimana konsep baling baling?', 'bagai mana ?', '2024-12-14 01:32:00', '2024-12-14 01:32:00'),
(2, 203, 'Bagaimana konsep baling baling?', 'bagai mana ?', '2024-12-14 01:32:26', '2024-12-14 01:32:26');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengumpulan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `judul`, `deskripsi`, `file`, `mapel_id`, `kelas_id`, `guru_id`, `tanggal_pengumpulan`, `created_at`, `updated_at`) VALUES
(2, 'Tugas Matematika', 'Kerjakan soal berikut', 'tugas_files/tugas_matematika.docx', 2, 1, 195, '2024-11-05', '2024-10-29 15:39:37', '2024-10-29 15:39:37'),
(3, 'Soal Mudah', 'kerjakan', 'tugas_files/eUwaVX9urqS7v9ZjQqmrAjMgjQh1IJbOhd6rXYmu.pdf', 2, 2, 195, '2024-10-30', '2024-10-29 08:46:59', '2024-10-29 10:01:21'),
(4, 'waf', 'aefcaesd', NULL, 2, 2, 195, '2024-11-04', '2024-10-29 09:12:57', '2024-10-31 01:13:58'),
(6, 'media', 'kerjakan tugas berikut ini', 'tugas_files/gsLqQBZaQZAoX5jkrw5a48rcykmZshaAfxHYSV0U.docx', 2, 2, 195, '2024-11-04', '2024-11-03 05:57:16', '2024-11-03 05:57:16'),
(7, 'kpk', 'ok', 'tugas_files/oI9DNwrS7wsLeBrIZ0TlxAy4uO6YU55CYGWX8pv4.pdf', 10, 1, 195, '2024-11-03', '2024-11-03 08:16:40', '2024-11-03 08:16:40'),
(8, 'Ilu pengetahuan alam', 'seslesai kan dengan cepat', 'tugas_files/EuCb77KV3RaYLXSeZVsE61YFSuVP1NkjIfq0ytyN.pdf', 1, 1, 196, '2024-12-06', '2024-12-05 08:02:05', '2024-12-05 08:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` bigint(20) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `waktu_pengerjaan` int(11) NOT NULL,
  `info_ujian` text DEFAULT NULL,
  `bobot_pilihan_ganda` int(11) DEFAULT NULL CHECK (`bobot_pilihan_ganda` between 0 and 100),
  `bobot_essay` int(11) DEFAULT NULL CHECK (`bobot_essay` between 0 and 100),
  `terbit` enum('Y','N') DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `judul`, `user_id`, `mapel_id`, `kelas_id`, `waktu_pengerjaan`, `info_ujian`, `bobot_pilihan_ganda`, `bobot_essay`, `terbit`, `created_at`, `updated_at`) VALUES
(7, 'UNBK', 53, 2, 1, 60, 'KOMPUTER', 100, 100, 'Y', '2024-10-21 05:30:36', '2024-10-26 07:25:21'),
(8, 'UTS', 53, 2, 1, 60, 'Matematika', 100, 100, 'Y', '2024-10-24 05:57:47', '2024-10-26 01:00:10'),
(9, 'GIAT BELAJJAR', 53, 1, 8, 60, 'selamat mengerjakan', 100, 100, 'Y', '2024-10-25 01:18:20', '2024-10-25 01:18:20'),
(10, 'tugas pertamana', 54, 1, 8, 60, 'selamat', 50, 50, 'Y', '2024-10-25 02:02:05', '2024-10-25 02:02:05'),
(12, 'komotida', 53, 2, 2, 60, 'gogo', 100, 100, 'Y', '2024-10-28 22:41:38', '2024-10-28 22:41:38'),
(15, 'Ujian Bahasa Indonesia', 54, 1, 1, 30, 'kerjakan dengan jujur', 50, 50, 'Y', '2024-12-14 00:40:29', '2024-12-14 00:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kelas_id` int(50) UNSIGNED DEFAULT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `foto`, `kelas_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', 'images/admin_photos/1733928658_Mahwa.jpeg', 0, 'admin', '2024-10-05 01:33:43', '2024-12-11 07:50:58'),
(195, 'Purwani, S.Pd.', 'anugrah@gmail.com', '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1732110431_nice.jpg', 0, 'guru', '2024-10-10 06:28:29', '2024-11-20 06:47:11'),
(196, 'Sri Dwiatmining E., S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1733412409_Mahwa.jpeg', 0, 'guru', '2024-10-10 06:28:30', '2024-12-05 08:26:49'),
(201, 'AKHMAD MAULANA RIZKI SAPUTRA', 'anugrahdwisaputra8@gmail.com', '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1733411489_Mahwa.jpeg', 1, 'siswa', '2024-10-14 23:24:31', '2024-12-05 08:11:29'),
(202, 'ANGGUN NOOR AFIEDHA', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 2, 'siswa', '2024-10-16 00:18:15', '2024-10-16 00:18:15'),
(203, 'APRILLIA HAPSARI AYUNINGTYAS', 'aan@gmail.com', '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1734161222_Mahwa.jpeg', 8, 'siswa', '2024-10-24 22:50:32', '2024-12-14 00:27:02'),
(204, 'QOFFA HUSNUN NADA', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 8, 'siswa', '2024-11-06 06:09:46', '2024-11-06 06:09:46'),
(205, 'PELANGI AYUSHITA', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 2, 'siswa', '2024-11-06 08:10:28', '2024-11-06 08:10:28'),
(206, 'Pujito, S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:42', '2024-11-06 08:17:42'),
(207, 'Joko Sugianto S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(208, 'Nyanto, S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(209, 'Sri Sumartini, S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(210, 'Siti Mutmainah,S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(211, 'Sulistamaji, S.Pd', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, NULL, 'guru', '2024-11-06 08:17:45', '2024-11-06 08:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `mapel_id` int(10) UNSIGNED DEFAULT NULL,
  `kelas_id` int(10) UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `link_youtube` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `judul`, `mapel_id`, `kelas_id`, `file_path`, `link_youtube`, `created_at`, `updated_at`) VALUES
(5, 'selamat mengerjakan', 6, 2, NULL, 'https://youtu.be/RKOeqFn-KnM?si=IXU6CAeT6D9HdPNI', '2024-11-18 08:20:09', '2024-11-18 08:20:09'),
(10, 'tugas pertamana', 10, 1, 'videos/xrbmLJlrMkg6JVk2BI6cRz4EVhDTCpOGSndDRlaP.mp4', NULL, '2024-11-19 01:30:54', '2024-11-19 01:30:54'),
(11, 'Matematika', 2, 2, 'videos/UFRK8rlIad66vkNbeoED4ctjFkDyNjZdrzlR8OvB.mp4', NULL, '2024-11-19 01:34:49', '2024-11-19 01:34:49'),
(14, 'tugas pertamana', 2, 8, 'videos/tuPDk5i6U0OnKWGKeLxiKt9oL246U0Swr7wAVFjU.mp4', NULL, '2024-11-25 07:55:38', '2024-11-25 07:55:38'),
(15, 'Ujian Bahasa Indonesia', 1, 1, NULL, 'https://www.youtube.com/watch?v=RK-jNrOUd-w', '2024-12-14 08:16:29', '2024-12-14 08:16:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balasan_pesan`
--
ALTER TABLE `balasan_pesan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`pengirim_id`),
  ADD KEY `fk_pesan` (`pesan_id`);

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`user_id`),
  ADD KEY `fk_threads` (`thread_id`);

--
-- Indexes for table `essay`
--
ALTER TABLE `essay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `fk_guru_user` (`user_id`);

--
-- Indexes for table `guru_mapels`
--
ALTER TABLE `guru_mapels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`siswa_id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indexes for table `jawaban_siswa_essay`
--
ALTER TABLE `jawaban_siswa_essay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`ujian_id`,`essay_id`),
  ADD KEY `fk_ujian` (`ujian_id`),
  ADD KEY `fk_essay` (`essay_id`);

--
-- Indexes for table `jawaban_siswa_pilgan`
--
ALTER TABLE `jawaban_siswa_pilgan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`ujian_id`,`pilihan_ganda_id`),
  ADD KEY `fk_users` (`siswa_id`);

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
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kelas` (`kode_kelas`);

--
-- Indexes for table `mapels`
--
ALTER TABLE `mapels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mapel` (`mapel_id`),
  ADD KEY `fk_kelas` (`kelas_id`),
  ADD KEY `fk_users` (`user_id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesans`
--
ALTER TABLE `pesans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pengirim_id` (`pengirim_id`),
  ADD KEY `fk_penerima_id` (`penerima_id`);

--
-- Indexes for table `pilihan_ganda`
--
ALTER TABLE `pilihan_ganda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `fk_siswa_user` (`user_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_guru_mapels` (`mapel_id`,`kelas_id`),
  ADD KEY `fk_users` (`guru_id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kelas` (`kelas_id`) USING BTREE,
  ADD KEY `fk_mapels` (`mapel_id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_kelas` (`kelas_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kelas` (`kelas_id`),
  ADD KEY `fk_mapels` (`mapel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balasan_pesan`
--
ALTER TABLE `balasan_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `essay`
--
ALTER TABLE `essay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `guru_mapels`
--
ALTER TABLE `guru_mapels`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jawaban_siswa_essay`
--
ALTER TABLE `jawaban_siswa_essay`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jawaban_siswa_pilgan`
--
ALTER TABLE `jawaban_siswa_pilgan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mapels`
--
ALTER TABLE `mapels`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesans`
--
ALTER TABLE `pesans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pilihan_ganda`
--
ALTER TABLE `pilihan_ganda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guru_mapels`
--
ALTER TABLE `guru_mapels`
  ADD CONSTRAINT `guru_mapels_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapels_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapels_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_guru` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesans`
--
ALTER TABLE `pesans`
  ADD CONSTRAINT `fk_penerima_id` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pengirim_id` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
