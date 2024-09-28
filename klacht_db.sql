-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2024 at 04:23 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klacht_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `boekingen`
--

CREATE TABLE `boekingen` (
  `ID` int(11) NOT NULL,
  `StartDatum` date DEFAULT NULL,
  `PINCode` int(11) DEFAULT NULL,
  `FKtochtenID` int(11) DEFAULT NULL,
  `FKklantenID` int(11) DEFAULT NULL,
  `FKstatussenID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `herbergen`
--

CREATE TABLE `herbergen` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) DEFAULT NULL,
  `Adres` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefoon` varchar(20) DEFAULT NULL,
  `Coordinaten` varchar(20) DEFAULT NULL,
  `Gewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `herbergen`
--

INSERT INTO `herbergen` (`ID`, `Naam`, `Adres`, `Email`, `Telefoon`, `Coordinaten`, `Gewijzigd`) VALUES
(5, 'aba', 'korhoenlaan 31 ', 'money@123.com', '0612345678', 'N 52.09065°', '2023-11-08 10:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `klacht`
--

CREATE TABLE `klacht` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `klacht_text` text,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `klacht`
--

INSERT INTO `klacht` (`id`, `naam`, `email`, `klacht_text`, `latitude`, `longitude`, `foto_url`, `created_at`) VALUES
(1, 'Billy', 'billy@gmail.com', 'Auto ongeluk', '51.94055680', '5.03971840', 'uploads/Schermafbeelding_20221216_212138.png', '2024-01-29 15:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `klanten`
--

CREATE TABLE `klanten` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telefoon` varchar(20) NOT NULL,
  `Wachtwoord` varchar(100) NOT NULL,
  `Gewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Rol` enum('Gast','Admin') NOT NULL DEFAULT 'Gast'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `klanten`
--

INSERT INTO `klanten` (`ID`, `Naam`, `Email`, `Telefoon`, `Wachtwoord`, `Gewijzigd`, `Rol`) VALUES
(1, 'Test Gebruiker', 'test@example.com', '123456789', 'wachtwoord123', '2023-09-27 08:10:30', 'Gast'),
(2, 'bill', 's@sgmail.com', '067345689', '12345', '2023-09-27 08:27:44', 'Gast'),
(3, 'aba', 'aba@sgmail.com', '0646783245', '12345', '2023-09-27 08:28:32', 'Gast'),
(4, 'Ben Hopkings', 'louis@yahoo.com', '063213213', '$2y$10$SFhVU1i1/pSzHAExi3vf3uonqAmlpxk5LGmGBf/2xrz3.wtm7w12a', '2023-10-05 06:45:36', 'Gast'),
(5, 'ses', 'ses@ses.com', '0627389382', '$2y$10$aY4Fz9PnioKHP6WzPC9dGeMhUmx2IwivPpBLPbzogdAWSyh28Ma0G', '2023-10-05 07:01:56', 'Gast'),
(6, 'Bill', 'xixisxt@gmail.com', '062302382', '$2y$10$DMPObcSvc8Jn5sRPUz5xfuQZzfudFCn/ErJ/q49VBq.nbSJXIt446', '2023-10-05 07:11:27', 'Gast'),
(7, 'tariw', 'tariw@gmail.com', '0612345678', '$2y$10$0F8Itkj32ot5wCJROq3bf.z/RnSZnYN83pQNP.r0nG3nbxDmwxfdK', '2023-10-30 10:00:07', 'Gast'),
(8, 'radwan', 'ufcradwan@gmail.com', '0672837323', '$2y$10$tNUcFN0RnjLgGgku1e6LGuTMBBJiMiu/6yC6ZTKGM6nwEm4uif4Rq', '2023-11-08 20:29:43', 'Admin'),
(9, 'tari11', 'mothermother@gmail.com', '0673848234', '$2y$10$cQf8rmggUcZ5WwxF98J6zOIbh.sX7LrEnkDle5ODetgwhFDGoFi4e', '2023-10-30 10:04:41', 'Gast'),
(10, 'Wer', 'Wer@gmail.com', '0612345678', '$2y$10$FtccnhSXdVDkL4/IIW.kwejpYiOdXCIaBhIe0/nUppk0NaIGZyAHu', '2023-11-07 15:49:28', 'Gast'),
(11, 'rad', 'rad@gmail.com', '0612345678', '$2y$10$VvrAKJQE.RoeCTnMwZV9l.5IgbWNU.tvPxgPP.uygNKLUk64kIMRW', '2023-11-08 09:17:59', 'Gast'),
(12, 'billw', 'billw@gmail.com', '0612345678', '$2y$10$ID7afmDNzJN0CsBI6r2BVuP08OwVTN.9VDZgB.6G/PddwiScptvSm', '2023-11-08 09:18:49', 'Gast'),
(14, 'aba', 'rad@gmail.com', '0612345678', '$2y$10$5uNdtk8/HptNbVz9nU0f/.gtkSV9ys9kse7RJ1LA9E6.Cs7gI9knu', '2023-11-08 21:46:35', 'Gast'),
(15, 'aba2', 'rad@gmail.com', '0612345678', '$2y$10$UpLg2fiFuZxTZXVzSzAhweMlCxRH41F7Coui5TFNVjFmHiziN7BLm', '2023-11-08 21:47:08', 'Gast'),
(16, 'aba3', 'rad@gmail.com', '0646783245', '$2y$10$8vPpei9Cn1R7Kuu11afHIusyf.8v5HxSNeCosGuVxIdJrGylKxwiq', '2023-11-08 21:47:38', 'Gast'),
(17, 'aba55', 'wsdd@gmail.com', '0672837322', '$2y$10$d2PfXnDXwv9ujEh1Gx7vA.PD5VxbVhbm6yseuiPV2lB8hZESc80U.', '2023-11-19 16:45:43', 'Admin'),
(18, 'bill2', 'wsddd@gmail.com', '0646783245', '$2y$10$ITW8i5QoxggOqg5eA1jUtu0K0DeQZeDUfVf/Kth77QnfzCgDIhuMK', '2023-11-10 18:35:53', 'Gast'),
(19, 'Billy', 'billy@gmail.com', '0627389382', '$2y$10$yMBpFFkaBQGQtyxmxsFRl.sKq06Oop..rr9do145ifIrNtCJBa.B2', '2024-01-29 15:44:19', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `overnachtingen`
--

CREATE TABLE `overnachtingen` (
  `ID` int(11) NOT NULL,
  `FKboekingenID` int(11) DEFAULT NULL,
  `FKherbergenID` int(11) DEFAULT NULL,
  `FKstatussenID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pauzeplaatsen`
--

CREATE TABLE `pauzeplaatsen` (
  `ID` int(11) NOT NULL,
  `FKboekingenID` int(11) DEFAULT NULL,
  `FKrestaurantsID` int(11) DEFAULT NULL,
  `FKstatussenID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) DEFAULT NULL,
  `Adres` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefoon` varchar(20) DEFAULT NULL,
  `Coordinaten` varchar(20) DEFAULT NULL,
  `Gewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`ID`, `Naam`, `Adres`, `Email`, `Telefoon`, `Coordinaten`, `Gewijzigd`) VALUES
(1, 'Macdonaldsss', 'bardstraat 26', 'maccie@outlook.com', '0643848234', 'N 46.09065°', '2023-11-20 16:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `statussen`
--

CREATE TABLE `statussen` (
  `ID` int(11) NOT NULL,
  `StatusCode` tinyint(4) DEFAULT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Verwijderbaar` tinyint(4) DEFAULT NULL,
  `PINtoekennen` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tochten`
--

CREATE TABLE `tochten` (
  `ID` int(11) NOT NULL,
  `Omschrijving` varchar(40) DEFAULT NULL,
  `Route` varchar(50) DEFAULT NULL,
  `AantalDagen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tochten`
--

INSERT INTO `tochten` (`ID`, `Omschrijving`, `Route`, `AantalDagen`) VALUES
(2, 'Dubai', 'best ver', 7);

-- --------------------------------------------------------

--
-- Table structure for table `trackers`
--

CREATE TABLE `trackers` (
  `ID` int(11) NOT NULL,
  `PINCode` int(11) DEFAULT NULL,
  `Lat` double DEFAULT NULL,
  `Lon` double DEFAULT NULL,
  `Time` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boekingen`
--
ALTER TABLE `boekingen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKtochtenID` (`FKtochtenID`),
  ADD KEY `FKstatussenID` (`FKstatussenID`),
  ADD KEY `fk_klanten_id` (`FKklantenID`);

--
-- Indexes for table `herbergen`
--
ALTER TABLE `herbergen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `klacht`
--
ALTER TABLE `klacht`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `overnachtingen`
--
ALTER TABLE `overnachtingen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKboekingenID` (`FKboekingenID`),
  ADD KEY `FKherbergenID` (`FKherbergenID`),
  ADD KEY `FKstatussenID` (`FKstatussenID`);

--
-- Indexes for table `pauzeplaatsen`
--
ALTER TABLE `pauzeplaatsen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKboekingenID` (`FKboekingenID`),
  ADD KEY `FKrestaurantsID` (`FKrestaurantsID`),
  ADD KEY `FKstatussenID` (`FKstatussenID`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `statussen`
--
ALTER TABLE `statussen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tochten`
--
ALTER TABLE `tochten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `trackers`
--
ALTER TABLE `trackers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boekingen`
--
ALTER TABLE `boekingen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `herbergen`
--
ALTER TABLE `herbergen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `klacht`
--
ALTER TABLE `klacht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `klanten`
--
ALTER TABLE `klanten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `overnachtingen`
--
ALTER TABLE `overnachtingen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pauzeplaatsen`
--
ALTER TABLE `pauzeplaatsen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statussen`
--
ALTER TABLE `statussen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tochten`
--
ALTER TABLE `tochten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trackers`
--
ALTER TABLE `trackers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boekingen`
--
ALTER TABLE `boekingen`
  ADD CONSTRAINT `boekingen_ibfk_1` FOREIGN KEY (`FKtochtenID`) REFERENCES `tochten` (`ID`),
  ADD CONSTRAINT `boekingen_ibfk_2` FOREIGN KEY (`FKklantenID`) REFERENCES `klanten` (`ID`),
  ADD CONSTRAINT `boekingen_ibfk_3` FOREIGN KEY (`FKstatussenID`) REFERENCES `statussen` (`ID`),
  ADD CONSTRAINT `fk_klanten_id` FOREIGN KEY (`FKklantenID`) REFERENCES `klanten` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `overnachtingen`
--
ALTER TABLE `overnachtingen`
  ADD CONSTRAINT `overnachtingen_ibfk_1` FOREIGN KEY (`FKboekingenID`) REFERENCES `boekingen` (`ID`),
  ADD CONSTRAINT `overnachtingen_ibfk_2` FOREIGN KEY (`FKherbergenID`) REFERENCES `herbergen` (`ID`),
  ADD CONSTRAINT `overnachtingen_ibfk_3` FOREIGN KEY (`FKstatussenID`) REFERENCES `statussen` (`ID`);

--
-- Constraints for table `pauzeplaatsen`
--
ALTER TABLE `pauzeplaatsen`
  ADD CONSTRAINT `pauzeplaatsen_ibfk_1` FOREIGN KEY (`FKboekingenID`) REFERENCES `boekingen` (`ID`),
  ADD CONSTRAINT `pauzeplaatsen_ibfk_2` FOREIGN KEY (`FKrestaurantsID`) REFERENCES `restaurants` (`ID`),
  ADD CONSTRAINT `pauzeplaatsen_ibfk_3` FOREIGN KEY (`FKstatussenID`) REFERENCES `statussen` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
