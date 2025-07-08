-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2025 at 04:41 PM
-- Server version: 8.0.30
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komikpiece`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` bigint UNSIGNED NOT NULL,
  `komik_id` bigint UNSIGNED NOT NULL,
  `chapter_number` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pages` json DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `komik_id`, `chapter_number`, `title`, `pages`, `views`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 'wleeee', '[\"chapters/11/1/Aswm7gz6aZeiov40J6v1CC5c1QzvZJ3TB3IR7zu4.jpg\", \"chapters/11/1/j2BcV2v2gSOX22Z6c5SGQfhMuAvIFznxzEGmJfML.jpg\", \"chapters/11/1/w3WdSTpsO0HFLowG1yGFT1v5iFOlvTJELHkRNCVz.jpg\"]', 5, '2025-06-22 14:39:48', '2025-06-30 22:31:06'),
(3, 13, 1, 'Mugiwara ya', '[\"chapters/13/1/9fbrrDJLdd8nuYiDBSB9rvTdWXlhvXsVPtpCAEG5.jpg\", \"chapters/13/1/wHA8OFjeMoPY4xI1AkqbPQIUASZ0fhPTSvA8zpCU.jpg\", \"chapters/13/1/JBAbvEgjot9bRcCLAQWkorUKtIe2XrAYe2vVCGfd.jpg\", \"chapters/13/1/pYwt0BapO0saZqS57QZniHfoRwLTrlDTZgPxOnIT.jpg\", \"chapters/13/1/6IqsLzoKxPYfEmOSkAmclxpoNUhid80DMhGUbj35.jpg\", \"chapters/13/1/5MKkOCAONx86xLEWHbU5rHSyLFtPI3zT8nJa9iNq.jpg\", \"chapters/13/1/RGW2DMnGWHbYwHVCOK6xi4RsgjbMOq2Dt6cPRTq5.jpg\", \"chapters/13/1/A5pft7tDBvpWVE6zWwoL2uvyw6eSj0UVRNlnHKnf.jpg\"]', 2, '2025-06-22 14:51:18', '2025-06-29 22:45:31'),
(12, 13, 2, 'Pertemuan', '[\"chapters/13/2/UgEBZUqGiGx3scra5JR5XLn3fWI5U3XAleIhBrje.jpg\", \"chapters/13/2/eHAF1GGGGIFE1pyRhejfDbvcrcOUNzFcqwTatkSa.jpg\", \"chapters/13/2/SXaZB5gFWyNCTOwonRSgcxqS6PHSYTMANGI14pdh.jpg\"]', 2, '2025-06-22 15:14:20', '2025-06-29 22:45:39'),
(15, 15, 1, NULL, '[\"chapters/15/1/nuzsZtZrcVcVLa7EOqgDkDJCoDDn83G5WMJzfUbW.jpg\", \"chapters/15/1/jEYZCZry8yV0EYvNJYO9AJ1IdcyJHrh4PVIyM3J2.jpg\"]', 2, '2025-06-22 15:18:23', '2025-06-22 15:23:13'),
(16, 15, 2, 'll', '[\"chapters/15/2/Q7ojTfSMbKVfuSzSDQjW1dwZHageBUq8KuGEpJsn.jpg\", \"chapters/15/2/TQg9V6wwalLjTHa94v2PhYdhpgv8Cgo3cIznkMO1.jpg\", \"chapters/15/2/yqYSvifDZi2IU7AbcmiKbfQMFT9TDpz3CrTSKooL.jpg\"]', 1, '2025-06-22 15:18:58', '2025-06-22 15:19:01'),
(17, 15, 3, ';l;l', '[\"chapters/15/3/Tz1zgZnqpk088R5ymV9RR57bjadxUNAQGpYdTARi.jpg\", \"chapters/15/3/o8YkHsRtbSQXsFUIuChBINzwSaebQQaFsqThnu4e.jpg\"]', 1, '2025-06-22 15:23:45', '2025-06-22 15:23:48'),
(19, 17, 1, NULL, '[\"chapters/17/1/R1loi0IyXrNMTHVbDrJd57Drm11cMO9zZkiZTh7t.jpg\", \"chapters/17/1/D7pEBBnXqx0pflgy2OG0WEf4M2g6YYUNf3fROqb4.jpg\", \"chapters/17/1/IMCtZG2huHeVdo6DWPibuHnxaRm2vRmetYyrs4wI.jpg\"]', 1, '2025-06-22 15:29:57', '2025-06-22 15:30:02'),
(20, 17, 2, NULL, '[\"chapters/17/2/VNkmRUHOd1FgIMmLWtBheA6zHzd4b9C6RDjkk9mi.jpg\", \"chapters/17/2/cWtonrPvDJCBIVlctu8Q5uJNXukCWY3mV5QeL2cZ.jpg\", \"chapters/17/2/uiPAH9J6f5rIme3Cz8mgDJPZfh69wkKcmBY0Y4sR.jpg\"]', 2, '2025-06-22 15:30:52', '2025-06-22 15:37:49'),
(21, 17, 3, NULL, '[\"chapters/17/3/4Xa7PYPOjt1PvrMmwsR9BkutdufMOcyPUxUP2VP5.jpg\", \"chapters/17/3/xhEL8zvKWxor6qgPSqVuwtYgf8lZcFTweZwMpwHX.jpg\", \"chapters/17/3/RFevD1LKiiRyFBqOvZiDlcky6Peve21IIWwheJMR.jpg\"]', 1, '2025-06-22 15:38:19', '2025-06-22 15:38:22'),
(22, 18, 1, NULL, '[\"chapters/18/1/z1P6f6LuiTlvfEpg2BbFMZucLdpWBSvYFU7kXjTM.jpg\", \"chapters/18/1/Piu2fBTJuGDAjMAO2A1Eq5HTgAqwZe2wUmRO4AQk.jpg\", \"chapters/18/1/9FtgwPyowSGIgOHBn2IvwtfHypJpqm2RkqurbmLH.jpg\"]', 20, '2025-06-22 15:39:47', '2025-06-23 20:35:21'),
(23, 18, 2, NULL, '[\"chapters/18/2/NvGs7F18smTdCLmt1rUbbrcQLQYaufMif7MocuNK.jpg\", \"chapters/18/2/2THMoltX3G9uC0wZY5gylDI0Y6Kq3OtYZzPcmEiV.jpg\", \"chapters/18/2/G5P9789nb7CJrjGf2BwkfzYDn097KcHUrzZVgFZL.jpg\"]', 2, '2025-06-22 15:49:58', '2025-06-23 20:25:04'),
(24, 19, 1, NULL, '[\"chapters/19/1/JX26W1lN6FoBZenkcaBqI6mor5UXJi6Cwa1UEvOj.jpg\"]', 3, '2025-06-23 22:33:49', '2025-06-23 22:35:51'),
(25, 19, 2, 'gasiiinnn', '[\"chapters/19/2/lkZu0f8lUp8CP8M4p50J9zLCKERkXfGuvrxXS37B.jpg\"]', 1, '2025-06-23 22:34:16', '2025-06-23 22:34:32'),
(26, 20, 1, 'siksaan pertama', '[\"chapters/20/1/x2gPi6qmCgExJmJY68lPSv790lK5y4ec75AtquTq.jpg\"]', 1, '2025-06-29 19:25:42', '2025-06-29 19:27:10'),
(28, 20, 2, NULL, '[\"chapters/20/2/6991eLgbbk0krrnAPSzEl1FLFwNaLeGAHIGwHG9j.jpg\"]', 1, '2025-06-29 22:50:20', '2025-06-29 22:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `komik_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `komik_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 13, 1, 'test', '2025-06-29 22:46:26', '2025-06-29 22:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Action', 'action', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(2, 'Adventure', 'adventure', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(3, 'Comedy', 'comedy', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(4, 'Drama', 'drama', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(5, 'Fantasy', 'fantasy', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(6, 'Horror', 'horror', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(7, 'Romance', 'romance', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(8, 'Sci-Fi', 'sci-fi', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(9, 'Slice of Life', 'slice-of-life', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(10, 'Sports', 'sports', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(11, 'Supernatural', 'supernatural', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(12, 'Thriller', 'thriller', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(13, 'Mystery', 'mystery', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(14, 'Historical', 'historical', NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `genre_komik`
--

CREATE TABLE `genre_komik` (
  `genre_id` bigint UNSIGNED NOT NULL,
  `komik_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genre_komik`
--

INSERT INTO `genre_komik` (`genre_id`, `komik_id`) VALUES
(1, 11),
(4, 11),
(6, 11),
(1, 13),
(2, 13),
(3, 13),
(4, 13),
(5, 13),
(1, 14),
(2, 14),
(4, 14),
(5, 14),
(8, 14),
(11, 14),
(7, 15),
(3, 17),
(1, 19),
(2, 19),
(3, 19),
(4, 19),
(5, 19),
(1, 20),
(3, 20),
(4, 20),
(7, 20),
(14, 20);

-- --------------------------------------------------------

--
-- Table structure for table `komiks`
--

CREATE TABLE `komiks` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komiks`
--

INSERT INTO `komiks` (`id`, `judul`, `cover`, `rating`, `status`, `language`, `description`, `author`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Qui velit provident.', 'https://via.placeholder.com/640x480.png/0066ff?text=komik+reiciendis', 4, 'Completed', 'English', 'Aperiam doloremque aut autem asperiores. Voluptatum dolores et non eos enim quae. Nam et distinctio consequuntur mollitia labore. Est ex iusto eligendi enim odit earum esse. Aut aut tenetur est totam quo praesentium.', 'Rylan Weimann Jr.', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(2, 'Vitae quia officia.', 'https://via.placeholder.com/640x480.png/0066ff?text=komik+corporis', 3, 'Completed', 'Japanese', 'Molestiae explicabo laudantium nihil sunt amet alias nostrum. Est rerum rerum impedit dolor sed vel omnis nam. Rem aut recusandae et et nisi et consectetur sed.', 'Ms. Jennie Hackett MD', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(3, 'Aliquid odio quam.', 'https://via.placeholder.com/640x480.png/0022cc?text=komik+rerum', 5, 'Ongoing', 'Japanese', 'Ut vel vitae consequatur sed. Sit repudiandae possimus dolore sapiente alias quam asperiores. Quia aliquam officiis et fugit. Magnam reprehenderit recusandae est et.', 'Jonatan Frami', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(4, 'Eos reiciendis vero corporis.', 'https://via.placeholder.com/640x480.png/001100?text=komik+enim', 3, 'Ongoing', 'Indonesian', 'Temporibus omnis quia rem commodi sint natus. Consequuntur vel recusandae voluptatem et cumque non blanditiis. Voluptates sed nostrum qui consectetur ut consequuntur. Soluta corporis quam repellat laborum.', 'Noelia Cummerata', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(5, 'Cupiditate aut blanditiis.', 'https://via.placeholder.com/640x480.png/004477?text=komik+sapiente', 3, 'Ongoing', 'Indonesian', 'Sunt aliquam sint non repudiandae et sit atque. Sapiente aut repudiandae facere delectus maxime vitae ut. Sint perspiciatis minima qui sit fugit fugiat. Quia quas sapiente et dignissimos ut quod et.', 'Stanton Legros', 1, '2025-06-22 14:37:22', '2025-06-22 14:51:44'),
(6, 'Voluptas quos distinctio eum.', 'https://via.placeholder.com/640x480.png/00ee33?text=komik+aut', 4, 'Completed', 'Japanese', 'Quia vero maxime voluptas ipsa est et non. Iste dolor in et. Omnis velit asperiores sed voluptatem voluptas.', 'Anya Pfannerstill', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(7, 'Consectetur facere quia.', 'https://via.placeholder.com/640x480.png/00cc77?text=komik+corporis', 5, 'Ongoing', 'Japanese', 'Ea recusandae voluptas et vel. Est rerum eius minus labore et ea. Fugit suscipit soluta et odio magni dolores.', 'Mrs. Daphnee McClure Jr.', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(8, 'Et molestiae ratione ea consectetur.', 'https://via.placeholder.com/640x480.png/000000?text=komik+id', 3, 'Completed', 'Indonesian', 'Hic beatae aut veritatis similique quia. Dolorem quo provident autem aut molestiae. Fugit laudantium et cum aut sit assumenda.', 'Mr. Oda Wisozk IV', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(9, 'Commodi consequatur nulla repellendus quis.', 'https://via.placeholder.com/640x480.png/009988?text=komik+qui', 5, 'Ongoing', 'Japanese', 'Quibusdam repellat ducimus sed nihil labore provident. Dolores delectus beatae nihil quod. Quo officiis sint quisquam qui nesciunt rerum a laudantium.', 'Mrs. Aylin Walker', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(10, 'Provident adipisci accusantium.', 'https://via.placeholder.com/640x480.png/0022ee?text=komik+dolor', 1, 'Ongoing', 'English', 'Perferendis nihil hic aliquam ut consectetur. Accusantium ratione a non dolores ex dolorum. Voluptatem necessitatibus ab mollitia sunt hic repellendus est.', 'Marcelle Considine Jr.', 0, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(11, 'SPY X FAMILY', 'covers/ps2GlAmtsTlR9dSwHfl7sBII09mW7klD1C0d5O75.jpg', 5, 'ongoing', 'Indonesia', 'anya waku waku', 'TATASUYA ENDO', 10, '2025-06-22 14:39:48', '2025-06-30 22:31:04'),
(13, 'ONE PIECE', 'covers/u7KM8GjPPsedoDdk6sjjCfm4MHyiOZQEsxBqfSCm.jpg', 5, 'ongoing', 'Indonesia', 'KAIZOKU OU NI NARU', 'Echiro Oda', 18, '2025-06-22 14:51:18', '2025-06-29 22:46:27'),
(14, 'Jojo Bouke', 'covers/1zSbKrC5M4ywzPnaUQd1KXhBIUWfsu8y6hfHqQJ0.jpg', 5, 'ongoing', 'English', 'KONO dIo da', 'arataki', 5, '2025-06-22 15:15:45', '2025-06-24 03:49:09'),
(15, 'pkn', 'covers/oLz1vDyhRHFEQ3AtqNW3q20Ahq8eaOTkiRhtE8N9.png', 0, 'ongoing', 'English', 'lnoonp;j', 'madani', 0, '2025-06-22 15:18:23', '2025-06-22 15:18:23'),
(17, 'Quae velit suscipit.', 'covers/yTkFkgtnQSoP1BU9lC3LVY1VIJ0pEiMNb57xF4IK.jpg', 0, 'completed', 'Japanese', 'sdfghjkl', 'madani', 4, '2025-06-22 15:29:57', '2025-06-29 18:34:37'),
(18, 'l', 'covers/GJxXkIMkDcn1K3auxJCsjHOjuqj1QAY5OvwQHSeJ.jpg', 3, 'completed', 'English', '\'l\'l\r\n\',aewrwarwaer', 'k', 8, '2025-06-22 15:39:47', '2025-06-23 22:30:12'),
(19, 'Solo Leveling', 'covers/TyIULW94CkJZ4FFHjhw1dVkdRrMU6w0iW49elcay.jpg', 4, 'completed', 'Korean', 'solo lev itu dah', 'Chu-gong', 1, '2025-06-23 22:33:49', '2025-06-23 22:34:21'),
(20, 'Siksa Neraka', 'covers/0v3e2CQqoWjWi9asDMr6pFhlV0C5eeVXVAS2VQ3B.jpg', 3, 'completed', 'Indonesia', 'di siksa kamuuuuuuuuuuuuuuuu', 'Madani', 4, '2025-06-29 19:25:42', '2025-06-30 22:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `komik_user`
--

CREATE TABLE `komik_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `komik_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komik_user`
--

INSERT INTO `komik_user` (`user_id`, `komik_id`, `created_at`, `updated_at`) VALUES
(1, 11, '2025-06-23 21:06:28', '2025-06-23 21:06:28'),
(1, 13, '2025-06-23 21:06:24', '2025-06-23 21:06:24'),
(1, 14, '2025-06-23 21:06:33', '2025-06-23 21:06:33'),
(1, 18, '2025-06-23 21:06:43', '2025-06-23 21:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_05_26_053119_komiks', 1),
(4, '2025_05_26_171652_create_komik_user_table', 1),
(5, '2025_05_27_001728_create__comments__komik', 1),
(6, '2025_05_29_121744_create_genres_table', 1),
(7, '2025_05_29_125459_genre_komik', 1),
(8, '2025_06_03_141838_create_chapters_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gofndGlKz2lgKRHg3nvTg0KFIasKUarqiqH6OojW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ1ZDMGhDY2FXUFNXTDV1NDRGS1dmZ0NJV3VGVDJHMm5PdG9oR2NjRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1751351486),
('o3cq5JkfHKlZp02cU0UiqSVxOSIzeXdx1B5lJiQh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM2x3bU9yWFdHREVMbGtDcGJmcWlic1BRanhOZ2JWUW1Na1hsOXV0RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==', 1751266246);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `role`, `email_verified_at`, `password`, `is_banned`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@komikpiece.com', 'admin', '2025-06-22 14:37:22', '$2y$12$Kvi3QBUN5nu8LTFC44CLlOu.2KHIB4oDtvNFF7gcfkEugtwBysI0W', 0, NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(2, 'Super Admin', 'superadmin@komikpiece.com', 'admin', '2025-06-22 14:37:22', '$2y$12$sv.NAdUtcgOZKx2ovVSJ2Oe7aWQjv043QIHC1ItBeYkYecqtZNqB.', 0, NULL, '2025-06-22 14:37:22', '2025-06-22 14:37:22'),
(3, 'dodi12345', 'halidrizki54@gmail.com', 'user', NULL, '$2y$12$k2Al54xeEavmHWQH.oGTU.f1OeFZHdtUmVDp4X9PLEyTqQbFAFAda', 0, NULL, '2025-06-22 14:38:29', '2025-06-23 22:24:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapters_komik_id_chapter_number_unique` (`komik_id`,`chapter_number`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_komik_id_foreign` (`komik_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genres_slug_unique` (`slug`);

--
-- Indexes for table `genre_komik`
--
ALTER TABLE `genre_komik`
  ADD PRIMARY KEY (`genre_id`,`komik_id`),
  ADD KEY `genre_komik_komik_id_foreign` (`komik_id`);

--
-- Indexes for table `komiks`
--
ALTER TABLE `komiks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komik_user`
--
ALTER TABLE `komik_user`
  ADD PRIMARY KEY (`user_id`,`komik_id`),
  ADD KEY `komik_user_komik_id_foreign` (`komik_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `komiks`
--
ALTER TABLE `komiks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komiks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komiks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `genre_komik`
--
ALTER TABLE `genre_komik`
  ADD CONSTRAINT `genre_komik_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `genre_komik_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komiks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komik_user`
--
ALTER TABLE `komik_user`
  ADD CONSTRAINT `komik_user_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komiks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komik_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
