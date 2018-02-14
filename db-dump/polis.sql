-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 14, 2018 alle 18:24
-- Versione del server: 10.1.28-MariaDB
-- Versione PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `families`
--

CREATE TABLE `families` (
  `tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `families`
--

INSERT INTO `families` (`tag`, `name`) VALUES
('123456789012', 'Famiglia Rossi'),
('000000000000', 'Famiglia Bianchi'),
('a7hzR6ogCIx2', 'Famiglia Ostinelli');

-- --------------------------------------------------------

--
-- Struttura della tabella `metrics`
--

CREATE TABLE `metrics` (
  `metric_id` int(11) NOT NULL,
  `thing_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `metric_definition_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `value` float NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `metrics`
--

INSERT INTO `metrics` (`metric_id`, `thing_tag`, `metric_definition_tag`, `value`, `time_stamp`) VALUES
(1, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 2.05, '2018-01-23 17:17:21'),
(2, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 2.22, '2018-01-25 09:25:17'),
(4, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 122, '2018-01-25 09:26:56'),
(5, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 128, '2018-01-25 09:27:00'),
(6, 'bbbbbbbbbbbb', 'caaaaaaaaaaa', -3, '2018-02-06 12:58:37'),
(7, 'cccccccccccc', 'daaaaaaaaaaa', 25, '2018-02-06 13:03:12'),
(8, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 85, '2018-02-06 16:05:08'),
(9, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 90, '2018-02-06 16:04:12'),
(10, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 95, '2018-02-06 16:03:14'),
(11, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 87, '2018-02-06 16:02:17'),
(12, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 1.99, '2018-02-14 15:39:06'),
(13, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 2.02, '2018-02-14 15:39:15'),
(14, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 2.1, '2018-02-14 15:39:18'),
(15, 'aaaaaaaaaaaa', 'baaaaaaaaaaa', 1.95, '2018-02-14 15:39:25'),
(16, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 55, '2018-02-14 15:41:26'),
(17, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 59, '2018-02-14 15:41:30'),
(18, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 65, '2018-02-14 15:41:33'),
(19, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 59, '2018-02-14 15:41:36'),
(20, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 35, '2018-02-14 15:41:43'),
(21, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 15, '2018-02-14 15:41:47'),
(22, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 0, '2018-02-14 15:41:50'),
(23, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 35, '2018-02-14 15:41:53');

-- --------------------------------------------------------

--
-- Struttura della tabella `metrics_definition`
--

CREATE TABLE `metrics_definition` (
  `id` int(11) NOT NULL,
  `thing_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `unit` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `metric_tag` varchar(12) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `metrics_definition`
--

INSERT INTO `metrics_definition` (`id`, `thing_tag`, `name`, `unit`, `metric_tag`) VALUES
(1, 'aaaaaaaaaaaa', 'Velocita', 'Kmh', 'aaaaaaaaaaaa'),
(2, 'aaaaaaaaaaaa', 'Pressione', 'bar', 'baaaaaaaaaaa'),
(4, 'bbbbbbbbbbbb', 'Temperatura', 'C', 'caaaaaaaaaaa'),
(5, 'cccccccccccc', 'Temperatura', 'C', 'daaaaaaaaaaa'),
(6, 'dddddddddddd', 'Temperatura', 'C', 'eaaaaaaaaaaa'),
(7, 'eeeeeeeeeeee', 'Accensione', '', 'faaaaaaaaaaa'),
(8, 'eeeeeeeeeeee', 'LuminositÃ ', 'cd', 'gaaaaaaaaaaa'),
(9, 'hHu/cfLoG0Yc', 'VelocitÃ ', 'kmh', 'haaaaaaaaaaa'),
(10, 'rsI2bBDAbw3I', 'Temperatura', 'Â°C', 'iaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Struttura della tabella `things`
--

CREATE TABLE `things` (
  `tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `family_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `user_type` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `things`
--

INSERT INTO `things` (`tag`, `name`, `family_tag`, `user_type`) VALUES
('aaaaaaaaaaaa', 'Automobile', '123456789012', 1),
('bbbbbbbbbbbb', 'Freezer', '123456789012', 3),
('cccccccccccc', 'Temperatura Zona Giorno', '123456789012', 2),
('dddddddddddd', 'Temperatura Zona Notte', '123456789012', 2),
('eeeeeeeeeeee', 'Luci Giardino', '123456789012', 1),
('zzzzzzzzzzzz', 'Thing Altra Familgia', '000000000000', 3),
('rsI2bBDAbw3I', 'Frigorifero', 'a7hzR6ogCIx2', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `family_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `user_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '1',
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`family_tag`, `user_name`, `password`, `user_type`, `email`) VALUES
('123456789012', 'admin', 'password', 1, 'admin@email.com'),
('123456789012', 'user', 'password', 2, 'user@email.com'),
('123456789012', 'guest', 'password', 3, 'guest@email.com'),
('a7hzR6ogCIx2', 'osty', 'password', 1, 'daostinelli@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `users_definition`
--

CREATE TABLE `users_definition` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `users_definition`
--

INSERT INTO `users_definition` (`id`, `name`, `description`, `access_level`) VALUES
(1, 'Admin', 'Family admin. Users setup, Thing setup, Thing read', 0),
(2, 'User', 'Read thing', 1),
(3, 'Guest', 'Read thing with limitation', 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`tag`);

--
-- Indici per le tabelle `metrics`
--
ALTER TABLE `metrics`
  ADD PRIMARY KEY (`metric_id`);

--
-- Indici per le tabelle `metrics_definition`
--
ALTER TABLE `metrics_definition`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `metric_tag` (`metric_tag`);

--
-- Indici per le tabelle `things`
--
ALTER TABLE `things`
  ADD PRIMARY KEY (`tag`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `users_definition`
--
ALTER TABLE `users_definition`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `metrics`
--
ALTER TABLE `metrics`
  MODIFY `metric_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `metrics_definition`
--
ALTER TABLE `metrics_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `users_definition`
--
ALTER TABLE `users_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
