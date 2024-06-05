-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: db:3306
-- Üretim Zamanı: 10 Nis 2024, 05:32:02
-- Sunucu sürümü: 5.7.44
-- PHP Sürümü: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dbtecnoc_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `ad` varchar(55) NOT NULL,
  `soyad` varchar(55) NOT NULL,
  `e_posta` varchar(55) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `admins`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adres`
--

CREATE TABLE `adres` (
  `adres_id` int(11) NOT NULL,
  `musteri_id` int(11) NOT NULL,
  `ad` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soyad` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `il` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ilce` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `adres`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `kategoriler` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `kategoriler`) VALUES
(1, 'Bilgisayar'),
(2, 'Telefon'),
(3, 'Televizyon'),
(4, 'Tablet'),
(5, 'Saat');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `resim_adi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seri` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urun_tipi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_karti` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ram` int(11) NOT NULL,
  `ekran_k_hafiza` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_k_tipi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ram_tipi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hafiza` int(11) NOT NULL,
  `renk` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isletim_sistemi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maks_islemci_hiz` float NOT NULL,
  `bellek_hizi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `islemci_nesli` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `islemci` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `islemci_modeli` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_boyut` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `computers`
--

INSERT INTO `computers` (`id`, `urun_kodu`, `resim_adi`, `marka`, `model`, `seri`, `kategori`, `urun_tipi`, `ekran_karti`, `ram`, `ekran_k_hafiza`, `ekran_k_tipi`, `ram_tipi`, `hafiza`, `renk`, `isletim_sistemi`, `maks_islemci_hiz`, `bellek_hizi`, `islemci_nesli`, `islemci`, `islemci_modeli`, `ekran_boyut`) VALUES
(1, 1001, '0001.jpg', 'Lenovo', 'IdeaPad 1', NULL, 'Bilgisayar', 'Notebook', 'Intel UHD Graphics 600', 4, 'Paylaşımlı', 'Dahili', 'DDR4', 128, 'Gri', 'FreeDos', 2.8, '-', 'Intel N Serisi', 'N4020', 'Intel Celeron', 15.6),
(2, 1002, '0002.jpg', 'Huawei', 'MateBook D15', NULL, 'Bilgisayar', 'Notebook', 'Intel Iris Xe Graphics', 16, 'Paylaşımlı', 'Dahili', 'LPDDR4X', 512, 'Gri', 'Windows', 5, '-', '11.Nesil', '1195G7', 'Intel Core i7', 15.6),
(3, 1003, '0003.jpg', 'Monster', 'Abra A5', 'V17.3.4', 'Bilgisayar', 'Oyun', 'Nvidia GeForce RTX 3050 Ti', 32, '4 GB', 'Harici', 'DDR4', 1024, 'Siyah', 'Windows', 4.6, '3200MHz', '11.Nesil', '11800H', 'Intel Core i7', 15.6),
(4, 1004, '0004.jpg', 'HP', 'Victus Gaming Laptop 15', '15-FB0025NT', 'Bilgisayar', 'Oyun', 'AMD Radeon RX6500M', 16, '-', 'Harici', 'DDR4', 512, 'Mavi', 'FreeDos', 4.2, '3200MHz', '5.Nesil', '5600H', 'AMD Ryzen 5', 15.6),
(5, 1005, '0005.jpg', 'Lenovo', 'LOQ', NULL, 'Bilgisayar', 'Notebook', 'Nvidia GeForce RTX 4050', 16, '6 GB', 'Harici', 'DDR5', 512, 'Gri', 'FreeDos', 4.6, '2370MHz', '13.Nesil', '13420H', 'Intel Core i5', 15.6),
(6, 1006, '0006.jpg', 'Asus', 'Rog Strix G16 ', 'G614JU-N3196', 'Bilgisayar', 'Oyun', 'Nvidia GeForce RTX 4050', 16, '6 GB', 'Harici', 'DDR5', 512, 'Gri', 'FreeDos', 4.9, '4800 MHz', '13.Nesil', '13650HX', 'Intel Core i7', 16),
(7, 1007, '0007.jpg', 'Asus', 'Tuf Gaming A15', 'FA507NU-LP051', 'Bilgisayar', 'Oyun', 'Nvidia GeForce RTX 4050', 8, '6 GB', 'Harici', 'DDR5', 512, 'Siyah', 'FreeDos', 4.7, '4800MHz', '7.Nesil', '7735HS', 'AMD Ryzen 7', 15.6),
(8, 1008, '0008.jpg', 'Huawei', 'MateBook D14', NULL, 'Bilgisayar', 'Notebook', 'Intel Iris Xe Graphics', 16, 'Paylaşımlı', 'Dahili', 'LPDDR4X', 512, 'Siyah', 'Windows', 4.4, '-', '12.Nesil', '1240P', 'Intel Core i5', 14),
(9, 1009, '0009.jpg', 'Lenovo', 'IdeaPad Slim 3', NULL, 'Bilgisayar', 'Notebook', 'Intel Iris Xe Graphics', 8, 'Paylaşımlı', 'Dahili', 'LPDDR5', 512, '-', 'FreeDos', 4.4, '4800MHz', '12.Nesil', '12450H', 'Intel Core i5', 15.6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `urun` varchar(55) NOT NULL,
  `musteri_id` int(11) NOT NULL,
  `ad` varchar(15) NOT NULL,
  `soyad` varchar(15) NOT NULL,
  `puan` double NOT NULL,
  `yorum` text NOT NULL,
  `add_time` date NOT NULL,
  `onay` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `evaluations`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `musteri_id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `add_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `favorites`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `siparis_id` int(11) NOT NULL,
  `musteri_id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `birim_fiyat` int(11) NOT NULL,
  `fiyat` int(11) NOT NULL,
  `miktar` int(11) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `add_time` datetime NOT NULL,
  `durum` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `orders`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `resim_adi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seri` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renk` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yuz_tanima` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_boyut` float NOT NULL,
  `kamera` int(11) NOT NULL,
  `pil_gucu` int(11) NOT NULL,
  `on_kamera` int(11) NOT NULL,
  `ram` int(11) NOT NULL,
  `hafiza` int(11) NOT NULL,
  `kablosuz_sarj` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isletim_sistemi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `phones`
--

INSERT INTO `phones` (`id`, `urun_kodu`, `resim_adi`, `marka`, `model`, `seri`, `kategori`, `renk`, `yuz_tanima`, `ekran_boyut`, `kamera`, `pil_gucu`, `on_kamera`, `ram`, `hafiza`, `kablosuz_sarj`, `isletim_sistemi`) VALUES
(1, 2001, '0011.jpg', 'Xiaomi', 'Redmi Note 12 Pro', NULL, 'Telefon', 'Gri', 'Var', 6.67, 108, 5000, 16, 8, 256, 'Yok', 'Android'),
(2, 2002, '0012.jpg', 'Apple', 'iPhone 13', NULL, 'Telefon', 'Siyah', 'Var', 6.1, 12, 3095, 12, 4, 128, 'Var', 'IOS'),
(3, 2003, '0013.jpg', 'Apple', 'iPhone 11', NULL, 'Telefon', 'Beyaz', 'Var', 6.1, 12, 3110, 12, 4, 128, 'Var', 'IOS'),
(4, 2004, '0014.jpg', 'Samsung', 'Galaxy A34', NULL, 'Telefon', 'Siyah', 'Yok', 6.6, 48, 5000, 13, 8, 128, 'Yok', 'Android'),
(5, 2005, '0015.jpg', 'Samsung', 'Galaxy S20 FE', NULL, 'Telefon', 'Mavi', 'Var', 6.5, 12, 4500, 32, 6, 128, 'Var', 'Android'),
(6, 2006, '0016.jpg', 'Apple', 'iPhone 15 Pro', NULL, 'Telefon', 'Siyah Titanyum', 'Var', 6.1, 48, 3650, 12, 8, 128, 'Var', 'IOS'),
(7, 2007, '0017.jpg', 'Samsung', 'Galaxy S23', NULL, 'Telefon', 'Yeşil', 'Var', 6.1, 50, 3900, 12, 8, 128, 'Var', 'Android'),
(8, 2008, '0018.jpg', 'Xiaomi', 'Redmi 10 2022', NULL, 'Telefon', 'Gri', 'Var', 6.5, 50, 5000, 8, 4, 128, 'Yok', 'Android'),
(9, 2009, '0019.jpg', 'General Mobile', 'Gm 24 Pro', NULL, 'Telefon', 'Gri', 'Var', 6.78, 50, 4700, 16, 8, 256, 'Yok', 'Android'),
(10, 2010, '0020.jpg', 'Xiaomi', 'Redmi Note 11 Pro Plus 5G', NULL, 'Telefon', 'Gri', 'Var', 6.65, 108, 4500, 16, 8, 256, 'Yok', 'Android');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sepet`
--

CREATE TABLE `sepet` (
  `sepet_id` int(11) NOT NULL,
  `musteri_id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `miktar` int(11) NOT NULL,
  `add_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `smart_watchs`
--

CREATE TABLE `smart_watchs` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `resim_adi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seri` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamera` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titresim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gps` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sesli_gorusme` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `su_gecirme` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uyku` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kalp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cinsiyet` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renk` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `smart_watchs`
--

INSERT INTO `smart_watchs` (`id`, `urun_kodu`, `resim_adi`, `marka`, `model`, `seri`, `kategori`, `kamera`, `titresim`, `gps`, `sesli_gorusme`, `su_gecirme`, `uyku`, `adim`, `kalp`, `cinsiyet`, `renk`) VALUES
(1, 5001, '0041.jpg', 'Apple', 'Watch Series 8', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Kadın', 'Lacivert'),
(2, 5002, '0042.jpg', 'Huawei', 'Watch GT4', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Erkek', 'Kahverengi'),
(3, 5003, '0043.jpg', 'Apple', 'Watch SE 2.Nesil (2023)', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Unisex', 'Lacivert'),
(4, 5004, '0044.jpg', 'Huawei', 'Watch Buds', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Unisex', 'Siyah'),
(5, 5005, '0045.jpg', 'Samsung', 'Galaxy Watch 6', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Kadın', 'Gümüş'),
(6, 5006, '0046.jpg', 'Huawei', 'Watch GT 3 Pro', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Unisex', 'Titanyum'),
(7, 5007, '0047.jpg', 'Apple', 'Watch Seri 9', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Unisex', 'Kırmızı'),
(8, 5008, '0048.jpg', 'Apple', 'Watch Ultra 2', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Unisex', 'Mavi'),
(9, 5009, '0049.jpg', 'Xiaomi', 'Watch S1', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Erkek', 'Siyah'),
(10, 5010, '0050.jpg', 'Xiaomi', 'Redmi Watch 3 Active', NULL, 'Saat', 'Yok', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Var', 'Erkek', 'Gri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stokfiyat`
--

CREATE TABLE `stokfiyat` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `fiyat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `stokfiyat`
--

INSERT INTO `stokfiyat` (`id`, `urun_kodu`, `stok`, `fiyat`) VALUES
(1, 1001, 20, 6499),
(2, 1002, 19, 20500),
(3, 1003, 20, 28499),
(4, 1004, 20, 21699),
(5, 1005, 20, 29999),
(6, 1006, 20, 41499),
(7, 1007, 20, 30599),
(8, 1008, 19, 18599),
(9, 1009, 20, 13999),
(10, 2001, 20, 12399),
(11, 2002, 20, 34999),
(12, 2003, 20, 32999),
(13, 2004, 20, 10199),
(14, 2005, 20, 11999),
(15, 2006, 20, 64999),
(16, 2007, 19, 28129),
(17, 2008, 20, 6190),
(18, 2009, 20, 9489),
(19, 2010, 20, 12899),
(20, 3001, 20, 15499),
(21, 3002, 20, 10299),
(22, 3003, 20, 42299),
(23, 3004, 20, 21357),
(24, 3005, 20, 11499),
(25, 3006, 20, 18540),
(26, 3007, 20, 3339),
(27, 3008, 20, 22420),
(28, 3009, 20, 40459),
(29, 3010, 20, 21262),
(39, 4001, 20, 4999),
(40, 4002, 20, 10599),
(41, 4003, 20, 8419),
(42, 4004, 20, 14599),
(43, 4005, 20, 19299),
(44, 4006, 20, 3899),
(45, 4007, 20, 13099),
(46, 4008, 20, 6999),
(47, 4009, 20, 24693),
(48, 4010, 20, 3039),
(49, 5001, 20, 21899),
(50, 5002, 20, 6999),
(51, 5003, 20, 8200),
(52, 5004, 20, 9499),
(53, 5005, 20, 6499),
(54, 5006, 20, 8764),
(55, 5007, 20, 14890),
(56, 5008, 20, 39599),
(57, 5009, 20, 4047),
(58, 5010, 20, 2049);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tablets`
--

CREATE TABLE `tablets` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `resim_adi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seri` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renk` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kalem` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ram` int(11) NOT NULL,
  `pil_gucu` int(11) NOT NULL,
  `isletim_sistemi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_boyut` float NOT NULL,
  `hafiza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tablets`
--

INSERT INTO `tablets` (`id`, `urun_kodu`, `resim_adi`, `marka`, `model`, `seri`, `kategori`, `renk`, `kalem`, `ram`, `pil_gucu`, `isletim_sistemi`, `ekran_boyut`, `hafiza`) VALUES
(1, 4001, '0031.jpg', 'Honor', 'Pad X9', NULL, 'Tablet', 'Uzay Grisi', 'Var', 4, 7250, 'Android', 11.5, 128),
(2, 4002, '0032.jpg', 'Samsung', 'Galaxy Tab S7 FE', NULL, 'Tablet', 'Siyah', 'Var', 4, 10090, 'Android', 12.4, 64),
(3, 4003, '0033.jpg', 'Samsung', 'Galaxy Tab S6 Lite', 'SM-P613', 'Tablet', 'Siyah', 'Var', 4, 7040, 'Android', 10.4, 128),
(4, 4004, '0034.jpg', 'Apple', 'iPad 9.Nesil', NULL, 'Tablet', 'Gümüş', 'Var', 8, 9000, 'IOS', 10.2, 256),
(5, 4005, '0035.jpg', 'Apple', 'iPad Air 5. Nesil', NULL, 'Tablet', 'Pembe', 'Var', 8, 9000, 'IOS', 10.9, 64),
(6, 4006, '0036.jpg', 'Lenovo', 'Tab M10', 'ZA6W0008TR', 'Tablet', 'Gri', 'Yok', 2, 5000, 'Android', 10.1, 32),
(7, 4007, '0037.jpg', 'Samsung', 'Galaxy Tab S9 FE+', 'SM-X610', 'Tablet', 'Gümüş', 'Var', 8, 10090, 'Android', 12.4, 128),
(8, 4008, '0038.jpg', 'Xiaomi', 'Redmi Pad Se', NULL, 'Tablet', 'Gri', 'Var', 8, 8000, 'Android', 11, 256),
(9, 4009, '0039.jpg', 'Apple', 'iPad Air 5. Nesil', NULL, 'Tablet', 'Uzay Grisi', 'Var', 8, 9000, 'IOS', 10.9, 256),
(10, 4010, '0040.jpg', 'Samsung', 'Tab A7 Lite', NULL, 'Tablet', 'Koyu Gri', 'Var', 3, 5100, 'Android', 8.7, 32);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `televisions`
--

CREATE TABLE `televisions` (
  `id` int(11) NOT NULL,
  `urun_kodu` int(11) NOT NULL,
  `resim_adi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seri` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekran_boyut` float NOT NULL,
  `smarttv` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isletim_sistemi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `goruntu` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_yil` int(11) NOT NULL,
  `cozunurluk` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enerji_sinifi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `televisions`
--

INSERT INTO `televisions` (`id`, `urun_kodu`, `resim_adi`, `marka`, `model`, `seri`, `kategori`, `ekran_boyut`, `smarttv`, `isletim_sistemi`, `goruntu`, `model_yil`, `cozunurluk`, `enerji_sinifi`) VALUES
(1, 3001, '0021.jpg', 'Toshiba', '65UA3D63DT', NULL, 'Televizyon', 65, 'Var', 'Android', 'LED', 2022, '4K Ultra HD', 'E'),
(2, 3002, '0022.jpg', 'Regal', '58R754U', NULL, 'Televizyon', 58, 'Var', 'Native', 'LED', 2021, '4K Ultra HD', 'E'),
(3, 3003, '0023.jpg', 'Philips', '65PUS8848', NULL, 'Televizyon', 65, 'Var', 'Android', 'LED', 2022, '4K Ultra HD', 'G'),
(4, 3004, '0024.jpg', 'Vestel', '65QA9700', NULL, 'Televizyon', 65, 'Var', 'Android', 'QLED', 2022, '4K Ultra HD', 'E'),
(5, 3005, '0025.jpg', 'Toshiba', '55UA3D63DT', NULL, 'Televizyon', 55, 'Var', 'Android', 'LED', 2022, '4K Ultra HD', 'E'),
(6, 3006, '0026.jpg', 'Vestel', '70U9600', NULL, 'Televizyon', 70, 'Var', 'Native', 'LED', 2021, '4K Ultra HD', 'G'),
(7, 3007, '0027.jpg', 'Onvo', '32OV5000H', NULL, 'Televizyon', 32, 'Yok', 'Native', 'LED', 2023, 'HD', 'E'),
(8, 3008, '0028.jpg', 'TCL', '65P635', NULL, 'Televizyon', 65, 'Var', 'Android', 'LED', 2022, '4K Ultra HD', 'G'),
(9, 3009, '0029.jpg', 'LG', 'OLED55CS3VA', NULL, 'Televizyon', 55, 'Var', 'webOS', 'OLED', 2023, '4K Ultra HD', 'G'),
(10, 3010, '0030.jpg', 'Samsung', '50Q60C', NULL, 'Televizyon', 50, 'Var', 'Tizen', 'QLED', 2022, '4K Ultra HD', 'E');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ad` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soyad` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dogum_tarih` date DEFAULT NULL,
  `e_posta` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durum` bit(1) NOT NULL DEFAULT b'1',
  `recording_time` datetime NOT NULL,
  `login_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--


--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`adres_id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`siparis_id`);

--
-- Tablo için indeksler `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sepet`
--
ALTER TABLE `sepet`
  ADD PRIMARY KEY (`sepet_id`);

--
-- Tablo için indeksler `smart_watchs`
--
ALTER TABLE `smart_watchs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stokfiyat`
--
ALTER TABLE `stokfiyat`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tablets`
--
ALTER TABLE `tablets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `televisions`
--
ALTER TABLE `televisions`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `e_posta` (`e_posta`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `adres`
--
ALTER TABLE `adres`
  MODIFY `adres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `siparis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `sepet`
--
ALTER TABLE `sepet`
  MODIFY `sepet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `smart_watchs`
--
ALTER TABLE `smart_watchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `stokfiyat`
--
ALTER TABLE `stokfiyat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Tablo için AUTO_INCREMENT değeri `tablets`
--
ALTER TABLE `tablets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `televisions`
--
ALTER TABLE `televisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
