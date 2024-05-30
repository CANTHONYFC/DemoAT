-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: demoat
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `account_bank`
--

DROP TABLE IF EXISTS `account_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_bank` (
  `id_account_bank` int(11) NOT NULL AUTO_INCREMENT,
  `account_number` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `estado_reg` int(11) DEFAULT NULL,
  `ruc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_account_bank`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_bank`
--

LOCK TABLES `account_bank` WRITE;
/*!40000 ALTER TABLE `account_bank` DISABLE KEYS */;
INSERT INTO `account_bank` VALUES (1,'20119292032','BCP',1,'1029202022'),(2,'20666666032','BBVA',1,'2029202022');
/*!40000 ALTER TABLE `account_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_diccionare`
--

DROP TABLE IF EXISTS `master_diccionare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_diccionare` (
  `id_master_diccionare` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(3) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `estado_reg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_master_diccionare`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_diccionare`
--

LOCK TABLES `master_diccionare` WRITE;
/*!40000 ALTER TABLE `master_diccionare` DISABLE KEYS */;
INSERT INTO `master_diccionare` VALUES (1,'CAN','Whattsap',1),(2,'CAN','Facebook',1),(3,'CAN','Telefonica',1);
/*!40000 ALTER TABLE `master_diccionare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person` (
  `id_person` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `type_person` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id_person`),
  UNIQUE KEY `player_unique` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (1,'71541899','993430563','criws@gmail.com','Cristopher Anthony','Falcon Ulpiano','0'),(3,'98899822','993430563','silver@gmail.com','Rafael Silver','Falcon Campos','1'),(5,'89927777','993430563','stalone@gmail.com','Franchesco Ulpiano','Rebaguiati','1');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer`
--

DROP TABLE IF EXISTS `transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfer` (
  `id_transfer` int(11) NOT NULL AUTO_INCREMENT,
  `id_responsable` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_user` varchar(100) DEFAULT NULL,
  `update_user` varchar(100) DEFAULT NULL,
  `estado_reg` varchar(100) DEFAULT NULL,
  `url_voucher` varchar(500) DEFAULT NULL,
  `type_canal` int(2) DEFAULT NULL,
  `id_person` int(11) DEFAULT NULL,
  `mount` decimal(10,2) DEFAULT NULL,
  `id_account_bank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_transfer`),
  KEY `transfer_account_bank_FK` (`id_account_bank`),
  KEY `transfer_person_FK` (`id_person`),
  CONSTRAINT `transfer_account_bank_FK` FOREIGN KEY (`id_account_bank`) REFERENCES `account_bank` (`id_account_bank`),
  CONSTRAINT `transfer_person_FK` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer`
--

LOCK TABLES `transfer` WRITE;
/*!40000 ALTER TABLE `transfer` DISABLE KEYS */;
INSERT INTO `transfer` VALUES (19,1,'2024-05-30 07:15:50','2024-05-30 07:15:50','1',NULL,'1','../uploads/CV-08-05-2024 (1)_1717048937112 (1)_1717053350294.pdf',1,3,230.00,1);
/*!40000 ALTER TABLE `transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer_log`
--

DROP TABLE IF EXISTS `transfer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfer_log` (
  `id_transfer_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_transfer` int(11) DEFAULT NULL,
  `create_date` varchar(100) DEFAULT NULL,
  `create_user` varchar(100) DEFAULT NULL,
  `url_voucher` varchar(500) DEFAULT NULL,
  `type_canal` int(2) DEFAULT NULL,
  `mount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_transfer_log`),
  KEY `transfer_log_transfer_FK` (`id_transfer`),
  CONSTRAINT `transfer_log_transfer_FK` FOREIGN KEY (`id_transfer`) REFERENCES `transfer` (`id_transfer`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer_log`
--

LOCK TABLES `transfer_log` WRITE;
/*!40000 ALTER TABLE `transfer_log` DISABLE KEYS */;
INSERT INTO `transfer_log` VALUES (25,19,'2024-05-30 02:15:50','1','../uploads/CV-08-05-2024 (1)_1717048937112 (1)_1717053350294.pdf',1,230.00);
/*!40000 ALTER TABLE `transfer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_users` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `estado_reg` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  KEY `users_person_FK` (`id_person`),
  CONSTRAINT `users_person_FK` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'criws@gmail.com','cd08250927333b8351ef3dfe465180fac68056fc1a543d8e07dfb8b248af7808',1),(2,3,'silver@gmail.com','cd08250927333b8351ef3dfe465180fac68056fc1a543d8e07dfb8b248af7808',1),(3,5,'stalone@gmail.com','cd08250927333b8351ef3dfe465180fac68056fc1a543d8e07dfb8b248af7808',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'demoat'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_history` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_history`(IN p_id_transfer INT)
begin
select 
p2.name as namePerson,
p2.last_name as lastnamePerson,
p.name as nameResponsable,
p.last_name as lastnameResponsable,
tl.create_date,
tl.create_user,
tl.url_voucher,
md.value as canalName,
tl.mount
from transfer_log tl
left join users u on u.id_users=tl.create_user 
left join person p on p.id_person=u.id_person
left join transfer t on t.id_transfer =tl.id_transfer 
left join person p2 on p2.id_person =t.id_person 
left join master_diccionare md on md.id_master_diccionare=tl.type_canal
where tl.id_transfer =p_id_transfer
order by tl.create_date;
 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_transfer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transfer`(IN p_id_transfer INT)
begin
	select 
t.id_transfer,
t.id_responsable,
t.create_date,
t.update_date,
t.create_user,
t.update_user,
t.estado_reg,
t.url_voucher,
t.type_canal,
t.id_person,
t.mount,
t.id_account_bank
from transfer t where t.id_transfer=p_id_transfer;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `list_account_numbers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `list_account_numbers`()
begin
	select id_account_bank,
account_number,
name,
estado_reg,
ruc from account_bank ab where ab.estado_reg =1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `list_channel` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `list_channel`()
begin
select id_master_diccionare,
type,
value,
estado_reg from master_diccionare md  where `type` ='CAN' and estado_reg =1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `list_client` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `list_client`()
begin
	select id_person,
dni,
phone,
email,
name,
last_name,
type_person from person p where p.type_person=1 ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `list_transfer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `list_transfer`()
begin
select 
t.id_transfer,
t.id_responsable,
p.name as namePerson,
p.last_name as lastnamePerson,
p2.name as nameResponsable,
p2.last_name as lastnameResponsable,
t.create_date,
t.update_date,
t.create_user,
t.update_user,
t.estado_reg,
t.url_voucher,
t.type_canal,
md.value as canalName,
t.id_person,
t.mount
from transfer t 
inner join person p on p.id_person =t.id_person 
inner join person p2 on p2.id_person =t.id_responsable
inner join master_diccionare md on md.id_master_diccionare=t.type_canal;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `list_transfer_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `list_transfer_user`(in p_person INT)
BEGIN
select 
t.id_transfer,
t.id_responsable,
p.name as namePerson,
p.last_name as lastnamePerson,
p2.name as nameResponsable,
p2.last_name as lastnameResponsable,
t.create_date,
t.update_date,
t.create_user,
t.update_user,
t.estado_reg,
t.url_voucher,
t.type_canal,
md.value as canalName,
t.id_person,
t.mount
from transfer t 
inner join person p on p.id_person =t.id_person 
inner join person p2 on p2.id_person =t.id_responsable
inner join master_diccionare md on md.id_master_diccionare=t.type_canal
where t.id_person=p_person;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `save_transferencia` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `save_transferencia`(
IN p_idclient INT,
IN p_idchannel INT,
IN p_mount DECIMAL(10,2),
IN p_urlvouche VARCHAR(255),
IN p_id_responsable INT,
IN p_user_create INT,
IN p_account_bank INT
)
begin
	INSERT INTO transfer ( id_responsable, create_date, update_date,
create_user, estado_reg, url_voucher, type_canal, id_person, mount, id_account_bank)
VALUES(p_id_responsable, current_timestamp(), current_timestamp(), p_user_create,1, p_urlvouche, 
p_idchannel, p_idclient, p_mount, p_account_bank);

SET @last_transfer_id = LAST_INSERT_ID();

INSERT INTO transfer_log (id_transfer, create_date, create_user, url_voucher, type_canal,mount)
VALUES( @last_transfer_id , current_timestamp(),  p_user_create, p_urlvouche, p_idchannel,p_mount);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `update_transfer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_transfer`(
IN p_id_transfer INT,
IN p_idchannel INT,
IN p_mount DECIMAL(10,2),
IN p_urlvouche VARCHAR(255),
IN p_id_responsable INT,
IN p_user_create INT,
IN p_account_bank INT
)
begin
	DECLARE transfer_url VARCHAR(255);
 	IF p_urlvouche IS NULL THEN
        -- Obtener la URL del comprobante de la tabla transfer
        SELECT url_voucher INTO transfer_url FROM transfer WHERE id_transfer = p_id_transfer;
    ELSE
        SET transfer_url = p_urlvouche; -- Usar la URL proporcionada en p_urlvouche
    END IF;
	UPDATE transfer
    SET
        id_responsable = p_id_responsable,
        update_date = CURRENT_TIMESTAMP(),
        update_user = p_user_create,
        url_voucher = IFNULL(p_urlvouche, url_voucher),
        type_canal = p_idchannel,
        mount = p_mount,
        id_account_bank = p_account_bank
    WHERE
        id_transfer = p_id_transfer;
       
       
       INSERT INTO transfer_log (
        id_transfer,
        create_date,
        create_user,
        url_voucher,
        type_canal,
        mount
    ) VALUES (
        p_id_transfer,
        CURRENT_TIMESTAMP(),
        p_user_create,
        transfer_url,
        p_idchannel,
        p_mount
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `validate_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `validate_user`(IN p_usuario VARCHAR(50), IN p_password VARCHAR(255))
begin
	   select u.id_users,
		p.id_person,
		p.dni,
		p.phone,
		p.email,
		p.name,
		p.last_name,
		p.type_person
		 from users u  inner join person p on u.id_person =p.id_person 
		 where u.username=p_usuario
		    and u.password=p_password;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-30  2:22:50
