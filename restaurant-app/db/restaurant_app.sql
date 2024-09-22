-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: db:3306
-- Üretim Zamanı: 22 Eyl 2024, 14:58:15
-- Sunucu sürümü: 9.0.1
-- PHP Sürümü: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `restaurant_app`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `basket`
--

CREATE TABLE `basket` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `food_id` int NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `food_id`, `note`, `quantity`, `created_at`) VALUES
(3, 5, 2, 'yarım saati geçerse gelmesin', 1, '2024-09-22 15:32:16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `score` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `restaurant_id`, `username`, `title`, `description`, `score`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 'zeyn', 'Güzeldi', 'Yediğim doyurucu bir yemekti gecikmeden dolayı 1 puan kırdım', 9, '2024-09-22 15:52:19', '2024-09-22 15:52:19');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `company`
--

INSERT INTO `company` (`id`, `name`, `description`, `logo_path`, `deleted_at`) VALUES
(1, 'Burger King', 'Sloganı Have It Your Way&#039;dir', './uploads/company/1727008364.svg', NULL),
(2, 'McDonald&#039;s', 'McDonald&#039;s lezzetleri; Hamburgerler, atıştırmalıklar', './uploads/company/1727008774.png', NULL),
(3, 'Çoban Katık', 'Fast Food', './uploads/company/1727008875.png', '2024-09-22 14:57:49'),
(4, 'Domino&#039;s Pizza', 'Her zevke hitap eden leziz pizzalar.', './uploads/company/1727009078.png', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cupon`
--

CREATE TABLE `cupon` (
  `id` int NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `discount` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cupon`
--

INSERT INTO `cupon` (`id`, `restaurant_id`, `name`, `discount`, `created_at`) VALUES
(1, NULL, 'hoşgeldin50', 50, '2024-09-22 15:13:56'),
(2, 1, 'ilk25', 25, '2024-09-22 15:14:12'),
(3, 4, 'sepette100', 50, '2024-09-22 15:14:36'),
(4, 7, 'tıklagelsin', 30, '2024-09-22 15:14:56'),
(5, NULL, 'guncell', 15, '2024-09-22 15:15:12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `food`
--

CREATE TABLE `food` (
  `id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `discount` int NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `food`
--

INSERT INTO `food` (`id`, `restaurant_id`, `name`, `description`, `image_path`, `price`, `discount`, `created_at`, `deleted_at`) VALUES
(1, 1, 'Whopper Menü', 'Whopper Menü keyfini istediğin gibi yaşa!', './uploads/food/1727009827.png', 250, 5, '2024-09-22 14:57:07', NULL),
(2, 2, 'Big King Menü', 'Big King Menü keyfini istediğin gibi yaşa!', './uploads/food/1727010045.png', 250, 10, '2024-09-22 15:00:45', NULL),
(3, 4, 'Çıtır Kova Menü', 'Doyuran Lezzet !', './uploads/food/1727010346.jpg', 552, 3, '2024-09-22 15:05:46', NULL),
(4, 5, 'Tavuk Döner', 'Katık', './uploads/food/1727010467.jpeg', 140, 0, '2024-09-22 15:07:47', NULL),
(5, 6, 'Orta Boy Pizza', 'Bol Malzemeli ', './uploads/food/1727010664.jpg', 240, 6, '2024-09-22 15:11:04', NULL),
(6, 7, 'Büyük Boy Pizza', 'Lezzeti Damağında Kalır !', './uploads/food/1727010711.jpeg', 300, 4, '2024-09-22 15:11:51', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `total_price` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order`
--

INSERT INTO `order` (`id`, `user_id`, `order_status`, `total_price`, `created_at`) VALUES
(1, 5, 2, 338, '2024-09-22 15:17:48'),
(2, 6, 1, 178, '2024-09-22 15:43:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `food_id` int NOT NULL,
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `food_id`, `order_id`, `quantity`, `price`) VALUES
(1, 3, 1, 1, 338),
(2, 4, 1, 1, 338),
(3, 1, 2, 1, 178);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `restaurant`
--

INSERT INTO `restaurant` (`id`, `company_id`, `name`, `description`, `image_path`, `created_at`) VALUES
(1, 1, 'Burger King İzmit', 'Kapanış saati: 23:00', './uploads/restaurant/1727009626.png', '2024-09-22 14:53:46'),
(2, 1, 'Burger King Başiskele', 'Kapanış saati: 00:30', './uploads/restaurant/1727009670.png', '2024-09-22 14:54:30'),
(3, 2, 'McDonald&#039;s İzmit', '10:00–22:00', './uploads/restaurant/1727010143.png', '2024-09-22 15:02:23'),
(4, 2, 'McDonald&#039;s Kartepe', '10:00–00:00', './uploads/restaurant/1727010170.png', '2024-09-22 15:02:50'),
(5, 3, 'Çoban Katık Döner - İzmit Şubesi', 'Dönerci', './uploads/restaurant/1727010406.png', '2024-09-22 15:06:46'),
(6, 4, 'Domino&#039;s Pizza İzmit', 'Kapanış saati: 02:00', './uploads/restaurant/1727010534.png', '2024-09-22 15:08:54'),
(7, 4, 'Domino&#039;s Pizza Kocaeli Yuvacık', 'Kapanış saati: 00:00', './uploads/restaurant/1727010558.png', '2024-09-22 15:09:18');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '2',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `balance` int NOT NULL DEFAULT '5000',
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `company_id`, `role`, `name`, `surname`, `username`, `password`, `balance`, `created_at`, `deleted_at`) VALUES
(0, NULL, 0, 'admin', 'admin', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$S0Q5MFVIc3RiMzJHb0NoeQ$U74dYhrrSF9Cqvg71HH5XEnEM3PY9aL6dHU2NkoKI58', 5000, '2024-09-15 17:18:48', NULL),
(1, 1, 1, 'TAB', 'Gıda ', 'burgerking', '$argon2id$v=19$m=65536,t=4,p=1$clpLNDJjS3JYcEsyZ2w0RA$4r5O9ECmsRqLerpl/7S2HfBk5DBwVLCrYDST9Ud9ShQ', 5000, '2024-09-22 14:48:01', NULL),
(2, 2, 1, 'Anadolu', 'Grubu', 'mcdonalds', '$argon2id$v=19$m=65536,t=4,p=1$ZHdpZC43WmxwOTQxRDcyMw$dJh9q1c9dGvHiBjKtSvStr4L2Eiu7lQZhB1CZcWIyKg', 5000, '2024-09-22 14:49:32', NULL),
(3, 3, 1, 'Çoban', 'Katık', 'Katık', '$argon2id$v=19$m=65536,t=4,p=1$NDN6d0dXTlRyQUVVNjNtOQ$fj2RNMGMMMBlDAg5hQsHQWFDFWrzhRxsUT8gdkb+ZKQ', 5000, '2024-09-22 14:50:26', NULL),
(4, 4, 1, 'Dominos', 'Pizza', 'dominos', '$argon2id$v=19$m=65536,t=4,p=1$VzFLUW12RTdUb1U1UnNZTA$k46SPHuj2ejJ5AP2UtP8YEME1xB1M6R0axGNFn9IhMc', 5000, '2024-09-22 14:51:07', NULL),
(5, NULL, 2, 'Yılmaz', 'Üstüntaş', 'yilmaz', '$argon2id$v=19$m=65536,t=4,p=1$Mnk2U3dsRkZmaTVnZTU5eA$Ypy2kLMWqSEHlLck/ihssOycNCzt3IFYur3mvg5DQlE', 4662, '2024-09-22 15:16:08', NULL),
(6, NULL, 2, 'Zeynep', 'Dağoğlu', 'zeyn', '$argon2id$v=19$m=65536,t=4,p=1$WFRMOFdFSE50WW44MnJWQQ$daDZkP4UR+CJQusSo/RJau2amM/mQuAqFesuJMeqL9I', 5022, '2024-09-22 15:41:46', NULL),
(7, NULL, 2, 'Ahmet', 'Keskin', 'ahmet', '$argon2id$v=19$m=65536,t=4,p=1$a09mRjV3cUpXM2pVOWs5ZA$FlStmd2wqMY8g5AtX+MQdWpxTi1CLmzEEDfoUxTG5uE', 5000, '2024-09-22 14:57:18', '2024-09-22 14:57:40');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_basket` (`user_id`),
  ADD KEY `fk_food_basket` (`food_id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_comments` (`user_id`),
  ADD KEY `fk_restaurant_comments` (`restaurant_id`);

--
-- Tablo için indeksler `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurant_cupon` (`restaurant_id`);

--
-- Tablo için indeksler `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurant_food` (`restaurant_id`);

--
-- Tablo için indeksler `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_order` (`user_id`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food_order_items` (`food_id`),
  ADD KEY `fk_order_order_items` (`order_id`);

--
-- Tablo için indeksler `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_restaurant` (`company_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_users` (`company_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `cupon`
--
ALTER TABLE `cupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `fk_food_basket` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_users_basket` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_restaurant_comments` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_users_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `cupon`
--
ALTER TABLE `cupon`
  ADD CONSTRAINT `fk_restaurant_cupon` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_restaurant_food` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_users_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_food_order_items` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_order_items` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `fk_company_restaurant` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_company_users` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
