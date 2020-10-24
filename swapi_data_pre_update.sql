# ************************************************************
# Sequel Ace SQL dump
# Version 2104
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.5.6-MariaDB)
# Database: southern
# Generation Time: 2020-10-24 01:28:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table swapi_characters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `swapi_characters`;

CREATE TABLE `swapi_characters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `mass` decimal(8,2) DEFAULT NULL,
  `hair_colour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homeworld` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `species` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `swapi_characters` WRITE;
/*!40000 ALTER TABLE `swapi_characters` DISABLE KEYS */;

INSERT INTO `swapi_characters` (`id`, `name`, `height`, `mass`, `hair_colour`, `birth_year`, `gender`, `homeworld`, `species`)
VALUES
	(1,'Luke Skywalker',172.00,77.00,'blond','19BBY','male','Tatooine',NULL),
	(2,'C-3PO',167.00,75.00,'n/a','112BBY','n/a','Tatooine','Droid'),
	(3,'R2-D2',96.00,32.00,'n/a','33BBY','n/a','Naboo','Droid'),
	(4,'Darth Vader',202.00,136.00,'none','41.9BBY','male','Tatooine',NULL),
	(5,'Leia Organa',150.00,49.00,'brown','19BBY','female','Alderaan',NULL),
	(6,'Owen Lars',178.00,120.00,'brown, grey','52BBY','male','Tatooine',NULL),
	(7,'Beru Whitesun lars',165.00,75.00,'brown','47BBY','female','Tatooine',NULL),
	(8,'R5-D4',97.00,32.00,'n/a',NULL,'n/a','Tatooine','Droid'),
	(9,'Biggs Darklighter',183.00,84.00,'black','24BBY','male','Tatooine',NULL),
	(10,'Obi-Wan Kenobi',182.00,77.00,'auburn, white','57BBY','male','Stewjon',NULL),
	(11,'Anakin Skywalker',188.00,84.00,'blond','41.9BBY','male','Tatooine',NULL),
	(12,'Wilhuff Tarkin',180.00,NULL,'auburn, grey','64BBY','male','Eriadu',NULL),
	(13,'Chewbacca',228.00,112.00,'brown','200BBY','male','Kashyyyk','Wookie'),
	(14,'Han Solo',180.00,80.00,'brown','29BBY','male','Corellia',NULL),
	(15,'Greedo',173.00,74.00,'n/a','44BBY','male','Rodia','Rodian'),
	(16,'Jabba Desilijic Tiure',175.00,NULL,'n/a','600BBY','hermaphrodite','Nal Hutta','Hutt'),
	(17,'Wedge Antilles',170.00,77.00,'brown','21BBY','male','Corellia',NULL),
	(18,'Jek Tono Porkins',180.00,110.00,'brown',NULL,'male','Bestine IV',NULL),
	(19,'Yoda',66.00,17.00,'white','896BBY','male','unknown','Yoda\'s species'),
	(20,'Palpatine',170.00,75.00,'grey','82BBY','male','Naboo',NULL),
	(21,'Boba Fett',183.00,78.20,'black','31.5BBY','male','Kamino',NULL),
	(22,'IG-88',200.00,140.00,'none','15BBY','none','unknown','Droid'),
	(23,'Bossk',190.00,113.00,'none','53BBY','male','Trandosha','Trandoshan'),
	(24,'Lando Calrissian',177.00,79.00,'black','31BBY','male','Socorro',NULL),
	(25,'Lobot',175.00,79.00,'none','37BBY','male','Bespin',NULL),
	(26,'Ackbar',180.00,83.00,'none','41BBY','male','Mon Cala','Mon Calamari'),
	(27,'Mon Mothma',150.00,NULL,'auburn','48BBY','female','Chandrila',NULL),
	(28,'Arvel Crynyd',NULL,NULL,'brown',NULL,'male','unknown',NULL),
	(29,'Wicket Systri Warrick',88.00,20.00,'brown','8BBY','male','Endor','Ewok'),
	(30,'Nien Nunb',160.00,68.00,'none',NULL,'male','Sullust','Sullustan'),
	(31,'Qui-Gon Jinn',193.00,89.00,'brown','92BBY','male','unknown',NULL),
	(32,'Nute Gunray',191.00,90.00,'none',NULL,'male','Cato Neimoidia','Neimodian'),
	(33,'Finis Valorum',170.00,NULL,'blond','91BBY','male','Coruscant',NULL),
	(34,'Padmé Amidala',185.00,45.00,'brown','46BBY','female','Naboo',NULL),
	(35,'Jar Jar Binks',196.00,66.00,'none','52BBY','male','Naboo','Gungan'),
	(36,'Roos Tarpals',224.00,82.00,'none',NULL,'male','Naboo','Gungan'),
	(37,'Rugor Nass',206.00,NULL,'none',NULL,'male','Naboo','Gungan'),
	(38,'Ric Olié',183.00,NULL,'brown',NULL,'male','Naboo',NULL),
	(39,'Watto',137.00,NULL,'black',NULL,'male','Toydaria','Toydarian'),
	(40,'Sebulba',112.00,40.00,'none',NULL,'male','Malastare','Dug'),
	(41,'Quarsh Panaka',183.00,NULL,'black','62BBY','male','Naboo',NULL),
	(42,'Shmi Skywalker',163.00,NULL,'black','72BBY','female','Tatooine',NULL),
	(43,'Darth Maul',175.00,80.00,'none','54BBY','male','Dathomir','Zabrak'),
	(44,'Bib Fortuna',180.00,NULL,'none',NULL,'male','Ryloth','Twi\'lek'),
	(45,'Ayla Secura',178.00,55.00,'none','48BBY','female','Ryloth','Twi\'lek'),
	(46,'Ratts Tyerel',79.00,15.00,'none',NULL,'male','Aleen Minor','Aleena'),
	(47,'Dud Bolt',94.00,45.00,'none',NULL,'male','Vulpter','Vulptereen'),
	(48,'Gasgano',122.00,NULL,'none',NULL,'male','Troiken','Xexto'),
	(49,'Ben Quadinaros',163.00,65.00,'none',NULL,'male','Tund','Toong'),
	(50,'Mace Windu',188.00,84.00,'none','72BBY','male','Haruun Kal',NULL),
	(51,'Ki-Adi-Mundi',198.00,82.00,'white','92BBY','male','Cerea','Cerean'),
	(52,'Kit Fisto',196.00,87.00,'none',NULL,'male','Glee Anselm','Nautolan'),
	(53,'Eeth Koth',171.00,NULL,'black',NULL,'male','Iridonia','Zabrak'),
	(54,'Adi Gallia',184.00,50.00,'none',NULL,'female','Coruscant','Tholothian'),
	(55,'Saesee Tiin',188.00,NULL,'none',NULL,'male','Iktotch','Iktotchi'),
	(56,'Yarael Poof',264.00,NULL,'none',NULL,'male','Quermia','Quermian'),
	(57,'Plo Koon',188.00,80.00,'none','22BBY','male','Dorin','Kel Dor'),
	(58,'Mas Amedda',196.00,NULL,'none',NULL,'male','Champala','Chagrian'),
	(59,'Gregar Typho',185.00,85.00,'black',NULL,'male','Naboo',NULL),
	(60,'Cordé',157.00,NULL,'brown',NULL,'female','Naboo',NULL),
	(61,'Cliegg Lars',183.00,NULL,'brown','82BBY','male','Tatooine',NULL),
	(62,'Poggle the Lesser',183.00,80.00,'none',NULL,'male','Geonosis','Geonosian'),
	(63,'Luminara Unduli',170.00,56.20,'black','58BBY','female','Mirial','Mirialan'),
	(64,'Barriss Offee',166.00,50.00,'black','40BBY','female','Mirial','Mirialan'),
	(65,'Dormé',165.00,NULL,'brown',NULL,'female','Naboo','Human'),
	(66,'Dooku',193.00,80.00,'white','102BBY','male','Serenno','Human'),
	(67,'Bail Prestor Organa',191.00,NULL,'black','67BBY','male','Alderaan','Human'),
	(68,'Jango Fett',183.00,79.00,'black','66BBY','male','Concord Dawn',NULL),
	(69,'Zam Wesell',168.00,55.00,'blonde',NULL,'female','Zolan','Clawdite'),
	(70,'Dexter Jettster',198.00,102.00,'none',NULL,'male','Ojom','Besalisk'),
	(71,'Lama Su',229.00,88.00,'none',NULL,'male','Kamino','Kaminoan'),
	(72,'Taun We',213.00,NULL,'none',NULL,'female','Kamino','Kaminoan'),
	(73,'Jocasta Nu',167.00,NULL,'white',NULL,'female','Coruscant','Human'),
	(74,'R4-P17',96.00,NULL,'none',NULL,'female','unknown',NULL),
	(75,'Wat Tambor',193.00,48.00,'none',NULL,'male','Skako','Skakoan'),
	(76,'San Hill',191.00,NULL,'none',NULL,'male','Muunilinst','Muun'),
	(77,'Shaak Ti',178.00,57.00,'none',NULL,'female','Shili','Togruta'),
	(78,'Grievous',216.00,159.00,'none',NULL,'male','Kalee','Kaleesh'),
	(79,'Tarfful',234.00,136.00,'brown',NULL,'male','Kashyyyk','Wookie'),
	(80,'Raymus Antilles',188.00,79.00,'brown',NULL,'male','Alderaan',NULL),
	(81,'Sly Moore',178.00,48.00,'none',NULL,'female','Umbara',NULL),
	(82,'Tion Medon',206.00,80.00,'none',NULL,'male','Utapau','Pau\'an');

/*!40000 ALTER TABLE `swapi_characters` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
