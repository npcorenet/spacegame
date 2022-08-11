-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.3.35-MariaDB-1:10.3.35+maria~focal-log - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db.Account
CREATE TABLE IF NOT EXISTS `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `experience` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 1,
  `premium` datetime DEFAULT NULL,
  `registered` datetime NOT NULL DEFAULT current_timestamp(),
  `isAdmin` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Account: ~0 rows (approximately)

-- Dumping structure for table db.AccountToken
CREATE TABLE IF NOT EXISTS `AccountToken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validUntil` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`userId`),
  CONSTRAINT `user` FOREIGN KEY (`userId`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.AccountToken: ~0 rows (approximately)

-- Dumping structure for table db.BankAccount
CREATE TABLE IF NOT EXISTS `BankAccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `money` int(11) NOT NULL DEFAULT 50000,
  `address` varchar(100) NOT NULL,
  `name` varchar(128) NOT NULL,
  `dailyMax` int(11) NOT NULL DEFAULT 25000,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `defaultAccount` tinyint(4) NOT NULL,
  `debtAllowed` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `accountOwner` (`user`),
  CONSTRAINT `accountOwner` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.BankAccount: ~0 rows (approximately)

-- Dumping structure for table db.Contract
CREATE TABLE IF NOT EXISTS `Contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `availableFrom` datetime NOT NULL DEFAULT current_timestamp(),
  `availableUntil` datetime NOT NULL,
  `maxDuration` int(11) NOT NULL,
  `minimumLevel` int(11) NOT NULL,
  `prePayment` int(11) NOT NULL,
  `reward` int(11) NOT NULL,
  `byUser` int(11) NOT NULL,
  `userLimit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `byUser` (`byUser`),
  CONSTRAINT `byUser` FOREIGN KEY (`byUser`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Contract: ~0 rows (approximately)

-- Dumping structure for table db.ContractAccount
CREATE TABLE IF NOT EXISTS `ContractAccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL,
  `contract` int(11) NOT NULL,
  `started` datetime NOT NULL,
  `expires` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `success` tinyint(4) NOT NULL,
  `expenses` int(11) NOT NULL,
  `expensesLimit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contractAccount` (`user`),
  KEY `contractId` (`contract`),
  KEY `contractVehicle` (`vehicle`),
  CONSTRAINT `contractAccount` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contractId` FOREIGN KEY (`contract`) REFERENCES `Contract` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contractVehicle` FOREIGN KEY (`vehicle`) REFERENCES `Vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.ContractAccount: ~0 rows (approximately)

-- Dumping structure for table db.Launch
CREATE TABLE IF NOT EXISTS `Launch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL,
  `satellite` int(11) NOT NULL,
  `contract` int(11) NOT NULL,
  `targetTime` datetime NOT NULL,
  `liftoff` datetime NOT NULL,
  `complete` tinyint(4) NOT NULL,
  `success` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `launchUser` (`user`),
  KEY `launchVehicle` (`vehicle`),
  KEY `launchSatellite` (`satellite`),
  KEY `launchContract` (`contract`),
  CONSTRAINT `launchContract` FOREIGN KEY (`contract`) REFERENCES `ContractAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `launchSatellite` FOREIGN KEY (`satellite`) REFERENCES `Satellite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `launchUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `launchVehicle` FOREIGN KEY (`vehicle`) REFERENCES `Vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Launch: ~0 rows (approximately)

-- Dumping structure for table db.Location
CREATE TABLE IF NOT EXISTS `Location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `completed` datetime NOT NULL,
  `lastLaunch` datetime NOT NULL,
  `inclinationMin` int(11) NOT NULL,
  `inclinationMax` int(11) NOT NULL,
  `fuelLevel` int(11) NOT NULL,
  `stabilityLevel` int(11) NOT NULL,
  `sizeLevel` int(11) NOT NULL,
  `crewLevel` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `LocationUser` (`user`),
  CONSTRAINT `LocationUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Location: ~0 rows (approximately)

-- Dumping structure for table db.LoginHistory
CREATE TABLE IF NOT EXISTS `LoginHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `loginUser` (`user`),
  CONSTRAINT `loginUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.LoginHistory: ~0 rows (approximately)

-- Dumping structure for table db.Planet
CREATE TABLE IF NOT EXISTS `Planet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solarSystem` int(11) NOT NULL,
  `moon` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `mass` float NOT NULL,
  `radius` int(11) NOT NULL,
  `distance` float NOT NULL,
  `atmosphereHeight` int(11) NOT NULL,
  `atmosphereDensity` float NOT NULL,
  `oxygen` tinyint(4) NOT NULL,
  `solidSurface` tinyint(4) NOT NULL DEFAULT 1,
  `coreTemperature` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `planetSolarSystem` (`solarSystem`),
  KEY `planetMoon` (`moon`),
  CONSTRAINT `planetMoon` FOREIGN KEY (`moon`) REFERENCES `Planet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `planetSolarSystem` FOREIGN KEY (`solarSystem`) REFERENCES `SolarSystem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Planet: ~7 rows (approximately)
INSERT INTO `Planet` (`id`, `solarSystem`, `moon`, `name`, `mass`, `radius`, `distance`, `atmosphereHeight`, `atmosphereDensity`, `oxygen`, `solidSurface`, `coreTemperature`) VALUES
	(1, 1, NULL, 'mercury', 0.055, 2439, 0.4, 0, 0, 0, 1, 440),
	(2, 1, NULL, 'venus', 0.815, 6051, 0.7, 250, 67, 0, 1, 737),
	(3, 1, NULL, 'earth', 1, 6371, 1, 100, 1.2041, 1, 1, 4850),
	(4, 1, 3, 'moon', 0.0123, 1737, 0.002569, 0, 0, 0, 1, 1873),
	(5, 1, NULL, 'mars', 0.107, 3389, 1.5303, 11, 0.02, 0, 1, 1305),
	(6, 1, NULL, 'jupiter', 317.8, 69911, 4.2, 50, 1.33, 0, 1, 20000),
	(7, 1, 6, 'Io', 0.015, 1821, 2.8209, 15, 3.55, 0, 1, 1973);

-- Dumping structure for table db.Satellite
CREATE TABLE IF NOT EXISTS `Satellite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `planet` int(11) DEFAULT NULL,
  `solarSystem` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `inOrbit` tinyint(4) NOT NULL,
  `inclination` int(11) NOT NULL,
  `periapsis` int(11) NOT NULL,
  `apoapsis` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `satelliteUser` (`user`),
  KEY `satelliteType` (`type`),
  KEY `satellitePlanet` (`planet`),
  KEY `satelliteSolarSystem` (`solarSystem`),
  CONSTRAINT `satellitePlanet` FOREIGN KEY (`planet`) REFERENCES `Planet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `satelliteSolarSystem` FOREIGN KEY (`solarSystem`) REFERENCES `SolarSystem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `satelliteType` FOREIGN KEY (`type`) REFERENCES `SatelliteType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `satelliteUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Satellite: ~0 rows (approximately)

-- Dumping structure for table db.SatelliteType
CREATE TABLE IF NOT EXISTS `SatelliteType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `minLevel` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.SatelliteType: ~0 rows (approximately)

-- Dumping structure for table db.SolarSystem
CREATE TABLE IF NOT EXISTS `SolarSystem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `starMass` int(11) NOT NULL,
  `starRadius` int(11) NOT NULL,
  `temperature` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.SolarSystem: ~0 rows (approximately)
INSERT INTO `SolarSystem` (`id`, `name`, `starMass`, `starRadius`, `temperature`) VALUES
	(1, 'sun', 332946, 696340, 5778);

-- Dumping structure for table db.Token
CREATE TABLE IF NOT EXISTS `Token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `validUntil` datetime NOT NULL,
  `used` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Token: ~0 rows (approximately)

-- Dumping structure for table db.Transaction
CREATE TABLE IF NOT EXISTS `Transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromAccount` int(11) DEFAULT NULL,
  `toAccount` int(11) DEFAULT NULL,
  `contract` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `contractAssigned` (`contract`),
  KEY `fromAccount` (`fromAccount`),
  KEY `toAccount` (`toAccount`),
  CONSTRAINT `contractAssigned` FOREIGN KEY (`contract`) REFERENCES `Contract` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fromAccount` FOREIGN KEY (`fromAccount`) REFERENCES `BankAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `toAccount` FOREIGN KEY (`toAccount`) REFERENCES `BankAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Transaction: ~0 rows (approximately)

-- Dumping structure for table db.Vehicle
CREATE TABLE IF NOT EXISTS `Vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `refurbished` tinyint(4) NOT NULL,
  `flightAmount` int(11) NOT NULL,
  `available` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicleType` (`type`),
  KEY `vehicleUser` (`user`),
  CONSTRAINT `vehicleType` FOREIGN KEY (`type`) REFERENCES `VehicleType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicleUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.Vehicle: ~0 rows (approximately)

-- Dumping structure for table db.VehicleType
CREATE TABLE IF NOT EXISTS `VehicleType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL,
  `highestOrbit` int(11) NOT NULL,
  `maximumWeight` int(11) NOT NULL,
  `vehicleData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `failrate` int(11) NOT NULL,
  `refreshable` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db.VehicleType: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
