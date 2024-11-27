-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 02:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bahrululum`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_users`
--

CREATE TABLE `akun_users` (
  `user_nis` char(10) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_users`
--

INSERT INTO `akun_users` (`user_nis`, `username`, `password`, `created_at`, `role`) VALUES
('199785', 'zovi', 'zovi123', '2024-11-23 15:06:52', 'user'),
('199946', 'Ridho', 'ridho123', '2024-11-21 17:01:08', 'user'),
('admin', 'admin', 'admin', '2024-11-23 13:45:38', 'admin'),
('XX', 'Fulan', '12345', '2024-11-16 19:20:11', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id_question` int(10) UNSIGNED NOT NULL,
  `id_quiz` int(10) UNSIGNED NOT NULL,
  `image_soal` varchar(255) DEFAULT NULL,
  `question_text` longtext NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id_question`, `id_quiz`, `image_soal`, `question_text`, `options`, `created_at`) VALUES
(22, 5, NULL, '<div style=\"line-height: 19px;\">Perhatikan kelompok besaran berikut!</div><div style=\"line-height: 19px;\"><br></div><div style=\"line-height: 19px;\">(1) Panjang</div><div style=\"line-height: 30px;\">(2) Kecepatan</div><div style=\"line-height: 19px;\">(3) Massa</div><div style=\"line-height: 30px;\">(4) Volume</div><div style=\"line-height: 19px;\">(5) Kuat Arus</div><div style=\"line-height: 19px;\"><br></div><div style=\"line-height: 30px;\">Yang termasuk kelompok besaran pokok adalah ...</div>', '{\"options\":{\"a\":\"1, 2, dan 4\",\"b\":\"1, 3, dan 5\",\"c\":\"2, 3, dan 5\",\"d\":\"3, 4, dan 5\"},\"answer\":\"b\"}', '2024-11-24 22:47:13'),
(23, 5, NULL, '<div style=\"line-height: 19px;\">Yang termasuk kelompok besaran pokok adalah ...</div>', '{\"options\":{\"a\":\"Panjang, massa, tekanan\",\"b\":\"Massa, suhu, kuat arus\",\"c\":\"Panjang, waktu, daya\",\"d\":\"Waktu, suhu, percepatan\"},\"answer\":\"b\"}', '2024-11-24 22:47:41'),
(24, 5, NULL, '<div style=\"line-height: 19px;\">Satuan kuat arus listrik dalam SI (Satuan Internasional) adalah ...</div>', '{\"options\":{\"a\":\"Ampere\",\"b\":\"Volt\",\"c\":\"Coulomb\",\"d\":\"Ohm\"},\"answer\":\"a\"}', '2024-11-24 23:29:19'),
(25, 5, NULL, '<div style=\"line-height: 19px;\">Besaran di bawah ini yang termasuk besaran pokok adalah  ...</div>', '{\"options\":{\"a\":\"Panjang, massa, waktu\",\"b\":\"Panjang, massa, kecepatan\",\"c\":\"Panjang, luas, volume\",\"d\":\"Panjang, gaya, berat\"},\"answer\":\"a\"}', '2024-11-24 23:43:36'),
(26, 5, NULL, '<div style=\"line-height: 19px;\">Sebuah kubus kayu memiliki volume 5 cm3. Jika massa jenis kayu 250 g/cm3, massa kayu tersebut adalah ...</div>', '{\"options\":{\"a\":\"1.250 gram\",\"b\":\"50 gram\",\"c\":\"10 gram\",\"d\":\"2 gram\"},\"answer\":\"a\"}', '2024-11-25 10:42:33'),
(27, 5, NULL, '<div style=\"line-height: 19px;\">Suatu logam alumunium mempunyai massa 120 gram dan volume 60 cm3, maka massa jenisnya adalah ....</div>', '{\"options\":{\"a\":\"2 g\\/cm3\",\"b\":\"20 g\\/cm3\",\"c\":\"200 g\\/cm3\",\"d\":\"2.000 g\\/cm3\"},\"answer\":\"a\"}', '2024-11-25 10:43:23'),
(28, 5, '743847562-img1.png', '<div style=\"line-height: 30px;\">Perhatikan gambar pengukuran dengan menggunakan alat dan bahan diatas! Jika massa benda 300 gram, massa jenis benda tersebut adalah ...</div>', '{\"options\":{\"a\":\"3,0 g\\/cm3\",\"b\":\"7,5 g\\/cm3\",\"c\":\"15 g\\/cm3\",\"d\":\"320 g\\/cm3\"},\"answer\":\"c\"}', '2024-11-25 10:45:13'),
(29, 5, NULL, '<div style=\"line-height: 30px;\">Tembaga bermassa 2 kg dengan suhu 30°C menerima kalor sebesar 39.000 J. Jika kalor jenis tembaga 390 J/kg °C, suhu akhir dari tembaga adalah ....</div>', '{\"options\":{\"a\":\"80\\u00b0C\",\"b\":\"50\\u00b0C\",\"c\":\"30\\u00b0C\",\"d\":\"20\\u00b0C\"},\"answer\":\"a\"}', '2024-11-25 10:46:47'),
(30, 5, '1752638991-img2.png', '<div style=\"line-height: 19px;\">Jika massa balok tersebut 200 gram, masa jenisnya adalah ... g/cm3</div>', '{\"options\":{\"a\":\"40\",\"b\":\"20\",\"c\":\"10\",\"d\":\"5\"},\"answer\":\"d\"}', '2024-11-25 10:47:42'),
(31, 5, NULL, '<div style=\"line-height: 19px;\">Pemuaian zat cair lebih besar dari zat padat. Pernyataan ini dapat menunjukkan peristiwa ....</div>', '{\"options\":{\"a\":\"Penguapan air laut oleh panas matahari\",\"b\":\"Es yang berada dalam gelas berisi penuh air ternyata es mencair seluruhnya tidak ada yang tumpah\",\"c\":\"Gelas yang berisi es, ternyata permukaan luar gelas basah\",\"d\":\"Panci yang berisi air penuh, ternyata airnya dapat tumpah ketika sedang mendidih\"},\"answer\":\"d\"}', '2024-11-25 10:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `quiz_time` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'private',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `subject_id`, `title`, `quiz_time`, `status`, `created_at`) VALUES
(1, 1, 'Latihan-1 Tajwid', 180, 'private', '2024-11-17 13:04:47'),
(2, 2, 'Latihan-1 Aljabar', 180, 'private', '2024-11-17 13:04:47'),
(3, 3, 'Latihan-1 Puisi', 15, 'private', '2024-11-17 13:04:47'),
(4, 4, 'Latihan-1 Past Tense', 180, 'private', '2024-11-17 13:04:47'),
(5, 5, 'Latihan-1 IPA', 300, 'publish', '2024-11-17 13:04:47'),
(6, 6, 'Latihan-1 G30S PKI', 180, 'private', '2024-11-17 13:04:47'),
(14, 3, 'Latihan-2 Teks Prosedur', 180, 'private', '2024-11-22 15:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_score`
--

CREATE TABLE `quiz_score` (
  `id_score` int(10) UNSIGNED NOT NULL,
  `user_nis` char(10) NOT NULL,
  `id_quiz` int(10) UNSIGNED NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `completed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(10) UNSIGNED NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `subject_name` varchar(45) NOT NULL,
  `subject_desc` text NOT NULL,
  `music` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `thumbnail`, `subject_name`, `subject_desc`, `music`) VALUES
(1, '487524825-Pendidikan Agama Islam.png', 'Pendidikan Agama Islam', 'Mata pelajaran ini membimbing siswa memahami ajaran Islam, meliputi akidah, ibadah, akhlak, dan sejarah Islam. Siswa diajarkan nilai-nilai keislaman untuk diterapkan dalam kehidupan sehari-hari sesuai dengan tuntunan Al-Qur\'an dan Hadis.', '1905600440-BGSPAI.mp3'),
(2, '647129532-Matematika.png', 'Matematika', 'Matematika mengembangkan kemampuan logika, analisis, dan pemecahan masalah. Siswa belajar konsep bilangan, aljabar, geometri, statistik, serta penerapannya dalam kehidupan sehari-hari dan bidang sains.', 'BGSMTK.mp3'),
(3, 'Bahasa Indonesia.png', 'Bahasa Indonesia', 'Mata pelajaran ini bertujuan untuk mengembangkan kemampuan berbahasa yang meliputi keterampilan membaca, menulis, berbicara, dan mendengarkan. Siswa diajarkan memahami, menganalisis, serta menghasilkan teks dengan ragam genre dan konteks budaya Indonesia.', 'BGSBIND.mp3'),
(4, 'Bahasa Inggris.png', 'Bahasa Inggris', 'Bahasa Inggris berfokus pada penguasaan kemampuan berkomunikasi dalam bahasa internasional ini, mencakup keterampilan berbicara, mendengarkan, membaca, dan menulis. Pembelajaran juga meliputi pemahaman budaya negara-negara berbahasa Inggris.', 'BGSBING.mp3'),
(5, 'IPA.png', 'IPA', 'Mata pelajaran ini mencakup pembelajaran tentang fenomena alam, meliputi biologi, fisika, dan kimia. IPA bertujuan mengasah kemampuan observasi, eksperimen, dan analisis ilmiah terhadap lingkungan sekitar.', 'BGSIPA.mp3'),
(6, 'IPS.png', 'IPS', 'IPS mempelajari interaksi manusia dengan lingkungan sosial, sejarah, ekonomi, dan geografi. Mata pelajaran ini membantu siswa memahami dinamika masyarakat, hubungan antarindividu, serta pengelolaan sumber daya.', 'BGSIPS.mp3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_users`
--
ALTER TABLE `akun_users`
  ADD PRIMARY KEY (`user_nis`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_quiz_idx` (`id_quiz`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `subject_id_idx` (`subject_id`);

--
-- Indexes for table `quiz_score`
--
ALTER TABLE `quiz_score`
  ADD PRIMARY KEY (`id_score`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_name_UNIQUE` (`subject_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_score`
--
ALTER TABLE `quiz_score`
  MODIFY `id_score` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_score`
--
ALTER TABLE `quiz_score`
  ADD CONSTRAINT `fk_quiz_score_user_nis` FOREIGN KEY (`user_nis`) REFERENCES `akun_users` (`user_nis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
