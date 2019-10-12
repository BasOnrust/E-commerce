CREATE DATABASE IF NOT EXISTS `supermarkt`;
USE `supermarkt`;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 aug 2019 om 11:55
-- Serverversie: 10.1.38-MariaDB
-- PHP-versie: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermarkt`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `naam_category` varchar(32) COLLATE utf8_bin NOT NULL,
  `beschrijving` varchar(32) COLLATE utf8_bin NOT NULL,
  `afbeelding` varchar(32) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `naam_category`, `beschrijving`, `afbeelding`) VALUES
(1, 'Groente', 'Verse groente', 'images/groente.jpg'),
(2, 'Fruit', 'Lekker fruit', 'images/fruit.jpg'),
(3, 'Alles', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_author` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `name`, `email`, `password`, `is_author`) VALUES
(1, 'Bas', 'bas@email.com', '$2y$10$ICmr60VTd6jhSAwKy817qehsUxrWXF8wIMaD42td0Tgefq4fIefOG', 0),
(2, 'admin', 'admin@email.com', '$2y$10$IOtWrfqL4IUmTWfG7MjqZeFnhhVGT3screK7GhfUQxZUa9m1Xr3aS', 0),
(3, 'author', 'author@email.com', '$2y$10$.XCAwvAtGO2XT2kG6bZmz.AGL4VBh4a25j5H6iT7TXdWjgKuJhiDi', 1),
(4, 'guest', 'guest@email.com', '$2y$10$dqclpRakv2oBDqE0dJ3ZquTPc.7uJ8/rAz8HQiNIc7ahSjkqPnDnq', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `soorten_id` int(11) NOT NULL,
  `naam_product` varchar(50) COLLATE utf8_bin NOT NULL,
  `prijs` varchar(32) COLLATE utf8_bin NOT NULL,
  `hoeveelheid` varchar(32) COLLATE utf8_bin NOT NULL,
  `afbeelding` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `category_id`, `soorten_id`, `naam_product`, `prijs`, `hoeveelheid`, `afbeelding`) VALUES
(1, 1, 1, 'Brocolli', '0.99', '500 gram', '114122.png'),
(2, 1, 1, 'Bloemkool', '1.89', '1 stuk', '114209.png'),
(3, 1, 1, 'Witlof', '0.89', '500 gram', '113948.png'),
(4, 1, 1, 'Kropsla', '0.65', '1 stuk', '114020.png'),
(5, 1, 1, 'Prei', '0.65', '1  stuk', '449412.png'),
(6, 1, 1, 'Asperges', '4.99', '500 gram', '114197.png'),
(7, 1, 1, 'Andijvie', '0.99', '500 gram', '114185.png'),
(8, 1, 1, 'Winterpeen', '0.75', '1 kilo', '113945.png'),
(9, 1, 2, 'Trostomaten', '0.89', '500 gram', '113882.png'),
(10, 1, 2, 'Paprikamix', '1.69', '3 stuks', '113996.png'),
(11, 1, 2, 'Komkommer', '1.29', '1 stuk', '369778.png'),
(12, 1, 3, 'Sperziebonen', '1.69', '500 gram', '114032.png'),
(13, 1, 3, 'Snijbonen', '1.49', '400 gram', '970399.png'),
(14, 1, 3, 'Peultjes', '1.49', '150 gram', '984720.png'),
(15, 1, 3, 'Sugarsnaps', '1.39', '150 gram', '984773.png'),
(16, 1, 4, 'Kastanjechampignons', '1.29', '250 gram', '369836.png'),
(17, 1, 4, 'Champignons wit', '1.75', '200 gram', '827614.png'),
(18, 1, 4, 'Paddenstoelen Shii-take', '2.19', '100 gram', '146144.png'),
(19, 1, 5, 'Gele uien', '0.95', '1 kilo', '113903.png'),
(20, 1, 5, 'Knoflook', '2.89', '250 gram', '291121.png'),
(21, 1, 5, 'Chilipepers mix', '1.75', '75 gram', '220254.png'),
(22, 1, 6, 'Peterselie', '0.85', '30 gram', '415506.png'),
(23, 1, 6, 'Bieslook', '1.79', '1 stuk', '983980.png'),
(24, 1, 6, 'Tijm', '0.89', '1 stuk', '983671.png'),
(25, 1, 6, 'Rozemarijn', '1.19', '1 stuk', '983665.png'),
(26, 1, 6, 'Munt', '1.09', '40 gram', '265888.png'),
(27, 1, 6, 'Selderij', '0.69', '30 gram', '415508.png'),
(28, 1, 6, 'Basilicum', '1.59', '1 stuk', '983645.png'),
(29, 2, 7, 'Bananen', '1.95', '1 kilo', '113651.png'),
(30, 2, 8, 'Handappels Elstar', '1.45', '1 kilo', '113798.png'),
(31, 2, 8, 'Handappels Kanzi', '2.99', '1 kilo', '835722.png'),
(32, 2, 8, 'Handappels Royal gala', '2.89', '1 kilo', '113816.png'),
(33, 2, 8, 'Handappels Maribelle', '1.99', '1 kilo', '513377.png'),
(34, 2, 8, 'Conference Peren', '1.39', '1 kilo', '113834.png'),
(35, 2, 9, 'Handsinaasappelen', '2.99', '2 kilo', '466166.png'),
(36, 2, 9, 'Perssinaasappelen', '2.59', '2 kilo', '466223.png'),
(37, 2, 9, 'Limoenen', '0.59', '1 stuk', '561921.png'),
(38, 2, 9, 'Grapefruit', '1.19', '500 gram', '113633.png'),
(39, 2, 9, 'Mandarijnen', '1.85', '750 gram', '916270.png'),
(40, 2, 10, 'Druiven wit pitloos', '1.99', '500 gram', '679037.png'),
(41, 2, 10, 'Druiven rood pitloos', '1.99', '500 gram', '974201.png'),
(42, 2, 11, 'Galia meloen', '1.89', '1 stuk', '113759.png'),
(43, 2, 11, 'Pitloze watermeloen', '2.99', '1 stuk', '828703.png'),
(44, 2, 11, 'Cantaloupe meloen', '2.49', '1 stuk', '656607.png'),
(45, 2, 12, 'Bramen', '1.89', '125 gram', '796522.png'),
(46, 2, 12, 'Aardbeien', '2.49', '400 gram', '255461.png'),
(47, 2, 12, 'Frambozen', '2.99', '250 gram', '182140.png'),
(48, 2, 12, 'Kersen', '2.49', '500 gram', '731352.png'),
(49, 2, 12, 'Blauwe bessen', '2.99', '125 gram', '796524.png'),
(50, 2, 13, 'Mango', '1.99', '1 stuk', '852877.png'),
(51, 2, 13, 'Kiwi', '2.19', '500 gram', '113750.png'),
(52, 2, 13, 'Ananas', '1.99', '1 stuk', '521533.png'),
(53, 2, 13, 'Papaya', '2.79', '1 stuk', '377081.png'),
(54, 2, 14, 'Dadels', '1.99', '250 gram', '338933.png'),
(55, 2, 14, 'Walnoten', '2.59', '75 gram', '338955.png'),
(56, 2, 14, 'Amandelen', '1.89', '100 gram', '338921.png'),
(57, 2, 14, 'Cashewnoten', '2.79', '100 gram', '338929.png'),
(58, 2, 14, 'Cranberries', '3.49', '250 gram', '338931.png'),
(59, 2, 14, 'Abrikozen', '2.49', '250 gram', '338899.png'),
(60, 2, 15, 'Perziken', '2.49', '500 gram', '113780.png'),
(61, 2, 15, 'Pruimen', '1.99', '500 gram', '392681.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `soorten`
--

CREATE TABLE `soorten` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `naam_soort` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `soorten`
--

INSERT INTO `soorten` (`id`, `category_id`, `naam_soort`) VALUES
(1, 1, 'Groente algemeen'),
(2, 1, 'Tomaten, paprika, komkommer, courgette, aubergine'),
(3, 1, 'Peulvruchten'),
(4, 1, 'Champignons en paddestoelen'),
(5, 1, 'Ui, knoflook en exotisch groente'),
(6, 1, 'Verse kruiden'),
(7, 2, 'Bananen'),
(8, 2, 'Appels, peren, overig hardfruit'),
(9, 2, 'Sinaasappels en overig citrusfruit'),
(10, 2, 'Druiven'),
(11, 2, 'Meloenen'),
(12, 2, 'Aardbeien, frambozen, bramen, bessen, kersen'),
(13, 2, 'Exotisch fruit en toebehoren'),
(14, 2, 'Noten en gedroogde vruchten'),
(15, 2, 'Nectarines en perziken');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `winkelmanden`
--

CREATE TABLE `winkelmanden` (
  `id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `soorten_id` int(11) NOT NULL,
  `naam_product` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `prijs` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `hoeveelheid` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `afbeelding` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `soorten_id` (`soorten_id`);

--
-- Indexen voor tabel `soorten`
--
ALTER TABLE `soorten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexen voor tabel `winkelmanden`
--
ALTER TABLE `winkelmanden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `soorten_id` (`soorten_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT voor een tabel `soorten`
--
ALTER TABLE `soorten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `winkelmanden`
--
ALTER TABLE `winkelmanden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD CONSTRAINT `producten_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `producten_ibfk_2` FOREIGN KEY (`soorten_id`) REFERENCES `soorten` (`id`);

--
-- Beperkingen voor tabel `soorten`
--
ALTER TABLE `soorten`
  ADD CONSTRAINT `soorten_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Beperkingen voor tabel `winkelmanden`
--
ALTER TABLE `winkelmanden`
  ADD CONSTRAINT `winkelmanden_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `winkelmanden_ibfk_2` FOREIGN KEY (`soorten_id`) REFERENCES `soorten` (`id`),
  ADD CONSTRAINT `winkelmanden_ibfk_3` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
