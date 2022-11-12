-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2022 at 08:29 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desarrollo`
--

-- --------------------------------------------------------

--
-- Table structure for table `autores`
--

CREATE TABLE `autores` (
  `ID` int(11) NOT NULL,
  `NOMBRES` varchar(250) NOT NULL,
  `APELLIDOS` varchar(250) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `autores`
--

INSERT INTO `autores` (`ID`, `NOMBRES`, `APELLIDOS`, `DESCRIPCION`) VALUES
(2, 'jorge luis', 'montes gomez', 'nan'),
(3, 'jp', 'ape', 'una');

-- --------------------------------------------------------

--
-- Table structure for table `fotos`
--

CREATE TABLE `fotos` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(250) NOT NULL,
  `TIPO` int(11) NOT NULL,
  `TAMAÑO` float NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `FECHA_CREACION` datetime NOT NULL,
  `FECHA_MODIFICACION` date NOT NULL,
  `EMAIL` varchar(250) NOT NULL,
  `FK_AUTORES` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fotos`
--

INSERT INTO `fotos` (`ID`, `NOMBRE`, `TIPO`, `TAMAÑO`, `DESCRIPCION`, `FECHA_CREACION`, `FECHA_MODIFICACION`, `EMAIL`, `FK_AUTORES`) VALUES
(9, 'foto1', 1, 124, 'jpeg', '2022-09-24 08:48:38', '2022-09-24', 'jooge1009@gmail.com', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_FOTOS` (`FK_AUTORES`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autores`
--
ALTER TABLE `autores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fotos`
--
ALTER TABLE `fotos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`FK_AUTORES`) REFERENCES `autores` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
