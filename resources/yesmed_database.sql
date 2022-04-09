-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Kwi 2022, 18:21
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `yesmed_database`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Content` text COLLATE utf32_polish_ci NOT NULL,
  `Author` text COLLATE utf32_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `Id` int(11) NOT NULL,
  `Name` varchar(40) COLLATE utf32_polish_ci NOT NULL,
  `Price` double NOT NULL,
  `Description` varchar(1000) COLLATE utf32_polish_ci NOT NULL,
  `Image` varchar(50) COLLATE utf32_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`Id`, `Name`, `Price`, `Description`, `Image`) VALUES
(1, 'Amol', 27.99, 'Amol to zwykły lek na niezwykłe dolegliwości.', 'Towar1.png'),
(2, 'APAP', 6.29, 'APAP to skuteczny sposób na ból i gorączkę. Dostępny w małym, przenośnym opakowaniu.', 'Towar2.png'),
(3, 'Białko KFD WPC 80 Premium', 238.99, 'Białko Premium WPC 80 od KFD. Stworzone przez Marcina Von Cock\'a. Poczuj jego wspaniały smak oraz niesamowite właściwości. Twój trening stanie si? niesamowicie wydajny.', 'Towar3.png'),
(4, 'Olejek CBD', 234.49, 'Olejek konopny CBD o zawartości 10%. Pomaga odnaleźć spokój po ciężkim dniu.', 'Towar4.png'),
(5, 'Gripex Hot Max', 16.49, 'Gripex Hot Max to najlepszy lek przy pierwszych objawach grypy i przeziębienia. Dostępny w wygodnej formie saszetek rozpuszczanych w gorącej wodzie.', 'Towar5.png'),
(6, 'Ibuprom RR Max', 8.39, 'Ibuprom RR Max to ekspresowa pomoc w nagłym bólu. Działa niemal natychmiast, dzięki substancjom stosowanym w szpitalach.', 'Towar6.png'),
(7, 'Hyal-Drop Multi', 24.17, 'Hyal-Drop Multi to Twój sposób na zmęczone i suche oczy. Poczuj natychmiastowa ulgę dzięki zaawansowanej technologii nawilżania.', 'Towar7.png'),
(8, 'Nasivin Soft', 14.05, 'Nasivin Soft pomaga odblokować i nawilżyć chory i zatkany nos.', 'Towar8.png'),
(9, 'Paracetamol', 5.99, 'Paracetamol pomaga na każdy rodzaj bólu.', 'Towar9.png'),
(10, 'Vicks VapoRub', 26.99, 'Vicks VapoRub to maść pomagająca pokonać przeziębienie. Ułatwia oddychanie i przyspiesza leczenie grupy oraz przeziębienia. Maść przeznaczona do stosowania miejscowego.', 'Towar10.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `Id` int(11) NOT NULL,
  `UserName` text COLLATE utf32_polish_ci NOT NULL,
  `Password` text COLLATE utf32_polish_ci NOT NULL,
  `Email` text COLLATE utf32_polish_ci NOT NULL,
  `Role` int(11) NOT NULL,
  `ShoppingCard` int(11) NOT NULL,
  `Comments` text COLLATE utf32_polish_ci NOT NULL,
  `Address` text COLLATE utf32_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Zrzut danych tabeli `profile`
--

INSERT INTO `profile` (`Id`, `UserName`, `Password`, `Email`, `Role`, `ShoppingCard`, `Comments`, `Address`) VALUES
(2, 'Root', '63a9f0ea7bb98050796b649e85481845', 'root@root.com', 1, 0, '', '00-001 Warszawa, ul. Tak 12'),
(3, 'Sprzedawca', '9f8c20adf0c8ebb8b85be89aa3ad0825', 'sprzedawca@yesmed.com', 2, 0, '', '00-001 Warszawa, ul. Tak 12'),
(4, 'Macius112347', '05cde9bb704614e8e1ce367354c92d43', 'test@test.com', 3, 0, '', '00-001 Warszawa, ul. Tak 12'),
(5, 'gal0wsky', '05cde9bb704614e8e1ce367354c92d43', 'test@test.com', 3, 0, '', '00-001 Warszawa, ul. Tak 12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `Name` text COLLATE utf32_polish_ci NOT NULL,
  `Users` text COLLATE utf32_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`Id`, `Name`, `Users`) VALUES
(1, 'root', ''),
(2, 'sprzedawca', ''),
(3, 'uzytkownik', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shoppingcard`
--

CREATE TABLE `shoppingcard` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Products` text COLLATE utf32_polish_ci NOT NULL,
  `Cash` double NOT NULL,
  `ProductsPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `shoppingcard`
--
ALTER TABLE `shoppingcard`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `profile`
--
ALTER TABLE `profile`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `shoppingcard`
--
ALTER TABLE `shoppingcard`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
