-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: sipus_del
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bukus`
--

DROP TABLE IF EXISTS `bukus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bukus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_terbit` smallint unsigned NOT NULL,
  `kategori_id` bigint unsigned NOT NULL,
  `stok` int unsigned NOT NULL DEFAULT '0',
  `sinopsis` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bukus_isbn_unique` (`isbn`),
  KEY `bukus_kategori_id_foreign` (`kategori_id`),
  KEY `bukus_judul_index` (`judul`),
  CONSTRAINT `bukus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bukus`
--

LOCK TABLES `bukus` WRITE;
/*!40000 ALTER TABLE `bukus` DISABLE KEYS */;
INSERT INTO `bukus` VALUES (1,'9780808425663','Clean Code','Robert C. Martin','Prentice Hall',2008,1,13,'Panduan menulis kode yang bersih, mudah dibaca, dan mudah dirawat, lengkap dengan contoh refactoring.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(2,'9786269333127','Introduction to Algorithms','Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein','MIT Press',2022,1,1,'Referensi lengkap algoritma dan struktur data beserta analisis kompleksitasnya.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(3,'9785117777106','The Pragmatic Programmer','David Thomas, Andrew Hunt','Addison-Wesley',2019,1,4,'Kumpulan praktik dan cara berpikir pengembang perangkat lunak profesional.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(4,'9797996379920','Operating System Concepts','Abraham Silberschatz, Peter B. Galvin, Greg Gagne','Wiley',2018,1,5,'Pembahasan konsep sistem operasi: proses, memori, penyimpanan, dan keamanan.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(5,'9780859702799','Computer Networking: A Top-Down Approach','James F. Kurose, Keith W. Ross','Pearson',2021,1,2,'Pengantar jaringan komputer dengan pendekatan top-down mulai dari lapisan aplikasi.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(6,'9798887325750','Cryptography and Network Security','William Stallings','Pearson',2017,1,9,'Prinsip dan praktik kriptografi serta keamanan jaringan, termasuk teori bilangan dan finite field.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(7,'9798900402741','Artificial Intelligence: A Modern Approach','Stuart Russell, Peter Norvig','Pearson',2020,1,1,'Buku acuan kecerdasan buatan: pencarian, constraint satisfaction, logika, dan pembelajaran mesin.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(8,'9783585821284','Laravel: Up & Running','Matt Stauffer','O\'Reilly Media',2019,1,14,'Panduan membangun aplikasi web dengan Laravel: routing, Eloquent, Blade, dan validasi.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(9,'9791900478792','Software Engineering','Ian Sommerville','Pearson',2015,1,2,'Dasar rekayasa perangkat lunak: proses pengembangan, kebutuhan, desain, dan pengujian.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(10,'9793402374381','Database System Concepts','Abraham Silberschatz, Henry F. Korth, S. Sudarshan','McGraw-Hill',2019,2,2,'Konsep basis data relasional, SQL, desain skema, transaksi, dan optimasi kueri.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(11,'9783053993451','Fundamentals of Database Systems','Ramez Elmasri, Shamkant B. Navathe','Pearson',2016,2,12,'Landasan sistem basis data: model ER, normalisasi, SQL, dan arsitektur DBMS.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(12,'9797384118063','Systems Analysis and Design','Kenneth E. Kendall, Julie E. Kendall','Pearson',2019,2,11,'Metode analisis dan perancangan sistem informasi, dari kebutuhan pengguna hingga implementasi.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(13,'9785503118476','Management Information Systems','Kenneth C. Laudon, Jane P. Laudon','Pearson',2020,2,11,'Peran sistem informasi dalam organisasi modern dan pengambilan keputusan bisnis.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(14,'9799710014469','Don\'t Make Me Think, Revisited','Steve Krug','New Riders',2014,2,5,'Prinsip usability dan desain web yang intuitif, dibahas ringkas dan praktis.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(15,'9799978401711','Introduction to Linear Algebra','Gilbert Strang','Wellesley-Cambridge Press',2016,3,13,'Pengantar aljabar linier: vektor, matriks, ruang vektor, eigenvalue, dan aplikasinya.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(16,'9782864348313','Probability & Statistics for Engineers & Scientists','Ronald E. Walpole, Raymond H. Myers, Sharon L. Myers, Keying Ye','Pearson',2012,3,13,'Probabilitas dan statistika untuk mahasiswa teknik dan sains, dengan banyak contoh soal.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(17,'9799530837743','Discrete Mathematics and Its Applications','Kenneth H. Rosen','McGraw-Hill',2018,3,7,'Matematika diskrit: logika, himpunan, graf, kombinatorika, dan teori bilangan.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(18,'9781715617820','A Guide to the Project Management Body of Knowledge (PMBOK Guide)','Project Management Institute','PMI',2021,4,1,'Standar dan panduan manajemen proyek: prinsip, domain kinerja, dan praktik terbaik.','2026-10-11 18:42:00','2026-10-11 18:42:00'),(19,'9781968132972','Principles of Marketing','Philip Kotler, Gary Armstrong','Pearson',2020,4,15,'Dasar-dasar pemasaran: segmentasi, penentuan target, bauran pemasaran, dan perilaku konsumen.','2026-10-11 18:42:00','2026-10-11 18:42:00');
/*!40000 ALTER TABLE `bukus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategoris_kode_kategori_unique` (`kode_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
INSERT INTO `kategoris` VALUES (1,'INF','Informatika & Komputer','2026-10-11 18:42:00','2026-10-11 18:42:00'),(2,'SIS','Sistem Informasi','2026-10-11 18:42:00','2026-10-11 18:42:00'),(3,'MAT','Matematika & Statistika','2026-10-11 18:42:00','2026-10-11 18:42:00'),(4,'MNJ','Manajemen & Bisnis','2026-10-11 18:42:00','2026-10-11 18:42:00'),(5,'UMM','Referensi Umum','2026-10-11 18:42:00','2026-10-11 18:42:00');
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_08_153804_create_kategoris_table',1),(5,'2026_10_08_153814_create_bukus_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-12  8:42:06
