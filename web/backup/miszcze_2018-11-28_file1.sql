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
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO const VALUES
('1','salt','UDF2SDERCZ8184Q5'),
('2','hash','sha512'),
('3','technical_break','0');



DROP TABLE IF EXISTS `godz_lek`;
CREATE TABLE `godz_lek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poczatek` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
  `haslo` varchar(200) NOT NULL,
  `sol` varchar(10) NOT NULL,
  `data` datetime NOT NULL,
  `proby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_hasla_uzytkownicy_idx` (`uzytkownik`),
  CONSTRAINT `FK_hasla_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

INSERT INTO hasla VALUES
('2','2','070e37aafded7e6c9ceb73bf3fffc454b32e7f0f9f321f00f8b53e56b54df1f7ada32a0a66702c2cbdc61c3a78246e4cf0d8928baee75fb25c8e79011e920b09','9VG','2018-08-25 18:57:24','0'),
('8','8','ce37ec9644d22ad2810c3b69fce3f3cce356bb2468fb730d306b89c11dae702b71902710f8d6ff5e1349c6a1ec315731c9dbe2c2ee7f2b381704b9c971efa52b','NAB','2018-08-26 06:36:37','0'),
('9','9','730500ea748785a1a5b148303b99572edc48573d21d279419d945708c62f38f3a0d3c305c03bab6b01c5110ab2ac6a7bd2ca9b85a7cdb0044bb9218a577b9bd8','DIX','2018-08-26 06:55:06','0'),
('10','10','ffd826a83a2e5121e54ad1fbf5474a754ff4f238015ccac7faaf136df3e2ecce457a62d5ed7ee891d747a61ecd5c4f84555bbdc268efad17c2a31afab15571d8','KD7','2018-08-26 06:55:33','0'),
('11','11','ce37ec9644d22ad2810c3b69fce3f3cce356bb2468fb730d306b89c11dae702b71902710f8d6ff5e1349c6a1ec315731c9dbe2c2ee7f2b381704b9c971efa52b','NAB','2018-08-26 06:55:47','0'),
('12','12','bfa6d55a5d61135acdaaaebf475348044ae3b2c97d75904db79222b154d4e372d0dcfa22729769dad3d8f148b7c58168bb7861e093ba7c4db15309e129a32943','G3U','2018-08-26 06:56:03','0'),
('13','13','ca2cb641084d728b3e6f0cf97fd575b2a42937e71c71f6911725c5b8697e39ceb24e7c8c8cf9730d3a92f8049823c3d60cee24bc2b0b32a403ab31384a162a08','NEO','2018-08-26 06:56:42','0'),
('14','14','b36bd39f7f805895f09bde4904c03441639f022a57010c6bcd80010b9f3f52b44bef099d46071c52d42c5073bda19e606907af95fa7c5b8b7330c6d7103b99bd','CD6','2018-08-26 06:57:06','0'),
('15','15','2c0961f704e1b768f6e91c22214a80a3c736844ebe9153999f063feee6b3b3d777be6ed045aa5fbb2d3aac4dc69875e5089edd8550941cb4697cd79484e91130','9R4','2018-08-26 09:57:06','0'),
('16','16','454a1431dda3cf1819a537258add3c5757a479d116db7ab29084b25ea9fd8b312ba48690a075541efdbeb6c8b8f948859d5049cc00dfb8d2b868497304144106','H38','2018-09-23 22:23:53','0'),
('18','18','f7e40d082cd71d1b577a22315b97aa0baf742a8a3b17414bf6d42b430189a02e5546ba7b1e24126def272fc8b5fbb3a0b3da592f5c3dac2a4594373798a0bc88','1YU','2018-10-12 14:28:57','0'),
('19','19','4f3724bc5fb4fd4f1070ac777cce11504939759b774b03e8f744fee118beb36ecf19ad9a441eafbffecb84f9d1858e676e1bcd7449943982f7a544f2dd2e97bd','EHK','2018-10-12 14:35:20','0'),
('20','20','650d2f84121ffd87baf1b22f3f4ffe827213cac687ac39fde0e783b960ca00e65d79fc4860a78fa385755a315bda444b424971599a56cba6dbb84f43b5df0666','WLY','2018-10-12 14:38:30','0'),
('21','21','eb5e091839cb5b8540a897c496c08f9fd932855f6e7c3684cf17e94b7d53005bb6a20111b74daddbe29eaabe636cc3f98f40d8639f8b4467216ca5616edbbfe1','7FT','2018-10-12 14:41:30','0'),
('22','22','331b07980ea6b5dfd7d753550ecb9a714e21c65ca7771f894ca6503de1af483ae35d5e39233a047b7ddff515ef8efa92f3c449cb05becb2dbc71f992dd76fab9','GR6','2018-11-04 10:28:13','0'),
('23','24','1f30b0c4d0fb678e951a4ba2a10c96a5fa40abe2c787df622d389603edfd33e73ec9ee2bb27ccd8abe134fb70e191fc48e614dd0af2031fd893ef08b014fc708','KEQ','2018-11-04 10:33:23','0'),
('24','25','32b141438502234207180e950e95f4cbf08dc0338fb0474ecb4ae603b23d225ccdf4964c1c379c2508460942a8723d630711d2a2cfa59bd5de268fbd37785d4d','MSB','2018-11-04 10:35:30','0'),
('25','26','9218ec5a23bd0af1b67565b07bc07adef20fbd117a00c7e7c4d0ed92858727fe7eb7c4f1ebf5c5c5ec8d8dd2c067564b3208f8c14991a36a2d0f979951ea1a5b','HDT','2018-11-04 10:43:15','0'),
('26','27','b086572eed536e00903ca92c68edc644d5ef08bc4efb5411091aeb8b6e7f78f2972abcb7f9dace04af30e2ba078f3ddb5a8f65a5791db105b73cb1cce386536e','LJF','2018-11-04 10:44:30','0'),
('27','28','b5ca4a8724588e74a98aa7a17ea5c8b7aeb672de5c23fac8157f6c81e4413bc8464b93fdb21815d1ccc91f439ae1776e2715dbe07fb9c1b5f62cf2d657af60fb','ERL','2018-11-04 10:46:08','0'),
('28','29','961abd3effa8583055be90e27f9a245f4afd0f84bc7c414ee0b8f631e4b2ac339ff4c3a51ae380ecad966743b60bdb4bee002c787e27b161404662037df4e7a6','XWH','2018-11-04 12:09:30','0'),
('29','30','87affa2c6418db1b9fae37f242213e26ac152137492d097ff64b6122697ff328a7820072223271f667ebdca5c62f78b018309134fbdf8e35dfd1f3fa86000f92','23H','2018-11-04 13:06:25','0');



DROP TABLE IF EXISTS `klasy`;
CREATE TABLE `klasy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poziom` int(11) NOT NULL,
  `klasa` varchar(1) DEFAULT NULL,
  `rocznik` varchar(4) NOT NULL,
  `wychowawca` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_KlasyUczniow_pracownicy_idx` (`wychowawca`),
  CONSTRAINT `FK_Klasy_pracownicy` FOREIGN KEY (`wychowawca`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO klasy VALUES
('1','1','a','2001','6','0'),
('2','2','a','2002','7','0'),
('3','3','a','2003','8','0'),
('4','1','b','2001','11','0'),
('5','2','b','2002','9','0'),
('6','6','x','2005','6','1'),
('7','6','x','2005','6','1'),
('8','2','t','1111','7','1'),
('9','4','p','1234','6','1'),
('10','9','9','9999','8','1'),
('11','9','9','0008','6','1');



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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

INSERT INTO obecnosci VALUES
('1','2','3','1'),
('2','0','4','1'),
('3','1','5','1'),
('4','1','3','2'),
('5','0','4','2'),
('6','1','5','2'),
('7','1','3','3'),
('8','0','4','3'),
('9','0','5','3'),
('10','1','3','4'),
('11','0','4','4'),
('12','0','5','4'),
('13','0','3','6'),
('14','0','4','6'),
('15','0','5','6'),
('16','0','3','7'),
('17','0','4','7'),
('18','0','5','7'),
('19','1','3','8'),
('20','1','4','8'),
('21','1','5','8'),
('22','1','3','9'),
('23','1','4','9'),
('24','1','5','9'),
('25','1','3','10'),
('26','1','4','10'),
('27','1','5','10'),
('28','1','3','11'),
('29','1','4','11'),
('30','1','5','11'),
('31','0','3','12'),
('32','0','4','12'),
('33','0','5','12'),
('34','0','3','13'),
('35','0','4','13'),
('36','0','5','13'),
('37','0','3','14'),
('38','0','4','14'),
('39','0','5','14'),
('40','2','3','15'),
('41','2','4','15'),
('42','4','5','15'),
('43','2','3','16'),
('44','4','4','16'),
('45','4','5','16');



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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO ocenianie VALUES
('1','14','6','1'),
('2','14','6','1'),
('3','14','6','1'),
('4','14','6','1'),
('5','14','6','1'),
('6','14','6','1'),
('7','14','6','1'),
('8','14','6','1'),
('9','14','6','1'),
('10','14','6','1'),
('11','14','7','1'),
('12','14','7','1'),
('13','14','7','1'),
('14','14','7','1'),
('15','14','7','1'),
('16','14','7','1'),
('17','14','7','1'),
('18','14','7','1'),
('19','14','7','1'),
('20','14','7','1'),
('21','14','8','1'),
('22','14','8','1'),
('23','14','8','1'),
('24','14','8','1'),
('25','14','8','1'),
('26','14','8','1'),
('27','14','8','1'),
('28','14','8','1'),
('29','14','8','1'),
('30','14','8','1'),
('31','14','9','1'),
('32','14','9','1'),
('33','14','9','1'),
('34','14','9','1'),
('35','14','9','1'),
('36','14','9','1'),
('37','14','9','1'),
('38','14','9','1'),
('39','14','9','1'),
('40','14','9','1'),
('41','14','10','1'),
('42','14','10','1'),
('43','14','10','1'),
('44','14','10','1'),
('45','14','10','1'),
('46','14','10','1'),
('47','14','10','1'),
('48','14','10','1'),
('49','14','10','1'),
('50','14','10','1'),
('51','14','11','1'),
('52','14','11','1'),
('53','14','11','1'),
('54','14','11','1'),
('55','14','11','1'),
('56','14','11','1'),
('57','14','11','1'),
('58','14','11','1'),
('59','14','11','1'),
('60','14','11','1'),
('61','14','12','1'),
('62','14','12','1'),
('63','14','12','1'),
('64','14','12','1'),
('65','14','12','1'),
('66','14','12','1'),
('67','14','12','1'),
('68','14','12','1'),
('69','14','12','1'),
('70','14','12','10');



DROP TABLE IF EXISTS `oceny`;
CREATE TABLE `oceny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ocena` decimal(2,1) NOT NULL,
  `waga` int(11) DEFAULT NULL,
  `kiedy` datetime NOT NULL,
  `uczen` int(11) DEFAULT NULL,
  `przedmiot` int(11) DEFAULT NULL,
  `typ` varchar(10) NOT NULL,
  `uwagi` text,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmi_idx` (`przedmiot`),
  KEY `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1_idx` (`uczen`),
  CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmiot1` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO oceny VALUES
('1','1.1','0','2018-10-02 00:00:00','4','1','test','','0'),
('2','4.8','0','2018-10-20 10:24:37','3','1','kartkówka','','0'),
('3','3.0','0','2018-10-20 10:29:13','3','1','kartkówka','','0'),
('4','6.0','0','2018-11-02 21:21:51','4','5','sprawdzian','','0'),
('5','6.0','0','2018-11-02 21:34:05','4','5','sprawdzian','','0'),
('6','6.0','0','2018-11-02 21:34:28','5','5','sprawdzian','','0'),
('7','3.0','0','2018-11-02 22:13:40','4','5','kartkówka','','0'),
('8','3.8','0','2018-11-02 22:15:36','4','5','kartkówka','','0');



DROP TABLE IF EXISTS `opiekunowie`;
CREATE TABLE `opiekunowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `kontakt` text NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_opiekunowie_users_idx` (`uzytkownik`),
  CONSTRAINT `FK_opiekunowie_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO opiekunowie VALUES
('1','stefan','stefan','stefan','29','0');



DROP TABLE IF EXISTS `pracownicy`;
CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `kontakt` text,
  `role` set('nauczyciel','dyrektor','sekretariat','wychowawca') NOT NULL,
  `uzytkownik` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pracownicy_uzytkownicy_idx` (`uzytkownik`),
  CONSTRAINT `FK_pracownicy_uzytkownicy` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO pracownicy VALUES
('6','Arnold','Wróbel','Pok. 218
Poniedziałki od 10:45 do 10:50','nauczyciel,dyrektor,sekretariat,wychowawca','8','0'),
('7','Grzegorz','Adamczuk','536 777 385','sekretariat,wychowawca','9','0'),
('8','Stanisława','Kowalska','Stanislawa.K@wp.pl','nauczyciel,wychowawca','10','0'),
('9','Anna','Mucha','449 356 877','nauczyciel,wychowawca','11','0'),
('10','Lech','Wałęsa','kom. 246 465 555
dom. (77) 65 63 334
praca (34) 56 99 101','nauczyciel','12','0'),
('11','Hieronim','Misztal','wew. 112','nauczyciel,wychowawca','13','0'),
('12','Mariola','Nowosad','Wew 115','nauczyciel,wychowawca','14','0'),
('13','krzysztof','barczak','barczak','sekretariat,wychowawca','30','0');



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO przedmioty VALUES
('1','7','1','0'),
('2','8','2','0'),
('3','9','4','0'),
('4','12','5','0'),
('5','6','6','0'),
('6','11','10','0'),
('7','10','9','0'),
('8','9','11','0'),
('9','13','10','1'),
('10','13','11','1');



DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nr_sali` varchar(4) NOT NULL,
  `opis` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nr_sali_UNIQUE` (`nr_sali`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO sale VALUES
('1','1',''),
('2','2',''),
('3','3',''),
('4','4',''),
('5','5','');



DROP TABLE IF EXISTS `slownik_przedmiotow`;
CREATE TABLE `slownik_przedmiotow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) NOT NULL,
  `opis` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO slownik_przedmiotow VALUES
('1','Matematyka','Trudne'),
('2','Polski',''),
('3','Angielski','Mój ulubiony'),
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
  KEY `FK_terminarz_klasy_idx` (`klasa`),
  CONSTRAINT `FK_godz_lek_rezerwacje` FOREIGN KEY (`godzina`) REFERENCES `godz_lek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_sale_rezerwacje` FOREIGN KEY (`sala`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_terminarz_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_terminarz_przedmioty` FOREIGN KEY (`kto_co`) REFERENCES `przedmioty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

INSERT INTO terminarz VALUES
('1','1','1','poniedzialek','1','1','plan','2018-08-01','2018-08-02',''),
('2','1','2','poniedzialek','2','1','plan','1906-06-05','1907-07-07','2'),
('3','1','3','poniedzialek','3','1','plan','1906-06-05','1907-07-07','2'),
('4','3','6','poniedzialek','4','1','plan','2018-08-27','2018-08-29',''),
('5','1','4','piatek','1','1','plan','1907-07-06','1907-07-07',''),
('6','1','1','poniedzialek','1','2','plan','1906-06-05','1906-06-05',''),
('7','1','1','poniedzialek','2','2','plan','1907-07-07','1907-07-07',''),
('8','1','1','poniedzialek','1','1','plan','2018-08-01','2018-08-02',''),
('9','1','4','poniedzialek','3','1','plan','2018-10-01','2018-10-16',''),
('10','4','5','poniedzialek','7','1','plan','2018-09-24','2018-10-26',''),
('11','1','2','wtorek','4','1','plan','2018-09-24','2018-11-02',''),
('12','1','3','wtorek','5','1','plan','2018-10-01','2018-10-31',''),
('13','1','4','wtorek','6','1','plan','2018-09-24','2018-10-28',''),
('14','1','5','wtorek','7','1','plan','2018-09-24','2018-10-31',''),
('15','1','2','sroda','1','1','plan','2018-10-01','2018-10-31',''),
('16','1','5','sroda','1','1','plan','2018-10-01','2018-10-31',''),
('17','1','3','sroda','1','1','plan','2018-10-01','2018-10-31',''),
('18','1','4','sroda','6','1','plan','2018-10-01','2018-10-31',''),
('19','1','1','czwartek','8','1','plan','2018-10-01','2018-10-31',''),
('20','4','2','czwartek','8','1','plan','2018-10-01','2018-10-31',''),
('21','1','3','poniedzialek','6','1','plan','2018-10-01','2018-10-31',''),
('22','1','5','czwartek','2','1','plan','2018-10-01','2018-10-31',''),
('23','1','4','czwartek','2','1','plan','2018-10-01','2018-10-31',''),
('24','1','3','czwartek','2','1','plan','2018-10-01','2018-10-31',''),
('25','1','6','piatek','6','1','plan','2018-10-01','2018-10-31',''),
('26','1','5','piatek','2','1','plan','2018-10-01','2018-10-31',''),
('27','1','3','piatek','5','1','plan','2018-10-01','2018-10-31','');



DROP TABLE IF EXISTS `uczniowie`;
CREATE TABLE `uczniowie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(15) NOT NULL,
  `imie_2` varchar(15) DEFAULT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `numer_legitymacji` int(11) NOT NULL,
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
  KEY `FK_uczniowie_klasy_idx` (`klasa`),
  CONSTRAINT `FK_uczniowe_users` FOREIGN KEY (`uzytkownik`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uczniowie_klasy` FOREIGN KEY (`klasa`) REFERENCES `klasy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uczniowie_opiekunowie` FOREIGN KEY (`opiekun`) REFERENCES `opiekunowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO uczniowie VALUES
('2','Henryk','','Szust','2001-02-11','01021187243','59708','Uhanie','brak','2','22-300','Uhanie','GG: 12345678
Tlen: Henio','2','1','2','0'),
('3','Zbigniew','','Krupa','2001-09-11','01091132956','59709','Kalinowice','brak','199','22-400','Zamość','tel. 654 499 601','1','1','15','0'),
('4','Bogusław','Adam','Tracz','2001-11-05','01110599223','59710','Zamość','Kalinowice','1','22-400','Zamość','Tel. 987654345','1','0','16','0'),
('5','Krzysztof','','Borewicz','2001-12-30','1123056744','59711','Lublin','Prosta','11','22-600','Lublin','459 789 566','1','0','18','0'),
('6','Malgorzata','','Mróz','2002-09-01','2090148777','59712','Wólka Panieska','brak','2','22-400','Zamość','775 884 993','2','0','19','0'),
('7','Robert','','Paszuk','2002-10-11','2101193384','59713','Szopinek','brak','10','22-400','Zamść','brak','2','0','20','0'),
('8','Joanna','Anna','Niemira','2002-05-05','2050510899','59714','Nowa Wieś','brak','100','33-500','Jasionka','657 234 867','2','0','21','0'),
('9','marcin','','gorski','1996-10-07','1996','199610','Krasnystaw','rybia','2','22-300','krasnystaw','co to','1','0','22','0'),
('10','marcin','','gorski','1996-10-07','123','199610','Krasnystaw','rybia','2','22-300','posiadam','nie mam','1','0','24','0'),
('11','marcin','marcin','gorsoki','1996-10-07','666','1996100','Krasnystaw','Rybia','2','22-300','nie mam','mam','1','1','25','0'),
('12','marcin','','gorski','1996-10-07','123222','1996100','Krasnystaw','Rybia','2','22-300','tk','','1','0','26','0'),
('13','marcin','marcin','gorski','1996-10-07','12341234','1996100','Krasnystaw','Rybia','2','22-300','uczen','','1','0','27','0'),
('14','dupa','dupa','gorski','1996-10-07','11111','1996101','dupa','dupa','11111','dupa','dupa','dupa','1','1','28','0');



DROP TABLE IF EXISTS `uwagi`;
CREATE TABLE `uwagi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uczen` int(11) NOT NULL,
  `nauczyciel` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `odczytane` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_uwagi_uczniowie_idx` (`uczen`),
  KEY `FK_uwagi_pracownicy_idx` (`nauczyciel`),
  CONSTRAINT `FK_uwagi_pracownicy` FOREIGN KEY (`nauczyciel`) REFERENCES `pracownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_uwagi_uczniowie` FOREIGN KEY (`uczen`) REFERENCES `uczniowie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `uzytkownicy`;
CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `sol` varchar(10) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

INSERT INTO uzytkownicy VALUES
('2','U01hesz','DTRI8','uczen','heszu@gmail.com','0'),
('8','admin','N4M5N','pracownik','admin@onet.pl','0'),
('9','GrzAda','98JTU','pracownik','grzech@wp.pl','0'),
('10','StaKow','8ZRBQ','pracownik','Stanislawa.K@wp.pl','0'),
('11','AnnMuc','N4M5N','pracownik','Muszka@interia.pl','0'),
('12','LecWal','4BZON','pracownik','bolek.to.ja@gmail.com','0'),
('13','HieMis','KFJ37','pracownik','Misztal.H@pl','0'),
('14','MarNow','D4BAF','pracownik','Nowoczesna@onet.pl','0'),
('15','U01zbkr','87514','uczen','zbych@poczta.pl','0'),
('16','U01botr','B6YQB','uczen','tralala@op.pl','0'),
('18','U01KrBo','T2C7I','uczen','Borewicz.Krzysztof@wp.pl','0'),
('19','U02MaMr','7L0MT','uczen','Mrozna@gmail.com','0'),
('20','U02ropa','MTP82','uczen','Rpaszu@o2.pl','0'),
('21','U02','PEW38','uczen','Asia06@wp.pl','0'),
('22','U96mago','MS5YQ','uczen','marcin@marcin','0'),
('24','U96mago1','YA8AH','uczen','marcin@marcin2','0'),
('25','U96mago2','M4T24','uczen','marcin@marcin3','0'),
('26','U96mago3','PEW1O','uczen','marcin@marcin0','0'),
('27','U96mago4','G51OA','uczen','marcin@marcin12','0'),
('28','U96mago5','4FBOM','uczen','dupa@dupa','0'),
('29','Osteste','MRF1O','opiekun','stefan@stefan','0'),
('30','Pkrzbar','GBY2B','pracownik','sexi@sexi','0');



DROP TABLE IF EXISTS `wiadomosci`;
CREATE TABLE `wiadomosci` (
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
  KEY `FK_wiadomosci_uzytkownicy_odbiorca_idx` (`odbiorca`),
  CONSTRAINT `FK_wiadomosci_uzytkownicy_nadawca` FOREIGN KEY (`nadawca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_wiadomosci_uzytkownicy_odbiorca` FOREIGN KEY (`odbiorca`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

INSERT INTO wiadomosci VALUES
('1','2','2','test','test','','0','0','0'),
('2','8','2','test','test','','0','0','1'),
('3','8','2','test 8','łorlololo','','0','0','1'),
('4','8','2','test 7','test','','1','0','1'),
('5','8','8','pisanie do siebie','pisanie do siebie','','0','0','1'),
('6','8','8','pisanie do siebie','pisanie do siebie','','0','0','1'),
('7','8','8','halo','halo','','0','0','1'),
('8','2','8','henio2000','henio2000','','0','1','1'),
('9','2','8','henio2000','henio2000','','0','0','1'),
('10','8','2','upload','upload','file1.png','0','0','1'),
('11','8','2','upload','upload','file1.png','0','0','0'),
('12','8','2','$file','$file','file1.png','1','0','0'),
('13','8','2','test','test','file1.png','0','0','0'),
('14','8','2','test','test','file1.png','0','0','0'),
('15','8','2','test','test','file2.png','0','0','0'),
('16','8','2','test','test','file1.jpeg','0','0','0'),
('17','8','8','test','test','','0','0','1'),
('18','8','8','test','test','file1.txt','0','0','1'),
('19','8','8','test','test','','1','1','0'),
('20','8','8','test','test','','1','1','0'),
('21','8','8','test','test','','1','1','0'),
('22','8','8','test3','test4','','1','1','0'),
('23','8','8','test','t','','0','0','0');



DROP TABLE IF EXISTS `zajecia`;
CREATE TABLE `zajecia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temat` varchar(255) NOT NULL,
  `opis` text,
  `termin` int(11) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `termin` (`termin`),
  CONSTRAINT `zajecia_ibfk_1` FOREIGN KEY (`termin`) REFERENCES `terminarz` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO zajecia VALUES
('1','test','','4','2018-10-16 19:52:13'),
('2','test','test','1','2018-10-16 20:18:19'),
('3','asfd','asdf','5','2018-10-16 20:20:51'),
('4','test','test','12','2018-10-26 21:59:37'),
('6','test','test','12','2018-10-26 22:02:26'),
('7','test','test','12','2018-10-27 01:00:00'),
('8','test','test','12','2018-11-02 21:04:40'),
('9','test','test','12','2018-11-02 21:05:27'),
('10','test','test','12','2018-11-02 21:05:59'),
('11','test','test','12','2018-11-02 21:06:55'),
('12','test spoznienia','','12','2018-11-02 22:18:39'),
('13','qqq','','12','2018-11-02 22:57:57'),
('14','test','test','12','2018-11-03 19:07:28'),
('15','test','test','12','2018-11-03 19:38:14'),
('16','test','','27','2018-11-03 20:00:30');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;