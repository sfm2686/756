-- MySQL dump 10.14  Distrib 5.5.60-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: sfm2686
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `PersonId` mediumint(100) NOT NULL AUTO_INCREMENT,
  `LastName` varchar(20) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `NickName` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`PersonId`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Doe','John',NULL),(2,'Mira','Sultan',NULL),(3,'Smith','Dan','danny'),(4,'Bashmail','Ahmed','Bash'),(5,'Jobs','Steve','Marketing tech'),(6,'Torvalds','Linus','Unix!!!!'),(11,'Gates','Bill','NOT UNIX :('),(12,'Ritchie','Dennis','C'),(16,'Of Siwa','Bayak','Assassin'),(17,'Of Alexandria','Aya','Assassin'),(18,'Smith','Jack',NULL),(27,'dooooooe','jane',NULL),(28,'assdasd','asd',NULL),(29,'assdasd','asd',NULL),(30,'test','test',NULL);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phonenumbers`
--

DROP TABLE IF EXISTS `phonenumbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phonenumbers` (
  `AreaCode` mediumint(3) DEFAULT NULL,
  `PhoneNumber` mediumint(6) NOT NULL,
  `PersonId` mediumint(100) NOT NULL,
  `PhoneTypeId` mediumint(10) NOT NULL,
  `PhoneId` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`PhoneId`),
  KEY `PersonId` (`PersonId`),
  KEY `PhoneTypeId` (`PhoneTypeId`),
  CONSTRAINT `phonenumbers_ibfk_1` FOREIGN KEY (`PersonId`) REFERENCES `people` (`PersonId`),
  CONSTRAINT `phonenumbers_ibfk_2` FOREIGN KEY (`PhoneTypeId`) REFERENCES `phonetypes` (`PhoneTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonenumbers`
--

LOCK TABLES `phonenumbers` WRITE;
/*!40000 ALTER TABLE `phonenumbers` DISABLE KEYS */;
INSERT INTO `phonenumbers` VALUES (222,123133,29,1,3),(5555,555555,27,2,5),(666,666666,27,3,6),(777,777777,27,1,7),(222,2222222,29,1,9);
/*!40000 ALTER TABLE `phonenumbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phonetypes`
--

DROP TABLE IF EXISTS `phonetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phonetypes` (
  `PhoneTypeId` mediumint(10) NOT NULL AUTO_INCREMENT,
  `PhoneType` varchar(20) NOT NULL,
  PRIMARY KEY (`PhoneTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonetypes`
--

LOCK TABLES `phonetypes` WRITE;
/*!40000 ALTER TABLE `phonetypes` DISABLE KEYS */;
INSERT INTO `phonetypes` VALUES (1,'Cellphone'),(2,'Fax'),(3,'Home');
/*!40000 ALTER TABLE `phonetypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_league`
--

DROP TABLE IF EXISTS `server_league`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_league` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_league`
--

LOCK TABLES `server_league` WRITE;
/*!40000 ALTER TABLE `server_league` DISABLE KEYS */;
INSERT INTO `server_league` VALUES (1,'High School'),(2,'Middle School');
/*!40000 ALTER TABLE `server_league` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_player`
--

DROP TABLE IF EXISTS `server_player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `jerseynumber` varchar(45) NOT NULL,
  `team` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teamFK_idx` (`team`),
  KEY `playPosFK_idx` (`id`),
  CONSTRAINT `teamFK` FOREIGN KEY (`team`) REFERENCES `server_team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_player`
--

LOCK TABLES `server_player` WRITE;
/*!40000 ALTER TABLE `server_player` DISABLE KEYS */;
INSERT INTO `server_player` VALUES (9,'Mohamed','Aljohnai','2019-03-23','31',3),(11,'john','doe','2019-03-11','12',3),(12,'Sultan','Mira','2019-03-27','66',8),(13,'Dean','Dean','2019-03-20','99',12),(14,'Summyah','Alfalha','2019-03-05','12',12),(15,'Ahmed','Sekaro','2019-03-23','77',12),(16,'Kritin','Mendora','2019-03-24','4',12),(17,'Abduallah','Mehmadi','2019-03-02','53',12),(18,'Ahmed','Amoudi','2018-10-11','98',12),(19,'Sami','Aljaber','2019-03-23','49',3),(20,'Moya','Barda','2019-03-03','92',3),(21,'Akl','Hendi','2018-05-17','72',3),(22,'Ac','Odyssey','2009-06-17','10',3),(23,'John','Ahn','2019-03-08','30',12),(24,'Tasleem','Mreed','2019-03-09','52',12),(25,'Bagi','Khamsa','2019-03-20','21',3),(26,'Zohair','Arkoby','2019-03-22','99',12),(27,'Steve','Jobs','2019-03-01','55',3),(28,'Tim','Hortons','2019-03-02','99',8),(29,'Akhr','Wahed','2019-03-05','52',12),(30,'Blaha','Mara','2019-03-22','87',3),(31,'Kman','Wahed','2019-03-07','31',3);
/*!40000 ALTER TABLE `server_player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_playerpos`
--

DROP TABLE IF EXISTS `server_playerpos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_playerpos` (
  `player` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`player`,`position`),
  KEY `ppPlayerFK_idx` (`player`),
  KEY `posFK_idx` (`position`),
  CONSTRAINT `posPlayerFK` FOREIGN KEY (`player`) REFERENCES `server_player` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `posFK` FOREIGN KEY (`position`) REFERENCES `server_position` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_playerpos`
--

LOCK TABLES `server_playerpos` WRITE;
/*!40000 ALTER TABLE `server_playerpos` DISABLE KEYS */;
INSERT INTO `server_playerpos` VALUES (9,1),(11,7),(12,1),(13,6),(14,6),(15,3),(16,2),(17,3),(18,1),(19,1),(20,1),(21,1),(22,1),(23,3),(24,7),(25,1),(26,2),(27,1),(28,1),(29,3),(30,1),(31,1);
/*!40000 ALTER TABLE `server_playerpos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_position`
--

DROP TABLE IF EXISTS `server_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_position` (
  `name` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_position`
--

LOCK TABLES `server_position` WRITE;
/*!40000 ALTER TABLE `server_position` DISABLE KEYS */;
INSERT INTO `server_position` VALUES ('Goalkeeper',1),('Striker',2),('Sweeper',3),('Central midfield',6),('Winger',7);
/*!40000 ALTER TABLE `server_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_roles`
--

DROP TABLE IF EXISTS `server_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_roles`
--

LOCK TABLES `server_roles` WRITE;
/*!40000 ALTER TABLE `server_roles` DISABLE KEYS */;
INSERT INTO `server_roles` VALUES (1,'Admin'),(2,'League Manager'),(3,'Team Manager'),(4,'Coach'),(5,'Parent');
/*!40000 ALTER TABLE `server_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_schedule`
--

DROP TABLE IF EXISTS `server_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_schedule` (
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `hometeam` int(11) NOT NULL,
  `awayteam` int(11) NOT NULL,
  `homescore` int(11) NOT NULL DEFAULT '0',
  `awayscore` int(11) NOT NULL DEFAULT '0',
  `scheduled` datetime NOT NULL,
  `completed` bit(1) NOT NULL DEFAULT b'0',
  KEY `sportleagueseasonFK_idx` (`sport`,`league`,`season`),
  KEY `hometeamFK_idx` (`hometeam`),
  KEY `awayteamFK_idx` (`awayteam`),
  CONSTRAINT `schslseasonFK` FOREIGN KEY (`sport`, `league`, `season`) REFERENCES `server_slseason` (`sport`, `league`, `season`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hometeamFK` FOREIGN KEY (`hometeam`) REFERENCES `server_team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `awayteamFK` FOREIGN KEY (`awayteam`) REFERENCES `server_team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_schedule`
--

LOCK TABLES `server_schedule` WRITE;
/*!40000 ALTER TABLE `server_schedule` DISABLE KEYS */;
INSERT INTO `server_schedule` VALUES (1,1,1,3,8,0,0,'0000-00-00 00:00:00',''),(1,1,1,12,3,21,12,'0000-00-00 00:00:00',''),(1,1,1,13,3,43,12,'0000-00-00 00:00:00',''),(1,1,1,3,12,0,0,'0000-00-00 00:00:00',''),(1,1,1,8,3,0,0,'0000-00-00 00:00:00',''),(2,1,1,12,3,0,0,'0000-00-00 00:00:00',''),(1,1,2,3,13,0,0,'2011-11-11 11:11:11',''),(1,1,1,12,13,100,0,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `server_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_season`
--

DROP TABLE IF EXISTS `server_season`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_season`
--

LOCK TABLES `server_season` WRITE;
/*!40000 ALTER TABLE `server_season` DISABLE KEYS */;
INSERT INTO `server_season` VALUES (1,'2020','Summer Season'),(2,'2022','Winter Season'),(4,'2030','future season');
/*!40000 ALTER TABLE `server_season` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_slseason`
--

DROP TABLE IF EXISTS `server_slseason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_slseason` (
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  PRIMARY KEY (`sport`,`league`,`season`),
  KEY `ssksseasonFK_idx` (`season`),
  KEY `sslsleagueFK_idx` (`league`),
  KEY `sslssportFK_idx` (`sport`),
  CONSTRAINT `sslssportFK` FOREIGN KEY (`sport`) REFERENCES `server_sport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sslsleaguetFK` FOREIGN KEY (`league`) REFERENCES `server_league` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sslsseasonFK` FOREIGN KEY (`season`) REFERENCES `server_season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_slseason`
--

LOCK TABLES `server_slseason` WRITE;
/*!40000 ALTER TABLE `server_slseason` DISABLE KEYS */;
INSERT INTO `server_slseason` VALUES (1,1,1),(1,1,2),(1,2,2),(2,1,1);
/*!40000 ALTER TABLE `server_slseason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_sport`
--

DROP TABLE IF EXISTS `server_sport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_sport`
--

LOCK TABLES `server_sport` WRITE;
/*!40000 ALTER TABLE `server_sport` DISABLE KEYS */;
INSERT INTO `server_sport` VALUES (1,'Soccer'),(2,'Football');
/*!40000 ALTER TABLE `server_sport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_team`
--

DROP TABLE IF EXISTS `server_team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `mascot` varchar(50) DEFAULT NULL,
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `homecolor` varchar(25) NOT NULL DEFAULT 'white',
  `awaycolor` varchar(25) NOT NULL,
  `maxplayers` varchar(45) NOT NULL DEFAULT '15',
  PRIMARY KEY (`id`),
  KEY `sls_idx` (`sport`,`league`,`season`),
  KEY `sls_sport_idx` (`sport`),
  KEY `sls_league_idx` (`league`),
  KEY `sls_season_idx` (`season`),
  CONSTRAINT `slsFK` FOREIGN KEY (`sport`, `league`, `season`) REFERENCES `server_slseason` (`sport`, `league`, `season`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_team`
--

LOCK TABLES `server_team` WRITE;
/*!40000 ALTER TABLE `server_team` DISABLE KEYS */;
INSERT INTO `server_team` VALUES (3,'UPV Soccer','Pete',1,1,2,'static/images/pete.jpg','blue','orange','11'),(8,'rit team','ritchie',1,1,2,NULL,'orange','white','12'),(12,'RIT Soccer','Ritchie',1,1,1,NULL,'Orange','White','12'),(13,'UoR Football','medicine pill',2,1,1,NULL,'Black','White','20');
/*!40000 ALTER TABLE `server_team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_user`
--

DROP TABLE IF EXISTS `server_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_user` (
  `username` varchar(25) NOT NULL,
  `role` int(11) NOT NULL,
  `password` char(60) NOT NULL,
  `team` int(11) DEFAULT NULL,
  `league` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `roleFK_idx` (`role`),
  KEY `teamUserFK_idx` (`team`),
  KEY `leagueUserFK_idx` (`league`),
  CONSTRAINT `roleFK` FOREIGN KEY (`role`) REFERENCES `server_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teamUserFK` FOREIGN KEY (`team`) REFERENCES `server_team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leagueUserFK` FOREIGN KEY (`league`) REFERENCES `server_league` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_user`
--

LOCK TABLES `server_user` WRITE;
/*!40000 ALTER TABLE `server_user` DISABLE KEYS */;
INSERT INTO `server_user` VALUES ('adminadmin',1,'$2y$10$syo3.KdjjRU00mExse7xXOpFZvEnbGi.sKqO3zIQ51byjNqxLkfmq',3,1),('coachcoach',4,'$2y$10$/ySB6YPLJ7Ht0gkLvZuUSe4XYcJ2QcOVma3kQ7eQxgSIERF8PoBvi',3,1),('lmanager',2,'$2y$10$3/ayA9bA4HdElt2wbtCVQuv49WIxqXpVkghy9jwcVbR0utPUQru9C',8,2),('parentparent',5,'$2y$10$27qsPF9dHNKdx7a6d4EVYup3UgmFpT.1CbTfVFWwDJkP342OOTyx.',3,1),('tmanager',3,'$2y$10$P7CBq.jxMVmvRTUM6z84tO7kVW5D/HVvAddhmPcAjNjMpTnH3pBFu',3,1);
/*!40000 ALTER TABLE `server_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-24 22:48:32
