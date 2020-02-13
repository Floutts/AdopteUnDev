-- MySQL dump 10.16  Distrib 10.1.41-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: AdopteUnDev
-- ------------------------------------------------------
-- Server version	10.1.41-MariaDB-0+deb9u1

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
-- Table structure for table `code`
--

DROP TABLE IF EXISTS `code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `code` (
  `idDev` int(11) NOT NULL,
  `idLang` int(11) NOT NULL,
  KEY `idDev` (`idDev`),
  KEY `idLang` (`idLang`),
  CONSTRAINT `code_ibfk_1` FOREIGN KEY (`idDev`) REFERENCES `developpeur` (`id`),
  CONSTRAINT `code_ibfk_2` FOREIGN KEY (`idLang`) REFERENCES `langage` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code`
--

LOCK TABLES `code` WRITE;
/*!40000 ALTER TABLE `code` DISABLE KEYS */;
INSERT INTO `code` VALUES (6,9),(30,12),(30,11),(30,10),(30,1),(30,9);
/*!40000 ALTER TABLE `code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `developpeur`
--

DROP TABLE IF EXISTS `developpeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `developpeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `NbUnique` varchar(13) NOT NULL,
  `idRole` int(11) NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `dateInscrit` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idRole` (`idRole`),
  CONSTRAINT `developpeur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `developpeur`
--

LOCK TABLES `developpeur` WRITE;
/*!40000 ALTER TABLE `developpeur` DISABLE KEYS */;
INSERT INTO `developpeur` VALUES (2,'alphonse','gluiglui','a.g@fr','$2y$10$/63RwuPjVbSMGlVNFbBQCuwSt0Dg1oH7o6739cXzmVJgSp4nMYkSO','5e20393176315',2,0,'0000-00-00 00:00:00'),(4,'Jean','Bon','Jambon@gmail.com','$2y$10$cgS1xLhjZlFecBaQfIxbNug4NQAx/G2fvGoBhFwPIfTAH5I5Xhwae','5e26adabc2500',2,0,'0000-00-00 00:00:00'),(6,'Harry','Cauvert','Haricot.vert@gmail.com','$2y$10$Expnrsv0tfOMLotGgZdS3ONpBJIlJkQ81oYW8klm69Tw0TQ8fILXy','5e26af2ed620f',2,0,'0000-00-00 00:00:00'),(30,'Bayon','fabien','fabienbayon@yahoo.fr','$2y$10$IGctYnaXTt4VPZmZYr5LR.hSNcqs/JI2MrYEnpsJkxNvkp51m6loG','5e2eb3b832810',1,1,'2020-01-27 09:56:08');
/*!40000 ALTER TABLE `developpeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `langage`
--

DROP TABLE IF EXISTS `langage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `langage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `langage`
--

LOCK TABLES `langage` WRITE;
/*!40000 ALTER TABLE `langage` DISABLE KEYS */;
INSERT INTO `langage` VALUES (1,'python'),(9,'PYTHON'),(10,'PYTHON'),(11,'php c la vie'),(12,'php c la vie'),(15,'lnaguafe');
/*!40000 ALTER TABLE `langage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Administrateur'),(2,'Client');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-13 10:34:20
