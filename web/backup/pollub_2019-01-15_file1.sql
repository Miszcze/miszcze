/*!40030 SET NAMES UTF8 */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `const`;
CREATE TABLE `const` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO const VALUES
('1','salt','UDF2SDERCZ8184Q5'),
('2','hash','sha512'),
('3','technical_break','0');



DROP TABLE IF EXISTS `godz_lek`;
CREATE TABLE `godz_lek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poczatek` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO godz_lek VALUES
('1','2018-11-28 08:00:00'),
('2','2018-11-28 08:55:00'),
('3','2018-11-28 09:40:00'),
('4','2018-11-28 10:35:00'),
('5','2018-11-28 11:30:00'),
('6','2018-11-28 12:25:00'),
('7','2018-11-28 13:20:00');



DROP TABLE IF EXISTS `hasla`;
CREATE TABLE `hasla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uzytkownik` int(11) DEFAULT NULL,
  `haslo` varchar(200) COLLATE utf8_bin NOT NULL,
  `sol` varchar(10) COLLATE utf8_bin NOT NULL,
  `data` datetime NOT NULL,
  `proby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_hasla_uzytkownicy_idx` (`uzytkownik`),
  CONSTRAINT `FK_hasla_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO hasla VALUES
('8','8','ce37ec9644d22ad2810c3b69fce3f3cce356bb2468fb730d306b89c11dae702b71902710f8d6ff5e1349c6a1ec315731c9dbe2c2ee7f2b381704b9c971efa52b','NAB','2018-08-26 06:36:37','0'),
('9','9','49abe130b043518555094181be0c29d627bb157a4c464864876faeb8540f180a1c11ea41254f1c44f586535f5865031f70ad35fe4049253458d12635608a210e','RIG','2019-01-15 21:48:20','0'),
('10','10','2d27019245cd098703ad30ac73e0a8a37b268ffa7ed282dc618c17d79dc641658e97541d3f0ddf4486721679b8b8d45d6d3436c539e6d9937904653400bc29c8','KW8','2019-01-15 21:49:12','0'),
('11','11','f5b2feee00ee22d6937af80d59057a0032ff0c6cc3902a860e3a8ce107635bfac56dad481d176124621b96c43b3ae10ed622d5511ee557c97fddc6928f741ef5','RSN','2019-01-15 21:51:15','0'),
('12','12','5d9b1a93714366399440189a780559628e04c7a43215e9aaec7468e34791ec636d9e4ed4db3777b6bc01f4b8ca5042c6cf15016bfa44c69a4ecec7dde010b97f','L4P','2019-01-15 21:52:19','0'),
('13','13','8d48ff58e54b35e1b959c0e625929bdd3aca6af34d1ae8863190bfa8124a90f3ec1db948006317a90167d66cfae7c59dcc5b93e7f7b962453464936f8db663d3','HJ1','2019-01-15 21:54:15','0'),
('14','14','22d69cad20950d5d4cb0183a4fcd0caba2445da10147f05ca3b297affcbd74e7d37d2e65346d3bfe67b380c739fed948c14cdd70e0f156e81d8538b77f68cb65','HLS','2019-01-15 21:56:09','0'),
('17','17','5f03ea20d2e5dfc0f9e70853e9148f2e103180d3c7c64ef2e5de4e77447fadf99148e445ce16845dedcfd4952739b3af69d37a3c0120f513f1913d2546ce5e56','F8Q','2019-01-15 21:58:45','0'),
('18','18','1e35513838bc98df41791f64b9d2c4d9563843195aa833f4c01705d98629f7a45f0fcb6efc6be122c431e7a6952c7318c9e2f24b4e8832cbc7e672d07385679c','9BS','2019-01-15 22:01:15','0'),
('19','19','8c8eeb75f8f96f73cfb37c96ad6627c54f6ce2c22d5d4f2c00f47881e379375958eb1459227ca911a6bf6eba3636727afc5b1e40f78d8a01b58750788a83d419','4JL','2019-01-15 22:02:17','0'),
('20','20','f25b81cfbb582639cf77e05f1609fcdb6bafb80ef7eacf6a58e26f1c321e5bc73b4b6a13a5c9eab015b1ec965e8dda23c83c8e9f71bcbafed537624a7ed9ba6c','4OE','2019-01-15 22:02:59','0');



DROP TABLE IF EXISTS `klasy`;
CREATE TABLE `klasy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poziom` int(11) NOT NULL,
  `klasa` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `rocznik` varchar(4) COLLATE utf8_bin NOT NULL,
  `wychowawca` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_KlasyUczniow_pracownicy_idx` (`wychowawca`),
  CONSTRAINT `FK_Klasy_pracownicy` FOREIGN KEY (`wychowawca`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO klasy VALUES
('1','1','a','2000','6','0'),
('2','1','b','2000','15','0'),
('3','1','c','2000','16','0');



DROP TABLE IF EXISTS `obecnosci`;
CREATE TABLE `obecnosci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `obecny` int(2) NOT NULL,
  `uczen` int(11) DEFAULT NULL,
  `zajecia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_uczniowe_has_zajecia_uczniowe1_idx` (`uczen`),
  KEY `fk_uczniowe_has_zajecia_zajecia1_idx` (`zajecia`),
  CONSTRAINT `fk_uczniowe_has_zajecia_uczniowe1` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `obecnosci_ibfk_1` FOREIGN KEY (`zajecia`) REFERENCES `zajecia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `ocenianie`;
CREATE TABLE `ocenianie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uczen` int(11) DEFAULT NULL,
  `prowadzacy` int(11) DEFAULT NULL,
  `ocena` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ocenianie_uczniowie_idx` (`uczen`),
  KEY `FK_ocenianie_pracownicy_idx` (`prowadzacy`),
  CONSTRAINT `FK_CD1D6A23565FE74` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`),
  CONSTRAINT `FK_CD1D6A26E16476E` FOREIGN KEY (`prowadzacy`) REFERENCES `pracownicy` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `oceny`;
CREATE TABLE `oceny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ocena` decimal(2,1) NOT NULL,
  `waga` int(11) DEFAULT NULL,
  `kiedy` datetime NOT NULL,
  `uczen` int(11) DEFAULT NULL,
  `przedmiot` int(11) DEFAULT NULL,
  `typ` varchar(10) COLLATE utf8_bin NOT NULL,
  `uwagi` text COLLATE utf8_bin,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmi_idx` (`przedmiot`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1_idx` (`uczen`),
  CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmiot1` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `opiekunowie`;
CREATE TABLE `opiekunowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(30) COLLATE utf8_bin NOT NULL,
  `kontakt` text COLLATE utf8_bin NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_opiekunowie_users_idx` (`uzytkownik`),
  CONSTRAINT `FK_opiekunowie_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO opiekunowie VALUES
('1','Weronika','Marciniak','123 456 789','20','0');



DROP TABLE IF EXISTS `pracownicy`;
CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(30) COLLATE utf8_bin NOT NULL,
  `kontakt` text COLLATE utf8_bin,
  `role` set('nauczyciel','dyrektor','sekretariat','wychowawca') COLLATE utf8_bin NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pracownicy_uzytkownicy_idx` (`uzytkownik`),
  CONSTRAINT `FK_pracownicy_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO pracownicy VALUES
('6','Arnold','Wróbel','Pok. 218
Poniedziałki od 10:45 do 10:50','nauczyciel,dyrektor,sekretariat,wychowawca','8','0'),
('15','Gabriela','Cieślak','','nauczyciel,wychowawca','9','0'),
('16','Bartek','Sikora','','nauczyciel,wychowawca','10','0'),
('17','Damian','Kozieł','','nauczyciel','11','0'),
('18','Maciej','Grabowski','','nauczyciel,dyrektor','12','0');



DROP TABLE IF EXISTS `przedmioty`;
CREATE TABLE `przedmioty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prowadzacy` int(11) DEFAULT NULL,
  `przedmiot` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pracownicy_przedmioty_idx` (`prowadzacy`),
  KEY `FK_przedmioty_[pracownicy_idx` (`przedmiot`),
  CONSTRAINT `FK_pracownicy_przedmioty` FOREIGN KEY (`prowadzacy`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_przedmioty_[pracownicy` FOREIGN KEY (`przedmiot`) REFERENCES `slownik_przedmiotow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO przedmioty VALUES
('1','6','1','0'),
('2','6','2','0'),
('3','6','3','0'),
('4','15','4','0'),
('5','6','5','0'),
('6','15','6','0'),
('7','16','7','0'),
('8','17','9','0'),
('9','18','10','0'),
('10','18','11','0');



DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nr_sali` varchar(4) COLLATE utf8_bin NOT NULL,
  `opis` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nr_sali_UNIQUE` (`nr_sali`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO sale VALUES
('1','1',''),
('2','2',''),
('3','3',''),
('4','4',''),
('5','5','');



DROP TABLE IF EXISTS `slownik_przedmiotow`;
CREATE TABLE `slownik_przedmiotow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_bin NOT NULL,
  `opis` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO slownik_przedmiotow VALUES
('1','Matematyka',''),
('2','Polski',''),
('3','Angielski',''),
('4','Informatyka',''),
('5','Niemiecki',''),
('6','Fizyka',''),
('7','Chemia',''),
('8','Godzina wychowawcza',''),
('9','Biologia',''),
('10','Geografia',''),
('11','Wychowanie fizyczne','');



DROP TABLE IF EXISTS `terminarz`;
CREATE TABLE `terminarz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sala` int(11) NOT NULL,
  `godzina` int(11) NOT NULL,
  `dzien_tygodnia` varchar(13) COLLATE utf8_bin NOT NULL,
  `kto_co` int(11) NOT NULL,
  `klasa` int(11) NOT NULL,
  `typ` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `poczatek` date DEFAULT NULL,
  `koniec` date DEFAULT NULL,
  `opis` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  KEY `FK_godz_lek_rezerwacje_idx` (`godzina`),
  KEY `FK_sale_rezerwacje_idx` (`sala`),
  KEY `FK_terminarz_przedmioty_idx` (`kto_co`),
  KEY `FK_terminarz_klasy_idx` (`klasa`),
  CONSTRAINT `FK_godz_lek_rezerwacje` FOREIGN KEY (`godzina`) REFERENCES `godz_lek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_sale_rezerwacje` FOREIGN KEY (`sala`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_terminarz_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_terminarz_przedmioty` FOREIGN KEY (`kto_co`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `uczniowie`;
CREATE TABLE `uczniowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) COLLATE utf8_bin NOT NULL,
  `imie_2` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `nazwisko` varchar(30) COLLATE utf8_bin NOT NULL,
  `data_urodzenia` date NOT NULL,
  `pesel` varchar(11) COLLATE utf8_bin NOT NULL,
  `numer_legitymacji` int(11) NOT NULL,
  `miejscowosc` varchar(45) COLLATE utf8_bin NOT NULL,
  `ulica` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `nr_domu` varchar(10) COLLATE utf8_bin NOT NULL,
  `kod_pocztowy` varchar(6) COLLATE utf8_bin NOT NULL,
  `poczta` varchar(45) COLLATE utf8_bin NOT NULL,
  `kontakt` text COLLATE utf8_bin,
  `klasa` int(11) DEFAULT NULL,
  `opiekun` int(11) DEFAULT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pesel_UNIQUE` (`pesel`),
  KEY `opiekun_idx` (`opiekun`),
  KEY `FK_uczniowe_users_idx` (`uzytkownik`),
  KEY `FK_uczniowie_klasy_idx` (`klasa`),
  CONSTRAINT `FK_uczniowe_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uczniowie_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uczniowie_opiekunowie` FOREIGN KEY (`opiekun`) REFERENCES `opiekunowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO uczniowie VALUES
('1','Maciej','','Mazur','1996-01-01','96101012345','1996010','Lublin','Zwyczajna','9','22-400','Lublin','','1','1','13','0'),
('2','Wiktor','','Lewandowski','1996-01-01','96010112345','1996011','Lublin','Dluga','34','22-400','Lublin','','1','','14','0'),
('3','Magdalena','','Wieczorek','1996-01-01','9601012345','1996012','Lublin','Raclawicka','134','22-400','Lublin','','1','','17','0'),
('4','Maciej','','Janicki','1996-01-01','96010112346','1996013','Lublin','Biedy','8','22-400','Lublin','','1','','18','0'),
('5','Witold','','Wysocki','1996-01-01','96010154321','1996014','Lublin','Raclawicka','34','22-400','Lublin','','1','','19','0');



DROP TABLE IF EXISTS `uwagi`;
CREATE TABLE `uwagi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uczen` int(11) NOT NULL,
  `nauczyciel` int(11) NOT NULL,
  `tresc` text COLLATE utf8_bin NOT NULL,
  `odczytane` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_uwagi_uczniowie_idx` (`uczen`),
  KEY `FK_uwagi_pracownicy_idx` (`nauczyciel`),
  CONSTRAINT `FK_uwagi_pracownicy` FOREIGN KEY (`nauczyciel`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uwagi_uczniowie` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `uzytkownicy`;
CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) COLLATE utf8_bin NOT NULL,
  `sol` varchar(10) COLLATE utf8_bin NOT NULL,
  `typ` varchar(20) COLLATE utf8_bin NOT NULL,
  `mail` varchar(60) COLLATE utf8_bin NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO uzytkownicy VALUES
('8','admin','N4M5N','pracownik','admin@admin.pl','0'),
('9','PGabCie','TVYKW','pracownik','cieslak@pollub.pl','0'),
('10','PBarSik','TUOGK','pracownik','barteksikora@pollub.pl','0'),
('11','PDamKoz','JDAAD','pracownik','damkoz@pl.pl','0'),
('12','PMacGra','D1DMP','pracownik','andrzejgrabowski@pl.pl','0'),
('13','U96MaMa','QW5NP','uczen','mazur@pl.pl','0'),
('14','U96WiLe','YO4D5','uczen','lewy@pl.pl','0'),
('17','U96MaWi','TJO20','uczen','wieczorek@pl.pl','0'),
('18','U96MaJa','1QZ5E','uczen','janicki@pl.pl','0'),
('19','U96WiWy','EDFI1','uczen','wysocki@pl.pl','0'),
('20','OWerMar','HBYGO','opiekun','marciniak@pl.pl','0');



DROP TABLE IF EXISTS `wiadomosci`;
CREATE TABLE `wiadomosci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nadawca` int(11) NOT NULL,
  `odbiorca` int(11) NOT NULL,
  `tytul` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `tresc` text COLLATE utf8_bin NOT NULL,
  `zalacznik` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `status_nadawcy` tinyint(1) DEFAULT NULL,
  `status_odbiorcy` tinyint(1) DEFAULT NULL,
  `odczytana` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_wiadomosci_uzytkownicy_nadawca_idx` (`nadawca`),
  KEY `FK_wiadomosci_uzytkownicy_odbiorca_idx` (`odbiorca`),
  CONSTRAINT `FK_wiadomosci_uzytkownicy_nadawca` FOREIGN KEY (`nadawca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_wiadomosci_uzytkownicy_odbiorca` FOREIGN KEY (`odbiorca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `zajecia`;
CREATE TABLE `zajecia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temat` varchar(255) COLLATE utf8_bin NOT NULL,
  `opis` mediumtext COLLATE utf8_bin,
  `termin` int(11) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `termin` (`termin`),
  CONSTRAINT `zajecia_ibfk_1` FOREIGN KEY (`termin`) REFERENCES `terminarz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;