-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Sep 04, 2022 at 03:58 PM
-- Server version: 10.3.35-MariaDB-1:10.3.35+maria~focal-log
-- PHP Version: 8.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `experience` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 1,
  `premium` datetime DEFAULT NULL,
  `registered` datetime NOT NULL DEFAULT current_timestamp(),
  `isAdmin` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `AccountToken`
--

CREATE TABLE `AccountToken` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validUntil` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `BankAccount`
--

CREATE TABLE `BankAccount` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `money` int(11) NOT NULL DEFAULT 50000,
  `address` varchar(100) NOT NULL,
  `name` varchar(128) NOT NULL,
  `dailyMax` int(11) NOT NULL DEFAULT 25000,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `defaultAccount` tinyint(4) NOT NULL,
  `debtAllowed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Contract`
--

CREATE TABLE `Contract` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `availableFrom` datetime NOT NULL DEFAULT current_timestamp(),
  `availableUntil` datetime DEFAULT NULL,
  `maxDuration` int(11) NOT NULL,
  `minimumLevel` int(11) NOT NULL,
  `prePayment` int(11) NOT NULL,
  `reward` int(11) NOT NULL,
  `byUser` int(11) DEFAULT NULL,
  `userLimit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ContractAccount`
--

CREATE TABLE `ContractAccount` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `contract` int(11) NOT NULL,
  `started` datetime NOT NULL DEFAULT current_timestamp(),
  `expires` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT 0,
  `success` tinyint(4) NOT NULL DEFAULT 0,
  `expenses` int(11) NOT NULL DEFAULT 0,
  `expensesLimit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Launch`
--

CREATE TABLE `Launch` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL,
  `satellite` int(11) NOT NULL,
  `contract` int(11) NOT NULL,
  `targetTime` datetime NOT NULL,
  `liftoff` datetime NOT NULL,
  `complete` tinyint(4) NOT NULL,
  `success` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE `Location` (
  `id` int(11) NOT NULL,
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
  `crewLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `LoginHistory`
--

CREATE TABLE `LoginHistory` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Planet`
--

CREATE TABLE `Planet` (
  `id` int(11) NOT NULL,
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
  `coreTemperature` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Satellite`
--

CREATE TABLE `Satellite` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `planet` int(11) DEFAULT NULL,
  `solarSystem` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `inOrbit` tinyint(4) NOT NULL,
  `inclination` int(11) NOT NULL,
  `periapsis` int(11) NOT NULL,
  `apoapsis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `SatelliteType`
--

CREATE TABLE `SatelliteType` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `minLevel` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `SolarSystem`
--

CREATE TABLE `SolarSystem` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `starMass` int(11) NOT NULL,
  `starRadius` int(11) NOT NULL,
  `temperature` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Token`
--

CREATE TABLE `Token` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `validUntil` datetime NOT NULL,
  `used` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `id` int(11) NOT NULL,
  `fromAccount` int(11) DEFAULT NULL,
  `toAccount` int(11) DEFAULT NULL,
  `contract` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `Vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `refurbished` tinyint(4) NOT NULL,
  `flightAmount` int(11) NOT NULL,
  `available` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `VehicleType`
--

CREATE TABLE `VehicleType` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL,
  `highestOrbit` int(11) NOT NULL,
  `maximumWeight` int(11) NOT NULL,
  `vehicleData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `failrate` int(11) NOT NULL,
  `refreshable` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `AccountToken`
--
ALTER TABLE `AccountToken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`userId`);

--
-- Indexes for table `BankAccount`
--
ALTER TABLE `BankAccount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accountOwner` (`user`);

--
-- Indexes for table `Contract`
--
ALTER TABLE `Contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `byUser` (`byUser`);

--
-- Indexes for table `ContractAccount`
--
ALTER TABLE `ContractAccount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractAccount` (`user`),
  ADD KEY `contractId` (`contract`),
  ADD KEY `contractVehicle` (`vehicle`);

--
-- Indexes for table `Launch`
--
ALTER TABLE `Launch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `launchUser` (`user`),
  ADD KEY `launchVehicle` (`vehicle`),
  ADD KEY `launchSatellite` (`satellite`),
  ADD KEY `launchContract` (`contract`);

--
-- Indexes for table `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `LocationUser` (`user`);

--
-- Indexes for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loginUser` (`user`);

--
-- Indexes for table `Planet`
--
ALTER TABLE `Planet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planetSolarSystem` (`solarSystem`),
  ADD KEY `planetMoon` (`moon`);

--
-- Indexes for table `Satellite`
--
ALTER TABLE `Satellite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satelliteUser` (`user`),
  ADD KEY `satelliteType` (`type`),
  ADD KEY `satellitePlanet` (`planet`),
  ADD KEY `satelliteSolarSystem` (`solarSystem`);

--
-- Indexes for table `SatelliteType`
--
ALTER TABLE `SatelliteType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SolarSystem`
--
ALTER TABLE `SolarSystem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Token`
--
ALTER TABLE `Token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractAssigned` (`contract`),
  ADD KEY `fromAccount` (`fromAccount`),
  ADD KEY `toAccount` (`toAccount`);

--
-- Indexes for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicleType` (`type`),
  ADD KEY `vehicleUser` (`user`);

--
-- Indexes for table `VehicleType`
--
ALTER TABLE `VehicleType`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Account`
--
ALTER TABLE `Account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AccountToken`
--
ALTER TABLE `AccountToken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BankAccount`
--
ALTER TABLE `BankAccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Contract`
--
ALTER TABLE `Contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ContractAccount`
--
ALTER TABLE `ContractAccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Launch`
--
ALTER TABLE `Launch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Location`
--
ALTER TABLE `Location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Planet`
--
ALTER TABLE `Planet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Satellite`
--
ALTER TABLE `Satellite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SatelliteType`
--
ALTER TABLE `SatelliteType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SolarSystem`
--
ALTER TABLE `SolarSystem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Token`
--
ALTER TABLE `Token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Vehicle`
--
ALTER TABLE `Vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VehicleType`
--
ALTER TABLE `VehicleType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AccountToken`
--
ALTER TABLE `AccountToken`
  ADD CONSTRAINT `user` FOREIGN KEY (`userId`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `BankAccount`
--
ALTER TABLE `BankAccount`
  ADD CONSTRAINT `accountOwner` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Contract`
--
ALTER TABLE `Contract`
  ADD CONSTRAINT `byUser` FOREIGN KEY (`byUser`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ContractAccount`
--
ALTER TABLE `ContractAccount`
  ADD CONSTRAINT `contractAccount` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contractId` FOREIGN KEY (`contract`) REFERENCES `Contract` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contractVehicle` FOREIGN KEY (`vehicle`) REFERENCES `Vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Launch`
--
ALTER TABLE `Launch`
  ADD CONSTRAINT `launchContract` FOREIGN KEY (`contract`) REFERENCES `ContractAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `launchSatellite` FOREIGN KEY (`satellite`) REFERENCES `Satellite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `launchUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `launchVehicle` FOREIGN KEY (`vehicle`) REFERENCES `Vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Location`
--
ALTER TABLE `Location`
  ADD CONSTRAINT `LocationUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  ADD CONSTRAINT `loginUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Planet`
--
ALTER TABLE `Planet`
  ADD CONSTRAINT `planetMoon` FOREIGN KEY (`moon`) REFERENCES `Planet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planetSolarSystem` FOREIGN KEY (`solarSystem`) REFERENCES `SolarSystem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Satellite`
--
ALTER TABLE `Satellite`
  ADD CONSTRAINT `satellitePlanet` FOREIGN KEY (`planet`) REFERENCES `Planet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `satelliteSolarSystem` FOREIGN KEY (`solarSystem`) REFERENCES `SolarSystem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `satelliteType` FOREIGN KEY (`type`) REFERENCES `SatelliteType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `satelliteUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD CONSTRAINT `contractAssigned` FOREIGN KEY (`contract`) REFERENCES `Contract` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fromAccount` FOREIGN KEY (`fromAccount`) REFERENCES `BankAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `toAccount` FOREIGN KEY (`toAccount`) REFERENCES `BankAccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD CONSTRAINT `vehicleType` FOREIGN KEY (`type`) REFERENCES `VehicleType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicleUser` FOREIGN KEY (`user`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
