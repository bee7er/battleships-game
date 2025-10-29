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
INSERT INTO `fleet_templates` VALUES (1,1,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(2,2,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(3,2,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(4,3,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(5,3,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(6,4,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(7,4,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(8,4,'2025-10-29 10:51:56','2025-10-29 10:51:56');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_vessel_locations`
--

LOCK TABLES `fleet_vessel_locations` WRITE;
/*!40000 ALTER TABLE `fleet_vessel_locations` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_vessels`
--

LOCK TABLES `fleet_vessels` WRITE;
/*!40000 ALTER TABLE `fleet_vessels` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleets`
--

LOCK TABLES `fleets` WRITE;
/*!40000 ALTER TABLE `fleets` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2025_09_07_000000_create_fleet_templates_table',1),('2025_09_07_000000_create_fleet_vessels_table',1),('2025_09_07_000000_create_fleets_table',1),('2025_09_07_000000_create_vessels_table',1),('2025_09_24_000000_create_games_table',1),('2025_09_24_000000_create_moves_table',1),('2025_10_10_000000_create_fleet_vessel_locations_table',1),('2025_10_11_000000_create_messages_table',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System','system@gmail.com','$2y$10$LZvHKML0IHgv13.IbsKwHulYYo8tOkCoLtZOeq0.NNmn8XfcDJ3dW','rPkYCWheY10a2Gvt',1,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(2,'brian','brian@gmail.com','$2y$10$VwA0N942u3xMJdPOoaD2hu50rD.zpangF6Gs2sWB7t/t7gAAk/2Sy','MVhTCARiswWLwnFh',1,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(3,'phil','phil@gmail.com','$2y$10$NbRiGxlMjwBNmNy9FC6rJO3gOkxt.ZgHZg0AjB9Ch7l/paadVzNKO','lw0tGbekRJlWe9Jq',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(4,'andrew','andrew@gmail.com','$2y$10$DNJBGOpUQ1uEIgKbguLltuuQh3Mw7PkJmC4I9AcM63s0TnIggE4VS','nq7DREoTvoNArbzP',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(5,'greg','greg@gmail.com','$2y$10$lGsnw8oufy9yOKYM1SxSqOB64JRiFjWFmZrRYYaEI7o4vJTzXDraq','0zX1uXUO92MmWENc',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(6,'tim','tim@gmail.com','$2y$10$YVaVj4mKlTtqw7Lq7rK9euRJyioTj5uSNXnHQRqOLHyOgHNZD8Nga','xuSFzF4PiXXL8rAR',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(7,'ben','ben@gmail.com','$2y$10$FthP3kqfCnFrFLd8k5OOyuX1h5Glnw1SPEm3L9Sh8gOutMDl8m6/y','IH9uAm6M3L4t2ef5',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(8,'russ','russ@gmail.com','$2y$10$tjIYuz.P/Xex/8rL7Qa.OeRhT3ER6z4Xt0iiRl4CoKqqbkOKvZ1Jm','wnzxHR5Bx8LRFHG1',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(9,'kika','kika@gmail.com','$2y$10$cUNsJWp4s/CJcw.nbyPG4.Dp/Hv/Xg9wY3b./JhnbFktdKEqPf57.','SaANPvkRn8TVn8nx',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(10,'ayndie','ayndie@gmail.com','$2y$10$duLc06h8ZPLcIlkMLJcweujyDcE1QjWHpfvCzaxOgD8yPyl7QSgLS','XHdWHR0ycAKkO3t8',0,NULL,0,0,0,'2025-10-29 10:51:56','2025-10-29 10:51:56');
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
INSERT INTO `vessels` VALUES (1,'battleship',3,5,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(2,'destroyer',2,4,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(3,'submarine',2,4,'2025-10-29 10:51:56','2025-10-29 10:51:56'),(4,'zodiac',1,3,'2025-10-29 10:51:56','2025-10-29 10:51:56');
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

-- Dump completed on 2025-10-29 10:52:02
