DROP DATABASE IF EXISTS `starwars`;
CREATE DATABASE  IF NOT EXISTS `starwars` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `starwars`;
-- MySQL dump 10.13  Distrib 8.0.43, for macos15 (arm64)
--
-- Host: 127.0.0.1    Database: starwars
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (16,'0001_01_01_000000_create_users_table',1),(17,'0001_01_01_000001_create_cache_table',1),(18,'0001_01_01_000002_create_jobs_table',1),(19,'2025_12_14_214733_create_people_table',1),(20,'2025_12_14_220255_create_movies_table',1),(21,'2025_12_14_221850_create_movie_person_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie_person`
--

DROP TABLE IF EXISTS `movie_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movie_person` (
  `movie_id` bigint unsigned NOT NULL,
  `person_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`movie_id`,`person_id`),
  KEY `movie_person_person_id_foreign` (`person_id`),
  CONSTRAINT `movie_person_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `movie_person_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie_person`
--

LOCK TABLES `movie_person` WRITE;
/*!40000 ALTER TABLE `movie_person` DISABLE KEYS */;
INSERT INTO `movie_person` VALUES (1,1),(2,1),(3,1),(6,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(1,4),(2,4),(3,4),(6,4),(1,5),(2,5),(3,5),(6,5),(1,6),(5,6),(6,6),(1,7),(5,7),(6,7),(1,8),(1,9),(1,10),(2,10),(3,10),(4,10),(5,10),(6,10),(4,11),(5,11),(6,11),(1,12),(6,12),(1,13),(2,13),(3,13),(6,13),(1,14),(2,14),(3,14),(1,15),(1,16),(3,16),(4,16),(1,17),(2,17),(3,17),(1,18),(2,19),(3,19),(4,19),(5,19),(6,19),(2,20),(3,20),(4,20),(5,20),(6,20),(2,21),(3,21),(5,21),(2,22),(2,23),(2,24),(3,24),(2,25),(3,26),(3,27),(3,28),(3,29),(3,30),(4,31),(4,32),(5,32),(6,32),(4,33),(4,34),(5,34),(6,34),(4,35),(5,35),(4,36),(4,37),(4,38),(4,39),(5,39),(4,40),(4,41),(4,42),(5,42),(4,43),(3,44),(4,45),(5,45),(6,45),(4,46),(4,47),(4,48),(4,49),(4,50),(5,50),(6,50),(4,51),(5,51),(6,51),(4,52),(5,52),(6,52),(4,53),(6,53),(4,54),(6,54),(4,55),(6,55),(4,56),(4,57),(5,57),(6,57),(4,58),(5,58),(5,59),(5,60),(5,61),(5,62),(6,62),(5,63),(6,63),(5,64),(5,65),(5,66),(6,66),(5,67),(6,67),(5,68),(5,69),(5,70),(5,71),(5,72),(5,73),(5,74),(6,74),(5,75),(5,76),(5,77),(6,77),(6,78),(6,79),(1,80),(6,80),(5,81),(6,81),(6,82);
/*!40000 ALTER TABLE `movie_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edited` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `episode_id` tinyint unsigned NOT NULL,
  `director` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_crawl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `movies_uid_unique` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,'1','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Gary Kurtz, Rick McCallum','A New Hope',4,'George Lucas','1977-05-25','It is a period of civil war.\r\nRebel spaceships, striking\r\nfrom a hidden base, have won\r\ntheir first victory against\r\nthe evil Galactic Empire.\r\n\r\nDuring the battle, Rebel\r\nspies managed to steal secret\r\nplans to the Empire\'s\r\nultimate weapon, the DEATH\r\nSTAR, an armored space\r\nstation with enough power\r\nto destroy an entire planet.\r\n\r\nPursued by the Empire\'s\r\nsinister agents, Princess\r\nLeia races home aboard her\r\nstarship, custodian of the\r\nstolen plans that can save her\r\npeople and restore\r\nfreedom to the galaxy....','2025-12-15 05:33:35','2025-12-17 08:40:24'),(2,'2','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Gary Kurtz, Rick McCallum','The Empire Strikes Back',5,'Irvin Kershner','1980-05-17','It is a dark time for the\r\nRebellion. Although the Death\r\nStar has been destroyed,\r\nImperial troops have driven the\r\nRebel forces from their hidden\r\nbase and pursued them across\r\nthe galaxy.\r\n\r\nEvading the dreaded Imperial\r\nStarfleet, a group of freedom\r\nfighters led by Luke Skywalker\r\nhas established a new secret\r\nbase on the remote ice world\r\nof Hoth.\r\n\r\nThe evil lord Darth Vader,\r\nobsessed with finding young\r\nSkywalker, has dispatched\r\nthousands of remote probes into\r\nthe far reaches of space....','2025-12-15 05:33:35','2025-12-17 08:40:24'),(3,'3','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Howard G. Kazanjian, George Lucas, Rick McCallum','Return of the Jedi',6,'Richard Marquand','1983-05-25','Luke Skywalker has returned to\r\nhis home planet of Tatooine in\r\nan attempt to rescue his\r\nfriend Han Solo from the\r\nclutches of the vile gangster\r\nJabba the Hutt.\r\n\r\nLittle does Luke know that the\r\nGALACTIC EMPIRE has secretly\r\nbegun construction on a new\r\narmored space station even\r\nmore powerful than the first\r\ndreaded Death Star.\r\n\r\nWhen completed, this ultimate\r\nweapon will spell certain doom\r\nfor the small band of rebels\r\nstruggling to restore freedom\r\nto the galaxy...','2025-12-15 05:33:35','2025-12-17 08:40:24'),(4,'4','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Rick McCallum','The Phantom Menace',1,'George Lucas','1999-05-19','Turmoil has engulfed the\r\nGalactic Republic. The taxation\r\nof trade routes to outlying star\r\nsystems is in dispute.\r\n\r\nHoping to resolve the matter\r\nwith a blockade of deadly\r\nbattleships, the greedy Trade\r\nFederation has stopped all\r\nshipping to the small planet\r\nof Naboo.\r\n\r\nWhile the Congress of the\r\nRepublic endlessly debates\r\nthis alarming chain of events,\r\nthe Supreme Chancellor has\r\nsecretly dispatched two Jedi\r\nKnights, the guardians of\r\npeace and justice in the\r\ngalaxy, to settle the conflict....','2025-12-15 05:33:35','2025-12-17 08:40:24'),(5,'5','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Rick McCallum','Attack of the Clones',2,'George Lucas','2002-05-16','There is unrest in the Galactic\r\nSenate. Several thousand solar\r\nsystems have declared their\r\nintentions to leave the Republic.\r\n\r\nThis separatist movement,\r\nunder the leadership of the\r\nmysterious Count Dooku, has\r\nmade it difficult for the limited\r\nnumber of Jedi Knights to maintain \r\npeace and order in the galaxy.\r\n\r\nSenator Amidala, the former\r\nQueen of Naboo, is returning\r\nto the Galactic Senate to vote\r\non the critical issue of creating\r\nan ARMY OF THE REPUBLIC\r\nto assist the overwhelmed\r\nJedi....','2025-12-15 05:33:35','2025-12-17 08:40:24'),(6,'6','2025-12-16T09:57:22.826Z','2025-12-16T09:57:22.826Z','Rick McCallum','Revenge of the Sith',3,'George Lucas','2005-05-19','War! The Republic is crumbling\r\nunder attacks by the ruthless\r\nSith Lord, Count Dooku.\r\nThere are heroes on both sides.\r\nEvil is everywhere.\r\n\r\nIn a stunning move, the\r\nfiendish droid leader, General\r\nGrievous, has swept into the\r\nRepublic capital and kidnapped\r\nChancellor Palpatine, leader of\r\nthe Galactic Senate.\r\n\r\nAs the Separatist Droid Army\r\nattempts to flee the besieged\r\ncapital with their valuable\r\nhostage, two Jedi Knights lead a\r\ndesperate mission to rescue the\r\ncaptive Chancellor....','2025-12-15 05:33:35','2025-12-17 08:40:24');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
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
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edited` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skin_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hair_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eye_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `people_uid_unique` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'1','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Luke Skywalker','male','fair','blond','172','blue','77','19BBY','2025-12-15 04:17:31','2025-12-15 04:32:56'),(2,'2','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','C-3PO','n/a','gold','n/a','167','yellow','75','112BBY','2025-12-15 04:17:32','2025-12-15 04:32:57'),(3,'3','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','R2-D2','n/a','white, blue','n/a','96','red','32','33BBY','2025-12-15 04:17:33','2025-12-15 04:32:58'),(4,'4','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Darth Vader','male','white','none','202','yellow','136','41.9BBY','2025-12-15 04:17:33','2025-12-15 04:32:59'),(5,'5','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Leia Organa','female','light','brown','150','brown','49','19BBY','2025-12-15 04:17:34','2025-12-15 04:32:59'),(6,'6','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Owen Lars','male','light','brown, grey','178','blue','120','52BBY','2025-12-15 04:17:35','2025-12-15 04:33:00'),(7,'7','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Beru Whitesun lars','female','light','brown','165','blue','75','47BBY','2025-12-15 04:17:36','2025-12-15 04:33:01'),(8,'8','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','R5-D4','n/a','white, red','n/a','97','red','32','unknown','2025-12-15 04:17:36','2025-12-15 04:33:01'),(9,'9','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Biggs Darklighter','male','light','black','183','brown','84','24BBY','2025-12-15 04:17:38','2025-12-15 04:33:02'),(10,'10','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Obi-Wan Kenobi','male','fair','auburn, white','182','blue-gray','77','57BBY','2025-12-15 04:17:38','2025-12-15 04:33:03'),(11,'11','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Anakin Skywalker','male','fair','blond','188','blue','84','41.9BBY','2025-12-15 04:17:41','2025-12-15 04:33:05'),(12,'12','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Wilhuff Tarkin','male','fair','auburn, grey','180','blue','unknown','64BBY','2025-12-15 04:17:43','2025-12-15 04:33:07'),(13,'13','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Chewbacca','male','unknown','brown','228','blue','112','200BBY','2025-12-15 04:17:44','2025-12-15 04:33:08'),(14,'14','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Han Solo','male','fair','brown','180','brown','80','29BBY','2025-12-15 04:17:46','2025-12-15 04:33:10'),(15,'15','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Greedo','male','green','n/a','173','black','74','44BBY','2025-12-15 04:17:47','2025-12-15 04:33:11'),(16,'16','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Jabba Desilijic Tiure','hermaphrodite','green-tan, brown','n/a','175','orange','1,358','600BBY','2025-12-15 04:17:49','2025-12-15 04:33:13'),(17,'18','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Wedge Antilles','male','fair','brown','170','hazel','77','21BBY','2025-12-15 04:17:51','2025-12-15 04:33:14'),(18,'19','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Jek Tono Porkins','male','fair','brown','180','blue','110','unknown','2025-12-15 04:17:53','2025-12-15 04:33:16'),(19,'20','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Yoda','male','green','white','66','brown','17','896BBY','2025-12-15 04:17:54','2025-12-15 04:33:18'),(20,'21','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Palpatine','male','pale','grey','170','yellow','75','82BBY','2025-12-15 04:17:56','2025-12-15 04:33:19'),(21,'22','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Boba Fett','male','fair','black','183','brown','78.2','31.5BBY','2025-12-15 04:18:00','2025-12-15 04:33:23'),(22,'23','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','IG-88','none','metal','none','200','red','140','15BBY','2025-12-15 04:18:02','2025-12-15 04:33:25'),(23,'24','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Bossk','male','green','none','190','red','113','53BBY','2025-12-15 04:18:04','2025-12-15 04:33:28'),(24,'25','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Lando Calrissian','male','dark','black','177','brown','79','31BBY','2025-12-15 04:18:06','2025-12-15 04:33:30'),(25,'26','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Lobot','male','light','none','175','blue','79','37BBY','2025-12-15 04:18:08','2025-12-15 04:33:30'),(26,'27','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ackbar','male','brown mottle','none','180','orange','83','41BBY','2025-12-15 04:18:11','2025-12-15 04:33:31'),(27,'28','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Mon Mothma','female','fair','auburn','150','blue','unknown','48BBY','2025-12-15 04:18:13','2025-12-15 04:33:33'),(28,'29','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Arvel Crynyd','male','fair','brown','unknown','brown','unknown','unknown','2025-12-15 04:18:16','2025-12-15 04:33:36'),(29,'30','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Wicket Systri Warrick','male','brown','brown','88','brown','20','8BBY','2025-12-15 04:18:18','2025-12-15 04:33:36'),(30,'31','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Nien Nunb','male','grey','none','160','black','68','unknown','2025-12-15 04:18:20','2025-12-15 04:33:38'),(31,'32','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Qui-Gon Jinn','male','fair','brown','193','blue','89','92BBY','2025-12-15 04:18:25','2025-12-15 04:33:42'),(32,'33','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Nute Gunray','male','mottled green','none','191','red','90','unknown','2025-12-15 04:18:28','2025-12-15 04:33:44'),(33,'34','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Finis Valorum','male','fair','blond','170','blue','unknown','91BBY','2025-12-15 04:18:30','2025-12-15 04:33:47'),(34,'35','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Padmé Amidala','female','light','brown','185','brown','45','46BBY','2025-12-15 04:18:33','2025-12-15 04:33:50'),(35,'36','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Jar Jar Binks','male','orange','none','196','orange','66','52BBY','2025-12-15 04:18:36','2025-12-15 04:33:52'),(36,'37','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Roos Tarpals','male','grey','none','224','orange','82','unknown','2025-12-15 04:18:38','2025-12-15 04:33:55'),(37,'38','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Rugor Nass','male','green','none','206','orange','unknown','unknown','2025-12-15 04:18:41','2025-12-15 04:33:59'),(38,'39','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ric Olié','male','fair','brown','183','blue','unknown','unknown','2025-12-15 04:18:44','2025-12-15 04:34:02'),(39,'40','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Watto','male','blue, grey','black','137','yellow','unknown','unknown','2025-12-15 04:18:47','2025-12-15 04:34:06'),(40,'41','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Sebulba','male','grey, red','none','112','orange','40','unknown','2025-12-15 04:18:51','2025-12-15 04:34:08'),(41,'42','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Quarsh Panaka','male','dark','black','183','brown','unknown','62BBY','2025-12-15 04:18:57','2025-12-15 04:34:15'),(42,'43','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Shmi Skywalker','female','fair','black','163','brown','unknown','72BBY','2025-12-15 04:18:59','2025-12-15 04:34:18'),(43,'44','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Darth Maul','male','red','none','175','yellow','80','54BBY','2025-12-15 04:19:02','2025-12-15 04:34:19'),(44,'45','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Bib Fortuna','male','pale','none','180','pink','unknown','unknown','2025-12-15 04:19:06','2025-12-15 04:34:22'),(45,'46','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ayla Secura','female','blue','none','178','hazel','55','48BBY','2025-12-15 04:19:09','2025-12-15 04:34:26'),(46,'47','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ratts Tyerel','male','grey, blue','none','79','unknown','15','unknown','2025-12-15 04:19:13','2025-12-15 04:34:28'),(47,'48','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Dud Bolt','male','blue, grey','none','94','yellow','45','unknown','2025-12-15 04:19:17','2025-12-15 04:34:32'),(48,'49','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Gasgano','male','white, blue','none','122','black','unknown','unknown','2025-12-15 04:19:20','2025-12-15 04:34:36'),(49,'50','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ben Quadinaros','male','grey, green, yellow','none','163','orange','65','unknown','2025-12-15 04:19:24','2025-12-15 04:34:39'),(50,'51','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Mace Windu','male','dark','none','188','brown','84','72BBY','2025-12-15 04:19:28','2025-12-15 04:34:43'),(51,'52','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Ki-Adi-Mundi','male','pale','white','198','yellow','82','92BBY','2025-12-15 04:19:36','2025-12-15 04:34:52'),(52,'53','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Kit Fisto','male','green','none','196','black','87','unknown','2025-12-15 04:19:39','2025-12-15 04:34:56'),(53,'54','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Eeth Koth','male','brown','black','171','brown','unknown','unknown','2025-12-15 04:19:44','2025-12-15 04:35:01'),(54,'55','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Adi Gallia','female','dark','none','184','blue','50','unknown','2025-12-15 04:19:48','2025-12-15 04:35:05'),(55,'56','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Saesee Tiin','male','pale','none','188','orange','unknown','unknown','2025-12-15 04:19:53','2025-12-15 04:35:07'),(56,'57','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Yarael Poof','male','white','none','264','yellow','unknown','unknown','2025-12-15 04:19:57','2025-12-15 04:35:12'),(57,'58','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Plo Koon','male','orange','none','188','black','80','22BBY','2025-12-15 04:20:02','2025-12-15 04:35:17'),(58,'59','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Mas Amedda','male','blue','none','196','blue','unknown','unknown','2025-12-15 04:20:07','2025-12-15 04:35:19'),(59,'60','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Gregar Typho','male','dark','black','185','brown','85','unknown','2025-12-15 04:20:11','2025-12-15 04:35:22'),(60,'61','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Cordé','female','light','brown','157','brown','unknown','unknown','2025-12-15 04:20:15','2025-12-15 04:35:24'),(61,'62','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Cliegg Lars','male','fair','brown','183','blue','unknown','82BBY','2025-12-15 04:20:25','2025-12-15 04:35:34'),(62,'63','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Poggle the Lesser','male','green','none','183','yellow','80','unknown','2025-12-15 04:20:28','2025-12-15 04:35:37'),(63,'64','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Luminara Unduli','female','yellow','black','170','blue','56.2','58BBY','2025-12-15 04:20:33','2025-12-15 04:35:40'),(64,'65','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Barriss Offee','female','yellow','black','166','blue','50','40BBY','2025-12-15 04:20:38','2025-12-15 04:35:45'),(65,'66','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Dormé','female','light','brown','165','brown','unknown','unknown','2025-12-15 04:20:44','2025-12-15 04:35:50'),(66,'67','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Dooku','male','fair','white','193','brown','80','102BBY','2025-12-15 04:20:50','2025-12-15 04:35:53'),(67,'68','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Bail Prestor Organa','male','tan','black','191','brown','unknown','67BBY','2025-12-15 04:20:55','2025-12-15 04:35:58'),(68,'69','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Jango Fett','male','tan','black','183','brown','79','66BBY','2025-12-15 04:20:58','2025-12-15 04:36:03'),(69,'70','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Zam Wesell','female','fair, green, yellow','blonde','168','yellow','55','unknown','2025-12-15 04:21:04','2025-12-15 04:36:07'),(70,'71','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Dexter Jettster','male','brown','none','198','yellow','102','unknown','2025-12-15 04:21:10','2025-12-15 04:36:12'),(71,'72','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Lama Su','male','grey','none','229','black','88','unknown','2025-12-15 04:21:19','2025-12-15 04:36:23'),(72,'73','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Taun We','female','grey','none','213','black','unknown','unknown','2025-12-15 04:21:23','2025-12-15 04:36:26'),(73,'74','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Jocasta Nu','female','fair','white','167','blue','unknown','unknown','2025-12-15 04:21:26','2025-12-15 04:36:29'),(74,'75','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','R4-P17','female','silver, red','none','96','red, blue','unknown','unknown','2025-12-15 04:21:30','2025-12-15 04:36:35'),(75,'76','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Wat Tambor','male','green, grey','none','193','unknown','48','unknown','2025-12-15 04:21:36','2025-12-15 04:36:41'),(76,'77','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','San Hill','male','grey','none','191','gold','unknown','unknown','2025-12-15 04:21:42','2025-12-15 04:36:44'),(77,'78','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Shaak Ti','female','red, blue, white','none','178','black','57','unknown','2025-12-15 04:21:46','2025-12-15 04:36:50'),(78,'79','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Grievous','male','brown, white','none','216','green, yellow','159','unknown','2025-12-15 04:21:50','2025-12-15 04:36:54'),(79,'80','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Tarfful','male','brown','brown','234','blue','136','unknown','2025-12-15 04:21:56','2025-12-15 04:37:00'),(80,'81','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Raymus Antilles','male','light','brown','188','brown','79','unknown','2025-12-15 04:22:02','2025-12-15 04:37:03'),(81,'82','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Sly Moore','female','pale','none','178','white','48','unknown','2025-12-15 04:22:15','2025-12-15 04:37:16'),(82,'83','2025-12-14T08:57:56+00:00','2025-12-14T08:57:56+00:00','Tion Medon','male','grey','none','206','black','80','unknown','2025-12-15 04:22:19','2025-12-15 04:37:22');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
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

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-17  1:37:33
