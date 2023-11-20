-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2023 at 12:23 AM
-- Server version: 10.1.48-MariaDB-0+deb9u2
-- PHP Version: 7.0.33-0+deb9u10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `votacions`
--

-- --------------------------------------------------------

--
-- Table structure for table `0_entitats`
--

CREATE TABLE `0_entitats` (
  `id` int(11) NOT NULL,
  `sNom` varchar(250) DEFAULT NULL,
  `sKeyPublica` text NOT NULL,
  `sKeyPrivada` text NOT NULL,
  `sKeyPrivada2` text,
  `sCIF` varchar(15) DEFAULT NULL,
  `sPoblacio` varchar(200) DEFAULT NULL,
  `sEmail` varchar(250) DEFAULT NULL,
  `sTelefon` varchar(100) DEFAULT NULL,
  `sPersona` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `1_censGlobal`
--

CREATE TABLE `1_censGlobal` (
  `id` int(11) NOT NULL,
  `idControl` text NOT NULL,
  `idRegistre` text NOT NULL,
  `sAny` text NOT NULL,
  `sSexe` text NOT NULL,
  `idEntitat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `1_censLocal`
--

CREATE TABLE `1_censLocal` (
  `id` int(11) NOT NULL,
  `idControl` text NOT NULL,
  `idRegistre` text NOT NULL,
  `sAny` text,
  `sSexe` text NOT NULL,
  `iVotat` tinyint(4) NOT NULL DEFAULT '0',
  `idEntitat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `2_blockchain`
--

CREATE TABLE `2_blockchain` (
  `id` int(11) NOT NULL,
  `idPublica` text NOT NULL,
  `sInformacio` text NOT NULL,
  `iValidat` tinyint(4) NOT NULL DEFAULT '0',
  `idSeguretat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `3_integritat`
--

CREATE TABLE `3_integritat` (
  `id` int(11) NOT NULL,
  `sIntegritat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `4_errors`
--

CREATE TABLE `4_errors` (
  `id` int(11) NOT NULL,
  `sEquivocat` text NOT NULL,
  `sErrors` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `sEmail` varchar(150) NOT NULL,
  `sPass` varchar(150) NOT NULL,
  `s2FA` varchar(20) NOT NULL,
  `sNom` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


--
-- Indexes for table `0_entitats`
--
ALTER TABLE `0_entitats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `1_censGlobal`
--
ALTER TABLE `1_censGlobal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `1_censLocal`
--
ALTER TABLE `1_censLocal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `2_blockchain`
--
ALTER TABLE `2_blockchain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `3_integritat`
--
ALTER TABLE `3_integritat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `4_errors`
--
ALTER TABLE `4_errors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `0_entitats`
--
ALTER TABLE `0_entitats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `1_censGlobal`
--
ALTER TABLE `1_censGlobal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `1_censLocal`
--
ALTER TABLE `1_censLocal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `2_blockchain`
--
ALTER TABLE `2_blockchain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `3_integritat`
--
ALTER TABLE `3_integritat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `4_errors`
--
ALTER TABLE `4_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
