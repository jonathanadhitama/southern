# ************************************************************
# Sequel Ace SQL dump
# Version 2101
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.5.6-MariaDB)
# Database: southern
# Generation Time: 2020-10-23 05:56:29 +0000
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
  `height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
	(1,'Luke Skywalker','172','77','blond','19BBY','male','Tatooine','n/a'),
	(2,'C-3PO','167','75','n/a','112BBY','n/a','Tatooine','Droid'),
	(3,'R2-D2','96','32','n/a','33BBY','n/a','Naboo','Droid'),
	(4,'Darth Vader','202','136','none','41.9BBY','male','Tatooine','n/a'),
	(5,'Leia Organa','150','49','brown','19BBY','female','Alderaan','n/a'),
	(6,'Owen Lars','178','120','brown, grey','52BBY','male','Tatooine','n/a'),
	(7,'Beru Whitesun lars','165','75','brown','47BBY','female','Tatooine','n/a'),
	(8,'R5-D4','97','32','n/a','unknown','n/a','Tatooine','Droid'),
	(9,'Biggs Darklighter','183','84','black','24BBY','male','Tatooine','n/a'),
	(10,'Obi-Wan Kenobi','182','77','auburn, white','57BBY','male','Stewjon','n/a'),
	(11,'Anakin Skywalker','188','84','blond','41.9BBY','male','Tatooine','n/a'),
	(12,'Wilhuff Tarkin','180','unknown','auburn, grey','64BBY','male','Eriadu','n/a'),
	(13,'Chewbacca','228','112','brown','200BBY','male','Kashyyyk','Wookie'),
	(14,'Han Solo','180','80','brown','29BBY','male','Corellia','n/a'),
	(15,'Greedo','173','74','n/a','44BBY','male','Rodia','Rodian'),
	(16,'Jabba Desilijic Tiure','175','1,358','n/a','600BBY','hermaphrodite','Nal Hutta','Hutt'),
	(17,'Wedge Antilles','170','77','brown','21BBY','male','Corellia','n/a'),
	(18,'Jek Tono Porkins','180','110','brown','unknown','male','Bestine IV','n/a'),
	(19,'Yoda','66','17','white','896BBY','male','unknown','Yoda\'s species'),
	(20,'Palpatine','170','75','grey','82BBY','male','Naboo','n/a'),
	(21,'Boba Fett','183','78.2','black','31.5BBY','male','Kamino','n/a'),
	(22,'IG-88','200','140','none','15BBY','none','unknown','Droid'),
	(23,'Bossk','190','113','none','53BBY','male','Trandosha','Trandoshan'),
	(24,'Lando Calrissian','177','79','black','31BBY','male','Socorro','n/a'),
	(25,'Lobot','175','79','none','37BBY','male','Bespin','n/a'),
	(26,'Ackbar','180','83','none','41BBY','male','Mon Cala','Mon Calamari'),
	(27,'Mon Mothma','150','unknown','auburn','48BBY','female','Chandrila','n/a'),
	(28,'Arvel Crynyd','unknown','unknown','brown','unknown','male','unknown','n/a'),
	(29,'Wicket Systri Warrick','88','20','brown','8BBY','male','Endor','Ewok'),
	(30,'Nien Nunb','160','68','none','unknown','male','Sullust','Sullustan'),
	(31,'Qui-Gon Jinn','193','89','brown','92BBY','male','unknown','n/a'),
	(32,'Nute Gunray','191','90','none','unknown','male','Cato Neimoidia','Neimodian'),
	(33,'Finis Valorum','170','unknown','blond','91BBY','male','Coruscant','n/a'),
	(34,'Padmé Amidala','185','45','brown','46BBY','female','Naboo','n/a'),
	(35,'Jar Jar Binks','196','66','none','52BBY','male','Naboo','Gungan'),
	(36,'Roos Tarpals','224','82','none','unknown','male','Naboo','Gungan'),
	(37,'Rugor Nass','206','unknown','none','unknown','male','Naboo','Gungan'),
	(38,'Ric Olié','183','unknown','brown','unknown','male','Naboo','n/a'),
	(39,'Watto','137','unknown','black','unknown','male','Toydaria','Toydarian'),
	(40,'Sebulba','112','40','none','unknown','male','Malastare','Dug'),
	(41,'Quarsh Panaka','183','unknown','black','62BBY','male','Naboo','n/a'),
	(42,'Shmi Skywalker','163','unknown','black','72BBY','female','Tatooine','n/a'),
	(43,'Darth Maul','175','80','none','54BBY','male','Dathomir','Zabrak'),
	(44,'Bib Fortuna','180','unknown','none','unknown','male','Ryloth','Twi\'lek'),
	(45,'Ayla Secura','178','55','none','48BBY','female','Ryloth','Twi\'lek'),
	(46,'Ratts Tyerel','79','15','none','unknown','male','Aleen Minor','Aleena'),
	(47,'Dud Bolt','94','45','none','unknown','male','Vulpter','Vulptereen'),
	(48,'Gasgano','122','unknown','none','unknown','male','Troiken','Xexto'),
	(49,'Ben Quadinaros','163','65','none','unknown','male','Tund','Toong'),
	(50,'Mace Windu','188','84','none','72BBY','male','Haruun Kal','n/a'),
	(51,'Ki-Adi-Mundi','198','82','white','92BBY','male','Cerea','Cerean'),
	(52,'Kit Fisto','196','87','none','unknown','male','Glee Anselm','Nautolan'),
	(53,'Eeth Koth','171','unknown','black','unknown','male','Iridonia','Zabrak'),
	(54,'Adi Gallia','184','50','none','unknown','female','Coruscant','Tholothian'),
	(55,'Saesee Tiin','188','unknown','none','unknown','male','Iktotch','Iktotchi'),
	(56,'Yarael Poof','264','unknown','none','unknown','male','Quermia','Quermian'),
	(57,'Plo Koon','188','80','none','22BBY','male','Dorin','Kel Dor'),
	(58,'Mas Amedda','196','unknown','none','unknown','male','Champala','Chagrian'),
	(59,'Gregar Typho','185','85','black','unknown','male','Naboo','n/a'),
	(60,'Cordé','157','unknown','brown','unknown','female','Naboo','n/a'),
	(61,'Cliegg Lars','183','unknown','brown','82BBY','male','Tatooine','n/a'),
	(62,'Poggle the Lesser','183','80','none','unknown','male','Geonosis','Geonosian'),
	(63,'Luminara Unduli','170','56.2','black','58BBY','female','Mirial','Mirialan'),
	(64,'Barriss Offee','166','50','black','40BBY','female','Mirial','Mirialan'),
	(65,'Dormé','165','unknown','brown','unknown','female','Naboo','Human'),
	(66,'Dooku','193','80','white','102BBY','male','Serenno','Human'),
	(67,'Bail Prestor Organa','191','unknown','black','67BBY','male','Alderaan','Human'),
	(68,'Jango Fett','183','79','black','66BBY','male','Concord Dawn','n/a'),
	(69,'Zam Wesell','168','55','blonde','unknown','female','Zolan','Clawdite'),
	(70,'Dexter Jettster','198','102','none','unknown','male','Ojom','Besalisk'),
	(71,'Lama Su','229','88','none','unknown','male','Kamino','Kaminoan'),
	(72,'Taun We','213','unknown','none','unknown','female','Kamino','Kaminoan'),
	(73,'Jocasta Nu','167','unknown','white','unknown','female','Coruscant','Human'),
	(74,'R4-P17','96','unknown','none','unknown','female','unknown','n/a'),
	(75,'Wat Tambor','193','48','none','unknown','male','Skako','Skakoan'),
	(76,'San Hill','191','unknown','none','unknown','male','Muunilinst','Muun'),
	(77,'Shaak Ti','178','57','none','unknown','female','Shili','Togruta'),
	(78,'Grievous','216','159','none','unknown','male','Kalee','Kaleesh'),
	(79,'Tarfful','234','136','brown','unknown','male','Kashyyyk','Wookie'),
	(80,'Raymus Antilles','188','79','brown','unknown','male','Alderaan','n/a'),
	(81,'Sly Moore','178','48','none','unknown','female','Umbara','n/a'),
	(82,'Tion Medon','206','80','none','unknown','male','Utapau','Pau\'an');

/*!40000 ALTER TABLE `swapi_characters` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
