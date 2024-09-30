-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Sep 2024 pada 03.35
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `terminalre`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buses`
--

CREATE TABLE `buses` (
  `id` int NOT NULL,
  `tnkb` varchar(20) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `trayek` varchar(100) NOT NULL,
  `terminal_id` int DEFAULT NULL,
  `status` enum('di_terminal','berangkat') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buses`
--

INSERT INTO `buses` (`id`, `tnkb`, `nama_perusahaan`, `trayek`, `terminal_id`, `status`, `created_at`) VALUES
(1, 'BA 7833 HU', 'PT. JASA MALINDO IBU', 'SAWAHLUNTO - PADANG', 1, 'di_terminal', '2024-09-01 05:47:05'),
(2, 'BA 7860 HU', 'PT. JASA MALINDO IBU', 'PADANG - SAWAHLUNTO', 1, 'di_terminal', '2024-09-01 05:47:05'),
(3, 'BA 7922 HU', 'PT. JASA MALINDO IBU', 'PADANG - SAWAHLUNTO', 1, 'di_terminal', '2024-09-01 05:47:05'),
(4, 'BA 7808 HU', 'PT. JASA MALINDO IBU', 'PADANG - SAWAHLUNTO', 1, 'di_terminal', '2024-09-01 05:47:05'),
(5, 'BA 7969 JU', 'PT. EMKAZET', 'PADANG - SAWAHLUNTO VIA BATU SANGKAR', 1, 'di_terminal', '2024-09-01 05:47:05'),
(14, 'BA 7021 PU', 'PT. JASA MALINDO IBU', 'sawahlunto - padang', 1, 'di_terminal', '2024-09-13 02:02:35'),
(15, 'BA 7019 HU', 'PT. JASA MALINDO IBU', 'sawahlunto - padang', 1, 'di_terminal', '2024-09-13 02:03:12'),
(16, 'BA 7016 HU', 'PT. JASA MALINDO IBU', 'sawahlunto - padang', 1, 'di_terminal', '2024-09-13 02:04:56'),
(17, 'BA 7987 PU', 'PT. JASA MALINDO IBU', 'sawahlunto - padang', 1, 'di_terminal', '2024-09-13 02:05:47'),
(18, 'BA 7979 JU', 'PT. EMKAZET', 'sawahlunto - bukit tinggi via batusangkar', 1, 'di_terminal', '2024-09-13 02:06:39'),
(23, 'BA 7979 JUfsd', 'PT. EMKAZET', 'sawahlunto - bukit tinggi', 5, 'di_terminal', '2024-09-13 03:07:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus_departures`
--

CREATE TABLE `bus_departures` (
  `id` int NOT NULL,
  `bus_id` int NOT NULL,
  `departure_time` datetime NOT NULL,
  `number_of_passengers` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `arrival_time` datetime DEFAULT NULL,
  `number_of_passengers_out` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `terminal_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bus_departures`
--

INSERT INTO `bus_departures` (`id`, `bus_id`, `departure_time`, `number_of_passengers`, `status`, `arrival_time`, `number_of_passengers_out`, `created_at`, `updated_at`, `terminal_id`) VALUES
(51, 5, '2024-09-01 20:48:00', 12, 'di_terminal', '2024-09-04 20:49:00', 12, '2024-09-12 13:48:56', '2024-09-12 13:49:46', 1),
(53, 1, '2024-08-30 20:55:00', 12, 'di_terminal', '2024-09-04 20:55:00', 12, '2024-09-12 13:55:34', '2024-09-12 13:55:44', 1),
(54, 3, '2024-09-09 21:00:00', 12, 'di_terminal', '2024-09-11 21:07:00', 12, '2024-09-12 14:00:06', '2024-09-12 14:09:13', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-08-31-060205', 'App\\Database\\Migrations\\CreateBusDeparturesTable', 'default', 'App', 1725084351, 1),
(2, '2024-08-31-062529', 'App\\Database\\Migrations\\AddTimestampsToBusDepartures', 'default', 'App', 1725085558, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `terminals`
--

CREATE TABLE `terminals` (
  `id` int NOT NULL,
  `nama_terminal` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `terminals`
--

INSERT INTO `terminals` (`id`, `nama_terminal`, `lokasi`) VALUES
(1, 'Sawahlunto', 'Pasar, Kec. Lembah Segar, Kota Sawahlunto, Sumatera Barat 27422'),
(2, 'Sago painan', 'Jl. Raya Padang - Painan No.15, Sago Salido, Kec. Iv Jurai, Kabupaten Pesisir Selatan, Sumatera Barat 25652'),
(3, 'Terminal Padang panjang', 'Bukit Surungan, Kec. Padang Panjang Bar., Kota Padang Panjang, Sumatera Barat'),
(4, 'terminal batusangkar', 'Jl. Kinantan, Baringin, Kec. Lima Kaum, Kabupaten Tanah Datar, Sumatera Barat 27212'),
(5, 'terminal payakumbuh', 'Bulakan Balai Kandih, Kec. Payakumbuh Bar., Kota Payakumbuh, Sumatera Barat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$Tj3J8kbSjBY3GVAtuDEqnuT98Y4aez1A5mNdx7XQeFs1Y4skHg3GK', 'admin'),
(2, 'user1', '$2y$10$7pC8t8yeq8XwfI0sxXYxNeVsZJ9qieZSMA/ES5oWw89Iw0xPw77HS', 'admin'),
(3, 'user2', '$2y$10$wkHl.jNKxqxopjDMN4bZBeX2bcneKjVvmrNuhSH5oiT9lb0yhHtr2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_terminal_id` (`terminal_id`);

--
-- Indeks untuk tabel `bus_departures`
--
ALTER TABLE `bus_departures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_departures_bus_id_foreign` (`bus_id`),
  ADD KEY `fk_bus_departures_terminal_id` (`terminal_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `bus_departures`
--
ALTER TABLE `bus_departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `fk_terminal_id` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bus_departures`
--
ALTER TABLE `bus_departures`
  ADD CONSTRAINT `bus_departures_bus_id_foreign` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bus_departures_terminal_id` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
