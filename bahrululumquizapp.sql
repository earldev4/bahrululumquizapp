-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: db_bahrululum
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akun_admins`
--

DROP TABLE IF EXISTS `akun_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_admins` (
  `id` int unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun_admins`
--

LOCK TABLES `akun_admins` WRITE;
/*!40000 ALTER TABLE `akun_admins` DISABLE KEYS */;
INSERT INTO `akun_admins` VALUES (1,'admin','admin12345');
/*!40000 ALTER TABLE `akun_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `akun_users`
--

DROP TABLE IF EXISTS `akun_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_users` (
  `user_nis` char(10) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_nis`),
  UNIQUE KEY `user_nis_UNIQUE` (`user_nis`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun_users`
--

LOCK TABLES `akun_users` WRITE;
/*!40000 ALTER TABLE `akun_users` DISABLE KEYS */;
INSERT INTO `akun_users` VALUES ('XNXX','Anjing','anjing','2024-11-17 16:31:35'),('XY','Fulanu','fulanu','2024-11-17 16:00:14');
/*!40000 ALTER TABLE `akun_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id_option` int unsigned NOT NULL,
  `id_question` int unsigned NOT NULL,
  `option_text` varchar(45) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_option`),
  KEY `id_question_idx` (`id_question`),
  CONSTRAINT `id_question` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id_question` int unsigned NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  `question_text` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_question`),
  KEY `id_quiz_idx` (`id_quiz`),
  CONSTRAINT `id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz` (
  `id_quiz` int unsigned NOT NULL,
  `subject_id` int unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_quiz`),
  KEY `subject_id_idx` (`subject_id`),
  CONSTRAINT `subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
INSERT INTO `quiz` VALUES (1,1,'Latihan-1','2024-11-17 13:04:47'),(2,2,'Latihan-1','2024-11-17 13:04:47'),(3,3,'Latihan-1','2024-11-17 13:04:47'),(4,4,'Latihan-1','2024-11-17 13:04:47'),(5,5,'Latihan-1','2024-11-17 13:04:47'),(6,6,'Latihan-1','2024-11-17 13:04:47');
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_score`
--

DROP TABLE IF EXISTS `quiz_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_score` (
  `id_score` int unsigned NOT NULL,
  `user_nis` char(10) NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  `score` int unsigned NOT NULL,
  `completed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_score`),
  UNIQUE KEY `user_nis_UNIQUE` (`user_nis`),
  KEY `id_quiz_idx` (`id_quiz`),
  CONSTRAINT `fk_quiz_score_id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_quiz_score_user_nis` FOREIGN KEY (`user_nis`) REFERENCES `akun_users` (`user_nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_score`
--

LOCK TABLES `quiz_score` WRITE;
/*!40000 ALTER TABLE `quiz_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ranking`
--

DROP TABLE IF EXISTS `ranking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ranking` (
  `id_ranking` int unsigned NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  `user_nis` char(10) NOT NULL,
  `rank` int unsigned NOT NULL,
  `id_score` int unsigned NOT NULL,
  PRIMARY KEY (`id_ranking`),
  UNIQUE KEY `user_nis_UNIQUE` (`user_nis`),
  KEY `fk_ranking_id_score_idx` (`id_score`),
  KEY `fk_ranking_id_quiz_idx` (`id_quiz`),
  CONSTRAINT `fk_ranking_id_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ranking_id_score` FOREIGN KEY (`id_score`) REFERENCES `quiz_score` (`id_score`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ranking_user_nis` FOREIGN KEY (`user_nis`) REFERENCES `akun_users` (`user_nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ranking`
--

LOCK TABLES `ranking` WRITE;
/*!40000 ALTER TABLE `ranking` DISABLE KEYS */;
/*!40000 ALTER TABLE `ranking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id_session` int unsigned NOT NULL,
  `user_nis` char(10) NOT NULL,
  `is_active` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_session`),
  UNIQUE KEY `user_nis_UNIQUE` (`user_nis`),
  CONSTRAINT `user_nis` FOREIGN KEY (`user_nis`) REFERENCES `akun_users` (`user_nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `subject_id` int unsigned NOT NULL,
  `subject_name` varchar(45) NOT NULL,
  `subject_desc` text NOT NULL,
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `subject_name_UNIQUE` (`subject_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'Pendidikan Agama Islam','Mata pelajaran ini membimbing siswa memahami ajaran Islam, meliputi akidah, ibadah, akhlak, dan sejarah Islam. Siswa diajarkan nilai-nilai keislaman untuk diterapkan dalam kehidupan sehari-hari sesuai dengan tuntunan Al-Qur\'an dan Hadis.'),(2,'Matematika','Matematika mengembangkan kemampuan logika, analisis, dan pemecahan masalah. Siswa belajar konsep bilangan, aljabar, geometri, statistik, serta penerapannya dalam kehidupan sehari-hari dan bidang sains.'),(3,'Bahasa Indonesia','Mata pelajaran ini bertujuan untuk mengembangkan kemampuan berbahasa yang meliputi keterampilan membaca, menulis, berbicara, dan mendengarkan. Siswa diajarkan memahami, menganalisis, serta menghasilkan teks dengan ragam genre dan konteks budaya Indonesia.'),(4,'Bahasa Inggris','Bahasa Inggris berfokus pada penguasaan kemampuan berkomunikasi dalam bahasa internasional ini, mencakup keterampilan berbicara, mendengarkan, membaca, dan menulis. Pembelajaran juga meliputi pemahaman budaya negara-negara berbahasa Inggris.'),(5,'IPA','Mata pelajaran ini mencakup pembelajaran tentang fenomena alam, meliputi biologi, fisika, dan kimia. IPA bertujuan mengasah kemampuan observasi, eksperimen, dan analisis ilmiah terhadap lingkungan sekitar.'),(6,'IPS','IPS mempelajari interaksi manusia dengan lingkungan sosial, sejarah, ekonomi, dan geografi. Mata pelajaran ini membantu siswa memahami dinamika masyarakat, hubungan antarindividu, serta pengelolaan sumber daya.');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_answer`
--

DROP TABLE IF EXISTS `user_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_answer` (
  `id_answer` int unsigned NOT NULL,
  `user_nis` char(10) NOT NULL,
  `id_quiz` int unsigned NOT NULL,
  `id_question` int unsigned NOT NULL,
  `id_option` int unsigned NOT NULL,
  `answered_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_answer`),
  UNIQUE KEY `user_nis_UNIQUE` (`user_nis`),
  KEY `id_quiz_idx` (`id_quiz`),
  KEY `id_question_idx` (`id_question`),
  KEY `id_option_idx` (`id_option`),
  CONSTRAINT `fk_user_answer_option` FOREIGN KEY (`id_option`) REFERENCES `options` (`id_option`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_answer_question` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_answer_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_answer_user_nis` FOREIGN KEY (`user_nis`) REFERENCES `akun_users` (`user_nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_answer`
--

LOCK TABLES `user_answer` WRITE;
/*!40000 ALTER TABLE `user_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_answer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-17 16:35:56
