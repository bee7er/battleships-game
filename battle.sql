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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet_templates`
--

LOCK TABLES `fleet_templates` WRITE;
/*!40000 ALTER TABLE `fleet_templates` DISABLE KEYS */;
INSERT INTO `fleet_templates` VALUES (1,1,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(2,1,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(3,2,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(4,2,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(5,2,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(6,3,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(7,3,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(8,4,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(9,4,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(10,4,'2025-11-11 17:31:15','2025-11-11 17:31:15');
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
  `status` enum('available','started','plotted','hit','destroyed') COLLATE utf8mb3_unicode_ci NOT NULL,
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
  `status` enum('edit','waiting','ready','engaged','completed','deleted','undeleted') COLLATE utf8mb3_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_texts`
--

LOCK TABLES `message_texts` WRITE;
/*!40000 ALTER TABLE `message_texts` DISABLE KEYS */;
INSERT INTO `message_texts` VALUES (1,'Invite owner','Hi %s, a game has been created for you by the system called \'%s\' against opponent \'%s\'. System','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(2,'Invite player','Hi %s, will you play \'%s\' with me? %s','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(3,'Accept invitation','Hi %s, I will love playing \'%s\' with you. %s','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(4,'Game ready','Hi %s and %s, I\'m happy to say that \'%s\' is ready to play. System','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(5,'Waiting','Hi %s, %s is waiting for you to finish plotting your fleet in the \'%s\' game. System','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(6,'Winner','Hi %s, you won the \'%s\' game.  Well done. %s','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(7,'Loser','Hi %s, sadly you lost the \'%s\' game.  Try again later. %s','specific','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(8,'Another go for hit','Hi %s, just to let you know, you now get another go after a successful hit. System','broadcast','ready','2025-11-11 17:31:15','2025-11-11 17:31:15'),(9,'Volume level can be set','Hi %s, there is now a range of volumes to which the sound can be set. System','broadcast','ready','2025-11-11 17:31:15','2025-11-11 17:31:15');
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
  `row` int unsigned NOT NULL DEFAULT '0',
  `col` int unsigned NOT NULL DEFAULT '0',
  `hit_vessel` int unsigned NOT NULL DEFAULT '0',
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
INSERT INTO `users` VALUES (1,'System','system@gmail.com','$2y$10$ZKBv2QvlPbwV9HXBhqLnk.5JEFSQD4q2dE7lFlGtcVLkMQZGiZb9G','Zxef2bGwpfqT1HS8',1,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(2,'brian','brian@gmail.com','$2y$10$JCuzQXHrYeA1zXZMlDQO/uYhKIG/uatQcmE1rWFq3GR2OZA/h9s2S','RalsVywgFDIbjf8Q',1,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(3,'steve','steve@gmail.com','$2y$10$q.7max4YNWckqgwiz9NTc.816wvSAjOgKcBDSb6NkPgCFXZxX7Ja6','vfD88JRrO1zg5a2l',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(4,'phil','phil@gmail.com','$2y$10$4PJIlIk3tobOsUv6J8k7ye5kCzxeX7vX4H2zs9Ry0UDGOWZuoEeGO','rcSOcLpZl0M0pt3S',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(5,'andrew','andrew@gmail.com','$2y$10$yEXY5/p52VXkyvnnzavkAucCWUJA.y7h.NOdDFoosTk6pgUA3xVi2','i2lWQcZDV1QBTJNN',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(6,'greg','greg@gmail.com','$2y$10$IB0n.SRWxmBw1gwmqG/AheWwOH0weKbkS6Kf20WIx5OF5tm2yy4ei','VSuE62Q1bYx8bJei',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(7,'tim','tim@gmail.com','$2y$10$wVjpdMVzNbB3P0Md30BWsePFDM/7bv1L3hYvq4CS2QZ58.vWoLXi6','9KF4dvn69PWdBRXl',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(8,'ben','ben@gmail.com','$2y$10$N.b2mWAuul.w.iW02lZXHu2zPsAEUuj7h/t6HPHj0Fr146kOjRjYe','7zmunP08OjeerrKl',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(9,'russ','russ@gmail.com','$2y$10$86SnmcriZagEHnlD/.CWiOl7jcLC78ncVFvGjYlW8Soi9cOn8/4Ha','CnCROKp9rsfiXKeD',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(10,'kika','kika@gmail.com','$2y$10$fF3E7yI3OBc8twIv71giGO8voPXdEV8q9ogy4PS3c3AW0XrQvJQpW','hzVHTYVzWV3ivAZi',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(11,'ayndie','ayndie@gmail.com','$2y$10$GQcTg9HcwLN00b64x29zKOCbP0LtoTUyq/f6f2AUBptY8YKGUNTiy','T2XINyX7fzE1YB5t',0,NULL,0,0,0,'2025-11-11 17:31:15','2025-11-11 17:31:15');
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
  `name` enum('battleship','destroyer','submarine','zodiac','custom') COLLATE utf8mb3_unicode_ci NOT NULL,
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
INSERT INTO `vessels` VALUES (1,'battleship',3,5,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(2,'destroyer',2,4,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(3,'submarine',2,4,'2025-11-11 17:31:15','2025-11-11 17:31:15'),(4,'zodiac',1,3,'2025-11-11 17:31:15','2025-11-11 17:31:15');
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

-- Dump completed on 2025-11-11 17:31:38
