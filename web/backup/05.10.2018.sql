-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 05 Paź 2018, 19:55
-- Wersja serwera: 5.7.21
-- Wersja PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `miszcze`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `const`
--

DROP TABLE IF EXISTS `const`;
CREATE TABLE IF NOT EXISTS `const` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `const`
--

INSERT INTO `const` (`id`, `name`, `value`) VALUES
(1, 'salt', 'UDF2SDERCZ8184Q5'),
(2, 'hash', 'sha512'),
(3, 'technical_break', '0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_lek`
--

DROP TABLE IF EXISTS `godz_lek`;
CREATE TABLE IF NOT EXISTS `godz_lek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poczatek` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `godz_lek`
--

INSERT INTO `godz_lek` (`id`, `poczatek`) VALUES
(1, '08:00:00'),
(2, '08:55:00'),
(3, '09:40:00'),
(4, '10:35:00'),
(5, '11:30:00'),
(6, '12:25:00'),
(7, '13:20:00'),
(8, '14:15:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hasla`
--

DROP TABLE IF EXISTS `hasla`;
CREATE TABLE IF NOT EXISTS `hasla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uzytkownik` int(11) NOT NULL,
  `haslo` varchar(200) NOT NULL,
  `sol` varchar(10) NOT NULL,
  `data` datetime NOT NULL,
  `proby` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_hasla_uzytkownicy_idx` (`uzytkownik`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `hasla`
--

INSERT INTO `hasla` (`id`, `uzytkownik`, `haslo`, `sol`, `data`, `proby`) VALUES
(2, 2, '070e37aafded7e6c9ceb73bf3fffc454b32e7f0f9f321f00f8b53e56b54df1f7ada32a0a66702c2cbdc61c3a78246e4cf0d8928baee75fb25c8e79011e920b09', '9VG', '2018-08-25 18:57:24', 0),
(8, 8, 'ce37ec9644d22ad2810c3b69fce3f3cce356bb2468fb730d306b89c11dae702b71902710f8d6ff5e1349c6a1ec315731c9dbe2c2ee7f2b381704b9c971efa52b', 'NAB', '2018-08-26 06:36:37', 0),
(9, 9, '730500ea748785a1a5b148303b99572edc48573d21d279419d945708c62f38f3a0d3c305c03bab6b01c5110ab2ac6a7bd2ca9b85a7cdb0044bb9218a577b9bd8', 'DIX', '2018-08-26 06:55:06', 0),
(10, 10, 'ffd826a83a2e5121e54ad1fbf5474a754ff4f238015ccac7faaf136df3e2ecce457a62d5ed7ee891d747a61ecd5c4f84555bbdc268efad17c2a31afab15571d8', 'KD7', '2018-08-26 06:55:33', 0),
(11, 11, '3676629dd178e9d77bebefdf44b321ab91e1e54b6b97f2bfc1ffccde29afed7e375a01a678792bd994c08157a0bbe7a93a64c5d7725cb8587aec7e5c8634307e', '0NX', '2018-08-26 06:55:47', 0),
(12, 12, 'bfa6d55a5d61135acdaaaebf475348044ae3b2c97d75904db79222b154d4e372d0dcfa22729769dad3d8f148b7c58168bb7861e093ba7c4db15309e129a32943', 'G3U', '2018-08-26 06:56:03', 0),
(13, 13, 'ca2cb641084d728b3e6f0cf97fd575b2a42937e71c71f6911725c5b8697e39ceb24e7c8c8cf9730d3a92f8049823c3d60cee24bc2b0b32a403ab31384a162a08', 'NEO', '2018-08-26 06:56:42', 0),
(14, 14, 'b36bd39f7f805895f09bde4904c03441639f022a57010c6bcd80010b9f3f52b44bef099d46071c52d42c5073bda19e606907af95fa7c5b8b7330c6d7103b99bd', 'CD6', '2018-08-26 06:57:06', 0),
(15, 15, '2c0961f704e1b768f6e91c22214a80a3c736844ebe9153999f063feee6b3b3d777be6ed045aa5fbb2d3aac4dc69875e5089edd8550941cb4697cd79484e91130', '9R4', '2018-08-26 09:57:06', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

DROP TABLE IF EXISTS `klasy`;
CREATE TABLE IF NOT EXISTS `klasy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poziom` int(11) NOT NULL,
  `klasa` varchar(1) DEFAULT NULL,
  `rocznik` varchar(4) NOT NULL,
  `wychowawca` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_KlasyUczniow_pracownicy_idx` (`wychowawca`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `klasy`
--

INSERT INTO `klasy` (`id`, `poziom`, `klasa`, `rocznik`, `wychowawca`, `status`) VALUES
(1, 1, 'a', '2000', 12, 0),
(2, 1, 'b', '2000', 12, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obecnosci`
--

DROP TABLE IF EXISTS `obecnosci`;
CREATE TABLE IF NOT EXISTS `obecnosci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kiedy` datetime NOT NULL,
  `obecny` int(2) NOT NULL,
  `uczen` int(11) NOT NULL,
  `termin` int(11) NOT NULL,
  `komentarz` text,
  PRIMARY KEY (`id`),
  KEY `fk_uczniowe_has_zajecia_uczniowe1_idx` (`uczen`),
  KEY `fk_uczniowe_has_zajecia_zajecia1_idx` (`termin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ocenianie`
--

DROP TABLE IF EXISTS `ocenianie`;
CREATE TABLE IF NOT EXISTS `ocenianie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `przedmiot` int(11) NOT NULL,
  `uczen` int(11) NOT NULL,
  `semestr` varchar(10) DEFAULT NULL,
  `terminowosc` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `wiedza` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `kulturalnosc` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_ocenianie_uczniowie_idx` (`uczen`),
  KEY `FK_ocenianie_przedmioty_idx` (`przedmiot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

DROP TABLE IF EXISTS `oceny`;
CREATE TABLE IF NOT EXISTS `oceny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ocena` int(11) NOT NULL,
  `waga` int(11) DEFAULT NULL,
  `kiedy` datetime NOT NULL,
  `uczen` int(11) NOT NULL,
  `przedmiot` int(11) NOT NULL,
  `typ` varchar(10) NOT NULL,
  `uwagi` text,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmi_idx` (`przedmiot`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1_idx` (`uczen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opiekunowie`
--

DROP TABLE IF EXISTS `opiekunowie`;
CREATE TABLE IF NOT EXISTS `opiekunowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `kontakt` text NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_opiekunowie_users_idx` (`uzytkownik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

DROP TABLE IF EXISTS `pracownicy`;
CREATE TABLE IF NOT EXISTS `pracownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `kontakt` text,
  `role` set('nauczyciel','dyrektor','sekretariat','wychowawca') NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pracownicy_uzytkownicy_idx` (`uzytkownik`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `imie`, `nazwisko`, `kontakt`, `role`, `uzytkownik`, `status`) VALUES
(6, 'admin', 'admin', 'admin', 'dyrektor', 8, 0),
(7, 'Grzech', 'Grzech', '', 'sekretariat,wychowawca', 9, 0),
(8, 'Stanisławia', 'Wielka VIII', '', 'nauczyciel', 10, 0),
(9, 'Anna', 'Zająć', '', 'nauczyciel', 11, 0),
(10, 'Lech', 'Wałęsa', '', 'nauczyciel', 12, 0),
(11, 'Harnaś', 'Ok', '', 'nauczyciel', 13, 0),
(12, 'Prezes', 'PGR', '', 'nauczyciel,wychowawca', 14, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

DROP TABLE IF EXISTS `przedmioty`;
CREATE TABLE IF NOT EXISTS `przedmioty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prowadzacy` int(11) NOT NULL,
  `przedmiot` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pracownicy_przedmioty_idx` (`prowadzacy`),
  KEY `FK_przedmioty_[pracownicy_idx` (`przedmiot`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`id`, `prowadzacy`, `przedmiot`, `status`) VALUES
(1, 7, 1, 0),
(2, 8, 2, 0),
(3, 9, 4, 0),
(4, 12, 5, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nr_sali` varchar(4) NOT NULL,
  `opis` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nr_sali_UNIQUE` (`nr_sali`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`id`, `nr_sali`, `opis`) VALUES
(1, '1', ''),
(2, '2', ''),
(3, '3', ''),
(4, '4', ''),
(5, '5', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slownik_przedmiotow`
--

DROP TABLE IF EXISTS `slownik_przedmiotow`;
CREATE TABLE IF NOT EXISTS `slownik_przedmiotow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) NOT NULL,
  `opis` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `slownik_przedmiotow`
--

INSERT INTO `slownik_przedmiotow` (`id`, `nazwa`, `opis`) VALUES
(1, 'Matematyka', 'Trudne'),
(2, 'Polski', ''),
(3, 'Angielski', 'Mój ulubiony'),
(4, 'Informatyka', ''),
(5, 'Niemiecki', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `terminarz`
--

DROP TABLE IF EXISTS `terminarz`;
CREATE TABLE IF NOT EXISTS `terminarz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sala` int(11) NOT NULL,
  `godzina` int(11) NOT NULL,
  `dzien_tygodnia` varchar(13) NOT NULL,
  `kto_co` int(11) NOT NULL,
  `klasa` int(11) NOT NULL,
  `typ` varchar(10) DEFAULT NULL,
  `poczatek` date DEFAULT NULL,
  `koniec` date DEFAULT NULL,
  `opis` text,
  PRIMARY KEY (`id`),
  KEY `FK_godz_lek_rezerwacje_idx` (`godzina`),
  KEY `FK_sale_rezerwacje_idx` (`sala`),
  KEY `FK_terminarz_przedmioty_idx` (`kto_co`),
  KEY `FK_terminarz_klasy_idx` (`klasa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `terminarz`
--

INSERT INTO `terminarz` (`id`, `sala`, `godzina`, `dzien_tygodnia`, `kto_co`, `klasa`, `typ`, `poczatek`, `koniec`, `opis`) VALUES
(1, 1, 1, 'poniedzialek', 1, 1, 'plan', '2018-08-01', '2018-08-02', ''),
(2, 1, 2, 'poniedzialek', 2, 1, 'plan', '1906-06-05', '1907-07-07', '2'),
(3, 1, 3, 'poniedzialek', 3, 1, 'plan', '1906-06-05', '1907-07-07', '2'),
(4, 3, 6, 'poniedzialek', 4, 1, 'plan', '2018-08-27', '2018-08-29', ''),
(5, 1, 4, 'piatek', 1, 1, 'plan', '1907-07-06', '1907-07-07', ''),
(6, 1, 1, 'poniedzialek', 1, 2, 'plan', '1906-06-05', '1906-06-05', ''),
(7, 1, 1, 'poniedzialek', 2, 2, 'plan', '1907-07-07', '1907-07-07', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

DROP TABLE IF EXISTS `uczniowie`;
CREATE TABLE IF NOT EXISTS `uczniowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `imie_2` varchar(15) DEFAULT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `miejscowosc` varchar(45) NOT NULL,
  `ulica` varchar(45) DEFAULT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `kod_pocztowy` varchar(6) NOT NULL,
  `poczta` varchar(45) NOT NULL,
  `kontakt` text,
  `klasa` int(11) DEFAULT NULL,
  `opiekun` int(11) DEFAULT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pesel_UNIQUE` (`pesel`),
  KEY `opiekun_idx` (`opiekun`),
  KEY `FK_uczniowe_users_idx` (`uzytkownik`),
  KEY `FK_uczniowie_klasy_idx` (`klasa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `uczniowie`
--

INSERT INTO `uczniowie` (`id`, `imie`, `imie_2`, `nazwisko`, `data_urodzenia`, `pesel`, `miejscowosc`, `ulica`, `nr_domu`, `kod_pocztowy`, `poczta`, `kontakt`, `klasa`, `opiekun`, `uzytkownik`, `status`) VALUES
(2, 'henio', '', 'ss', '1915-02-11', '111', 'henio', '2', '2', '22-300', 'poczta', '', 1, 0, 2, 0),
(3, 'zbychu', '', 'troll', '1915-02-11', '2123', 'K', 'K', '2', 'k', 'k', '', 1, 0, 15, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uwagi`
--

DROP TABLE IF EXISTS `uwagi`;
CREATE TABLE IF NOT EXISTS `uwagi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uczen` int(11) NOT NULL,
  `nauczyciel` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `odczytane` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_uwagi_uczniowie_idx` (`uczen`),
  KEY `FK_uwagi_pracownicy_idx` (`nauczyciel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

DROP TABLE IF EXISTS `uzytkownicy`;
CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `sol` varchar(10) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `sol`, `typ`, `mail`, `status`) VALUES
(2, 'henio2000', 'DTRI8', 'uczen', 'henio@h', 0),
(8, 'admin', 'N4M5N', 'pracownik', 'admin@admin', 0),
(9, 'Grzech', '98JTU', 'pracownik', 'grzech@sin', 0),
(10, 'Stanisławia', '8ZRBQ', 'pracownik', 'stani@pl', 0),
(11, 'Anna', '93ZC3', 'pracownik', 'anna@pl', 0),
(12, 'Lech', '4BZON', 'pracownik', 'leszek@pl', 0),
(13, 'Harnaś', 'KFJ37', 'pracownik', 'har@pl', 0),
(14, 'Prezes', 'D4BAF', 'pracownik', 'prezes@pl', 0),
(15, 'zbychu', '87514', 'uczen', 'zbych@pl', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

DROP TABLE IF EXISTS `wiadomosci`;
CREATE TABLE IF NOT EXISTS `wiadomosci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nadawca` int(11) NOT NULL,
  `odbiorca` int(11) NOT NULL,
  `tytul` varchar(100) DEFAULT NULL,
  `tresc` text NOT NULL,
  `zalacznik` varchar(45) DEFAULT NULL,
  `status_nadawcy` tinyint(1) DEFAULT NULL,
  `status_odbiorcy` tinyint(1) DEFAULT NULL,
  `odczytana` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_wiadomosci_uzytkownicy_nadawca_idx` (`nadawca`),
  KEY `FK_wiadomosci_uzytkownicy_odbiorca_idx` (`odbiorca`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `wiadomosci`
--

INSERT INTO `wiadomosci` (`id`, `nadawca`, `odbiorca`, `tytul`, `tresc`, `zalacznik`, `status_nadawcy`, `status_odbiorcy`, `odczytana`) VALUES
(1, 2, 2, 'test', 'test', '', 0, 0, 0),
(2, 8, 2, 'test', 'test', '', 0, 0, 0),
(3, 8, 2, 'test 8', 'łorlololo', '', 0, 0, 1),
(4, 8, 2, 'test 7', 'test', '', 1, 0, 1),
(5, 8, 8, 'pisanie do siebie', 'pisanie do siebie', '', 0, 0, 1),
(6, 8, 8, 'pisanie do siebie', 'pisanie do siebie', '', 0, 0, 1),
(7, 8, 8, 'halo', 'halo', '', 0, 0, 1),
(8, 2, 8, 'henio2000', 'henio2000', '', 0, 1, 1),
(9, 2, 8, 'henio2000', 'henio2000', '', 0, 0, 1),
(10, 8, 2, 'upload', 'upload', 'file1.png', 0, 0, 0),
(11, 8, 2, 'upload', 'upload', 'file1.png', 0, 0, 0),
(12, 8, 2, '$file', '$file', 'file1.png', 1, 0, 0),
(13, 8, 2, 'test', 'test', 'file1.png', 0, 0, 0),
(14, 8, 2, 'test', 'test', 'file1.png', 0, 0, 0),
(15, 8, 2, 'test', 'test', 'file2.png', 0, 0, 0),
(16, 8, 2, 'test', 'test', 'file1.jpeg', 0, 0, 0),
(17, 8, 8, 'test', 'test', '', 0, 0, 1),
(18, 8, 8, 'test', 'test', 'file1.txt', 0, 0, 1),
(19, 8, 8, 'test', 'test', '', 0, 0, 0);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `hasla`
--
ALTER TABLE `hasla`
  ADD CONSTRAINT `FK_hasla_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD CONSTRAINT `FK_Klasy_pracownicy` FOREIGN KEY (`wychowawca`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `obecnosci`
--
ALTER TABLE `obecnosci`
  ADD CONSTRAINT `fk_uczniowe_has_zajecia_uczniowe1` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_uczniowe_has_zajecia_zajecia1` FOREIGN KEY (`termin`) REFERENCES `terminarz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `ocenianie`
--
ALTER TABLE `ocenianie`
  ADD CONSTRAINT `FK_ocenianie_przedmioty` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ocenianie_uczniowie` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmiot1` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `opiekunowie`
--
ALTER TABLE `opiekunowie`
  ADD CONSTRAINT `FK_opiekunowie_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `FK_pracownicy_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD CONSTRAINT `FK_pracownicy_przedmioty` FOREIGN KEY (`prowadzacy`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_przedmioty_[pracownicy` FOREIGN KEY (`przedmiot`) REFERENCES `slownik_przedmiotow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `terminarz`
--
ALTER TABLE `terminarz`
  ADD CONSTRAINT `FK_godz_lek_rezerwacje` FOREIGN KEY (`godzina`) REFERENCES `godz_lek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_rezerwacje` FOREIGN KEY (`sala`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_terminarz_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_terminarz_przedmioty` FOREIGN KEY (`kto_co`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD CONSTRAINT `FK_uczniowe_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_uczniowie_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_uczniowie_opiekunowie` FOREIGN KEY (`opiekun`) REFERENCES `opiekunowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `uwagi`
--
ALTER TABLE `uwagi`
  ADD CONSTRAINT `FK_uwagi_pracownicy` FOREIGN KEY (`nauczyciel`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_uwagi_uczniowie` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD CONSTRAINT `FK_wiadomosci_uzytkownicy_nadawca` FOREIGN KEY (`nadawca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_wiadomosci_uzytkownicy_odbiorca` FOREIGN KEY (`odbiorca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
