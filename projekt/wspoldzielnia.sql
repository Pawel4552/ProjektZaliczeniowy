-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Gru 2020, 10:32
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wspoldzielnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `czlonek`
--

CREATE TABLE `czlonek` (
  `id_czlonka` int(11) NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `nr_lokalu` varchar(3) NOT NULL,
  `blok` enum('A','B','C') NOT NULL,
  `metraz` decimal(5,2) NOT NULL,
  `data_zamieszkania` date NOT NULL,
  `data_wyprowadzki` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `czlonek`
--

INSERT INTO `czlonek` (`id_czlonka`, `imie`, `nazwisko`, `nr_lokalu`, `blok`, `metraz`, `data_zamieszkania`, `data_wyprowadzki`) VALUES
(4, 'Jan', 'Kowalski', '1', 'A', '123.45', '2020-12-01', NULL),
(5, 'Piotr', 'Bednarz', '5', 'B', '245.00', '2019-02-14', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konto`
--

CREATE TABLE `konto` (
  `login` varchar(25) NOT NULL,
  `haslo` text DEFAULT NULL,
  `typ_konta` enum('A','U') NOT NULL DEFAULT 'U',
  `id_czlonka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `konto`
--

INSERT INTO `konto` (`login`, `haslo`, `typ_konta`, `id_czlonka`) VALUES
('admin', '$2y$10$OHIKzNWbkygeY56PaFA7HejdNvr9lkLXAm4/B6Py.7SzUnDYaowGy', 'A', NULL),
('JanKow1A', '$2y$10$Oy.yWSd.2babjgE9tm3yMuXrQmbEUiRnAhBcvd3sz9tfYY.SijBFG', 'U', 4),
('PioBed5B', '$2y$10$Z78FSkNfYDEanCeMEavX2uNye.7FB1bMHgCZ8MDk8XYy7ITF/CMa6', 'U', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `licznik`
--

CREATE TABLE `licznik` (
  `id_stanu` int(11) NOT NULL,
  `stan` decimal(6,0) NOT NULL,
  `id_czlonka` int(11) NOT NULL,
  `id_oplaty` int(11) NOT NULL,
  `data_odczytu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `licznik`
--

INSERT INTO `licznik` (`id_stanu`, `stan`, `id_czlonka`, `id_oplaty`, `data_odczytu`) VALUES
(1, '512', 4, 4, '2020-12-05'),
(2, '421', 4, 5, '2020-12-05'),
(3, '156', 4, 6, '2020-12-05');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oplaty`
--

CREATE TABLE `oplaty` (
  `id_oplaty` int(11) NOT NULL,
  `rodzaj` enum('Eksploatacja i konserwacja','Fundusz remontowy','Przegląd techniczny','Woda i kanalizacja','Opłata za ogrzanie wody','CO') NOT NULL,
  `typ` enum('stała','za m^2','za m^3') DEFAULT NULL,
  `koszt` decimal(6,3) DEFAULT NULL,
  `zalezna` enum('T','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `oplaty`
--

INSERT INTO `oplaty` (`id_oplaty`, `rodzaj`, `typ`, `koszt`, `zalezna`) VALUES
(1, 'Eksploatacja i konserwacja', 'za m^2', '1.550', 'T'),
(2, 'Fundusz remontowy', 'za m^2', '2.450', 'T'),
(3, 'Przegląd techniczny', 'stała', '50.000', 'T'),
(4, 'Woda i kanalizacja', 'za m^3', '0.025', 'N'),
(5, 'Opłata za ogrzanie wody', 'za m^3', '0.015', 'N'),
(6, 'CO', 'za m^3', '0.015', 'N');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rachunek`
--

CREATE TABLE `rachunek` (
  `id_rachunku` int(11) NOT NULL,
  `miesiac` enum('Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień') NOT NULL,
  `termin_platnosci` date NOT NULL,
  `kwota` decimal(7,2) NOT NULL,
  `uregulowane` enum('T','N') NOT NULL,
  `data_oplaty` date DEFAULT NULL,
  `odsetki` decimal(6,2) DEFAULT NULL,
  `id_czlonka` int(11) NOT NULL,
  `id_oplaty` int(11) NOT NULL,
  `id_stanu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `rachunek`
--

INSERT INTO `rachunek` (`id_rachunku`, `miesiac`, `termin_platnosci`, `kwota`, `uregulowane`, `data_oplaty`, `odsetki`, `id_czlonka`, `id_oplaty`, `id_stanu`) VALUES
(1, 'Grudzień', '2020-12-29', '12.80', 'T', '2020-12-09', '0.00', 4, 4, 1),
(2, 'Grudzień', '2020-12-29', '6.32', 'N', NULL, '0.00', 4, 5, 2),
(3, 'Grudzień', '2020-12-19', '2.34', 'N', NULL, '0.00', 4, 6, 3),
(10, 'Grudzień', '2020-12-22', '8354.50', 'N', NULL, '0.00', 5, 1, NULL),
(11, 'Grudzień', '2020-12-22', '13205.50', 'T', '2020-12-09', '0.00', 5, 2, NULL),
(12, 'Grudzień', '2020-12-22', '1100.00', 'N', NULL, '0.00', 5, 3, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tablica`
--

CREATE TABLE `tablica` (
  `id` int(11) NOT NULL,
  `blok` enum('A','B','C') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `tablica`
--

INSERT INTO `tablica` (`id`, `blok`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `czlonek`
--
ALTER TABLE `czlonek`
  ADD PRIMARY KEY (`id_czlonka`);

--
-- Indeksy dla tabeli `konto`
--
ALTER TABLE `konto`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `konto_czlonka_fk` (`id_czlonka`);

--
-- Indeksy dla tabeli `licznik`
--
ALTER TABLE `licznik`
  ADD PRIMARY KEY (`id_stanu`),
  ADD KEY `licznik_id_czlonka_fk` (`id_czlonka`),
  ADD KEY `licznik_id_oplaty_fk` (`id_oplaty`);

--
-- Indeksy dla tabeli `oplaty`
--
ALTER TABLE `oplaty`
  ADD PRIMARY KEY (`id_oplaty`);

--
-- Indeksy dla tabeli `rachunek`
--
ALTER TABLE `rachunek`
  ADD PRIMARY KEY (`id_rachunku`),
  ADD KEY `rachunek_id_czlonka_fk` (`id_czlonka`),
  ADD KEY `rachunek_id_oplaty_fk` (`id_oplaty`),
  ADD KEY `rachunek_id_stanu_fk` (`id_stanu`);

--
-- Indeksy dla tabeli `tablica`
--
ALTER TABLE `tablica`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `czlonek`
--
ALTER TABLE `czlonek`
  MODIFY `id_czlonka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `licznik`
--
ALTER TABLE `licznik`
  MODIFY `id_stanu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `oplaty`
--
ALTER TABLE `oplaty`
  MODIFY `id_oplaty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `rachunek`
--
ALTER TABLE `rachunek`
  MODIFY `id_rachunku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `tablica`
--
ALTER TABLE `tablica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `konto`
--
ALTER TABLE `konto`
  ADD CONSTRAINT `konto_czlonka_fk` FOREIGN KEY (`id_czlonka`) REFERENCES `czlonek` (`id_czlonka`);

--
-- Ograniczenia dla tabeli `licznik`
--
ALTER TABLE `licznik`
  ADD CONSTRAINT `licznik_id_czlonka_fk` FOREIGN KEY (`id_czlonka`) REFERENCES `czlonek` (`id_czlonka`),
  ADD CONSTRAINT `licznik_id_oplaty_fk` FOREIGN KEY (`id_oplaty`) REFERENCES `oplaty` (`id_oplaty`);

--
-- Ograniczenia dla tabeli `rachunek`
--
ALTER TABLE `rachunek`
  ADD CONSTRAINT `rachunek_id_czlonka_fk` FOREIGN KEY (`id_czlonka`) REFERENCES `czlonek` (`id_czlonka`),
  ADD CONSTRAINT `rachunek_id_oplaty_fk` FOREIGN KEY (`id_oplaty`) REFERENCES `oplaty` (`id_oplaty`),
  ADD CONSTRAINT `rachunek_id_stanu_fk` FOREIGN KEY (`id_stanu`) REFERENCES `licznik` (`id_stanu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
