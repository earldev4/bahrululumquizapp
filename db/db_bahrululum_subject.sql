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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'Pendidikan Agama Islam','Mata pelajaran ini membimbing siswa memahami ajaran Islam, meliputi akidah, ibadah, akhlak, dan sejarah Islam. Siswa diajarkan nilai-nilai keislaman untuk diterapkan dalam kehidupan sehari-hari sesuai dengan tuntunan Al-Qur\'an dan Hadis.'),(2,'Matematika','Matematika mengembangkan kemampuan logika, analisis, dan pemecahan masalah. Siswa belajar konsep bilangan, aljabar, geometri, statistik, serta penerapannya dalam kehidupan sehari-hari dan bidang sains.'),(3,'Bahasa Indonesia','Mata pelajaran ini bertujuan untuk mengembangkan kemampuan berbahasa yang meliputi keterampilan membaca, menulis, berbicara, dan mendengarkan. Siswa diajarkan memahami, menganalisis, serta menghasilkan teks dengan ragam genre dan konteks budaya Indonesia.'),(4,'Bahasa Inggris','Bahasa Inggris berfokus pada penguasaan kemampuan berkomunikasi dalam bahasa internasional ini, mencakup keterampilan berbicara, mendengarkan, membaca, dan menulis. Pembelajaran juga meliputi pemahaman budaya negara-negara berbahasa Inggris.'),(5,'IPA','Mata pelajaran ini mencakup pembelajaran tentang fenomena alam, meliputi biologi, fisika, dan kimia. IPA bertujuan mengasah kemampuan observasi, eksperimen, dan analisis ilmiah terhadap lingkungan sekitar.'),(6,'IPS','IPS mempelajari interaksi manusia dengan lingkungan sosial, sejarah, ekonomi, dan geografi. Mata pelajaran ini membantu siswa memahami dinamika masyarakat, hubungan antarindividu, serta pengelolaan sumber daya.');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-17 14:38:04
