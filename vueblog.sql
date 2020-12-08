-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2020 at 09:49 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vueblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogcategories`
--

CREATE TABLE `blogcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_except` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `featuredImage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metaDescription` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogtags`
--

CREATE TABLE `blogtags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoryName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iconImage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categoryName`, `iconImage`, `created_at`, `updated_at`) VALUES
(10, 'Javascript', '/uploads/1606213164.jpeg', '2020-11-24 03:19:27', '2020-11-24 03:19:27'),
(11, 'Java', '/uploads/1606291045.jpeg', '2020-11-25 00:59:08', '2020-11-25 00:59:08'),
(12, 'a', '/uploads/1606291799.jpeg', '2020-11-25 01:10:02', '2020-11-25 01:10:02'),
(13, 'qw', '/uploads/1606291876.jpeg', '2020-11-25 01:11:20', '2020-11-25 01:11:20'),
(14, 'as', '/uploads/1606291975.jpeg', '2020-11-25 01:12:58', '2020-11-25 01:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_11_05_071524_create_categories_table', 1),
(5, '2020_11_05_071634_create_tags_table', 1),
(6, '2020_11_05_071651_create_blogs_table', 1),
(7, '2020_11_05_071706_create_blogtags_table', 1),
(8, '2020_11_05_071731_create_blogcategories_table', 1),
(9, '2020_11_24_152222_create_roles_table', 2),
(10, '2020_11_27_151514_create_roles_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roleName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` int(11) NOT NULL,
  `permission` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roleName`, `isAdmin`, `permission`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '[{\"resourceName\":\"Home\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-home\",\"name\":\"/\"},{\"resourceName\":\"Tags\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-desktop\",\"name\":\"tags\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-apps\",\"name\":\"category\"},{\"resourceName\":\"Create Blog\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"md-create\",\"name\":\"createblog\"},{\"resourceName\":\"Admin users\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-people\",\"name\":\"adminusers\"},{\"resourceName\":\"Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"md-lock\",\"name\":\"role\"},{\"resourceName\":\"Assign Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"md-contacts\",\"name\":\"assignrole\"}]', '2020-11-29 02:47:59', '2020-12-03 01:21:15'),
(2, 'Moderator', 1, '[{\"resourceName\":\"Home\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-home\",\"name\":\"/\"},{\"resourceName\":\"Tags\",\"read\":true,\"write\":false,\"update\":false,\"delete\":true,\"icon\":\"ios-desktop\",\"name\":\"tags\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":false,\"update\":false,\"delete\":true,\"icon\":\"ios-apps\",\"name\":\"category\"},{\"resourceName\":\"Create Blog\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-create\",\"name\":\"createblog\"},{\"resourceName\":\"Admin users\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-people\",\"name\":\"adminusers\"},{\"resourceName\":\"Role\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-lock\",\"name\":\"role\"},{\"resourceName\":\"Assign Role\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-contacts\",\"name\":\"assignrole\"}]', '2020-11-29 02:46:03', '2020-12-03 01:25:30'),
(3, 'Editor', 1, '[{\"resourceName\":\"Home\",\"read\":true,\"write\":true,\"update\":true,\"delete\":false,\"icon\":\"ios-home\",\"name\":\"/\"},{\"resourceName\":\"Tags\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"ios-desktop\",\"name\":\"tags\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":true,\"update\":true,\"delete\":false,\"icon\":\"ios-apps\",\"name\":\"category\"},{\"resourceName\":\"Create Blog\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"icon\":\"md-create\",\"name\":\"createblog\"},{\"resourceName\":\"Admin users\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-people\",\"name\":\"adminusers\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-lock\",\"name\":\"role\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-contacts\",\"name\":\"assignrole\"}]', '2020-11-27 08:27:16', '2020-12-03 01:26:22'),
(4, 'User', 0, '[{\"resourceName\":\"Home\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-home\",\"name\":\"/\"},{\"resourceName\":\"Tags\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-desktop\",\"name\":\"tags\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-apps\",\"name\":\"category\"},{\"resourceName\":\"Create Blog\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-create\",\"name\":\"createblog\"},{\"resourceName\":\"Admin users\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"ios-people\",\"name\":\"adminusers\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-lock\",\"name\":\"role\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"icon\":\"md-contacts\",\"name\":\"assignrole\"}]', '2020-11-27 08:24:38', '2020-12-03 01:26:40');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tagName`, `created_at`, `updated_at`) VALUES
(7, 'React', '2020-11-24 06:25:34', '2020-11-24 06:25:34'),
(8, 'go', '2020-11-29 03:03:06', '2020-11-29 03:03:06'),
(9, 'Laravel', '2020-11-30 23:18:23', '2020-11-30 23:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `FullName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `isActivated` tinyint(1) NOT NULL DEFAULT '0',
  `passwordResetCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activationCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socialType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FullName`, `email`, `password`, `role_id`, `isActivated`, `passwordResetCode`, `activationCode`, `socialType`, `created_at`, `updated_at`) VALUES
(3, 'Admins', '1@2.com', '$2y$10$DKZiggOL5x7IbhW.JNg2/uMARbge4F5jRgT9BU5i.miWsArueoSLa', 1, 0, NULL, NULL, NULL, '2020-11-25 00:55:43', '2020-12-02 00:28:43'),
(7, 'Hidayat', '123@gmail.com', '$2y$10$eVWumTcXcw7wwB/EhG5NkOveRUUmvABD7nu1XngjPrxNoOhcse8Iy', 1, 0, NULL, NULL, NULL, '2020-11-25 23:19:12', '2020-11-25 23:19:12'),
(8, 'moderator', 'm@g.com', '$2y$10$1lvoVyIN84Yv6AN21BPZuOyPEwaPtOL6NCdiWKFfbs2uRWhjvpkmC', 2, 0, NULL, NULL, NULL, '2020-11-27 09:00:22', '2020-12-02 00:28:33'),
(10, 'role', 'a@d.m', '$2y$10$f5TC6NgFHc7mIlExpWBrHu9.bBFPCMOnIB0kDlQxtwC2YFi92h.jq', 1, 0, NULL, NULL, NULL, '2020-11-27 09:03:33', '2020-12-02 00:28:24'),
(11, 'as', 'as@as.com', '$2y$10$BVcAt9NOtUUV.vO9EqSPuubJEcsPX6r9Uu0Gb51M01OVGpasbRxlO', 3, 0, NULL, NULL, NULL, '2020-12-02 01:18:38', '2020-12-02 01:18:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogcategories`
--
ALTER TABLE `blogcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `blogtags`
--
ALTER TABLE `blogtags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogcategories`
--
ALTER TABLE `blogcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogtags`
--
ALTER TABLE `blogtags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
