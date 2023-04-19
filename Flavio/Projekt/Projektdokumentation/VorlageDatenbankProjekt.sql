-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Apr 2023 um 21:51
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `trainingsplan`
--
CREATE DATABASE IF NOT EXISTS `trainingsplan` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `trainingsplan`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `idBenutzer` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Vorname` varchar(45) DEFAULT NULL,
  `Alter` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `Passwort` varchar(255) DEFAULT NULL,
  `Gewicht` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`idBenutzer`, `Name`, `Vorname`, `Alter`, `email`, `Passwort`, `Gewicht`) VALUES
(1, 'Muster', 'Hans', NULL, 'test@test.com', '$2y$10$bPmGM/G47bMx6Gm7PmyuWeeUkYdDrQeuZbUf8VfMmL2w0PL.icrra', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gewicht`
--

CREATE TABLE `gewicht` (
  `idGewicht` int(11) NOT NULL,
  `Datum` date DEFAULT NULL,
  `Gewicht` int(11) DEFAULT NULL,
  `Benutzer_idBenutzer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `gewicht`
--

INSERT INTO `gewicht` (`idGewicht`, `Datum`, `Gewicht`, `Benutzer_idBenutzer`) VALUES
(1, '2023-04-01', 30, 1),
(2, '2023-04-03', 40, 1),
(3, '2023-04-07', 80, 1),
(4, '2023-04-10', 30, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trainingplan`
--

CREATE TABLE `trainingplan` (
  `idTrainingplan` int(11) NOT NULL,
  `Benutzer_idBenutzer` int(11) NOT NULL,
  `Traingplanname` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `trainingplan`
--

INSERT INTO `trainingplan` (`idTrainingplan`, `Benutzer_idBenutzer`, `Traingplanname`) VALUES
(1, 1, 'Push'),
(2, 1, 'Pull');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `uebungen`
--

CREATE TABLE `uebungen` (
  `idUebungen` int(11) NOT NULL,
  `Uebungname` varchar(100) DEFAULT NULL,
  `Zielmuskel` varchar(45) DEFAULT NULL,
  `Beschreibung` mediumtext DEFAULT NULL,
  `UebungGif` varchar(255) DEFAULT NULL,
  `Trainingplan_idTrainingplan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `uebungen`
--

INSERT INTO `uebungen` (`idUebungen`, `Uebungname`, `Zielmuskel`, `Beschreibung`, `UebungGif`, `Trainingplan_idTrainingplan`) VALUES
(1, 'Bankdrücken', 'Brust', NULL, NULL, 1),
(2, 'Seitheben', 'Schulter', NULL, NULL, 1),
(3, 'Schulterdrücken', 'Schulter', NULL, NULL, 1),
(4, 'Latzug', 'Rücken', NULL, NULL, 2),
(5, 'Rudern', 'Rücken', NULL, NULL, 2),
(6, 'Bizepscurls', 'Bizeps', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vorgabeuebungen`
--

CREATE TABLE `vorgabeuebungen` (
  `idVorgabeUebungen` int(11) NOT NULL,
  `Uebungname` varchar(45) DEFAULT NULL,
  `Zielmuskel` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`idBenutzer`);

--
-- Indizes für die Tabelle `gewicht`
--
ALTER TABLE `gewicht`
  ADD PRIMARY KEY (`idGewicht`),
  ADD KEY `fk_Gewicht_Benutzer1_idx` (`Benutzer_idBenutzer`);

--
-- Indizes für die Tabelle `trainingplan`
--
ALTER TABLE `trainingplan`
  ADD PRIMARY KEY (`idTrainingplan`),
  ADD KEY `fk_Trainingplan_Benutzer_idx` (`Benutzer_idBenutzer`);

--
-- Indizes für die Tabelle `uebungen`
--
ALTER TABLE `uebungen`
  ADD PRIMARY KEY (`idUebungen`),
  ADD KEY `fk_Uebungen_Trainingplan1_idx` (`Trainingplan_idTrainingplan`);

--
-- Indizes für die Tabelle `vorgabeuebungen`
--
ALTER TABLE `vorgabeuebungen`
  ADD PRIMARY KEY (`idVorgabeUebungen`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `idBenutzer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `gewicht`
--
ALTER TABLE `gewicht`
  MODIFY `idGewicht` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `trainingplan`
--
ALTER TABLE `trainingplan`
  MODIFY `idTrainingplan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `uebungen`
--
ALTER TABLE `uebungen`
  MODIFY `idUebungen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `vorgabeuebungen`
--
ALTER TABLE `vorgabeuebungen`
  MODIFY `idVorgabeUebungen` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `gewicht`
--
ALTER TABLE `gewicht`
  ADD CONSTRAINT `fk_Gewicht_Benutzer1` FOREIGN KEY (`Benutzer_idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `trainingplan`
--
ALTER TABLE `trainingplan`
  ADD CONSTRAINT `fk_Trainingplan_Benutzer` FOREIGN KEY (`Benutzer_idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `uebungen`
--
ALTER TABLE `uebungen`
  ADD CONSTRAINT `fk_Uebungen_Trainingplan1` FOREIGN KEY (`Trainingplan_idTrainingplan`) REFERENCES `trainingplan` (`idTrainingplan`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
