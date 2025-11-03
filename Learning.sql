-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Okt 2025 pada 11.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `attachable_type` varchar(255) NOT NULL,
  `attachable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `balasan_pesan`
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
-- Dumping data untuk tabel `balasan_pesan`
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
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
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
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `thread_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 203, 'bagaiman cah', '2024-12-14 01:32:48', '2024-12-14 01:32:48'),
(2, 2, 201, 'wah bagus juga tu bagai\r\nmana', '2024-12-14 01:35:44', '2024-12-14 01:35:44'),
(3, 2, 196, 'benarkah begitu ?', '2024-12-14 01:47:02', '2024-12-14 01:47:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `essay`
--

CREATE TABLE `essay` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) DEFAULT NULL,
  `soal` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `essay`
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
(13, 15, 'kerjakan dengan Benar berapa 20 + 19 ?', '2024-12-14 00:47:43', '2024-12-14 00:47:43'),
(14, 16, 'testing', '2025-10-22 14:57:27', '2025-10-22 14:57:27'),
(15, 16, 'apa', '2025-10-22 14:57:37', '2025-10-22 14:57:37'),
(16, 16, 'esok kan bagaimana', '2025-10-22 14:57:45', '2025-10-22 14:57:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `grades`
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
-- Struktur dari tabel `guru`
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
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `alamat`, `tgl_lahir`, `telepon`, `gender`, `jabatan`, `created_at`, `updated_at`) VALUES
(54, 196, '19630917 198501 2 002', 'Bulungcangkring Rt 1 Rw 06 Jekulo Kudus', '1970-01-01', '085640449608', 'Laki-laki', 'Guru', '2024-10-10 06:28:30', '2025-10-26 10:23:47'),
(56, 207, '19640322 198703 1 004', 'T Rejo Rt 04 RW 03 Jekulo Kudus', '1970-01-01', '081575994113', 'Laki-laki', 'Guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(57, 208, '19640412 198703 1 015', 'Klaling Rt.03 Rw. II  Jekulo, Kudus', '1970-01-01', '085640963668', 'Laki-laki', 'Guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(58, 209, '19640122 198803 2 004', 'T Rejo Rt 06 RW 03 Jekulo Kudus', '1970-01-01', '087833985286', 'Perempuan', 'Guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(59, 210, '19650603 199201 2 001', 'T Rejo Rt 04 RW 03 Jekulo Kudus', '1970-01-01', '085740257113', 'Perempuan', 'Guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(60, 211, '19670701 199003 1 008', 'T Rejo Rt 02 RW 05 Jekulo Kudus', '1970-01-01', '081325609203', 'Laki-laki', 'Guru', '2024-11-06 08:17:45', '2024-11-06 08:17:45'),
(61, 212, '10110017', 'jakarta', '2005-10-04', '93678900303', 'Laki-laki', 'UI/UX', '2025-10-14 05:26:10', '2025-10-14 05:26:10'),
(62, 215, '19640322 198703 1 022', 'indonesia', '2025-10-20', '0851234569862', 'Laki-laki', 'guru', '2025-10-20 07:45:20', '2025-10-20 07:45:20'),
(64, 308, '1232424422424229', 'jakarta', '2025-10-26', '2948832299203', 'Perempuan', 'Guru', '2025-10-26 10:24:20', '2025-10-26 10:24:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_mapels`
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
-- Dumping data untuk tabel `guru_mapels`
--

INSERT INTO `guru_mapels` (`id`, `user_id`, `mapel_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(5, 196, 1, 8, '2024-10-24 22:51:30', '2024-10-24 22:51:30'),
(8, 212, 10, 9, '2025-10-20 05:29:06', '2025-10-20 05:29:06'),
(9, 215, 1, 9, '2025-10-20 07:45:58', '2025-10-26 10:21:21'),
(11, 215, 2, 13, '2025-10-22 07:49:55', '2025-10-22 07:49:55'),
(13, 212, 12, 17, '2025-10-25 13:20:19', '2025-10-25 13:20:19'),
(14, 212, 20, 18, '2025-10-25 13:20:19', '2025-10-25 13:20:19'),
(15, 215, 28, 19, '2025-10-25 13:22:51', '2025-10-25 13:22:51'),
(16, 215, 35, 20, '2025-10-25 13:22:51', '2025-10-25 13:22:51'),
(19, 196, 1, 14, '2025-10-26 10:20:59', '2025-10-26 10:20:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_ujian`
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
-- Dumping data untuk tabel `hasil_ujian`
--

INSERT INTO `hasil_ujian` (`id`, `siswa_id`, `ujian_id`, `total_nilai_essay`, `total_nilai_pilgan`, `created_at`, `updated_at`) VALUES
(1, 135, 7, 37, 0.00, '2024-10-26 02:16:05', '2024-10-26 02:16:05'),
(2, 135, 8, 70, 0.00, '2024-10-26 02:17:37', '2024-10-26 02:17:46'),
(3, 136, 8, 194, 0.00, '2024-10-26 02:18:37', '2024-10-26 02:18:44'),
(4, 137, 9, 100, 0.00, '2024-10-28 22:56:33', '2024-10-28 22:57:04'),
(5, 137, 10, 90, 0.00, '2024-10-31 07:24:20', '2024-10-31 08:13:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester_manual` varchar(255) DEFAULT NULL,
  `hari` varchar(255) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruang` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `kelas_id`, `mapel_id`, `user_id`, `guru_id`, `semester_id`, `semester_manual`, `hari`, `jam_mulai`, `jam_selesai`, `ruang`, `created_at`, `updated_at`) VALUES
(1, 9, 10, 212, 55, 1, NULL, 'Selasa', '20:15:00', '22:15:00', 'Lab Program', '2025-10-20 06:16:07', '2025-10-20 07:24:12'),
(2, 9, 3, 206, NULL, 1, NULL, 'Sabtu', '13:41:00', '15:41:00', 'ruang agamis', '2025-10-25 06:41:31', '2025-10-25 06:41:31'),
(3, 17, 12, 301, 212, 1, NULL, 'Senin', '07:30:00', '09:00:00', 'Ruang 101', '2025-10-25 13:29:26', '2025-10-25 13:29:26'),
(4, 17, 15, 301, 212, 1, NULL, 'Selasa', '09:00:00', '10:30:00', 'Ruang 102', '2025-10-25 13:29:26', '2025-10-25 13:29:26'),
(5, 18, 21, 302, 212, 1, NULL, 'Rabu', '10:30:00', '12:00:00', 'Ruang 103', '2025-10-25 13:29:26', '2025-10-25 13:29:26'),
(6, 9, 27, 207, 212, 1, NULL, 'Jumat', '11:00:00', '13:00:00', 'Ruang 104', '2025-10-25 13:29:26', '2025-10-26 10:33:18'),
(7, 19, 28, 303, 215, 1, NULL, 'Senin', '08:00:00', '09:30:00', 'Ruang 201', '2025-10-25 13:29:38', '2025-10-25 13:29:38'),
(8, 19, 31, 303, 215, 1, NULL, 'Selasa', '09:30:00', '11:00:00', 'Ruang 202', '2025-10-25 13:29:38', '2025-10-25 13:29:38'),
(11, 21, 42, 305, 206, 1, NULL, 'Senin', '07:30:00', '09:00:00', 'Studio 1', '2025-10-25 13:29:50', '2025-10-25 13:29:50'),
(12, 21, 45, 305, 206, 1, NULL, 'Selasa', '09:00:00', '10:30:00', 'Studio 2', '2025-10-25 13:29:50', '2025-10-25 13:29:50'),
(13, 22, 50, 306, 206, 1, NULL, 'Rabu', '10:30:00', '12:00:00', 'Studio 3', '2025-10-25 13:29:50', '2025-10-25 13:29:50'),
(14, 22, 53, 306, 206, 1, NULL, 'Kamis', '08:00:00', '09:30:00', 'Studio 4', '2025-10-25 13:29:50', '2025-10-25 13:29:50'),
(15, 17, 16, 301, 212, 1, NULL, 'Sabtu', '09:00:00', '10:30:00', 'Ruang 105', '2025-10-25 13:31:41', '2025-10-25 13:31:41'),
(16, 9, 23, 212, NULL, 1, NULL, 'Sabtu', '20:37:00', '23:37:00', 'r1', '2025-10-25 13:37:22', '2025-10-25 13:37:22'),
(17, 9, 1, 196, NULL, 1, NULL, 'Rabu', '17:11:00', '19:11:00', 'Lab Program', '2025-10-26 10:11:41', '2025-10-26 10:11:41'),
(18, 9, 2, 196, NULL, 1, NULL, 'Senin', '19:30:00', '20:31:00', 'Ruang 104', '2025-10-26 10:31:03', '2025-10-26 10:31:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_siswa_essay`
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
-- Dumping data untuk tabel `jawaban_siswa_essay`
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
-- Struktur dari tabel `jawaban_siswa_pilgan`
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
-- Dumping data untuk tabel `jawaban_siswa_pilgan`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
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
(16, '9 C', 'IX C', '2025-10-22 14:50:41', '2025-10-22 14:50:41'),
(17, 'AB1', 'Administrasi Bisnis Semester 1', '2025-10-25 13:18:40', '2025-10-25 13:18:40'),
(18, 'AB2', 'Administrasi Bisnis Semester 2', '2025-10-25 13:18:40', '2025-10-25 13:18:40'),
(19, 'AK1', 'Akuntansi Komputer Semester 1', '2025-10-25 13:22:02', '2025-10-25 13:22:02'),
(20, 'AK2', 'Akuntansi Komputer Semester 2', '2025-10-25 13:22:02', '2025-10-25 13:22:02'),
(21, 'DG1', 'Desain Grafis Semester 1', '2025-10-25 13:23:14', '2025-10-25 13:23:14'),
(22, 'DG2', 'Desain Grafis Semester 2', '2025-10-25 13:23:14', '2025-10-25 13:23:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapels`
--

CREATE TABLE `mapels` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_mapel` varchar(255) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapels`
--

INSERT INTO `mapels` (`id`, `semester_id`, `kode_mapel`, `nama_mapel`, `created_at`, `updated_at`) VALUES
(1, NULL, 'BI', 'Bahasa Indonesia', '2024-10-10 08:07:14', '2024-10-20 00:07:11'),
(2, NULL, 'MTK', 'Matematika', '2024-10-11 09:47:28', '2024-10-20 00:07:55'),
(3, 3, 'PAI', 'Agama', '2024-10-20 00:07:42', '2025-10-26 10:26:44'),
(4, NULL, 'pjok', 'PJOK', '2024-10-20 00:08:46', '2024-10-20 00:08:46'),
(5, NULL, 'ipa', 'Ilmu Pengetahuan Alam', '2024-10-28 23:58:05', '2024-10-28 23:58:05'),
(6, NULL, 'ips', 'Ilmu Pengetahuan Sosial', '2024-10-28 23:58:34', '2024-10-28 23:58:34'),
(7, NULL, 'ppkn', 'PPKN', '2024-10-29 00:00:59', '2024-10-29 00:00:59'),
(8, NULL, 'B Ing', 'Bahasa Inggris', '2024-10-29 00:01:41', '2024-10-29 00:01:49'),
(9, NULL, 'Sn Budaya', 'Seni Budaya', '2024-10-29 00:02:27', '2024-10-29 00:02:27'),
(10, NULL, 'imk', 'Informatika', '2024-10-29 00:03:51', '2025-10-20 06:53:40'),
(11, NULL, 'bhs Jawa', 'Bahasa Jawa', '2024-10-29 00:04:26', '2024-10-29 00:04:26'),
(12, 1, 'AB101', 'Typing (Mengetik 10 Jari) I', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(13, 1, 'AB102', 'Microsoft Word', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(14, 1, 'AB103', 'Microsoft Excel', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(15, 1, 'AB104', 'Koresponden Bisnis', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(16, 1, 'AB105', 'Manajemen Perkantoran', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(17, 1, 'AB106', 'English Conversation I', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(18, 1, 'AB107', 'English Conversation II', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(19, 1, 'AB108', 'Photoshop', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(20, 1, 'AB201', 'Typing (Mengetik 10 Jari) II', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(21, 1, 'AB202', 'Corel Draw', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(22, 1, 'AB203', 'Power Point', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(23, 1, 'AB204', 'Pemasaran (Marketing)', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(24, 1, 'AB205', 'Etika Perkantoran', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(25, 1, 'AB206', 'English Conversation III', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(26, 1, 'AB207', 'English Conversation IV', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(27, 1, 'AB208', 'Magang (Job Training)', '2025-10-25 13:19:21', '2025-10-25 13:19:21'),
(28, 1, 'AK101', 'Typing (Mengetik 10 Jari) I', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(29, 1, 'AK102', 'Microsoft Word', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(30, 1, 'AK103', 'Microsoft Excel', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(31, 1, 'AK104', 'Akuntansi Dasar I', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(32, 1, 'AK105', 'Akuntansi Dasar II', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(33, 1, 'AK106', 'English Conversation I', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(34, 1, 'AK107', 'English Conversation II', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(35, 1, 'AK201', 'Typing (Mengetik 10 Jari) II', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(36, 1, 'AK202', 'Power Point', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(37, 1, 'AK203', 'Akuntansi Biaya', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(38, 1, 'AK204', 'Akuntansi Komputer', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(39, 1, 'AK205', 'English Conversation III', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(40, 1, 'AK206', 'English Conversation IV', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(41, 1, 'AK207', 'Magang (Job Training)', '2025-10-25 13:22:23', '2025-10-25 13:22:23'),
(42, 1, 'DG101', 'Typing (Mengetik 10 Jari) I', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(43, 1, 'DG102', 'Microsoft Word', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(44, 1, 'DG103', 'Microsoft Excel', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(45, 1, 'DG104', 'Corel Draw', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(46, 1, 'DG105', 'English Conversation I', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(47, 1, 'DG106', 'English Conversation II', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(48, 1, 'DG201', 'Typing (Mengetik 10 Jari) II', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(49, 1, 'DG202', 'Power Point', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(50, 1, 'DG203', 'Photoshop', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(51, 1, 'DG204', 'English Conversation III', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(52, 1, 'DG205', 'English Conversation IV', '2025-10-25 13:23:37', '2025-10-25 13:23:37'),
(53, 1, 'DG206', 'Magang (Job Training)', '2025-10-25 13:23:37', '2025-10-25 13:23:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
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
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `judul`, `mapel_id`, `kelas_id`, `file_path`, `user_id`, `created_at`, `updated_at`) VALUES
(8, 'GIAT BELAJJAR', 2, 1, 'uploads/materi/1730552676_MODUL AJAR B IND KLS 3 fase B.docx', 196, '2024-11-02 06:04:37', '2024-11-02 06:04:47'),
(11, 'Pemahaman Algoritma', 10, 9, 'uploads/materi/1760963444_Fajar-10110017-artiker apsi uts.pdf', 212, '2025-10-20 05:30:44', '2025-10-20 05:30:44'),
(12, 'test', 1, 1, 'uploads/materi/1761145876_SOAL UAS PRAKTIKUM.pdf', 215, '2025-10-22 15:11:16', '2025-10-22 15:11:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_12_19_000000_create_semesters_table', 1),
(2, '2025_10_20_000001_add_semester_manual_to_jadwal_table', 2),
(4, '2025_10_20_135224_add_semester_id_to_mapels_table', 3),
(5, '2025_10_20_142159_add_user_id_to_jadwals_table', 4),
(6, '2025_10_20_150307_create_forum_tables', 5),
(7, '2025_01_20_000001_create_presensi_records_table', 6),
(8, '2025_10_20_161632_add_description_and_attachments_to_quizzes_table', 7),
(9, '2025_10_21_073525_create_quiz_submissions_table', 8),
(10, '2025_10_21_075408_add_grade_to_quiz_submissions_table', 9),
(11, '2025_10_22_090855_add_visibility_to_tugas_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumpulan_tugas`
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
-- Dumping data untuk tabel `pengumpulan_tugas`
--

INSERT INTO `pengumpulan_tugas` (`id`, `tugas_id`, `siswa_id`, `file_tugas`, `nilai`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 2, 201, 'tugas_pengumpulan/5V0XjTZQWZsLw5diKkSPVW07xWSuDB9hM3sIfhBP.jpg', 100, 'sudah selesai', '2024-10-30 01:54:34', '2024-11-03 05:51:13'),
(2, 7, 201, 'tugas_pengumpulan/iIowEEIw9Z7h5D0siwWah26zOtDI947DaZ2Drbdn.jpg', 92, NULL, '2024-11-03 08:44:59', '2024-11-17 09:17:31'),
(3, 8, 201, 'tugas_pengumpulan/ZtcDT6TvNYtZlNyklVTD0EatyrS0n4M8N5UhOn3g.jpg', 100, 'selesai bu silahkan dilihat', '2024-12-05 08:04:28', '2024-12-14 08:42:56'),
(4, 9, 213, 'tugas_pengumpulan/KhL21ytkePepJWmqVL1LyV8lElL9Ylbcb5vUe94c.docx', 80, 'sudah pak', '2025-10-20 05:39:43', '2025-10-20 05:40:41'),
(5, 10, 214, 'tugas_pengumpulan/e52pxe6oRevf6CyFr5E9AxiNgGeyyWNFA5um8h65.pdf', 90, NULL, '2025-10-22 01:49:27', '2025-10-22 01:51:59'),
(7, 11, 216, 'tugas_pengumpulan/FJPGKEVSe59YHvOQvaWgJaX36ZNGiFHGicaVp39P.pdf', NULL, 'silahkan liat tugaas aku', '2025-10-22 02:59:23', '2025-10-22 02:59:23'),
(8, 11, 214, 'tugas_pengumpulan/ky6R7bzd53CJfahDdJuADzP77Li1ok3bnFedRDfi.pdf', NULL, NULL, '2025-10-22 03:28:02', '2025-10-22 03:28:02'),
(9, 12, 216, 'tugas_pengumpulan/927ARF5OK7EWUwoxVEZmTZVnKV5WfeHbK2ZJO3KN.pdf', 100, NULL, '2025-10-22 07:13:29', '2025-10-22 07:14:34'),
(10, 12, 214, 'tugas_pengumpulan/fyqqIuN1yCSxL9T6kuhNgjfTVGfzh2PjBKcTd2wi.pdf', 100, NULL, '2025-10-22 07:14:02', '2025-10-22 07:14:40'),
(11, 13, 217, 'tugas_pengumpulan/mAjQaUNEcrS5FtNhrs8q8CJjdhaGV9qrBrVQIjPH.pdf', 100, NULL, '2025-10-22 07:52:55', '2025-10-22 07:53:51'),
(12, 13, 218, 'tugas_pengumpulan/pJoAI0tD9RpH73aVQkuApPlhmqc0eoUewSjK6RhW.pdf', NULL, NULL, '2025-10-22 08:00:59', '2025-10-22 08:00:59'),
(13, 14, 218, 'tugas_pengumpulan/hfRQEtgnqab8VX323I0WNKBxzIyTm3C2D6uGORUu.pdf', NULL, NULL, '2025-10-22 08:05:43', '2025-10-22 08:05:43'),
(14, 12, 219, 'tugas_pengumpulan/t5X1sxZubBcfGJqqnZAnmpgmA72ALpj1WVv3SLMs.pdf', NULL, NULL, '2025-10-22 12:31:55', '2025-10-22 12:31:55'),
(15, 16, 150, 'tugas_pengumpulan/KbpR3wynm0I7v65VQJyzBh65DClmbTrtiuWOsmF4.pdf', 100, NULL, '2025-10-22 16:20:34', '2025-10-22 16:26:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesans`
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
-- Dumping data untuk tabel `pesans`
--

INSERT INTO `pesans` (`id`, `pengirim_id`, `penerima_id`, `judul`, `isi_pesan`, `is_read`, `created_at`, `updated_at`) VALUES
(4, 203, 196, 'Absen Tanggal 16 April 2024', 'absen bu', 1, '2024-11-16 06:41:36', '2024-12-14 00:50:56'),
(7, 196, 203, 'siang', 'siang siswa aprilia', 1, '2024-11-25 08:11:57', '2024-12-11 06:33:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_ganda`
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
-- Dumping data untuk tabel `pilihan_ganda`
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
(16, 15, 'Berpara solanya', '1', '2', '3', '4', '5', 'A', '2024-12-14 09:39:51', '2024-12-14 09:39:51'),
(17, 16, 'dilengkapi lapisan selimiut', 'yang berupa', 'dekapan nadi', 'yang mengalir', 'jadi seruan dihati', 'bermuarakan kabar', 'A', '2025-10-22 14:58:32', '2025-10-22 14:58:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi_records`
--

CREATE TABLE `presensi_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `presensi_session_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('hadir','terlambat','tidak_hadir','sakit','izin') NOT NULL DEFAULT 'tidak_hadir',
  `waktu_absen` timestamp NULL DEFAULT NULL,
  `metode_absen` enum('qr','manual') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi_records`
--

INSERT INTO `presensi_records` (`id`, `presensi_session_id`, `siswa_id`, `status`, `waktu_absen`, `metode_absen`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 201, 'tidak_hadir', NULL, NULL, NULL, '2025-10-22 01:43:44', '2025-10-22 01:43:44'),
(2, 1, 214, 'hadir', '2025-10-22 01:44:08', 'manual', NULL, '2025-10-22 01:43:44', '2025-10-22 01:44:08'),
(3, 3, 213, 'terlambat', '2025-10-22 16:56:59', 'qr', NULL, '2025-10-22 16:55:56', '2025-10-22 16:56:59'),
(4, 2, 213, 'terlambat', '2025-10-22 16:56:39', 'manual', NULL, '2025-10-22 16:56:39', '2025-10-22 16:56:39'),
(5, 4, 213, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 10:59:15', '2025-10-24 10:59:15'),
(6, 5, 201, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:18:37', '2025-10-24 11:18:37'),
(7, 5, 214, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:18:37', '2025-10-24 11:18:37'),
(8, 5, 216, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:18:37', '2025-10-24 11:18:37'),
(9, 5, 219, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:18:37', '2025-10-24 11:18:37'),
(10, 5, 225, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:18:37', '2025-10-24 11:18:37'),
(11, 6, 213, 'tidak_hadir', NULL, NULL, NULL, '2025-10-24 11:38:27', '2025-10-24 11:38:27'),
(12, 7, 213, 'terlambat', '2025-10-24 12:43:19', 'manual', NULL, '2025-10-24 12:42:23', '2025-10-24 12:43:19'),
(13, 8, 213, 'terlambat', '2025-10-25 10:07:18', 'qr', NULL, '2025-10-25 08:32:36', '2025-10-25 10:07:18'),
(14, 9, 213, 'sakit', NULL, 'manual', NULL, '2025-10-25 14:55:53', '2025-10-25 15:24:35'),
(15, 10, 201, 'tidak_hadir', NULL, NULL, NULL, '2025-10-26 10:28:51', '2025-10-26 10:28:51'),
(16, 10, 213, 'terlambat', '2025-10-26 10:30:09', 'qr', NULL, '2025-10-26 10:28:51', '2025-10-26 10:30:09'),
(17, 10, 307, 'tidak_hadir', NULL, NULL, NULL, '2025-10-26 10:28:51', '2025-10-26 10:28:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi_sessions`
--

CREATE TABLE `presensi_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time DEFAULT NULL,
  `mode` enum('qr','manual') NOT NULL DEFAULT 'qr',
  `qr_code` varchar(255) DEFAULT NULL,
  `qr_expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi_sessions`
--

INSERT INTO `presensi_sessions` (`id`, `kelas_id`, `mapel_id`, `guru_id`, `semester_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `mode`, `qr_code`, `qr_expires_at`, `is_active`, `is_closed`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 215, 1, '2025-10-22', '08:43:00', NULL, 'manual', NULL, NULL, 0, 1, 'pertemuan 1', '2025-10-22 01:43:44', '2025-10-24 10:58:18'),
(2, 9, 9, 212, 1, '2025-10-22', '23:42:00', NULL, 'manual', NULL, NULL, 0, 1, 'isww', '2025-10-22 16:42:31', '2025-10-24 10:36:22'),
(3, 9, 2, 212, 1, '2025-10-22', '23:55:00', NULL, 'qr', 'PRESENSI_3_1761152156_5237', '2025-10-22 16:59:59', 0, 1, 'uhuj', '2025-10-22 16:55:56', '2025-10-24 10:36:17'),
(4, 9, 2, 212, 1, '2025-10-25', '17:58:00', NULL, 'manual', NULL, NULL, 0, 1, 'ihwd', '2025-10-24 10:59:15', '2025-10-24 10:59:31'),
(5, 1, 10, 212, 1, '2025-10-24', '18:18:00', NULL, 'manual', NULL, NULL, 0, 1, 'kkk k', '2025-10-24 11:18:37', '2025-10-24 11:33:46'),
(6, 9, 3, 212, 1, '2025-10-24', '18:37:00', NULL, 'manual', NULL, NULL, 0, 1, 'hhhhhh', '2025-10-24 11:38:27', '2025-10-24 11:38:37'),
(7, 9, 6, 212, 1, '2025-10-24', '19:42:00', NULL, 'manual', NULL, NULL, 0, 1, 'ibwd', '2025-10-24 12:42:23', '2025-10-25 14:55:11'),
(8, 9, 1, 212, 1, '2025-10-25', '15:32:00', NULL, 'qr', 'PRESENSI_8_1761381156_4307', '2025-10-25 16:59:59', 0, 1, 'uu', '2025-10-25 08:32:36', '2025-10-25 14:55:08'),
(9, 9, 9, 212, 1, '2025-10-25', '21:57:00', NULL, 'qr', 'PRESENSI_9_1761404153_2535', '2025-10-25 16:59:59', 0, 1, 'per 1', '2025-10-25 14:55:53', '2025-10-26 10:20:45'),
(10, 9, 2, 212, 1, '2025-10-26', '17:28:00', NULL, 'qr', 'PRESENSI_10_1761474531_1270', '2025-10-26 16:59:59', 1, 0, 'per 2', '2025-10-26 10:28:51', '2025-10-26 10:28:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `guru_mapel_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `attachment_file` varchar(255) DEFAULT NULL,
  `attachment_link` varchar(255) DEFAULT NULL,
  `attachment_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `quizzes`
--

INSERT INTO `quizzes` (`id`, `judul`, `guru_mapel_id`, `description`, `attachment_file`, `attachment_link`, `attachment_image`, `created_at`, `updated_at`) VALUES
(3, 'gasda', 9, 'faas', 'quiz_attachments/files/sye5yCcSxcZZtAjnshkWxJbvJ4nQ1XFWzUR5GFjd.pdf', NULL, NULL, '2025-10-22 15:00:29', '2025-10-22 15:00:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_semester` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `semesters`
--

INSERT INTO `semesters` (`id`, `nama_semester`, `tahun_ajaran`, `tanggal_mulai`, `tanggal_selesai`, `is_active`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'semester 1', '2024/2025', '2025-10-20', '2025-11-02', 1, 'testing', '2025-10-20 06:51:19', '2025-10-26 10:36:43'),
(3, 'semester 3', '2024/2025', '2025-10-26', '2025-11-07', 0, 'uagfuafaqr', '2025-10-26 10:25:31', '2025-10-26 10:36:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5b0DQ6ipgPkqPPK1qKS8hWmgnYtlyMZo1rSIds8P', 1, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_7_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSE1ldXRXNW9kTVRraURqOXNqN285N3Zoa1EzbHhBTHI5bUZ2d1RQTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZW1lc3RlciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761475003),
('aLduNZFfE4owKSB1QNbO5Okh5p1YUHPb8rcULQ5x', 213, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzk1VmZjNUd4ZXNCMnRuVGhPdDd1UmZHS2xzdFZaY2Z4UG45Y3ZuSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9KYWR3YWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMTM7fQ==', 1761475006),
('Fg7Utn0poM5k76mIzP3L1prtXpmFtzfSv9sxW491', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_7_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3FneXE4WnBXMG1saHZGR090bnFRNW9rb2lrdUlnbjF6ZDlwS0J2SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lX3BhZ2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761473007);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
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
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `kelas_id`, `nis`, `nisn`, `telepon`, `alamat`, `tgl_lahir`, `gender`, `created_at`, `updated_at`) VALUES
(135, 201, 9, '9184', '51515151515155', '085277525581', 'Ds Kutoharjo Dk Karangdowo, Jalan Guyub Rukun II, RT.5/RW.1, Kutoharjo, Pati, KAB. PATI, PATI, JAWA TENGAH, ID, 59118', '2020-02-20', 'Laki-laki', '2024-10-14 23:24:31', '2025-10-26 10:23:20'),
(137, 203, 8, '9156', '63546541', '08156124759', 'kudus jekulo', '2002-05-12', 'Perempuan', '2024-10-24 22:50:32', '2025-10-22 07:36:28'),
(138, 204, 8, '9174', '3104452536', '088806029157', 'Tanjungrejo Rt/Rw 004/006 Kel. Tanjungrejo Kec.Jekulo Kab.Kudus', '2010-01-07', 'Perempuan', '2024-11-06 06:09:46', '2025-10-22 07:36:28'),
(139, 205, 2, '8993', '0101838003', '085878626616', 'Tanjungrejo, Rt. 1, Rw. 5, Kel. Tanjung Rejo, Kec. Jekulo', '2010-09-08', 'Perempuan', '2024-11-06 08:10:28', '2025-10-22 07:36:28'),
(140, 213, 9, '101100177', '101100172005', '08923830299', 'subang', '2006-04-20', 'Laki-laki', '2025-10-20 05:22:09', '2025-10-22 07:36:28'),
(141, 214, 1, '23232', '121212122121212', '0851234569862', 'subang', '2025-10-20', 'Laki-laki', '2025-10-20 07:37:45', '2025-10-22 07:36:28'),
(142, 216, 1, '11111', '1010101010', '019109202910', 'indonesia', '2025-10-22', 'Laki-laki', '2025-10-22 02:42:42', '2025-10-22 07:36:28'),
(145, 219, 1, '123456', '2121212121', '085647984521', 'dimana', '2025-10-21', 'Laki-laki', '2025-10-22 12:25:08', '2025-10-22 12:25:08'),
(149, 223, 13, '321321', '1231213123211', '0212335413518', 'gataw', '2025-10-01', 'Laki-laki', '2025-10-22 14:25:59', '2025-10-22 14:25:59'),
(150, 225, 1, '10110039', '123123131321', '0521654981', 'gtw', '2025-10-15', 'Laki-laki', '2025-10-22 14:51:32', '2025-10-22 16:04:59'),
(153, 305, 21, '25001', '20240021', '082110223311', 'Jl. Gatot Subroto No.22, Subang', '2006-05-02', 'Laki-laki', NULL, NULL),
(154, 306, 22, '25002', '20240022', '082110223322', 'Jl. RA Kartini No.15, Subang', '2005-08-25', 'Perempuan', NULL, NULL),
(155, 303, 19, '24001', '20240011', '081222330001', 'Jl. Otista No.12, Subang', '2006-03-18', 'Perempuan', NULL, NULL),
(156, 304, 20, '24002', '20240012', '081222330002', 'Jl. Cagak Barat No.7, Subang', '2005-09-14', 'Laki-laki', NULL, NULL),
(157, 301, 17, '23001', '20240001', '085600111222', 'Jl. Ahmad Yani No.45, Subang', '2005-04-20', 'Perempuan', NULL, NULL),
(158, 302, 18, '23002', '20240002', '085600111333', 'Jl. Raya Kalijati, Subang', '2004-11-02', 'Laki-laki', NULL, NULL),
(159, 307, 9, '1011001799', '101100172005998', '08923830299', 'jakarta', '2025-10-26', 'Perempuan', '2025-10-26 10:23:05', '2025-10-26 10:23:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submissions`
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
-- Struktur dari tabel `threads`
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
-- Dumping data untuk tabel `threads`
--

INSERT INTO `threads` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 203, 'Bagaimana konsep baling baling?', 'bagai mana ?', '2024-12-14 01:32:00', '2024-12-14 01:32:00'),
(2, 203, 'Bagaimana konsep baling baling?', 'bagai mana ?', '2024-12-14 01:32:26', '2024-12-14 01:32:26'),
(3, 214, 'test', 'testing fitur baru', '2025-10-20 07:47:00', '2025-10-20 07:47:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `answers_visible_to_others` tinyint(1) NOT NULL DEFAULT 0,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengumpulan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `judul`, `deskripsi`, `file`, `answers_visible_to_others`, `mapel_id`, `kelas_id`, `guru_id`, `tanggal_pengumpulan`, `created_at`, `updated_at`) VALUES
(2, 'Tugas Matematika', 'Kerjakan soal berikut', 'tugas_files/tugas_matematika.docx', 0, 2, 1, 195, '2024-11-05', '2024-10-29 15:39:37', '2024-10-29 15:39:37'),
(3, 'Soal Mudah', 'kerjakan', 'tugas_files/eUwaVX9urqS7v9ZjQqmrAjMgjQh1IJbOhd6rXYmu.pdf', 0, 2, 2, 195, '2024-10-30', '2024-10-29 08:46:59', '2024-10-29 10:01:21'),
(4, 'waf', 'aefcaesd', NULL, 0, 2, 2, 195, '2024-11-04', '2024-10-29 09:12:57', '2024-10-31 01:13:58'),
(6, 'media', 'kerjakan tugas berikut ini', 'tugas_files/gsLqQBZaQZAoX5jkrw5a48rcykmZshaAfxHYSV0U.docx', 0, 2, 2, 195, '2024-11-04', '2024-11-03 05:57:16', '2024-11-03 05:57:16'),
(7, 'kpk', 'ok', 'tugas_files/oI9DNwrS7wsLeBrIZ0TlxAy4uO6YU55CYGWX8pv4.pdf', 0, 10, 1, 195, '2024-11-03', '2024-11-03 08:16:40', '2024-11-03 08:16:40'),
(8, 'Ilu pengetahuan alam', 'seslesai kan dengan cepat', 'tugas_files/EuCb77KV3RaYLXSeZVsE61YFSuVP1NkjIfq0ytyN.pdf', 0, 1, 1, 196, '2024-12-06', '2024-12-05 08:02:05', '2024-12-05 08:02:05'),
(9, 'latihan soal 1 pemahaman dasar', 'silahkan akses file ini dan kerjakan secara mandiri', 'tugas_files/tdg80iVVdJxW83hCDUMsLnvlnJGT72KbQ80P9jzd.docx', 0, 10, 9, 212, '2025-10-23', '2025-10-20 05:38:35', '2025-10-20 05:38:35'),
(16, 'testing', 'blablala', 'tugas_files/OxYg1nohE6ZL2Kw3rtPkbShhd4hoVLrqQK6TGAyn.pdf', 0, 1, 1, 215, '2025-10-22', '2025-10-22 16:03:21', '2025-10-22 16:03:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
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
-- Dumping data untuk tabel `ujian`
--

INSERT INTO `ujian` (`id`, `judul`, `user_id`, `mapel_id`, `kelas_id`, `waktu_pengerjaan`, `info_ujian`, `bobot_pilihan_ganda`, `bobot_essay`, `terbit`, `created_at`, `updated_at`) VALUES
(7, 'UNBK', 53, 2, 1, 60, 'KOMPUTER', 100, 100, 'Y', '2024-10-21 05:30:36', '2024-10-26 07:25:21'),
(8, 'UTS', 53, 2, 1, 60, 'Matematika', 100, 100, 'Y', '2024-10-24 05:57:47', '2024-10-26 01:00:10'),
(9, 'GIAT BELAJJAR', 53, 1, 8, 60, 'selamat mengerjakan', 100, 100, 'Y', '2024-10-25 01:18:20', '2024-10-25 01:18:20'),
(10, 'tugas pertamana', 54, 1, 8, 60, 'selamat', 50, 50, 'Y', '2024-10-25 02:02:05', '2024-10-25 02:02:05'),
(12, 'komotida', 53, 2, 2, 60, 'gogo', 100, 100, 'Y', '2024-10-28 22:41:38', '2024-10-28 22:41:38'),
(15, 'Ujian Bahasa Indonesia', 54, 1, 1, 30, 'kerjakan dengan jujur', 50, 50, 'Y', '2024-12-14 00:40:29', '2024-12-14 00:40:29'),
(16, 'ujian bahasa indonesia', 62, 1, 1, 60, 'blablalabal', 50, 50, 'Y', '2025-10-22 14:57:06', '2025-10-22 15:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `foto`, `role`, `created_at`, `updated_at`) VALUES
(1, 'adminsuper', 'admin@example.com', '$2y$12$bQWrIH0hfsNLaHiy9jOEsuY0xBPpUK2ebNTo14HiDRIx.YaiCGXNK', 'images/admin_photos/1761473114_alhaitham-genshin-impacts-world.jpg', 'admin', '2024-10-05 01:33:43', '2025-10-26 10:10:10'),
(196, 'Sri Dwiatmining E., S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1733412409_Mahwa.jpeg', 'guru', '2024-10-10 06:28:30', '2024-12-05 08:26:49'),
(201, 'AKHMAD MAULANA RIZKI SAPUTRA', 'anugrahdwisaputra8@gmail.com', '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', '1733411489_Mahwa.jpeg', 'siswa', '2024-10-14 23:24:31', '2024-12-05 08:11:29'),
(203, 'APRILLIA HAPSARI AYUNINGTYAS', 'aan@gmail.com', '$2y$12$NqBfr548PFAEYpGWgvyk1OICG8rkrKYT3lUiiLsZtph6QoWqB.mjm', '1734161222_Mahwa.jpeg', 'siswa', '2024-10-24 22:50:32', '2025-10-14 05:38:42'),
(204, 'QOFFA HUSNUN NADA', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'siswa', '2024-11-06 06:09:46', '2024-11-06 06:09:46'),
(205, 'PELANGI AYUSHITA', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'siswa', '2024-11-06 08:10:28', '2024-11-06 08:10:28'),
(207, 'Joko Sugianto S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(208, 'Nyanto, S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'guru', '2024-11-06 08:17:43', '2024-11-06 08:17:43'),
(209, 'Sri Sumartini, S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(210, 'Siti Mutmainah,S.Pd.', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'guru', '2024-11-06 08:17:44', '2024-11-06 08:17:44'),
(211, 'Sulistamaji, S.Pd', NULL, '$2y$10$d4iAs0kGBW2HkDHjReg4eu0clLMcJAu/EWCG2d9zBlw.qTeIfnfci', NULL, 'guru', '2024-11-06 08:17:45', '2024-11-06 08:17:45'),
(212, 'Fajar Ramadhan Ms', NULL, '$2y$12$CCX845LSeLUbIiVcg.zq4uWY6RidaeoJU4pF3X6ulnZXqWLG4gM.m', NULL, 'guru', '2025-10-14 05:26:10', '2025-10-14 05:26:10'),
(213, 'Fajar Ramadhan Mulyana Sidik', 'dhefajar0410@gmail.com', '$2y$12$yHI8Mb7tx9RP8DlKS.6moet7juvCXsyaDrVH88UeIeiRY0fXSaH4W', '1761232136_alhaitham-genshin-impacts-world.jpg', 'siswa', '2025-10-20 05:22:09', '2025-10-23 15:08:56'),
(214, 'mrap', NULL, '$2y$12$bV9AaSUuif29LUrfRKrYYORw/BFrhIHHtpIPO/7RhvPyTmXCusFmm', NULL, 'siswa', '2025-10-20 07:37:45', '2025-10-20 07:37:45'),
(215, 'rifqi', NULL, '$2y$12$PNN9qiFaPiYjCNn4Dij6uOARm7g2AcWmXWKlDzIWe9rh/zJ/aw9SO', NULL, 'guru', '2025-10-20 07:45:20', '2025-10-20 07:45:20'),
(216, 'augy', NULL, '$2y$12$s2EbRqTsf.lOgCMeBO0yIuwVHcVhSDB5hRcFXxHgC/..L4mA.CyFe', NULL, 'siswa', '2025-10-22 02:42:42', '2025-10-22 02:42:42'),
(219, 'aji', NULL, '$2y$12$r9PMZ/go.IvIDoq9Cqh/peQbF9ijTt5fzzc32JBucn.WEsMCfh8u.', NULL, 'siswa', '2025-10-22 12:25:08', '2025-10-22 12:25:08'),
(223, 'jarz', NULL, '$2y$12$QVpKArJ.uGU/nvfagv1mjOZnaeFvmscXW.2WPQ9RJYCkRYarbQYTm', NULL, 'siswa', '2025-10-22 14:25:59', '2025-10-22 14:25:59'),
(225, 'mrap dev', NULL, '$2y$12$AvxyexvVIGqjyqR3hJbX1eH/Z1HGW5wuT863TBksR65RPMob1ADV.', NULL, 'siswa', '2025-10-22 14:51:32', '2025-10-22 14:51:32'),
(301, 'Rina Setiawati', 'rina.ab1@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(302, 'Dani Pratama', 'dani.ab2@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(303, 'Nisa Ramadhani', 'nisa.ak1@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(304, 'Bagas Wibowo', 'bagas.ak2@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(305, 'Fajar Aditya', 'fajar.dg1@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(306, 'Aulia Maharani', 'aulia.dg2@example.com', '$2y$10$Y5R.1hpQmz9oH4GxtvCkqOxxcZ3lY8PGvTcmkSiTjSNO6ZbZl1T.u', NULL, 'siswa', '2025-10-25 13:24:48', '2025-10-25 13:24:48'),
(307, 'fajar04', NULL, '$2y$12$gpYZKFFUxpT9yHarfXfU/etmDaHNGmCL0InwSRWF9R62oDDrwDhGq', NULL, 'siswa', '2025-10-26 10:23:05', '2025-10-26 10:23:05'),
(308, 'fajar0410111', NULL, '$2y$12$Ck2Vp2TsSjLrAzX1N4Qwuu0fA2MCeVViJs9PMG0h0EJzZgdLewMj2', NULL, 'guru', '2025-10-26 10:24:20', '2025-10-26 10:24:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `videos`
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
-- Dumping data untuk tabel `videos`
--

INSERT INTO `videos` (`id`, `judul`, `mapel_id`, `kelas_id`, `file_path`, `link_youtube`, `created_at`, `updated_at`) VALUES
(5, 'selamat mengerjakan', 6, 2, NULL, 'https://youtu.be/RKOeqFn-KnM?si=IXU6CAeT6D9HdPNI', '2024-11-18 08:20:09', '2024-11-18 08:20:09'),
(10, 'tugas pertamana', 10, 1, 'videos/xrbmLJlrMkg6JVk2BI6cRz4EVhDTCpOGSndDRlaP.mp4', NULL, '2024-11-19 01:30:54', '2024-11-19 01:30:54'),
(11, 'Matematika', 2, 2, 'videos/UFRK8rlIad66vkNbeoED4ctjFkDyNjZdrzlR8OvB.mp4', NULL, '2024-11-19 01:34:49', '2024-11-19 01:34:49'),
(14, 'tugas pertamana', 2, 8, 'videos/tuPDk5i6U0OnKWGKeLxiKt9oL246U0Swr7wAVFjU.mp4', NULL, '2024-11-25 07:55:38', '2024-11-25 07:55:38'),
(16, 'asads', 1, 1, NULL, 'https://www.youtube.com/watch?v=cQNkdt__HAs&list=RD8VfXMeaYWQ0&index=8', '2025-10-22 15:11:52', '2025-10-22 15:11:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_attachable_type_attachable_id_index` (`attachable_type`,`attachable_id`);

--
-- Indeks untuk tabel `balasan_pesan`
--
ALTER TABLE `balasan_pesan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`pengirim_id`),
  ADD KEY `fk_pesan` (`pesan_id`);

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
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`user_id`),
  ADD KEY `fk_threads` (`thread_id`);

--
-- Indeks untuk tabel `essay`
--
ALTER TABLE `essay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `fk_guru_user` (`user_id`);

--
-- Indeks untuk tabel `guru_mapels`
--
ALTER TABLE `guru_mapels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`siswa_id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jawaban_siswa_essay`
--
ALTER TABLE `jawaban_siswa_essay`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`ujian_id`,`essay_id`),
  ADD KEY `fk_ujian` (`ujian_id`),
  ADD KEY `fk_essay` (`essay_id`);

--
-- Indeks untuk tabel `jawaban_siswa_pilgan`
--
ALTER TABLE `jawaban_siswa_pilgan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`ujian_id`,`pilihan_ganda_id`),
  ADD KEY `fk_users` (`siswa_id`);

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
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kelas` (`kode_kelas`);

--
-- Indeks untuk tabel `mapels`
--
ALTER TABLE `mapels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mapel` (`mapel_id`),
  ADD KEY `fk_kelas` (`kelas_id`),
  ADD KEY `fk_users` (`user_id`) USING BTREE;

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesans`
--
ALTER TABLE `pesans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pengirim_id` (`pengirim_id`),
  ADD KEY `fk_penerima_id` (`penerima_id`);

--
-- Indeks untuk tabel `pilihan_ganda`
--
ALTER TABLE `pilihan_ganda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian` (`ujian_id`);

--
-- Indeks untuk tabel `presensi_records`
--
ALTER TABLE `presensi_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `presensi_records_presensi_session_id_siswa_id_unique` (`presensi_session_id`,`siswa_id`),
  ADD KEY `presensi_records_siswa_id_status_index` (`siswa_id`,`status`),
  ADD KEY `presensi_records_presensi_session_id_status_index` (`presensi_session_id`,`status`);

--
-- Indeks untuk tabel `presensi_sessions`
--
ALTER TABLE `presensi_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_submissions_quiz_id_foreign` (`quiz_id`),
  ADD KEY `quiz_submissions_user_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `fk_siswa_user` (`user_id`);

--
-- Indeks untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_guru_mapels` (`mapel_id`,`kelas_id`),
  ADD KEY `fk_users` (`guru_id`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kelas` (`kelas_id`) USING BTREE,
  ADD KEY `fk_mapels` (`mapel_id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kelas` (`kelas_id`),
  ADD KEY `fk_mapels` (`mapel_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `balasan_pesan`
--
ALTER TABLE `balasan_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `essay`
--
ALTER TABLE `essay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `guru_mapels`
--
ALTER TABLE `guru_mapels`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `jawaban_siswa_essay`
--
ALTER TABLE `jawaban_siswa_essay`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `jawaban_siswa_pilgan`
--
ALTER TABLE `jawaban_siswa_pilgan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `mapels`
--
ALTER TABLE `mapels`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pesans`
--
ALTER TABLE `pesans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pilihan_ganda`
--
ALTER TABLE `pilihan_ganda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `presensi_records`
--
ALTER TABLE `presensi_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `presensi_sessions`
--
ALTER TABLE `presensi_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT untuk tabel `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT untuk tabel `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru_mapels`
--
ALTER TABLE `guru_mapels`
  ADD CONSTRAINT `guru_mapels_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapels_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapels_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_guru` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesans`
--
ALTER TABLE `pesans`
  ADD CONSTRAINT `fk_penerima_id` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pengirim_id` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi_records`
--
ALTER TABLE `presensi_records`
  ADD CONSTRAINT `presensi_records_presensi_session_id_foreign` FOREIGN KEY (`presensi_session_id`) REFERENCES `presensi_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensi_records_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_submissions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_submissions_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
