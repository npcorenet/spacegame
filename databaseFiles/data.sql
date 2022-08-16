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

-- Dumping data for table db.Contract: ~0 rows (approximately)

-- Dumping data for table db.Planet: ~7 rows (approximately)
INSERT INTO `Planet` (`id`, `solarSystem`, `moon`, `name`, `mass`, `radius`, `distance`, `atmosphereHeight`, `atmosphereDensity`, `oxygen`, `solidSurface`, `coreTemperature`) VALUES
	(1, 1, NULL, 'mercury', 0.055, 2439, 0.4, 0, 0, 0, 1, 440),
	(2, 1, NULL, 'venus', 0.815, 6051, 0.7, 250, 67, 0, 1, 737),
	(3, 1, NULL, 'earth', 1, 6371, 1, 100, 1.2041, 1, 1, 4850),
	(4, 1, 3, 'moon', 0.0123, 1737, 0.002569, 0, 0, 0, 1, 1873),
	(5, 1, NULL, 'mars', 0.107, 3389, 1.5303, 11, 0.02, 0, 1, 1305),
	(6, 1, NULL, 'jupiter', 317.8, 69911, 4.2, 50, 1.33, 0, 1, 20000),
	(7, 1, 6, 'Io', 0.015, 1821, 2.8209, 15, 3.55, 0, 1, 1973);

-- Dumping data for table db.SatelliteType: ~0 rows (approximately)

-- Dumping data for table db.SolarSystem: ~0 rows (approximately)
INSERT INTO `SolarSystem` (`id`, `name`, `starMass`, `starRadius`, `temperature`) VALUES
	(1, 'sun', 332946, 696340, 5778);

-- Dumping data for table db.VehicleType: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
