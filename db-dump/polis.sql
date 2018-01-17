-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 15, 2018 alle 17:17
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
-- Struttura della tabella `metrics_definition`
--

CREATE TABLE `metrics_definition` (
  `id` int(11) NOT NULL,
  `thing_tag` varchar(12) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `unit` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `metrics_definition`
--

INSERT INTO `metrics_definition` (`id`, `thing_tag`, `name`, `unit`) VALUES
(1, 'aaaaaaaaaaaa', 'Velocita', 'Kmh'),
(2, 'aaaaaaaaaaaa', 'Pressione', 'bar'),
(4, 'bbbbbbbbbbbb', 'Temperatura', 'C'),
(5, 'cccccccccccc', 'Temperatura', 'C'),
(6, 'dddddddddddd', 'Temperatura', 'C'),
(7, 'eeeeeeeeeeee', 'Accensione', ''),
(8, 'eeeeeeeeeeee', 'LuminositÃ ', 'cd');

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
('eeeeeeeeeeee', 'Luci Giardino', '123456789012', 3),
('zzzzzzzzzzzz', 'Thing Altra Familgia', '000000000000', 3);

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
-- Indici per le tabelle `metrics_definition`
--
ALTER TABLE `metrics_definition`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT per la tabella `metrics_definition`
--
ALTER TABLE `metrics_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `users_definition`
--
ALTER TABLE `users_definition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
