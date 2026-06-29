-- MySQL dump 10.13  Distrib 8.4.10, for Linux (x86_64)
--
-- Host: localhost    Database: ace_intranet
-- ------------------------------------------------------
-- Server version	8.4.10-0ubuntu0.26.04.1

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
-- Table structure for table `Articulo`
--

DROP TABLE IF EXISTS `Articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Articulo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Modelo` varchar(25) NOT NULL,
  `Descripcion` varchar(150) DEFAULT NULL,
  `Costo` decimal(10,2) NOT NULL,
  `PrecioVenta` decimal(10,2) NOT NULL,
  `Peso` float DEFAULT NULL,
  `Stock` int NOT NULL,
  `Largo` float DEFAULT NULL,
  `Alto` float DEFAULT NULL,
  `Ancho` float DEFAULT NULL,
  `fk_id_unidad` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Articulo_Unidad_FK` (`fk_id_unidad`),
  CONSTRAINT `Articulo_Unidad_FK` FOREIGN KEY (`fk_id_unidad`) REFERENCES `Unidad` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articulo`
--

LOCK TABLES `Articulo` WRITE;
/*!40000 ALTER TABLE `Articulo` DISABLE KEYS */;
INSERT INTO `Articulo` VALUES (1,'DW44540','Disco para desbaste de metal de Ø4.5\" x 1/4\", A24R',15.50,22.00,0.5,20,11.5,11.5,0.6,1),(2,'DWE1622K','Taladro de base magnética de 1,200W, 300-450rpm',850.00,1250.00,14.5,5,40,30,15,1),(3,'D26414','Pistola de Calor de 2,000W, de 50 a 600°C con LCD',120.50,185.00,1.2,10,25,20,8,1),(4,'VC3210LX1','Aspiradora (Húmedo y Seco) de 2.0m³/min (Tanque 32L)',1550.00,2709.53,10.5,0,40,60,40,1),(5,'195250-1','Guarda para solaqueo de 5\" con conexión para aspiradora',150.00,244.08,0.8,5,15,15,5,1),(6,'D-36837','Disco diamantado continuo marmol de 4.5\" x 2.2mm',12.00,22.93,0.4,0,11.5,11.5,0.2,1),(7,'VC2510LX1','Aspiradora (Húmedo y Seco) de 2.0m³/min (Tanque 25L)',1280.00,2408.31,9,1,38,55,38,1),(8,'VC1310LX1','Aspiradora (Húmedo y Seco) de 2.0m³/min (Tanque 13L)',1100.00,2107.08,7.5,0,35,45,35,1),(9,'BCG180ZB','Pistola de Calafatear de 18V, cap 310-600ml',450.00,750.00,2.5,0,45,20,10,1),(11,'HP1630K','Taladro Percutor 1/2\" 710W con estuche',200.00,320.50,2.1,30,28,20,8,1),(12,'DWD112','Taladro VVR 3/8\" 7.0 Amps',180.00,275.00,1.8,18,25,18,7,1),(13,'GWS670','Miniesmeriladora 4.5\" 670W',160.00,250.00,1.5,38,26,10,10,1),(14,'GSR12V-15','Atornillador Inalámbrico 12V Max',280.00,410.00,0.9,17,17,18,5,1),(15,'GBH2-24D','Rotomartillo SDS Plus 820W',550.00,820.00,2.8,12,36,21,8,1),(16,'2704','Sierra de Banco 10\" 1650W',2100.00,3200.00,30,0,71,38,75,1),(17,'LS1040','Sierra Ingletadora 10\" 1650W',1100.00,1650.00,11,0,53,53,47,1),(18,'DWE302','Sierra Sable 1050W',450.00,700.00,3.2,0,45,15,10,1),(19,'DCF885B','Llave de Impacto 20V Max (Solo herramienta)',380.00,590.00,1.2,14,15,20,6,1),(20,'4350FCT','Sierra Caladora 720W con luz LED',420.00,680.00,2.6,9,23,20,7,1),(22,'DWD112','Taladro VVR 3/8\" 7.0 Amps',180.00,500.00,1.8,18,25,18,7,1),(25,'sadasd','asdaasdasd',123.00,123.00,123,100,123,123,123,8);
/*!40000 ALTER TABLE `Articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Boleta`
--

DROP TABLE IF EXISTS `Boleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Boleta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Dias_Laborados` tinyint NOT NULL,
  `Prima_Seguro` float DEFAULT NULL,
  `Sueldo_Neto` float NOT NULL,
  `Total_Horas` int NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Sueldo_Bruto` float NOT NULL,
  `fk_id_personal` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Boleta_Personal_FK` (`fk_id_personal`),
  CONSTRAINT `Boleta_Personal_FK` FOREIGN KEY (`fk_id_personal`) REFERENCES `Personal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Boleta`
--

LOCK TABLES `Boleta` WRITE;
/*!40000 ALTER TABLE `Boleta` DISABLE KEYS */;
INSERT INTO `Boleta` VALUES (1,20,150.5,2800,160,'2024-02-04',3000,11),(2,22,140,3200,176,'2026-09-13',3400,20),(3,18,120,2100,144,'2023-07-14',2300,15),(4,25,180,4100,200,'2023-10-09',4400,17),(5,21,135,2900,168,'2024-11-16',3100,19),(6,20,150.5,2800,160,'2023-09-29',3000,4),(7,22,140,3200,176,'2024-03-28',3400,1),(8,18,120,2100,144,'2023-11-14',2300,20),(9,25,180,4100,200,'2024-05-17',4400,15),(10,21,135,2900,168,'2025-05-01',3100,15),(11,20,150.5,2800,160,'2026-12-10',3000,14),(12,22,140,3200,176,'2024-12-10',3400,8),(13,18,120,2100,144,'2024-06-07',2300,15),(14,25,180,4100,200,'2024-09-23',4400,2),(15,21,135,2900,168,'2026-12-22',3100,16),(16,20,150.5,2800,160,'2026-12-19',3000,12),(17,22,140,3200,176,'2026-08-05',3400,16),(18,18,120,2100,144,'2023-08-07',2300,9),(19,25,180,4100,200,'2025-12-31',4400,9),(20,21,135,2900,168,'2026-08-18',3100,5),(21,20,150.5,2800,160,'2024-12-28',3000,16),(22,22,140,3200,176,'2024-03-08',3400,5),(23,18,120,2100,144,'2023-07-31',2300,3),(24,25,180,4100,200,'2023-05-07',4400,3),(25,21,135,2900,168,'2024-05-20',3100,8),(26,20,150.5,2800,160,'2026-03-04',3000,18),(27,22,140,3200,176,'2026-11-03',3400,4),(28,18,120,2100,144,'2023-06-11',2300,20),(29,25,180,4100,200,'2024-10-23',4400,8),(30,21,135,2900,168,'2025-06-17',3100,18),(31,20,150.5,2800,160,'2025-06-17',3000,8),(32,22,140,3200,176,'2023-08-06',3400,11),(33,18,120,2100,144,'2024-02-27',2300,17),(34,25,180,4100,200,'2023-08-17',4400,8),(35,21,135,2900,168,'2024-06-21',3100,15),(37,22,140,3200,176,'2026-10-18',3400,11),(38,18,120,2100,144,'2025-11-02',2300,1),(39,25,180,4100,200,'2026-10-13',4400,14),(40,21,135,2900,168,'2025-05-05',3100,18),(41,20,150.5,2800,160,'2025-06-29',3000,10),(42,22,140,3200,176,'2025-04-09',3400,8),(43,18,120,2100,144,'2023-10-03',2300,17),(44,25,180,4100,200,'2024-11-25',4400,20),(45,21,135,2900,168,'2024-04-28',3100,17),(46,20,150.5,2800,160,'2023-01-25',3000,14),(48,18,120,2100,144,'2023-08-18',2300,18),(49,25,180,4100,200,'2026-12-25',4400,7),(50,21,135,2900,168,'2025-01-23',3100,14),(51,12,12,12,12,'2026-06-05',12,1),(53,20,200,1300,120,'2026-06-01',1500,22),(54,3,10,90,8,'2026-06-24',100,22);
/*!40000 ALTER TABLE `Boleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lista_Articulos`
--

DROP TABLE IF EXISTS `Lista_Articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Lista_Articulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_id_articulo` int NOT NULL,
  `fk_id_Ventas` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Lista_Articulos_Articulo_FK` (`fk_id_articulo`),
  KEY `Lista_Articulos_Ventas_FK` (`fk_id_Ventas`),
  CONSTRAINT `Lista_Articulos_Articulo_FK` FOREIGN KEY (`fk_id_articulo`) REFERENCES `Articulo` (`id`),
  CONSTRAINT `Lista_Articulos_Ventas_FK` FOREIGN KEY (`fk_id_Ventas`) REFERENCES `Ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lista_Articulos`
--

LOCK TABLES `Lista_Articulos` WRITE;
/*!40000 ALTER TABLE `Lista_Articulos` DISABLE KEYS */;
INSERT INTO `Lista_Articulos` VALUES (20,25,10,38),(21,1,10,4),(22,5,11,3),(23,1,11,4),(25,18,12,6);
/*!40000 ALTER TABLE `Lista_Articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Permisos`
--

DROP TABLE IF EXISTS `Permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Slug` varchar(100) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Habilitado` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permisos`
--

LOCK TABLES `Permisos` WRITE;
/*!40000 ALTER TABLE `Permisos` DISABLE KEYS */;
INSERT INTO `Permisos` VALUES (1,'Crear Venta','ventas-create','Permite registrar nuevas ventas en el sistema',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(2,'Ver Ventas','ventas-index','Permite visualizar el listado de ventas',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(3,'Editar Venta','ventas-edit','Permite modificar los datos de una venta existente',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(4,'Gestionar Inventario','inventario-crud','Acceso total para gestionar artículos y stock',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(5,'Gestionar Facturas','facturas-crud','Acceso total para crear, ver, editar y eliminar facturas',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(6,'Gestionar Boletas','boletas-crud','Acceso total para gestionar boletas de pago',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(7,'Acceso Total','admin-all','Permiso especial para el administrador con acceso a todo el sistema',1,'2026-06-28 01:02:31','2026-06-28 01:02:31'),(8,'Vista en todo','all-vistas','Acceso a todas las vistas del sistema, no puede modificar nada',1,'2026-06-28 01:02:31','2026-06-28 01:02:31');
/*!40000 ALTER TABLE `Permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Personal`
--

DROP TABLE IF EXISTS `Personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Personal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre_1` varchar(100) NOT NULL,
  `Nombre_2` varchar(100) DEFAULT NULL,
  `Apellido_1` varchar(100) NOT NULL,
  `Apellido_2` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `Codigo_Documento` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fk_id_tipo_documento` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Personal_Tipo_Documento_FK` (`fk_id_tipo_documento`),
  CONSTRAINT `Personal_Tipo_Documento_FK` FOREIGN KEY (`fk_id_tipo_documento`) REFERENCES `Tipo_Documento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Personal`
--

LOCK TABLES `Personal` WRITE;
/*!40000 ALTER TABLE `Personal` DISABLE KEYS */;
INSERT INTO `Personal` VALUES (1,'Juan','Carlos','Perez','Gomez','912345678','70000001',1),(2,'Maria','Elena','Rodriguez','Lopez','923456789','80000001',2),(3,'Luis','Alberto','Garcia','Martinez','934567890','70000002',1),(4,'Ana','Sofia','Hernandez','Diaz','945678901','90000001',3),(5,'Pedro','Jose','Torres','Ramirez','956789012','70000003',1),(6,'Laura','Isabel','Flores','Vargas','967890123','80000002',2),(7,'Jorge','Luis','Castillo','Ruiz','978901234','70000004',1),(8,'Carmen','Rosa','Mendoza','Soto','989012345','90000002',3),(9,'Miguel','Angel','Ortega','Rojas','990123456','70000005',1),(10,'Lucia','Fernanda','Morales','Paredes','901234567','80000003',2),(11,'Ricardo','Antonio','Salazar','Jimenez','911234567','70000006',1),(12,'Patricia','Beatriz','Aguilar','Cabrera','922345678','95000001',4),(13,'Diego','Alejandro','Vargas','Muñoz','933456789','70000007',1),(14,'Elena','Marcela','Ramos','Guerrero','944567890','80000004',2),(15,'Victor','Manuel','Reyes','Castillo','955678901','70000008',1),(16,'Sandra','Milena','Herrera','Cortes','966789012','90000003',3),(17,'Javier','Ignacio','Gomez','Silva','977890123','70000009',1),(18,'Valeria','Andrea','López','Ríos','988901234','80000005',2),(19,'Fernando','David','Suarez','Molina','999012345','70000010',1),(20,'Camila','Fernanda','Pineda','Salgado','900123456','95000002',4),(21,'Camila','Camila','Camila','Camila','969340057','00120291221',4),(22,'Diego','Rodrigo','Fernandez','Herrera','986046778','72658838',1);
/*!40000 ALTER TABLE `Personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Rol` varchar(100) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,'Administrador','Usuario con privilegios totales sobre el sistema; acceso completo a todos los módulos, configuraciones y funciones de administración.'),(2,'Personal de Ventas','Encargado de la gestión comercial; permite crear, visualizar y editar registros de ventas, sin permisos para eliminar transacciones.'),(3,'Logistico','Responsable del control de inventarios; facultad completa (CRUD) para gestionar, actualizar y monitorear la existencia de artículos en almacén.'),(4,'Contabilidad','Gestión administrativa y financiera; permite realizar todas las operaciones (CRUD) sobre las facturas y comprobantes emitidos por el negocio.'),(5,'Recursos Humanos','Administración de personal; acceso total (CRUD) para la gestión, registro y modificación de boletas de pago de los colaboradores.');
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles_Permisos`
--

DROP TABLE IF EXISTS `Roles_Permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roles_Permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_id_rol` int NOT NULL,
  `fk_id_permiso` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Roles_Permisos_Roles_FK` (`fk_id_rol`),
  KEY `Roles_Permisos_Permisos_FK` (`fk_id_permiso`),
  CONSTRAINT `Roles_Permisos_Permisos_FK` FOREIGN KEY (`fk_id_permiso`) REFERENCES `Permisos` (`id`),
  CONSTRAINT `Roles_Permisos_Roles_FK` FOREIGN KEY (`fk_id_rol`) REFERENCES `Roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles_Permisos`
--

LOCK TABLES `Roles_Permisos` WRITE;
/*!40000 ALTER TABLE `Roles_Permisos` DISABLE KEYS */;
INSERT INTO `Roles_Permisos` VALUES (1,1,7,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(2,2,1,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(3,2,2,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(4,2,3,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(5,3,4,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(6,4,5,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(7,4,8,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(8,5,6,'2026-06-28 01:11:53','2026-06-28 01:11:53'),(9,5,8,'2026-06-28 01:11:53','2026-06-28 01:11:53');
/*!40000 ALTER TABLE `Roles_Permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tipo_Documento`
--

DROP TABLE IF EXISTS `Tipo_Documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tipo_Documento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Documento` varchar(100) NOT NULL,
  `Nacionalidad` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tipo_Documento`
--

LOCK TABLES `Tipo_Documento` WRITE;
/*!40000 ALTER TABLE `Tipo_Documento` DISABLE KEYS */;
INSERT INTO `Tipo_Documento` VALUES (1,'DNI','Peruano'),(2,'Carnet de Extranjería','Extranjero'),(3,'Pasaporte','Extranjero'),(4,'PTP','Extranjero');
/*!40000 ALTER TABLE `Tipo_Documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Unidad`
--

DROP TABLE IF EXISTS `Unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Unidad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Unidad` varchar(20) NOT NULL,
  `Sigla` varchar(15) DEFAULT NULL,
  `Descripcion` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Unidad`
--

LOCK TABLES `Unidad` WRITE;
/*!40000 ALTER TABLE `Unidad` DISABLE KEYS */;
INSERT INTO `Unidad` VALUES (1,'Unidad','und','Unidad de venta simple'),(2,'Caja','cj','Caja de cartón cerrada'),(3,'Paquete','paq','Paquete o bulto'),(4,'Docena','doc','Conjunto de 12 unidades'),(5,'Juego','jgo','Kit o set de piezas'),(6,'Par','par','Conjunto de dos unidades'),(7,'Kilogramo','kg','Unidad de peso estándar'),(8,'Gramo','g','Peso en gramos'),(9,'Tonelada','tn','Unidad de carga pesada'),(10,'Metro','m','Longitud lineal'),(11,'Centímetro','cm','Longitud pequeña'),(12,'Milímetro','mm','Precisión mecánica'),(13,'Pulgada','in','Medida estandarizada'),(14,'Litro','L','Capacidad de líquidos'),(15,'Mililitro','ml','Capacidad pequeña'),(16,'Galón','gal','Capacidad en galones'),(17,'Metro cuadrado','m2','Superficie'),(18,'Metro cúbico','m3','Volumen');
/*!40000 ALTER TABLE `Unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_id_personal` int NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Habilitado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Usuarios_UNIQUE` (`Email`,`Username`),
  KEY `Usuarios_Personal_FK` (`fk_id_personal`),
  CONSTRAINT `Usuarios_Personal_FK` FOREIGN KEY (`fk_id_personal`) REFERENCES `Personal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (1,1,'juan.perez@empresa.com','hashed_password_1','jperez',1),(2,2,'maria.rodriguez@empresa.com','hashed_password_2','mrodriguez',1),(3,3,'luis.garcia@empresa.com','hashed_password_3','lgarcia',1),(4,4,'ana.hernandez@empresa.com','hashed_password_4','ahernandez',1),(5,5,'pedro.torres@empresa.com','hashed_password_5','ptorres',1),(6,6,'laura.flores@empresa.com','hashed_password_6','lflores',0),(8,8,'carmen.mendoza@empresa.com','hashed_password_8','cmendoza',1),(9,9,'miguel.ortega@empresa.com','hashed_password_9','mortega',1),(10,10,'lucia.morales@empresa.com','hashed_password_10','lmorales',1),(11,11,'ricardo.salazar@empresa.com','hashed_password_11','rsalazar',1),(12,12,'patricia.aguilar@empresa.com','hashed_password_12','paguilar',1),(28,18,'valeria_prueba@gmail.com','$2y$12$PNEbgYaQXE6kW50huJZBs.30th383/PemQIUMCv1SLhytFF7jcYSC','valeriaPrueba',1),(31,22,'diegox2912@gmail.com','$2y$12$g5oNKhjrimb0k109gA67f.lAWsPJ0bJ14g/9rR00km59.AaQz2fOG','diegox2912',1),(32,22,'admin@gmail.com','$2y$12$D5JDPyrxMEspHwbSkgWGGOTi/IDWnaEl.HmDwR7gvf/iCNxPBIqye','admin',1),(33,1,'juan@gmail.com','$2y$12$T9uOeYTIAsNJ9nxEWCjdV.wZ.FGMujt/vzHg8Cn9yU1kAF4VSwqGm','juan',1);
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios_Roles`
--

DROP TABLE IF EXISTS `Usuarios_Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios_Roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_id_usuario` int NOT NULL,
  `fk_id_rol` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Usuarios_Roles_Usuarios_FK` (`fk_id_usuario`),
  KEY `Usuarios_Roles_Roles_FK` (`fk_id_rol`),
  CONSTRAINT `Usuarios_Roles_Roles_FK` FOREIGN KEY (`fk_id_rol`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `Usuarios_Roles_Usuarios_FK` FOREIGN KEY (`fk_id_usuario`) REFERENCES `Usuarios` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios_Roles`
--

LOCK TABLES `Usuarios_Roles` WRITE;
/*!40000 ALTER TABLE `Usuarios_Roles` DISABLE KEYS */;
INSERT INTO `Usuarios_Roles` VALUES (1,1,1),(2,2,2),(3,3,2),(4,4,2),(5,5,3),(8,8,4),(9,9,4),(10,10,4),(11,11,5),(12,12,5),(43,28,5),(44,31,1),(45,6,3),(46,32,1),(47,33,3);
/*!40000 ALTER TABLE `Usuarios_Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ventas`
--

DROP TABLE IF EXISTS `Ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre_Cliente` varchar(150) NOT NULL,
  `fk_personal_Vendedor` int NOT NULL,
  `Fecha_Emision` date NOT NULL,
  `Fecha_Entrega` date NOT NULL,
  `Fecha_Cobro` date DEFAULT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `MontoCancelado` decimal(10,2) NOT NULL,
  `Cuotas` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Ventas_Personal_FK` (`fk_personal_Vendedor`),
  CONSTRAINT `Ventas_Personal_FK` FOREIGN KEY (`fk_personal_Vendedor`) REFERENCES `Personal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ventas`
--

LOCK TABLES `Ventas` WRITE;
/*!40000 ALTER TABLE `Ventas` DISABLE KEYS */;
INSERT INTO `Ventas` VALUES (10,'Churreria Ventus',2,'2026-06-27','2026-06-28','2026-08-15',4762.00,5619.16,5619.16,1),(11,'PRUEBA',22,'2026-06-27','2026-06-30','2026-07-31',820.24,967.88,0.00,1),(12,'ACE',22,'2026-06-27','2026-06-28','2026-07-17',4200.00,4956.00,4956.00,1);
/*!40000 ALTER TABLE `Ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ace_intranet'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-29 15:26:26
