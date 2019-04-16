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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (26,'beauty palour'),(20,'book shop'),(12,'camping equipment'),(10,'chemist'),(13,'coaching classes'),(6,'department store'),(9,'drug store'),(7,'general store'),(5,'grocer'),(16,'guitar'),(28,'ice cream palour'),(2,'mobile repair'),(1,'mobile sale'),(15,'music'),(22,'namkeen'),(8,'pharmacy'),(4,'phone recharge'),(3,'photostat'),(24,'resturant'),(25,'salon'),(23,'snacks'),(11,'sports'),(19,'stationer'),(21,'sweets'),(17,'toy shop'),(18,'toy store'),(14,'tutorials');
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
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `est_cat`
--

LOCK TABLES `est_cat` WRITE;
/*!40000 ALTER TABLE `est_cat` DISABLE KEYS */;
INSERT INTO `est_cat` VALUES (1,8,1),(2,9,1),(3,10,1),(4,21,2),(5,22,2),(6,23,2),(7,24,2),(8,21,3),(9,22,3),(10,23,3),(11,24,3),(12,8,4),(13,9,4),(14,10,4),(15,5,5),(16,6,5),(17,7,5),(18,5,6),(19,6,6),(20,7,6),(21,1,7),(22,2,7),(23,3,7),(24,4,7),(25,8,8),(26,9,8),(27,10,8),(28,17,9),(29,18,9),(30,19,9),(31,20,9),(32,11,10),(33,12,10),(34,11,11),(35,12,11),(36,11,12),(37,12,12),(38,11,13),(39,12,13),(40,11,14),(41,12,14),(42,5,15),(43,6,15),(44,7,15),(45,1,16),(46,2,16),(47,3,16),(48,4,16),(49,8,17),(50,9,17),(51,10,17),(52,8,18),(53,9,18),(54,10,18),(55,8,19),(56,9,19),(57,10,19),(58,8,20),(59,9,20),(60,10,20),(61,8,21),(62,9,21),(63,10,21),(64,1,22),(65,2,22),(66,3,22),(67,4,22),(68,1,23),(69,2,23),(70,3,23),(71,4,23),(72,1,24),(73,2,24),(74,3,24),(75,4,24),(76,1,25),(77,2,25),(78,3,25),(79,4,25),(80,1,26),(81,2,26),(82,3,26),(83,4,26),(84,1,27),(85,2,27),(86,3,27),(87,4,27),(88,1,28),(89,2,28),(90,3,28),(91,4,28),(92,1,29),(93,2,29),(94,3,29),(95,4,29),(96,21,30),(97,22,30),(98,23,30),(99,24,30),(100,5,31),(101,6,31),(102,7,31),(103,5,32),(104,6,32),(105,7,32),(106,5,33),(107,6,33),(108,7,33),(109,5,34),(110,6,34),(111,7,34),(112,5,35),(113,6,35),(114,7,35),(115,5,36),(116,6,36),(117,7,36),(118,5,37),(119,6,37),(120,7,37),(121,8,38),(122,9,38),(123,10,38),(124,11,39),(125,12,39),(126,11,40),(127,12,40),(128,11,41),(129,12,41),(130,11,42),(131,12,42),(132,11,43),(133,12,43),(134,17,44),(135,18,44),(136,19,44),(137,20,44),(138,13,45),(139,14,45),(140,15,45),(141,16,45),(142,13,46),(143,14,46),(144,15,46),(145,16,46),(146,13,47),(147,14,47),(148,15,47),(149,16,47),(150,13,48),(151,14,48),(152,15,48),(153,16,48),(154,13,49),(155,14,49),(156,15,49),(157,16,49),(158,13,50),(159,14,50),(160,15,50),(161,16,50),(162,13,51),(163,14,51),(164,15,51),(165,16,51),(166,13,52),(167,14,52),(168,15,52),(169,16,52),(170,13,53),(171,14,53),(172,15,53),(173,16,53),(174,13,54),(175,14,54),(176,15,54),(177,16,54),(178,17,55),(179,18,55),(180,19,55),(181,20,55),(182,17,56),(183,18,56),(184,19,56),(185,20,56),(186,17,57),(187,18,57),(188,19,57),(189,20,57),(190,17,58),(191,18,58),(192,19,58),(193,20,58),(194,17,59),(195,18,59),(196,19,59),(197,20,59),(198,17,60),(199,18,60),(200,19,60),(201,20,60),(202,17,61),(203,18,61),(204,19,61),(205,20,61),(206,17,62),(207,18,62),(208,19,62),(209,20,62),(210,17,63),(211,18,63),(212,19,63),(213,20,63),(214,17,64),(215,18,64),(216,19,64),(217,20,64),(218,17,65),(219,18,65),(220,19,65),(221,20,65),(222,21,66),(223,22,66),(224,23,66),(225,24,66),(226,21,67),(227,22,67),(228,23,67),(229,24,67),(230,21,68),(231,22,68),(232,23,68),(233,24,68),(234,21,69),(235,22,69),(236,23,69),(237,24,69),(238,21,70),(239,22,70),(240,23,70),(241,24,70),(242,21,71),(243,22,71),(244,23,71),(245,24,71),(246,21,72),(247,22,72),(248,23,72),(249,24,72),(250,21,73),(251,22,73),(252,23,73),(253,24,73),(254,21,74),(255,22,74),(256,23,74),(257,24,74),(258,25,75),(259,26,75),(260,25,76),(261,26,76),(262,25,77),(263,26,77),(264,25,78),(265,26,78),(266,25,79),(267,26,79),(268,25,80),(269,26,80),(270,25,81),(271,26,81),(272,24,82),(273,28,82),(274,24,83),(275,28,83),(276,24,84),(277,28,84),(278,24,85),(279,28,85),(280,24,86),(281,28,86),(282,24,87),(283,28,87);
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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `establishment`
--

LOCK TABLES `establishment` WRITE;
/*!40000 ALTER TABLE `establishment` DISABLE KEYS */;
INSERT INTO `establishment` VALUES (1,'apollo pharmacy','Shop No. 29','7926643627',1),(2,'bikaner','Shop No. 85','9913637476',1),(3,'halidrams','Shop No. 9','8364481387',1),(4,'vijay chemist','Shop No. 63','8325367088',1),(5,'agarwal daily needs','Shop No. 16','7140754581',1),(6,'ajay grocer','Shop No. 77','8292559144',1),(7,'balaji mobile','Shop No. 128','9532890295',1),(8,'javal store','Shop No. 27','8815247946',1),(9,'vista stationers','Shop No. 156','7333873302',1),(10,'mega sports','Shop No. 100','8793681424',1),(11,'decathalon','Shop No. 95','9171789668',1),(12,'vishal sons','Shop No. 88','9812428077',1),(13,'rama store','Shop No. 57','8290319753',1),(14,'ragila store','Shop No. 5','8003073962',1),(15,'Nityam Departmental Store','Shop No. 148','7197023228',1),(16,'baba mobile','Shop No. 116','9757936327',1),(17,'balaji medicos','Shop No. 166','9947108946',1),(18,'gaurav medical store','Shop No. 173','7939849976',1),(19,'shri indra medical store','Shop No. 64','7128538064',1),(20,'arpan medicos','Shop No. 29','7348214453',1),(21,'Gadget Doctor','Shop No. 4','9195105698',1),(22,'Fix Screen Pro','Shop No. 195','9536418682',1),(23,'mobile point','Shop No. 117','7427558077',1),(24,'mobile mantra','Shop No. 179','9820684508',1),(25,'mobile 360','Shop No. 156','9178741289',1),(26,'retouch','Shop No. 80','8748201854',1),(27,'v fixit','Shop No. 126','7354661775',1),(28,'ginny mobile repair','Shop No. 168','9137810448',1),(29,'online street','Shop No. 198','8996270439',1),(30,'agarwal sweets','Shop No. 184','9918422478',1),(31,'reliance smart','Shop No. 147','9962264777',1),(32,'big bazaar','Shop No. 197','7401051191',1),(33,'easy day express','Shop No. 5','7485129742',1),(34,'more','Shop No. 183','7197781465',1),(35,'jumbo daily needs','Shop No. 169','8684670370',1),(36,'ginnis department store','Shop No. 105','7425281575',1),(37,'bansal store','Shop No. 93','7387270606',1),(38,'sai care chemst','Shop No. 81','9227159696',1),(39,'bhoomi sports','Shop No. 47','7238905676',1),(40,'gupta sports','Shop No. 168','9090540398',1),(41,'prym sports worldwide','Shop No. 53','8547468152',1),(42,'sk sports','Shop No. 69','8135733295',1),(43,'bright rajput sports','Shop No. 187','8114908449',1),(44,'Chhabra Enterprises','Shop No. 89','7316901730',1),(45,'gyan mantra','Shop No. 48','9454580704',1),(46,'kaushal tutorials','Shop No. 197','7673115394',1),(47,'3i coaching','Shop No. 181','8710695822',1),(48,'superior minds','Shop No. 158','8450767922',1),(49,'ayam academty','Shop No. 104','9890724836',1),(50,'educrafters','Shop No. 10','9370614896',1),(51,'simply gyan tutorials','Shop No. 60','7082558670',1),(52,'education park','Shop No. 26','9497687396',1),(53,'anant coaching','Shop No. 119','9691964560',1),(54,'tutors world','Shop No. 124','8898117207',1),(55,'saluja toys','Shop No. 115','9653259755',1),(56,'shri rajkamal enterprises','Shop No. 97','8206851283',1),(57,'craze gift galery','Shop No. 88','9573448820',1),(58,'grand prix toys','Shop No. 129','7899226389',1),(59,'chuckles forever','Shop No. 146','8260008097',1),(60,'kriti creations','Shop No. 153','9623575652',1),(61,'surjeet toys','Shop No. 91','8570612587',1),(62,'shivam collections','Shop No. 11','9992672090',1),(63,'jainson toys','Shop No. 27','7097291638',1),(64,'play rabbits','Shop No. 106','9898418819',1),(65,'khushi toys','Shop No. 112','7064160972',1),(66,'shagun sweets','Shop No. 62','8608544647',1),(67,'roasted namkeen shop','Shop No. 26','7649201493',1),(68,'indian bakers','Shop No. 30','9715464361',1),(69,'jain traders','Shop No. 148','9871648595',1),(70,'bansiwala sweets and snacks','Shop No. 39','8473963870',1),(71,'shiv snacks point','Shop No. 8','9720943201',1),(72,'south indian hot chips','Shop No. 163','8202935574',1),(73,'jain namkeen bhandar','Shop No. 3','8368139646',1),(74,'frontier biscuits','Shop No. 134','9806334852',1),(75,'fresh look salon','Shop No. 5','8599081700',1),(76,'lakme salon','Shop No. 59','7799710875',1),(77,'hair art unisex salon','Shop No. 97','9764035025',1),(78,'donna beauty salon','Shop No. 107','7047009340',1),(79,'looks salon','Shop No. 67','7340140815',1),(80,'frizzles salon','Shop No. 33','7197973091',1),(81,'geetanjali salon','Shop No. 79','7376238691',1),(82,'maharani the kitchen','Shop No. 4','9113174820',1),(83,'jayka resturant','Shop No. 142','8633732804',1),(84,'knight king','Shop No. 70','9615197979',1),(85,'the cool hut','Shop No. 69','7423466441',1),(86,'new madras cafÚ','Shop No. 50','7506129428',1),(87,'just punjabi','Shop No. 130','9085509001',1);
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

-- Dump completed on 2019-04-16  9:26:20
