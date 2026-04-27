-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th4 19, 2021 lúc 04:23 AM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `iapk`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '2021-03-15 05:03:00', '$2y$10$fIpxMHp3HA.fOIbB4.EcUOLP9.NyiPTCLYjJU2Np4inKzVd1275lC', 'Iy9xJD3O0Rz4qwMl2hQW9plZiOuUCv0FBagLdse3yUOdRusBlDQ3NFAQdtfR', '2021-03-15 05:03:00', '2021-04-18 19:22:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ads`
--

CREATE TABLE `ads` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ads`
--

INSERT INTO `ads` (`id`, `title`, `code`, `created_at`, `updated_at`) VALUES
(1, 'below_header', NULL, NULL, '2021-04-14 03:25:31'),
(2, 'above_footer', NULL, NULL, '2021-04-14 03:31:43'),
(3, 'above_top_downloads', NULL, NULL, '2021-04-14 03:36:39'),
(4, 'below_top_downloads', NULL, NULL, '2020-01-06 18:59:38'),
(5, 'above_right_column', NULL, NULL, '2021-04-14 03:30:14'),
(6, 'below_right_column', NULL, NULL, '2020-01-06 18:59:31'),
(7, 'below_download_page', NULL, NULL, '2020-01-06 18:59:28'),
(8, 'above_download_page', NULL, NULL, '2021-04-17 07:38:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `developer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `five` int(20) DEFAULT 0,
  `four` int(20) DEFAULT 0,
  `three` int(20) DEFAULT 0,
  `two` int(20) DEFAULT 0,
  `one` int(20) DEFAULT 0,
  `releasedTimestamp` int(10) DEFAULT NULL,
  `updatedTimestamp` int(10) DEFAULT NULL,
  `numberVoters` int(10) NOT NULL DEFAULT 0,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `votes` decimal(3,2) DEFAULT 0.00,
  `screenshots` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apps_info`
--

CREATE TABLE `apps_info` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appid` varchar(255) NOT NULL,
  `summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recentChange` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appVersion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `androidVersion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` tinyint(4) NOT NULL DEFAULT 1,
  `navbar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `title`, `fa_icon`, `slug`, `category`, `sort`, `navbar`, `footer`, `created_at`, `updated_at`) VALUES
(1, 'Art & Design', NULL, 'ART_AND_DESIGN', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(2, 'Auto & Vehicles', NULL, 'AUTO_AND_VEHICLES', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(3, 'Beauty', NULL, 'BEAUTY', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(4, 'Books & Reference', NULL, 'BOOKS_AND_REFERENCE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(5, 'Business', NULL, 'BUSINESS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(6, 'Comics', NULL, 'COMICS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(7, 'Communication', NULL, 'COMMUNICATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(8, 'Dating', NULL, 'DATING', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(9, 'Education', NULL, 'EDUCATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(10, 'Entertainment', NULL, 'ENTERTAINMENT', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(11, 'Events', NULL, 'EVENTS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(12, 'Finance', NULL, 'FINANCE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(13, 'Food & Drink', NULL, 'FOOD_AND_DRINK', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(14, 'Health & Fitness', NULL, 'HEALTH_AND_FITNESS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(15, 'House & Home', NULL, 'HOUSE_AND_HOME', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(16, 'Libraries & Demo', NULL, 'LIBRARIES_AND_DEMO', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(17, 'Lifestyle', NULL, 'LIFESTYLE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(18, 'Maps & Navigation', NULL, 'MAPS_AND_NAVIGATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(19, 'Medical', NULL, 'MEDICAL', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(20, 'Music & Audio', NULL, 'MUSIC_AND_AUDIO', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(21, 'News & Magazines', NULL, 'NEWS_AND_MAGAZINES', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(22, 'Parenting', NULL, 'PARENTING', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(23, 'Personalization', NULL, 'PERSONALIZATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(24, 'Photography', NULL, 'PHOTOGRAPHY', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(25, 'Productivity', NULL, 'PRODUCTIVITY', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(26, 'Shopping', NULL, 'SHOPPING', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(27, 'Social', NULL, 'SOCIAL', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(28, 'Sports', NULL, 'SPORTS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(29, 'Tools', NULL, 'TOOLS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(30, 'Travel & Local', NULL, 'TRAVEL_AND_LOCAL', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(31, 'Video Players & Editors', NULL, 'VIDEO_PLAYERS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(32, 'Wear OS by Google', NULL, 'ANDROID_WEAR', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(33, 'Weather', NULL, 'WEATHER', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(34, 'Games', NULL, 'GAME', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(35, 'Action', NULL, 'GAME_ACTION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(36, 'Adventure', NULL, 'GAME_ADVENTURE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(37, 'Arcade', NULL, 'GAME_ARCADE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(38, 'Board', NULL, 'GAME_BOARD', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(39, 'Card', NULL, 'GAME_CARD', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(40, 'Casino', NULL, 'GAME_CASINO', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(41, 'Casual', NULL, 'GAME_CASUAL', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(42, 'Educational', NULL, 'GAME_EDUCATIONAL', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(43, 'Music', NULL, 'GAME_MUSIC', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(44, 'Puzzle', NULL, 'GAME_PUZZLE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(45, 'Racing', NULL, 'GAME_RACING', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(46, 'Role Playing', NULL, 'GAME_ROLE_PLAYING', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(47, 'Simulation', NULL, 'GAME_SIMULATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(48, 'Sports', NULL, 'GAME_SPORTS', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(49, 'Strategy', NULL, 'GAME_STRATEGY', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(50, 'Trivia', NULL, 'GAME_TRIVIA', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(51, 'Word', NULL, 'GAME_WORD', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(52, 'Kids', NULL, 'FAMILY', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(53, 'Action & Adventure', NULL, 'FAMILY_ACTION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(54, 'Brain Games', NULL, 'FAMILY_BRAINGAMES', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(55, 'Creativity', NULL, 'FAMILY_CREATE', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(56, 'Education', NULL, 'FAMILY_EDUCATION', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(57, 'Music & Video', NULL, 'FAMILY_MUSICVIDEO', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38'),
(58, 'Pretend Play', NULL, 'FAMILY_PRETEND', NULL, 1, NULL, NULL, '2021-03-19 02:05:38', '2021-03-19 02:05:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `app_id` mediumint(9) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `developer`
--

CREATE TABLE `developer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2019_10_08_193313_create_programs_table', 1),
(6, '2019_10_24_135043_votes', 1),
(8, '2019_10_28_154816_fa_icons', 1),
(13, '2019_11_01_055232_ads', 4),
(14, '2019_10_09_130112_settings', 5),
(17, '2019_10_09_112343_categories', 6),
(18, '2019_10_31_152257_pages', 7),
(19, '2019_10_25_153242_platforms', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(755) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` tinyint(4) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `title`, `details`, `sort`, `slug`, `local`, `created_at`, `updated_at`) VALUES
(4, 'Contact Us', '<h1 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; color: rgb(85, 85, 85); font-size: 24px; line-height: 40px; font-weight: 500; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\"><span style=\"color: rgb(102, 102, 102); font-size: 16px; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit;\">If you want to Contact administrator, Send your suggestions, DMCA takedown request, Report website bugs, or Submit your apps, Please contact us using the following way:</span><br></h1><ul style=\"margin: 10px 20px; list-style-image: initial; list-style-type: disc; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\"><li style=\"margin: 0px; padding: 0px; list-style: inherit; font-size: 16px; line-height: 30px;\">Send Email:&nbsp;<strong><a href=\"mailto:apkstore.biz@gmail.com\">apkstore.biz@gmail.com</a></strong></li></ul>', 3, 'contact-us', 'en', '2019-10-31 14:13:50', '2021-04-15 00:01:35'),
(14, 'About Us', '<div><p>Lorem\r\n ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod \r\ntempor incididunt ut labore et dolore magna aliqua. Orci nulla \r\npellentesque dignissim enim sit. Pellentesque nec nam aliquam sem et \r\ntortor consequat id. Nisl tincidunt eget nullam non nisi. Eget velit \r\naliquet sagittis id consectetur purus ut faucibus. Magna fermentum \r\niaculis eu non diam phasellus vestibulum. Eleifend donec pretium \r\nvulputate sapien. Faucibus et molestie ac feugiat sed. Lacus sed viverra\r\n tellus in hac habitasse platea dictumst vestibulum. Id aliquet risus \r\nfeugiat in. In nulla posuere sollicitudin aliquam ultrices sagittis orci\r\n a scelerisque. Quisque non tellus orci ac auctor augue mauris. Ornare \r\nsuspendisse sed nisi lacus sed.</p>\r\n<p>Nulla porttitor massa id neque aliquam vestibulum morbi blandit. \r\nVivamus at augue eget arcu. Eget nunc scelerisque viverra mauris in \r\naliquam sem fringilla. Risus nullam eget felis eget nunc lobortis. \r\nLibero enim sed faucibus turpis in. Scelerisque in dictum non \r\nconsectetur a. Habitant morbi tristique senectus et netus et malesuada \r\nfames. Nulla aliquet porttitor lacus luctus accumsan tortor. Faucibus et\r\n molestie ac feugiat. Turpis massa sed elementum tempus egestas sed. \r\nSemper auctor neque vitae tempus. Sapien pellentesque habitant morbi \r\ntristique senectus. Non nisi est sit amet facilisis. Est lorem ipsum \r\ndolor sit amet consectetur adipiscing elit pellentesque. Diam quis enim \r\nlobortis scelerisque fermentum dui faucibus in ornare. Lorem ipsum dolor\r\n sit amet consectetur adipiscing elit.</p>\r\n<p>Nunc sed id semper risus in hendrerit gravida. Tellus id interdum \r\nvelit laoreet. Congue mauris rhoncus aenean vel elit scelerisque mauris \r\npellentesque. Nunc vel risus commodo viverra maecenas accumsan lacus vel\r\n facilisis. Donec et odio pellentesque diam volutpat. Nunc vel risus \r\ncommodo viverra maecenas accumsan lacus vel facilisis. Amet volutpat \r\nconsequat mauris nunc congue nisi vitae suscipit tellus. Etiam sit amet \r\nnisl purus in mollis nunc sed id. Et leo duis ut diam quam nulla. Sem \r\nviverra aliquet eget sit amet tellus cras adipiscing enim.</p></div>', 0, 'about-us', 'en', '2019-11-15 20:15:08', '2021-03-31 02:16:53'),
(15, 'Terms of Service', '<p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">These terms of use (the \"terms of use\") set out the legal duties of the parties with respect to the use of our services and of WEBSITE (the \"site\"). Please read them carefully before using this website.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\"><span style=\"margin: 0px; padding: 0px; font-weight: 700;\">Note: WEBSITE is NOT associated or affiliated with Google, Google Play or Android in any way. Android is a trademark of Google Inc. All the apps &amp; games are property and trademark of their respective developer or publisher and for HOME or PERSONAL use ONLY. Please be aware that WEBSITE ONLY SHARE THE ORIGINAL APK FILE FOR FREE APPS. ALL THE APK FILE IS THE SAME AS IN GOOGLE PLAY WITHOUT ANY CHEAT, UNLIMITED GOLD PATCH OR ANY OTHER MODIFICATIONS.</span></p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">The Agreement</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">These terms of use are a legal agreement between you (referred to hereinafter as \"you\", \"your,\" or \"user\") and APKPure, Inc., including its parent company and all of its subsidiaries and affiliated entities (referred to hereinafter as \"WEBSITE\", \"we,\" \"us\", or \"our\"). These terms of use set forth the Terms and Conditions under which you may use our site and any services (i.e. search) that may be offered at our site now or in the future (the \"services\"). References to \"our site\" include, where applicable, the services.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You should also review our Privacy Policy before using this site.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">By using our site you signify your agreement to these terms of use and to the&nbsp;<a href=\"https://apkstore.biz/page/privacy-policy\" style=\"margin: 0px; padding: 0px; color: rgb(0, 166, 237); cursor: pointer; font-style: italic;\">Privacy Policy</a>. We may amend these terms of use from time to time without notice to you, and you agree to be bound by any such amendments. Therefore, you should review these terms of use each time you use our site.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WEBSITE only provides general information and nothing on the site should be taken as any form of advice, warranty or endorsement. The content, information, articles, links, pictures, graphics, and other information contained on this site is for information and entertainment purposes only and is not a substitute for professional advice. To learn more, your should review our&nbsp;<a href=\"https://apkstore.biz/page/privacy-policy\" style=\"margin: 0px; padding: 0px; color: rgb(0, 166, 237); cursor: pointer; font-style: italic;\">Privacy Policy</a>&nbsp;which details important information that will help answer questions regarding personal privacy in relation to the use of our site.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">1. Use Restrictions</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">All information, content and materials contained or offered on our site are our copyrighted property or the copyrighted property of our content suppliers, licensors or licensees. All trademarks, service marks, trade names, and trade dress are proprietary to us and/or our content suppliers, licensors or licensees. Nothing contained on our site confers any license, right, title, or interest in or to our intellectual property or any third-party\'s intellectual property (including but not limited to patents, copyrights and trademarks) in any form by implication, estoppel, or otherwise. No content or material from our site may be copied, reproduced, republished, uploaded, posted, transmitted or distributed in any way that violates these terms of use or applicable law.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You agree that you will only use our site for your personal use. You must not use our site for commercial purposes or in any way that harms us or any other person or entity. You shall not use or attempt to use our site for any improper or unlawful purpose including, without limitation, to violate any of our policies, procedures, or requirements, or to interfere with, disrupt, or breach the security of our site or any of our servers or networks. You are further responsible for ensuring that your use of our site does not violate any applicable local, state, federal, international or other law, rule, or regulation.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We are committed to protecting the privacy of children. You should be aware that this site is not intended or designed to attract children under the age of 13. We do not collect personally identifiable information from any person we actually know is a child under the age of 13.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">2. Links to Third Party Websites</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">When you are on our site you could be directed, via hyperlink, to third party websites that are beyond our control. For example, our site may provide search results in response to user queries or other links from advertisers, sponsors or content partners that may or may not use ads or logo(s) to link to their own sites. You acknowledge that when you click on a link that leaves our site, the site you will land on may not be controlled by us and different terms of use and privacy policies shall apply. By clicking on such links you hereby acknowledge that WEBSITE is not responsible for those websites or their associated content or services. We also reserve the right to disable links from any third-party sites, although we are under no obligation to do so.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">3. Electronic Communications</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Should you send e-mails to us for any reason, you are communicating with us electronically. By doing so, you consent to receive communications from us electronically. We may communicate with you by e-mail or by posting notices on our site. You agree that all notices, disclosures, agreements and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">4. Policy Restrictions</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You will not impair or cause damage to our site, or any connected network, or otherwise interfere with any person or entity\'s use or enjoyment of our site in any way, including without limitation, using or launching any automated system that accesses our site in a manner that sends more request messages to our servers in a given period of time than a human can reasonably produce in the same period by using a conventional online web browser. Notwithstanding the foregoing, operators of public search engines may use spiders for the sole purpose of creating publicly available searchable indices of the materials and our site, but not for caching or archiving such materials.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You agree that you will not take any action that imposes an unreasonable or disproportionately large load on the infrastructure of our sites.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">5. DISCLAIMER</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">THE SERVICES, INFORMATION, CONTENT AND MATERIALS ON OUR SITE OR PROVIDED THROUGH OUR SITE ARE PROVIDED \"AS IS\" AND WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO, ANY IMPLIED WARRANTY OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE; NON-INFRINGEMENT; ANY IMPLIED WARRANTY RELATING TO COURSE OF PERFORMANCE, COURSE OF DEALING, OR USAGE OF TRADE; AND ANY WARRANTY REGARDING THE SUITABILITY AND QUALITY OF OUR SITE FOR YOUR PURPOSES OR EXPECTATIONS. WE DO NOT WARRANT THAT THE FUNCTIONS CONTAINED IN INFORMATION, CONTENT AND MATERIALS ON OUR SITE OR THROUGH OUR SITE WILL BE UNINTERRUPTED OR ERROR-FREE, THAT DEFECTS WILL BE CORRECTED, OR THAT OUR SITE OR THE SERVERS THAT MAKE SUCH INFORMATION, CONTENT AND MATERIALS AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. MOREOVER, YOU ASSUME THE ENTIRE COST OF ALL ASSOCIATED SERVICING, REPAIR OR NECESSARY CORRECTION DUE TO ANY SUCH HARM. WE DO NOT WARRANT OR MAKE ANY REPRESENTATIONS REGARDING THE USE OR THE RESULTS OF THE USE OF ANY INFORMATION, CONTENT, MATERIALS, PRODUCTS OR SERVICES CONTAINED ON OR OFFERED, MADE AVAILABLE THROUGH, OR OTHERWISE RELATED IN ANY WAY TO OUR SITE OR ANY THIRD PARTY SITES OR SERVICES LINKED TO OR FROM OUR SITE IN TERMS OF THEIR CORRECTNESS, ACCURACY, COMPLETENESS, AVAILABILITY, RELIABILITY, SAFETY OR OTHERWISE.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WE CANNOT ENSURE THAT YOU WILL BE SATISFIED WITH ANY PRODUCTS OR SERVICES THAT YOU MAY PURCHASE FROM A THIRD PARTY WEBSITE THAT LINKS TO OR FROM OUR SITE OR THIRD PARTY INFORMATION, CONTENT OR MATERIALS CONTAINED ON OUR SITE. WE DO NOT ENDORSE ANY OF THE CONTENT, NOR HAVE WE TAKEN ANY STEPS TO CONFIRM THE ACCURACY, COMPLETENESS OR RELIABILITY OF, ANY OF THE INFORMATION, CONTENT OR MATERIALS CONTAINED ON ANY THIRD PARTY WEBSITE. WE DO NOT MAKE ANY REPRESENTATIONS OR WARRANTIES AS TO THE SECURITY OF ANY INFORMATION, CONTENT OR MATERIALS YOU MIGHT BE REQUESTED TO GIVE TO ANY THIRD PARTY.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">YOU HEREBY IRREVOCABLY WAIVE ANY CLAIM AGAINST US WITH RESPECT TO (A) INFORMATION, CONTENT AND MATERIALS CONTAINED ON OUR SITE OR PROVIDED THROUGH OUR SERVICES, (B) THIRD PARTY WEBSITES OR OFFERS PLACED THROUGH THE SITE IN RESPECT TO ANY INFORMATION, CONTENT AND MATERIALS YOU PROVIDE TO SUCH THIRD PARTIES.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">SOME JURISDICATIONS MAY NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, SO SOME OR ALL OF THE ABOVE EXCLUSION MAY NOT APPLY TO YOU.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">6. Indemnification</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You hereby agree to indemnify, defend, and hold us, our content providers, licensors, licensees, distributors, agents, representatives and other authorized users, and each of the foregoing entities\' respective resellers, distributors, service providers and suppliers, and all of the foregoing entities\' respective officers, directors, owners, employees, agents, representatives, successors and assigns (collectively, the \"indemnified parties\") harmless from and against any and all losses, damages, liabilities and costs (including, without limitation, settlement costs and any legal or other fees and expenses for investigating or defending any actions or threatened actions) incurred by the indemnified parties in connection with any claim arising out of any breach by you of these terms of use or claims arising directly or indirectly from your use of our site.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We reserve the right, at our own expense, to employ separate counsel and assume the exclusive defense and control of any matter otherwise subject to indemnification by you and you hereby agree to cooperate with us in the defense of any such claim.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">7. LIMITATION OF LIABILITY</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">IN NO EVENT SHALL WE OR ANY OF OUR DIRECTORS, OFFICERS, EMPLOYEES, AGENTS, CONTRACTORS, AFFILIATES, SUBSIDIARIES, SUCCESSORS OR ASSIGNS BE LIABLE TO YOU OR ANY OTHER PARTY FOR ANY CLAIM FOR DIRECT, INDIRECT, INCIDENTAL, SPECIAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES (INCLUDING BUT NOT LIMITED TO LOST PROFITS), OR FOR DAMAGE TO YOUR COMPUTER (INCLUDING BUT NOT LIMITED TO HARM RESULTING FROM DOWNLOADING OR ACCESSING INFORMATION OR MATERIAL ON THE INTERNET), OR FOR FAILURE TO STORE OR DELIVER, IN A TIMELY OR UNTIMELY MANNER, ANY INFORMATION OR MATERIAL DISPLAYED, OR ANY CLAIM IN CONTRACT OR TORT (WHETHER OR NOT ARISING IN WHOLE OR PART OUT OF OUR ACT, OMISSION, FAULT, NEGLIGENCE, STRICT LIABILITY, OR PRODUCT LIABILITY) ARISING OUT OF OR IN CONNECTION WITH OUR SITE, THE CONTENT OF OUR SITE, OR FROM USERS OF OUR SITE (WHETHER OFFLINE OR ONLINE), EVEN IF SUCH DAMAGES ARE FORESEEABLE OR WE HAVE BEEN ADVISED OF OR HAVE CONSTRUCTIVE KNOWLEDGE OF THE POSSIBILITY OF SUCH DAMAGES. YOU FURTHER ACKNOWLEDGE AND AGREE THAT NEITHER WE, NOR OUR CONTENT PROVIDERS, LICENSORS, LICENSEES, NOR ANY OF THE FOREGOING ENTITIES\' RESPECTIVE RESELLERS, DISTRIBUTORS, SERVICE PROVIDERS OR SUPPLIERS ARE RESPONSIBLE OR LIABLE FOR ANY INCOMPATIBILITY BETWEEN OUR SITE AND ANY OTHER WEBSITE, BROWSER, SERVICE, SOFTWARE OR HARDWARE. THE LIMITATIONS, EXCLUSIONS AND DISCLAIMERS IN THIS SECTION AND ELSEWHERE IN THESE TERMS OF USE APPLY TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW. BECAUSE SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES, CERTAIN PARTS OF THE FOREGOING PARAGRAPH OF THIS SECTION MAY NOT APPLY TO YOU.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">FURTHERMORE, IN NO EVENT SHALL WE OR ANY OF OUR DIRECTORS, OFFICERS, EMPLOYEES, AGENTS, CONTRACTORS, AFFILIATES, SUBSIDIARIES, SUCCESSORS OR ASSIGNS BE RESPONSIBLE OR LIABLE FOR THE CONTENT, COMPLETENESS, ACCURACY OR LEGALITY OF INFORMATION OR MATERIAL DISPLAYED IN CONNECTION WITH OR ARISING OUT OF OUR SITE OR ANY CESSATION, INTERRUPTION OR DELAY IN THE PERFORMANCE OF OUR SITE FOR ANY REASON INCLUDING, WITHOUT LIMITATION, CAUSES BEYOND OUR REASONABLE CONTROL SUCH AS EARTHQUAKE, FLOOD, FIRE, STORM OR OTHER NATURAL DISASTER, ACT OF GOD, LABOR CONTROVERSY OR THREAT THEREOF, CIVIL DISTURBANCE OR COMMOTION, ACT OF TERRORISM, DISRUPTION OF THE PUBLIC MARKETS, WAR OR ARMED CONFLICT OR THE INABILITY TO OBTAIN SUFFICIENT MATERIAL, SUPPLIES, LABOR, TRANSPORTATION, POWER OR OTHER ESSENTIAL COMMODITY OR SERVICE REQUIRED IN THE CONDUCT OF BUSINESS INCLUDING INTERNET ACCESS, OR ANY CHANGE IN OR THE ADOPTION OF ANY LAW, ORDINANCE, RULE, REGULATION, ORDER, JUDGMENT OR DECREE. OUR TOTAL LIABILITY TO YOU FOR ANY DAMAGES, LOSSES AND CAUSES OF ACTION WHETHER IN CONTRACT, TORT (INCLUDING, BUT NOT LIMITED TO, NEGLIGENCE) OR OTHERWISE ARISING OUT OF OR CONNECTED TO OUR SITE SHALL IN NO EVENT EXCEED $100.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">8. General Provisions</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We reserve the right at any time to modify or discontinue, temporarily or permanently, the site (or any part thereof) with or without notice. You agree that we shall not be liable to you or to any third party for any modification, suspension or discontinuance of the service.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">If any provision of these terms of use, for any reason, be declared void, illegal, invalid, or unenforceable in whole or in part, such provision will be severable from all other provisions herein and will not affect or impair the validity or enforceability of any other provision of these terms of use; provided, however, that a court having jurisdiction may revise such provision to the extent necessary to make such provision valid and enforceable.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">The laws of the State of Arkansas, U.S.A. govern all matters arising out of these terms of use, without giving effect to any conflicts or choice of laws principles that would require the application of the laws of a different jurisdiction. Any dispute or claim arising out of or in relation to these terms of use, or the interpretation, making, performance, breach or termination thereof, will be finally settled by the courts of Faulkner County, Arkansas, U.S.A. and of any federal court located in the eastern district of Arkansas.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">No waiver of any provision of these terms of use by us shall be deemed a further or continuing waiver of such provision or any other provision, and our failure to assert any right or provision under these terms of use shall not constitute a waiver of such right or provision. Any waiver of any provision of these terms of use will be effective only if in writing and signed by Inuvo.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We may immediately terminate these terms of use with respect to you (including your access to our site, or any portion thereof) without cause and without notice to you in our sole discretion. Upon termination, you must cease use of our site.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">The provisions of these terms of use, which by their nature should survive the termination of these terms of use, shall so survive such termination.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">These terms of use along with any other notices, policies, procedures, agreements, and terms and conditions on our site contain the entire understanding with respect to your use of our site and our relationship with you and such shall supersede all prior understandings and agreements, whether written or oral, and all prior dealings.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You agree that regardless of any statute or law to the contrary, any cause of action against us arising out of or related to our site must commence within one (1) year after the cause of action accrues or such cause of action shall be permanently barred.</p>', 1, 'terms-of-service', 'en', '2019-11-21 20:51:11', '2021-03-31 02:16:53'),
(16, 'Privacy Policy', '<p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Effective as of May 25, 2018</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Our updated Privacy Policy explains what information we collect, how we use it, and the choices you have, including how to manage your privacy and cookies settings, access the information we have about you, and delete your account.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WEBSITE is committed to protecting consumer privacy online. We believe that greater protection of personal privacy on the Web will not only protect our users, but also increase users confidence and ultimately their participation in online activities. The purpose of our policy is to inform you about the types of information we gather about you when you visit our site, how we may use that information, whether we disclose it to anyone, and the choices you have regarding our use of the information. WEBSITE.com strives to offer its visitors the many advantages of Internet technology and to provide an interactive and personalized experience.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Your Consent</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">BY USER WEBSITE SERVICES, INSTALLING AND/OR RUNNING ON YOUR MOBILE DEVICE OR BROWSER, ENTERING INTO, CONNECTING TO, ACCESSING AND/OR USING THE APP, YOU AGREE TO THE TERMS AND CONDITIONS SET FORTH IN THIS PRIVACY POLICY, INCLUDING TO THE POSSIBLE COLLECTION AND PROCESSING OF YOUR PERSONAL INFORMATION. PLEASE NOTE: IF YOU OR, AS APPLICABLE, YOUR LEGAL GUARDIAN, DISAGREE TO ANY TERM PROVIDED HEREIN, YOU MUST NOT INSTALL, ACCESS AND/OR USE THE APP, WEBSITE OTHER SERVICES AND YOU ARE REQUESTED TO PROMPTLY ERASE THE APP FROM YOUR MOBILE DEVICE OR STOP USING OUR APP/WEBSITE THROUGH YOUR BROWSER AND DO NOT ENTER TO, CONNECT TO, ACCESS OR USE ANY OF OUR SERVICES RELATED TO THE APP.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">What information do we collect?</h3><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Data you give us directly</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">● if you register with us (such as your date of birth, username, avatar, password and email address);<br style=\"margin: 0px; padding: 0px;\">● information you provide by participating in any chats, communities or social media functions. We will consider that information as part of the public domain;<br style=\"margin: 0px; padding: 0px;\">● information you provide us if you report a problem with our Services or App.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Data we may collect when you use our services and App (whether or not you register with us)</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">● data about your location, device type, operating system and platform;<br style=\"margin: 0px; padding: 0px;\">● mobile device identifiers (such as your unique device ID (persistent/non-persistent, hardware type, medial access control (\"MAC\") address, international mobile equipment identity (\"IMEI\"), OS, and your device name;<br style=\"margin: 0px; padding: 0px;\">● data about your computer\'s browser version, operating system version, page loading time, network, generated device identifier information, hashed MAC address, referral source and IP address.<br style=\"margin: 0px; padding: 0px;\">● the number of times you visit our APP and the amount of time you spend using the APP;<br style=\"margin: 0px; padding: 0px;\">● when you are accessing the APP through a third-party account such as Facebook or Google - certain information relating to your account with those third parties including your name, user ID, gender, location (country and/or city specific), email address, date of birth, information from your public profile including friends and connections, log in details, avatar, gender and other information based on your use of our APP. You can manage the information which is shared by such third parties by amending your preferences through the privacy settings such third parties provide. With this list, we try to be as clear and complete as possible, but we find it important to keep this Privacy Policy legible, so there may be other information we collect.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">How do we use your information?</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We may use your data in the following ways:<br style=\"margin: 0px; padding: 0px;\">● To provide you the App and associated websites and continuously improve their features;<br style=\"margin: 0px; padding: 0px;\">● To store your running-history;<br style=\"margin: 0px; padding: 0px;\">● To provide helpdesk and support services;<br style=\"margin: 0px; padding: 0px;\">● To customise the App which is available to you;<br style=\"margin: 0px; padding: 0px;\">● To ensure that you are in compliance with our terms;<br style=\"margin: 0px; padding: 0px;\">● To moderate any chat messages;<br style=\"margin: 0px; padding: 0px;\">● To improve the App, for analysis and reporting purposes and to offer you technical support or respond to your questions. This also includes using data to log any crashes in our provision of the App, so we may report such interruptions (in this regard, we may use a third party to assist us);<br style=\"margin: 0px; padding: 0px;\">● To notify you if you have received message update notifications or something;<br style=\"margin: 0px; padding: 0px;\">● To enable social network integration, especially with Facebook;<br style=\"margin: 0px; padding: 0px;\">● To personalise your experience;<br style=\"margin: 0px; padding: 0px;\">● To send you push notifications for the App (which you can choose not to accept or turn off by visiting the settings section of your device and selecting the appropriate setting);<br style=\"margin: 0px; padding: 0px;\">● To offer you other services and Apps which we think may be of interest to you;<br style=\"margin: 0px; padding: 0px;\">● To prevent fraud and crime;<br style=\"margin: 0px; padding: 0px;\">● To create a profile for marketing purposes with for example Facebook or Google;<br style=\"margin: 0px; padding: 0px;\">● Emails (regarding updates, newsletter, new features, (new) apps etc.);<br style=\"margin: 0px; padding: 0px;\">● Administrative purposes, such as notification of a violation of our terms of use.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Cookies and Web Beacons</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We use \"cookies.\" The cookies we place on your computer are very small text files that uniquely identify your browser and may be sent to your computer or mobile device. They are stored on your hard drive and communicate with our servers only when you are visiting our websites. We use cookies to improve the quality of WEBSITE.com. They allow us to monitor aggregate metrics such as total number of visitors and number of pages viewed. They also allow us to optimize WEBSITE.com to make sure that we are delivering the best possible experience to our users. Your web browser is likely already set to accept cookies, yet you may choose to block cookies in your web browser’s settings. Note that blocking cookies may result in some features not being able to function properly. To learn more about controlling browser cookies visit:&nbsp;<a target=\"_blank\" rel=\"nofollow\" href=\"http://www.aboutcookies.org/Default.aspx?page=1\" style=\"margin: 0px; padding: 0px; color: rgb(0, 166, 237); cursor: pointer;\">http://www.aboutcookies.org/Default.aspx?page=1</a>.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Note that WEBSITE has no access to or control over these cookies that are used by third-party advertisers. Learn more about our&nbsp;<a href=\"https://apkstore.biz/vn/cookie-policy.html\" style=\"margin: 0px; padding: 0px; color: rgb(0, 166, 237); cursor: pointer;\">Cookies Policy</a>.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Device Information.</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We collect information regarding the Internet browser, computer, tablet, mobile phone, smartphone or other device utilized to access WEBSITE.com to ensure that WEBSITE.com is optimized for those devices.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Log Files.</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We may also automatically log certain anonymous information about visitors to WEBSITE.com, including, but not limited to, where the user came from to visit our site, IP address, search terms utilized, browser type and a reading history of the pages viewed.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Analytics</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We use third party information, reports and analysis about the usage and browsing patterns of users of WEBSITE.com. We allow the third party analytics companies to include web beacons and cookies on WEBSITE.com. The collected information includes search terms, search parameters, click-throughs by users, and other similar information. We utilize this information to improve WEBSITE.com and make sure we are delivering relevant content to our users. The Analytics we use do not identify individual users of WEBSITE.com.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Third Party Ad Networks and Social Networks</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WEBSITE.com expects its partners, advertisers to respect the privacy of our users. However, third parties, including our partners, advertisers and other content providers accessible through our site, may have their own privacy and data collection policies and practices. For example, during your visit to our site you may link to, or view as part of a frame on WEBSITE.com page, certain content that is actually created or hosted by a third party. Also, through WEBSITE.com you may be introduced to, or be able to access, information, Web sites, advertisements, features, contests or sweepstakes offered by other parties. WEBSITE.com is not responsible for the actions or policies of such third parties. You should check the applicable privacy policies of those third parties when providing information on a feature or page operated by a third party.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">While on our site, our advertisers, promotional partners or other third parties may use cookies or other technology to attempt to identify some of your preferences or retrieve information about you. For example, some of our advertising is served by third parties and may include cookies that enable the advertiser to determine whether you have seen a particular advertisement before. Through features available on our site, third parties may use cookies or other technology to gather information. WEBSITE.com does not control the use of this technology or the resulting information and is not responsible for any actions or policies of such third parties.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We use third-party advertising companies to serve ads when you visit our Web site. These companies may use non-personal information (i.e., information that does not include your name, address, email address or telephone number) about your visits to this and other Web sites in an effort to provide advertisements about goods and services that may be of interest to you. To learn more about third-party advertising or to opt-out of such advertising, you can visit both the Network Advertising Initiative and the Digital Advertising Alliance.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">In addition to the above, we have implemented at WEBSITE.com certain \"Google Analytics\" features that support display advertising, including re-targeting. Visitors to WEBSITE.com may opt out of Google Analytics, customize the Google Display Network ads by using the Google Ad Preferences Manager and learn more about how google serves ads by viewing its Customer Ads Help Center. If you do not wish to participate in Google Analytics, you may also download the Google Analytics pt-out browser add-on.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Children\'s Information</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WEBSITE does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Information security and accuracy</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We intend to protect your personal information and to maintain its accuracy.WEBSITE implements reasonable physical, administrative and technical safeguards to help us protect your personal information from unauthorized access, use and disclosure.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Online Privacy Policy Only</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">This privacy policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in WEBSITE. This policy is not applicable to any information collected offline or via channels other than this website.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Access to information</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">You have the right to request access to the information we have on you. You can do this by contacting us at&nbsp;support@WEBSITE.com.&nbsp;We will make sure to provide you with a copy of the data we process about you. In order to comply with your request, we may ask you to verify your identity. We will fulfill your request by sending your copy electronically. For any subsequent access request, we may charge you with an administrative fee.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Information correction &amp; deletion</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">If you believe that the information we have about you is incorrect, you are welcome to contact us so we can update it and keep your data accurate. If at any point you wish for WEBSITE to delete information about you, you can simply contact us at&nbsp;support@WEBSITE.com.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Changes in Privacy Policy</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">WEBSITE.com reserves the right to change or update this Privacy Policy at any time by posting a notice at the Site explaining that we are changing our Privacy Policy.</p><h3 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 30px; color: rgb(85, 85, 85); font-size: 16px;\">Contacting the Site</h3><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">We welcome your feedback and we thank you for using WEBSITE! If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us through email at&nbsp;support@WEBSITE.com</p>', 2, 'privacy-policy', 'en', '2019-11-21 20:51:44', '2021-03-31 02:16:53');
INSERT INTO `pages` (`id`, `title`, `details`, `sort`, `slug`, `local`, `created_at`, `updated_at`) VALUES
(19, 'DMCA Copyright Infringement Notification', '<p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">All trademarks, registered trademarks, product names and company names or logos appearing on the site are the property of their respective owners. WEBSITE abides by the federal Digital Millennium Copyright Act (DMCA) by responding to notices of alleged infringement that complies with the DMCA and other applicable laws. As part of our response, we may remove or disable access to material residing on site that is controlled or operated by WEBSITE that is claimed to be infringing, in which case we will make a good-faith attempting to contact the developer who submitted the affected material so that they may make a counter notification, also in accordance with the DMCA.</p><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Before serving either a Notice of Infringing Material or Counter-Notification, you may wish to contact a lawyer to better understand your rights and obligations under the DMCA and other applicable laws. The following notice requirements are intended to comply with WEBSITE’s rights and obligations under the DMCA, in particular, section 512(c), and do not constitute legal advice.</p><h2 style=\"margin-top: 20px; margin-bottom: 20px; padding: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 32px; color: rgb(85, 85, 85); font-size: 18px;\">Notice of Copyright Infringing</h2><p style=\"margin-bottom: 0px; padding: 0px; line-height: 30px; font-size: 16px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">To file a notice of infringing material on WEBSITE please provide a notification containing the following details</p><ul class=\"pad-left\" style=\"margin: 10px 20px; padding-left: 20px; list-style-image: initial; list-style-type: disc; line-height: 30px; color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\"><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">A physical signature of a developer or development team authorized to act on behalf of the owner of an exclusive right that is allegedly infringed. It\'s necessary for third party agencies to provide a copy of \"Physical Authorization Letter\" that agency can address all the copyrights things of them.</li><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">Identification of the copyrighted work claimed to have been infringed, or, if multiple copyrighted works at a single online site are covered by a single notification, a representative list of such works at that site.</li><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">Providing URLs in the body of an email is the best way to help us locate content quickly.</li><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">Information reasonably sufficient to permit the service provider to contact the complaining party, such as an address, telephone number, and, if available, an electronic mail address at which the complaining party may be contacted.</li><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">A statement that the complaining party has a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law.</li><li style=\"margin: 0px; padding: 0px; list-style: decimal; line-height: 30px;\">A statement that the information in the notification is accurate, and under penalty of perjury, that the complaining party is authorized to act on behalf of the owner of an exclusive right that is allegedly infringed (Note that under Section 512(f) any person who knowingly and materially misrepresents that material or activity is infringing may be subject to liability for damages.</li></ul>', 4, 'dmca-copyright-infringement-notification', 'en', '2021-03-31 02:15:04', '2021-03-31 02:16:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'site_title', 'Apk Store - Google Play site php'),
(2, 'facebook', '#'),
(3, 'twitter', '#'),
(5, 'site_description', 'Google Play Store CMS is an android market site specifically for Google Play Store. You can add apps / games  in this CMS'),
(6, 'before_head_tag', ''),
(7, 'after_head_tag', ''),
(8, 'before_body_end_tag', ''),
(11, 'time_before_redirect', '10'),
(13, 'default_country', 'US'),
(14, 'default_language', 'en'),
(21, 'screenshot_save', '0'),
(23, 'search_in', 'site'),
(26, 'google', '#'),
(27, 'instagram', '#');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `link`, `image`, `active`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'Test Slider', '#', '1617250612.jpeg', 1, 1, NULL, '2021-04-16 02:09:05'),
(2, 'new', '#', '1617250670.jpeg', 1, 2, '2021-03-15 06:33:38', '2021-04-16 02:09:05'),
(3, 'Slider 3', '#', '1617250679.webp', 1, 0, '2021-03-25 19:49:53', '2021-04-16 02:09:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(755) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `developer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `platform` int(11) NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `toppics`
--

CREATE TABLE `toppics` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` tinyint(4) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home` int(3) NOT NULL DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 0,
  `apps` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `translations`
--

CREATE TABLE `translations` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `translations`
--

INSERT INTO `translations` (`id`, `language`, `code`, `locale_code`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'US', NULL, '2020-01-24 18:00:28'),
(2, 'Tiếng Việt', 'vi', 'VN', NULL, '2020-01-24 18:00:08'),
(3, 'Français', 'fr', 'FR', NULL, '2020-01-24 17:59:42'),
(4, '한국어', 'ko', 'KR', NULL, '2020-01-24 18:00:21'),
(5, 'Italiano', 'it', 'IT', NULL, '2020-01-24 10:15:24'),
(6, '中文(简体)', 'zh', 'CN', NULL, NULL),
(7, '中文(繁體)', 'zh', 'TW', NULL, NULL),
(8, 'Indonesia', 'id', 'ID', NULL, NULL),
(9, '日本語', 'ja', 'JP', NULL, NULL),
(10, 'हिन्', 'hi', 'IN', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `votes`
--

CREATE TABLE `votes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Chỉ mục cho bảng `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appid` (`appid`),
  ADD KEY `appid_2` (`appid`);

--
-- Chỉ mục cho bảng `apps_info`
--
ALTER TABLE `apps_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `toppics`
--
ALTER TABLE `toppics`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ads`
--
ALTER TABLE `ads`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `apps_info`
--
ALTER TABLE `apps_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `developer`
--
ALTER TABLE `developer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `toppics`
--
ALTER TABLE `toppics`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `translations`
--
ALTER TABLE `translations`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `votes`
--
ALTER TABLE `votes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
