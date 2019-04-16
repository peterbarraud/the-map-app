-- MySQL dump 10.16  Distrib 10.2.9-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: themapapp
-- ------------------------------------------------------
-- Server version	10.2.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `areaname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `areaname` (`areaname`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (3,'sector 123'),(6,'sector 128'),(5,'sector 129'),(1,'sector 132'),(2,'sector 148'),(4,'sector 178');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (26,'beauty palour'),(18,'book shop'),(20,'camping equipment'),(3,'chemist'),(21,'coaching classes'),(9,'department store'),(2,'drug store'),(10,'general store'),(8,'grocer'),(24,'guitar'),(27,'ice cream palour'),(12,'mobile repair'),(11,'mobile sale'),(23,'music'),(5,'namkeen'),(1,'pharmacy'),(14,'phone recharge'),(13,'photostat'),(7,'resturant'),(25,'salon'),(6,'snacks'),(19,'sports'),(17,'stationer'),(4,'sweets'),(15,'toy shop'),(16,'toy store'),(22,'tutorials');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `est_cat`
--

DROP TABLE IF EXISTS `est_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `est_cat` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL,
  `estid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`),
  KEY `estid` (`estid`),
  CONSTRAINT `est_cat_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`id`),
  CONSTRAINT `est_cat_ibfk_2` FOREIGN KEY (`estid`) REFERENCES `establishment` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `est_cat`
--

LOCK TABLES `est_cat` WRITE;
/*!40000 ALTER TABLE `est_cat` DISABLE KEYS */;
INSERT INTO `est_cat` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,2),(5,5,2),(6,6,2),(7,7,2),(8,4,3),(9,5,3),(10,6,3),(11,7,3),(12,1,4),(13,2,4),(14,3,4),(15,8,5),(16,9,5),(17,10,5),(18,8,6),(19,9,6),(20,10,6),(21,11,7),(22,12,7),(23,13,7),(24,14,7),(25,1,8),(26,2,8),(27,3,8),(28,15,9),(29,16,9),(30,17,9),(31,18,9),(32,19,10),(33,20,10),(34,19,11),(35,20,11),(36,19,12),(37,20,12),(38,19,13),(39,20,13),(40,19,14),(41,20,14),(42,8,15),(43,9,15),(44,10,15),(45,11,16),(46,12,16),(47,13,16),(48,14,16),(49,1,17),(50,2,17),(51,3,17),(52,1,18),(53,2,18),(54,3,18),(55,1,19),(56,2,19),(57,3,19),(58,1,20),(59,2,20),(60,3,20),(61,1,21),(62,2,21),(63,3,21),(64,11,22),(65,12,22),(66,13,22),(67,14,22),(68,11,23),(69,12,23),(70,13,23),(71,14,23),(72,11,24),(73,12,24),(74,13,24),(75,14,24),(76,11,25),(77,12,25),(78,13,25),(79,14,25),(80,11,26),(81,12,26),(82,13,26),(83,14,26),(84,11,27),(85,12,27),(86,13,27),(87,14,27),(88,11,28),(89,12,28),(90,13,28),(91,14,28),(92,11,29),(93,12,29),(94,13,29),(95,14,29),(96,4,30),(97,5,30),(98,6,30),(99,7,30),(100,8,31),(101,9,31),(102,10,31),(103,8,32),(104,9,32),(105,10,32),(106,8,33),(107,9,33),(108,10,33),(109,8,34),(110,9,34),(111,10,34),(112,8,35),(113,9,35),(114,10,35),(115,8,36),(116,9,36),(117,10,36),(118,8,37),(119,9,37),(120,10,37),(121,1,38),(122,2,38),(123,3,38),(124,19,39),(125,20,39),(126,19,40),(127,20,40),(128,19,41),(129,20,41),(130,19,42),(131,20,42),(132,19,43),(133,20,43),(134,19,44),(135,20,44),(136,21,45),(137,22,45),(138,23,45),(139,24,45),(140,21,46),(141,22,46),(142,23,46),(143,24,46),(144,21,47),(145,22,47),(146,23,47),(147,24,47),(148,21,48),(149,22,48),(150,23,48),(151,24,48),(152,21,49),(153,22,49),(154,23,49),(155,24,49),(156,21,50),(157,22,50),(158,23,50),(159,24,50),(160,21,51),(161,22,51),(162,23,51),(163,24,51),(164,21,52),(165,22,52),(166,23,52),(167,24,52),(168,21,53),(169,22,53),(170,23,53),(171,24,53),(172,21,54),(173,22,54),(174,23,54),(175,24,54),(176,15,55),(177,16,55),(178,17,55),(179,18,55),(180,15,56),(181,16,56),(182,17,56),(183,18,56),(184,15,57),(185,16,57),(186,17,57),(187,18,57),(188,15,58),(189,16,58),(190,17,58),(191,18,58),(192,15,59),(193,16,59),(194,17,59),(195,18,59),(196,15,60),(197,16,60),(198,17,60),(199,18,60),(200,15,61),(201,16,61),(202,17,61),(203,18,61),(204,15,62),(205,16,62),(206,17,62),(207,18,62),(208,15,63),(209,16,63),(210,17,63),(211,18,63),(212,15,64),(213,16,64),(214,17,64),(215,18,64),(216,15,65),(217,16,65),(218,17,65),(219,18,65),(220,15,66),(221,16,66),(222,17,66),(223,18,66),(224,4,67),(225,5,67),(226,6,67),(227,7,67),(228,4,68),(229,5,68),(230,6,68),(231,7,68),(232,4,69),(233,5,69),(234,6,69),(235,7,69),(236,4,70),(237,5,70),(238,6,70),(239,7,70),(240,4,71),(241,5,71),(242,6,71),(243,7,71),(244,4,72),(245,5,72),(246,6,72),(247,7,72),(248,4,73),(249,5,73),(250,6,73),(251,7,73),(252,4,74),(253,5,74),(254,6,74),(255,7,74),(256,4,75),(257,5,75),(258,6,75),(259,7,75),(260,25,76),(261,26,76),(262,25,77),(263,26,77),(264,25,78),(265,26,78),(266,25,79),(267,26,79),(268,25,80),(269,26,80),(270,25,81),(271,26,81),(272,25,82),(273,26,82),(274,7,83),(275,27,83),(276,7,84),(277,27,84),(278,7,85),(279,27,85),(280,7,86),(281,27,86),(282,7,87),(283,27,87),(284,7,88),(285,27,88);
/*!40000 ALTER TABLE `est_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `establishment`
--

DROP TABLE IF EXISTS `establishment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `establishment` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `areaid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `establishment`
--

LOCK TABLES `establishment` WRITE;
/*!40000 ALTER TABLE `establishment` DISABLE KEYS */;
INSERT INTO `establishment` VALUES (1,'apollo pharmacy','999','999',1),(2,'bikaner','999','999',1),(3,'halidrams','999','999',1),(4,'vijay chemist','999','999',1),(5,'agarwal daily needs','999','999',1),(6,'ajay grocer','999','999',1),(7,'balaji mobile','999','999',1),(8,'javal store','999','999',1),(9,'vista stationers','999','999',1),(10,'mega sports','999','999',1),(11,'decathalon','999','999',1),(12,'vishal sons','999','999',1),(13,'rama store','999','999',1),(14,'ragila store','999','999',1),(15,'Nityam Departmental Store','999','999',1),(16,'baba mobile','999','999',1),(17,'balaji medicos','999','999',1),(18,'gaurav medical store','999','999',1),(19,'shri indra medical store','999','999',1),(20,'arpan medicos','999','999',1),(21,'Gadget Doctor','999','999',1),(22,'Fix Screen Pro','999','999',1),(23,'mobile point','999','999',1),(24,'mobile mantra','999','999',1),(25,'mobile 360','999','999',1),(26,'retouch','999','999',1),(27,'v fixit','999','999',1),(28,'ginny mobile repair','999','999',1),(29,'online street','999','999',1),(30,'agarwal sweets','999','999',1),(31,'reliance smart','999','999',1),(32,'big bazaar','999','999',1),(33,'easy day express','999','999',1),(34,'more','999','999',1),(35,'jumbo daily needs','999','999',1),(36,'ginnis department store','999','999',1),(37,'bansal store','999','999',1),(38,'sai care chemst','999','999',1),(39,'bhoomi sports','999','999',1),(40,'gupta sports','999','999',1),(41,'prym sports worldwide','999','999',1),(42,'sk sports','999','999',1),(43,'bright rajput sports','999','999',1),(44,'Chhabra Enterprises','999','999',1),(45,'gyan mantra','999','999',1),(46,'kaushal tutorials','999','999',1),(47,'3i coaching','999','999',1),(48,'superior minds','999','999',1),(49,'ayam academty','999','999',1),(50,'educrafters','999','999',1),(51,'simply gyan tutorials','999','999',1),(52,'education park','999','999',1),(53,'anant coaching','999','999',1),(54,'tutors world','999','999',1),(55,'Chhabra Enterprises','999','999',1),(56,'saluja toys','999','999',1),(57,'shri rajkamal enterprises','999','999',1),(58,'craze gift galery','999','999',1),(59,'grand prix toys','999','999',1),(60,'chuckles forever','999','999',1),(61,'kriti creations','999','999',1),(62,'surjeet toys','999','999',1),(63,'shivam collections','999','999',1),(64,'jainson toys','999','999',1),(65,'play rabbits','999','999',1),(66,'khushi toys','999','999',1),(67,'shagun sweets','999','999',1),(68,'roasted namkeen shop','999','999',1),(69,'indian bakers','999','999',1),(70,'jain traders','999','999',1),(71,'bansiwala sweets and snacks','999','999',1),(72,'shiv snacks point','999','999',1),(73,'south indian hot chips','999','999',1),(74,'jain namkeen bhandar','999','999',1),(75,'frontier biscuits','999','999',1),(76,'fresh look salon','999','999',1),(77,'lakme salon','999','999',1),(78,'hair art unisex salon','999','999',1),(79,'donna beauty salon','999','999',1),(80,'looks salon','999','999',1),(81,'frizzles salon','999','999',1),(82,'geetanjali salon','999','999',1),(83,'maharani the kitchen','999','999',1),(84,'jayka resturant','999','999',1),(85,'knight king','999','999',1),(86,'the cool hut','999','999',1),(87,'new madras cafÃ©','999','999',1),(88,'just punjabi','999','999',1),(89,'','999','999',1);
/*!40000 ALTER TABLE `establishment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-16 22:27:22
