-- MySQL dump 10.13  Distrib 8.4.5, for macos14.7 (x86_64)
--
-- Host: localhost    Database: battle_db
-- ------------------------------------------------------
-- Server version	8.4.5

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
-- Table structure for table `fleet_templates`
--

DROP TABLE IF EXISTS `fleet_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fleet_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `vessel_id` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_templates`
--

LOCK TABLES `fleet_templates` WRITE;
/*!40000 ALTER TABLE `fleet_templates` DISABLE KEYS */;
INSERT INTO `fleet_templates` VALUES (1,1,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,2,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,2,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(4,3,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(5,3,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(6,4,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(7,4,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(8,4,'2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `fleet_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fleet_vessel_locations`
--

DROP TABLE IF EXISTS `fleet_vessel_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fleet_vessel_locations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fleet_vessel_id` int unsigned NOT NULL,
  `move_id` int unsigned NOT NULL,
  `row` tinyint unsigned NOT NULL,
  `col` tinyint unsigned NOT NULL,
  `status` enum('normal','hit','destroyed') COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_vessel_locations`
--

LOCK TABLES `fleet_vessel_locations` WRITE;
/*!40000 ALTER TABLE `fleet_vessel_locations` DISABLE KEYS */;
INSERT INTO `fleet_vessel_locations` VALUES (1,16,0,4,5,'normal','2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `fleet_vessel_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fleet_vessels`
--

DROP TABLE IF EXISTS `fleet_vessels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fleet_vessels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fleet_id` int unsigned NOT NULL,
  `vessel_id` int unsigned NOT NULL,
  `status` enum('available','started','plotted') COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_vessels`
--

LOCK TABLES `fleet_vessels` WRITE;
/*!40000 ALTER TABLE `fleet_vessels` DISABLE KEYS */;
INSERT INTO `fleet_vessels` VALUES (1,1,1,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,2,1,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,3,1,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(4,1,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(5,2,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(6,3,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(7,1,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(8,2,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(9,3,2,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(10,1,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(11,2,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(12,3,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(13,1,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(14,2,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(15,3,3,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(16,1,4,'plotted','2025-11-02 15:28:05','2025-11-02 15:28:05'),(17,2,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(18,3,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(19,1,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(20,2,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(21,3,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(22,1,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(23,2,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05'),(24,3,4,'available','2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `fleet_vessels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fleets`
--

DROP TABLE IF EXISTS `fleets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fleets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `game_id` int unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleets`
--

LOCK TABLES `fleets` WRITE;
/*!40000 ALTER TABLE `fleets` DISABLE KEYS */;
INSERT INTO `fleets` VALUES (1,2,1,'dreadnought','2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,8,2,'victory','2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,3,3,'my favourite fleet','2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `fleets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('edit','waiting','ready','engaged','completed','deleted') COLLATE utf8mb3_unicode_ci NOT NULL,
  `protagonist_id` int unsigned NOT NULL,
  `opponent_id` int unsigned NOT NULL,
  `winner_id` int unsigned NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `games_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'1st naval battle','edit',2,8,0,NULL,NULL,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,'2nd naval battle','edit',8,2,0,NULL,NULL,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,'3rd naval battle','edit',3,8,0,NULL,NULL,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_texts`
--

DROP TABLE IF EXISTS `message_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_texts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` enum('specific','broadcast') COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('ready','sent') COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_texts`
--

LOCK TABLES `message_texts` WRITE;
/*!40000 ALTER TABLE `message_texts` DISABLE KEYS */;
INSERT INTO `message_texts` VALUES (1,'Invite player','Hi %s, will you play \'%s\' with me? %s','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,'Accept invitation','Hi %s, I will love playing \'%s\' with you. %s','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,'Game ready','Hi %s and %s, I\'m happy to say that \'%s\' is ready to play. System','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(4,'Waiting','Hi %s, %s is waiting for you to finish plotting your fleet in the \'%s\' game. System','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(5,'Winner','Hi %s, you won the \'%s\' game.  Well done. %s','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(6,'Loser','Hi %s, sadly you lost the \'%s\' game.  Try again later. %s','specific','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(7,'Another go for hit','Hi %s, just to let you know, you now get another go after a successful hit. System','broadcast','ready','2025-11-02 15:28:05','2025-11-02 15:28:05'),(8,'Volume level can be set','Hi %s, there is now a range of volumes to which the sound can be set. System','broadcast','ready','2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `message_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `message_text` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('open','read') COLLATE utf8mb3_unicode_ci NOT NULL,
  `sending_user_id` int unsigned NOT NULL,
  `receiving_user_id` int unsigned NOT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Hi ben, will you play \'1st naval battle\' with me? brian','open',2,8,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,'Hi brian, will you play \'2nd naval battle\' with me? ben','open',8,2,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,'Hi ben, will you play \'3rd naval battle\' with me? steve','open',3,8,NULL,'2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2025_09_07_000000_create_fleet_templates_table',1),('2025_09_07_000000_create_fleet_vessels_table',1),('2025_09_07_000000_create_fleets_table',1),('2025_09_07_000000_create_vessels_table',1),('2025_09_24_000000_create_games_table',1),('2025_09_24_000000_create_moves_table',1),('2025_10_10_000000_create_fleet_vessel_locations_table',1),('2025_10_11_000000_create_messages_table',1),('2025_11_01_000000_create_message_texts_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moves`
--

DROP TABLE IF EXISTS `moves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `moves` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int unsigned NOT NULL,
  `player_id` int unsigned NOT NULL,
  `row` int unsigned NOT NULL,
  `col` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moves`
--

LOCK TABLES `moves` WRITE;
/*!40000 ALTER TABLE `moves` DISABLE KEYS */;
/*!40000 ALTER TABLE `moves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_token` varchar(16) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `games_played` int unsigned NOT NULL DEFAULT '0',
  `vessels_destroyed` int unsigned NOT NULL DEFAULT '0',
  `points_scored` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_user_token_unique` (`user_token`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System','system@gmail.com','$2y$10$Pibyk2r/UchzCjjPddDkKu0vULpDb8vUpdoXib.DfXQ8IUZCJtSWy','ReYwbf251LktVuTY',1,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,'brian','brian@gmail.com','$2y$10$42ThAsyG41/q/RsjYzFwbuWjz30tRv8jV3.qG0vyiFKstHkZiu1si','xhpQIQLIh9xTNjHJ',1,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,'steve','steve@gmail.com','$2y$10$4TKrQANHJa8JbsBa7ij/euf9TyQb9k0m3SWr6inGyKVxEbhDblKG.','CDHKX6xUc3vKzkPM',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(4,'phil','phil@gmail.com','$2y$10$DUPv6ywwkRQyW1wUmMbEj.YqoRNncrx1YeVVEuf9/qMjvoCQ92yeq','OsFlm0EuaNqQU0fS',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(5,'andrew','andrew@gmail.com','$2y$10$qu/DaocG//.9aSmWfBqZh.Xr5ywmpictuqqDpaT/49oxVgWW.5qyW','t4tGNQN0JTSDhfSD',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(6,'greg','greg@gmail.com','$2y$10$qUHC53GXfFfT/dmhxKHU9uLODfqpk0EhxinuG2TK3fSUVBhMQ14Gq','KcTZZd4sd7vUutkp',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(7,'tim','tim@gmail.com','$2y$10$Z5vNA8BrJEOzc3y3LlYAWuNzdQB6ufYqIWkCx6kZCpOB/UsdaFrS6','EpR0qtzXD97u5GAG',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(8,'ben','ben@gmail.com','$2y$10$yc3nMazrPQHVriir/fkCPuMtVEKAeVSxnKlSRFAyXRgKnjUpYwwjC','oSrHYTWfVd8kAU2H',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(9,'russ','russ@gmail.com','$2y$10$xdYMGw2Oyl4GxTrUgLE8NutXeKB6raPBltjUlMFmM/H3JYLW89nka','6BNZ79NUHYO383eN',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(10,'kika','kika@gmail.com','$2y$10$.SfdEek2jeeagsOrKBkxZOKUs66QbPNkZ331x6iLpjZWQE3lJiO7u','N1mXe3FOCz5Z7vUn',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(11,'ayndie','ayndie@gmail.com','$2y$10$FVk1M7B29cDUZlRBhyMlYu06csw6hOjNRIva5ygb5YisfOSnP/yHe','mrbkxHOqETb3hHDf',0,NULL,0,0,0,'2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vessels`
--

DROP TABLE IF EXISTS `vessels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vessels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` enum('battleship','destroyer','submarine','zodiac') COLLATE utf8mb3_unicode_ci NOT NULL,
  `length` int unsigned NOT NULL,
  `points` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vessels`
--

LOCK TABLES `vessels` WRITE;
/*!40000 ALTER TABLE `vessels` DISABLE KEYS */;
INSERT INTO `vessels` VALUES (1,'battleship',3,5,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(2,'destroyer',2,4,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(3,'submarine',2,4,'2025-11-02 15:28:05','2025-11-02 15:28:05'),(4,'zodiac',1,3,'2025-11-02 15:28:05','2025-11-02 15:28:05');
/*!40000 ALTER TABLE `vessels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-02 15:28:40
