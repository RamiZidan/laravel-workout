-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 17, 2024 at 12:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jasur`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `left_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `duration`, `created_by`, `is_public`, `left_days`, `created_at`, `updated_at`) VALUES
(2, 'Beginner\r\n', 30, 1, 1, 30, '2024-08-11 21:08:25', '2024-08-11 21:08:25'),
(4, 'Intermediate', 30, 1, 1, 30, '2024-08-16 18:23:32', '2024-08-16 18:23:32'),
(5, 'Advance', 30, 1, 1, 30, '2024-08-16 18:24:58', '2024-08-16 18:24:58'),
(11, 'Beginner\r\n', 30, 26, 0, 30, '2024-08-17 07:05:59', '2024-08-17 07:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `course_days`
--

CREATE TABLE `course_days` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_days`
--

INSERT INTO `course_days` (`id`, `name`, `course_id`, `created_at`, `updated_at`) VALUES
(2, 'Legs Day', 5, '2024-08-11 22:07:41', '2024-08-11 22:07:41'),
(3, 'Arms day', 2, '2024-08-16 18:27:42', '2024-08-16 18:27:42'),
(4, 'Arms day', 4, '2024-08-16 18:27:45', '2024-08-16 18:27:45'),
(5, 'Legs Day', 2, '2024-08-17 03:51:02', '2024-08-17 03:51:02'),
(6, 'Legs Day', 4, '2024-08-17 03:51:05', '2024-08-17 03:51:05'),
(7, 'Arms day', 5, '2024-08-17 03:51:51', '2024-08-17 03:51:51'),
(8, 'Abs Day', 2, '2024-08-17 03:51:53', '2024-08-17 03:51:53'),
(9, 'Abs Day', 4, '2024-08-17 03:52:24', '2024-08-17 03:52:24'),
(10, 'Abs Day', 5, '2024-08-17 03:52:26', '2024-08-17 03:52:26'),
(11, 'Shoulder Day', 2, '2024-08-17 03:52:50', '2024-08-17 03:52:50'),
(12, 'Shoulder Day', 4, '2024-08-17 03:52:52', '2024-08-17 03:52:52'),
(13, 'Shoulder Day', 5, '2024-08-17 03:53:06', '2024-08-17 03:53:06'),
(14, 'Back Day', 2, '2024-08-17 03:53:09', '2024-08-17 03:53:09'),
(15, 'Back Day', 4, '2024-08-17 03:53:37', '2024-08-17 03:53:37'),
(16, 'Back Day', 5, '2024-08-17 03:53:39', '2024-08-17 03:53:39'),
(17, 'Chest Day', 2, '2024-08-17 03:54:07', '2024-08-17 03:54:07'),
(18, 'Chest Day', 4, '2024-08-17 03:54:09', '2024-08-17 03:54:09'),
(19, 'Chest Day', 5, '2024-08-17 03:54:20', '2024-08-17 03:54:20'),
(45, 'Arms day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(46, 'Legs Day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(47, 'Abs Day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(48, 'Shoulder Day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(49, 'Back Day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(50, 'Chest Day', 11, '2024-08-17 07:05:59', '2024-08-17 07:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `days_have_exercises`
--

CREATE TABLE `days_have_exercises` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days_have_exercises`
--

INSERT INTO `days_have_exercises` (`id`, `day_id`, `exercise_id`, `created_at`, `updated_at`) VALUES
(2, 2, 6, '2024-08-14 01:56:27', '2024-08-14 01:56:27'),
(3, 2, 5, '2024-08-17 03:58:24', '2024-08-17 03:58:24'),
(4, 5, 3, '2024-08-17 03:58:26', '2024-08-17 06:32:01'),
(5, 5, 5, '2024-08-17 03:59:09', '2024-08-17 06:32:14'),
(6, 6, 11, '2024-08-17 03:59:11', '2024-08-17 03:59:11'),
(7, 6, 5, '2024-08-17 03:59:50', '2024-08-17 03:59:50'),
(8, 3, 21, '2024-08-17 03:59:52', '2024-08-17 07:05:12'),
(9, 3, 18, '2024-08-17 04:01:12', '2024-08-17 07:05:19'),
(10, 4, 20, '2024-08-17 04:01:15', '2024-08-17 04:01:15'),
(11, 4, 21, '2024-08-17 04:02:54', '2024-08-17 04:02:54'),
(12, 7, 21, '2024-08-17 04:02:57', '2024-08-17 04:02:57'),
(13, 7, 22, '2024-08-17 04:04:19', '2024-08-17 04:04:19'),
(14, 8, 12, '2024-08-17 04:04:22', '2024-08-17 04:04:22'),
(15, 8, 14, '2024-08-17 04:05:01', '2024-08-17 04:05:01'),
(16, 9, 16, '2024-08-17 04:05:03', '2024-08-17 04:05:03'),
(17, 9, 15, '2024-08-17 04:05:36', '2024-08-17 04:05:36'),
(18, 10, 15, '2024-08-17 04:05:40', '2024-08-17 04:05:40'),
(19, 10, 13, '2024-08-17 04:06:36', '2024-08-17 04:06:36'),
(20, 11, 30, '2024-08-17 04:06:38', '2024-08-17 06:36:26'),
(21, 11, 32, '2024-08-17 04:07:44', '2024-08-17 06:37:15'),
(22, 12, 30, '2024-08-17 04:07:46', '2024-08-17 04:07:46'),
(23, 12, 31, '2024-08-17 04:08:22', '2024-08-17 04:08:22'),
(24, 13, 31, '2024-08-17 04:08:25', '2024-08-17 04:08:25'),
(25, 13, 32, '2024-08-17 04:08:47', '2024-08-17 04:08:47'),
(26, 14, 23, '2024-08-17 04:08:51', '2024-08-17 06:34:29'),
(27, 14, 27, '2024-08-17 04:09:49', '2024-08-17 06:34:34'),
(28, 15, 27, '2024-08-17 04:09:52', '2024-08-17 04:09:52'),
(29, 15, 25, '2024-08-17 04:10:53', '2024-08-17 04:10:53'),
(30, 16, 25, '2024-08-17 04:10:55', '2024-08-17 04:10:55'),
(31, 16, 24, '2024-08-17 04:11:18', '2024-08-17 04:11:18'),
(32, 17, 7, '2024-08-17 04:11:20', '2024-08-17 06:32:56'),
(33, 17, 2, '2024-08-17 04:12:17', '2024-08-17 06:33:09'),
(34, 18, 8, '2024-08-17 04:12:19', '2024-08-17 04:12:19'),
(35, 18, 9, '2024-08-17 04:13:42', '2024-08-17 04:13:42'),
(36, 19, 9, '2024-08-17 04:13:44', '2024-08-17 04:13:44'),
(37, 19, 10, '2024-08-17 04:16:00', '2024-08-17 04:16:00'),
(87, 45, 21, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(88, 45, 18, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(89, 46, 3, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(90, 46, 5, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(91, 47, 12, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(92, 47, 14, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(93, 48, 30, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(94, 48, 32, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(95, 49, 23, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(96, 49, 27, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(97, 50, 7, '2024-08-17 07:05:59', '2024-08-17 07:05:59'),
(98, 50, 2, '2024-08-17 07:05:59', '2024-08-17 07:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `day_practices`
--

CREATE TABLE `day_practices` (
  `id` int(11) NOT NULL,
  `day_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `day_practices`
--

INSERT INTO `day_practices` (`id`, `day_id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 45, 26, NULL, '2024-08-17 07:11:08', '2024-08-17 07:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `set_count` int(11) NOT NULL,
  `times` int(11) NOT NULL,
  `level` enum('1','2','3','4','5') NOT NULL,
  `muscle_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `name`, `image`, `set_count`, `times`, `level`, `muscle_id`, `created_at`, `updated_at`) VALUES
(2, 'push-up', 'posts/push_up.gif', 12, 3, '1', 2, '2024-08-10 19:17:45', '2024-08-10 19:17:45'),
(3, 'Squats', 'posts/squat.gif', 8, 3, '1', 4, NULL, NULL),
(4, 'Jump Squats', 'posts/jump_squats.gif', 8, 3, '2', 4, NULL, NULL),
(5, 'Bulgarian Squats ', 'posts/Bulgarian Squats.gif', 8, 3, '4', 4, NULL, NULL),
(6, 'jump from the knee', 'posts/jump_from_the_knee.gif', 8, 3, '5', 4, NULL, NULL),
(7, 'Diamond Push Up', 'posts/diamond_push_up.gif', 8, 3, '2', 2, NULL, NULL),
(8, 'Circular Push Up', 'posts/Circular_Push_Up.gif', 8, 3, '3', 2, NULL, NULL),
(9, 'Explosive Slow Push Up ', 'posts/Explosive_Slow_Push_Up.gif', 8, 3, '5', 2, NULL, NULL),
(10, 'Push Up Stretch', 'posts/push_up_stretch.gif', 8, 3, '4', 2, NULL, NULL),
(11, 'Squat and Hold', 'posts/squat_hold.gif', 8, 3, '3', 4, NULL, NULL),
(12, 'Bicycle', 'posts/bicycle.gif', 8, 3, '1', 6, NULL, NULL),
(13, 'Circles', 'posts/circles.gif', 8, 3, '5', 6, NULL, NULL),
(14, 'Crunches', 'posts/crunches.gif', 8, 3, '2', 6, NULL, NULL),
(15, 'Crunches And Bicycle', 'posts/crunches_and_bicycle.gif', 8, 3, '4', 6, NULL, NULL),
(16, 'Side To Side Crunches', 'posts/side_to_side_crunches.gif', 8, 3, '3', 6, NULL, NULL),
(18, 'Diamond Push Up', 'posts/diamond_push_up.gif', 8, 3, '2', 3, NULL, NULL),
(19, 'Double Lift Crul', 'posts/double_lift_crul.gif', 8, 3, '1', 3, NULL, NULL),
(20, 'Lifting Leg With Tricepses', 'posts/lefting_legs_with_tricepses.gif', 8, 3, '3', 3, NULL, NULL),
(21, 'Dragon Push Up', 'posts/dragon_push_up.gif', 8, 3, '4', 3, NULL, NULL),
(22, 'Double Rep Push Up', 'posts/double_rep_push_up.gif', 8, 3, '5', 3, NULL, NULL),
(23, 'Boat', 'posts/boat.gif', 10, 3, '2', 5, NULL, NULL),
(24, 'Butterfly', 'posts/butterfly.gif', 10, 3, '5', 5, NULL, NULL),
(25, 'Iron Man Fly', 'posts/iron_man_fly.gif', 10, 3, '4', 5, NULL, NULL),
(26, 'Penguins', 'posts/penguins.gif', 10, 3, '1', 5, NULL, NULL),
(27, 'Towel Push Up', 'posts/towel_push_up.gif', 10, 3, '3', 5, NULL, NULL),
(28, 'Pike Push Up', 'posts/pike_push_up.gif', 8, 3, '2', 7, NULL, NULL),
(29, 'Side Shoulder Raise', 'posts/side_shoulder_raise.gif', 8, 3, '1', 7, NULL, NULL),
(30, 'Shoulder Leans', 'posts/shoulder_leans.gif', 8, 3, '3', 7, NULL, NULL),
(31, 'Bombers', 'posts/bombers.gif', 8, 3, '4', 7, NULL, NULL),
(32, 'Tuke Planche Hold', 'posts/tuke_planche_hold.gif', 8, 3, '5', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_29_010237_create_personal_access_tokens_table', 2),
(5, '2024_06_29_130716_models', 3);

-- --------------------------------------------------------

--
-- Table structure for table `muscles`
--

CREATE TABLE `muscles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `muscles`
--

INSERT INTO `muscles` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Chest', 'posts/chest.jpeg', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(3, 'Arms', 'posts/arms.jpeg', '2024-08-15 05:57:09', '2024-08-15 05:57:09'),
(4, 'Legs', 'posts/legs.jpeg', '2024-08-15 05:57:23', '2024-08-15 05:57:23'),
(5, 'Back', 'posts/back.jpg', '2024-08-15 05:59:17', '2024-08-15 05:59:17'),
(6, 'ABS', 'posts/abs.jpeg', '2024-08-15 05:59:20', '2024-08-15 05:59:20'),
(7, 'Shoulder', 'posts/shoulders.jpeg', '2024-08-15 06:00:02', '2024-08-15 06:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `practices`
--

CREATE TABLE `practices` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `duration` time NOT NULL,
  `feed_back` enum('1','2','3','4','5') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `exercise_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practices`
--

INSERT INTO `practices` (`id`, `user_id`, `duration`, `feed_back`, `created_at`, `updated_at`, `exercise_id`, `day_id`) VALUES
(2, 22, '00:00:30', '2', '2024-08-14 02:00:50', '2024-08-14 02:00:50', 2, 2),
(3, 22, '00:00:30', '2', '2024-08-14 02:01:38', '2024-08-14 02:01:38', 2, 2),
(4, 22, '00:00:30', '2', '2024-08-14 02:02:41', '2024-08-14 02:02:41', 2, 2),
(5, 22, '00:00:30', '2', '2024-08-14 02:02:56', '2024-08-14 02:02:56', 2, 2),
(6, 22, '00:00:30', '2', '2024-08-14 02:03:05', '2024-08-14 02:03:05', 2, 2),
(7, 22, '00:00:30', '2', '2024-08-14 02:03:19', '2024-08-14 02:03:19', 2, 2),
(8, 22, '00:00:30', '2', '2024-08-14 02:03:55', '2024-08-14 02:03:55', 2, 2),
(9, 22, '00:00:30', '2', '2024-08-14 02:04:55', '2024-08-14 02:04:55', 2, 2),
(10, 22, '00:00:30', '2', '2024-08-14 02:05:51', '2024-08-14 02:05:51', 2, 2),
(11, 22, '00:00:30', '2', '2024-08-14 02:05:52', '2024-08-14 02:05:52', 2, 2),
(12, 22, '00:00:30', '2', '2024-08-14 02:05:53', '2024-08-14 02:05:53', 2, 2),
(13, 22, '00:00:30', '2', '2024-08-14 02:05:56', '2024-08-14 02:05:56', 2, 2),
(14, 22, '00:00:30', '2', '2024-08-14 02:06:39', '2024-08-14 02:06:39', 2, 2),
(15, 22, '00:00:30', '2', '2024-08-14 02:06:42', '2024-08-14 02:06:42', 2, 2),
(16, 22, '00:00:30', '2', '2024-08-14 02:09:11', '2024-08-14 02:09:11', 2, 2),
(17, 22, '00:00:30', '3', '2024-08-14 02:09:20', '2024-08-14 02:09:20', 2, 2),
(18, 22, '00:00:30', '4', '2024-08-14 02:09:25', '2024-08-14 02:09:25', 2, 2),
(19, 22, '00:00:30', '5', '2024-08-14 02:09:31', '2024-08-14 02:09:31', 2, 2),
(20, 26, '00:00:01', '4', '2024-08-17 03:55:32', '2024-08-17 03:55:32', 19, 3),
(21, 26, '00:00:01', '2', '2024-08-17 03:55:37', '2024-08-17 03:55:37', 18, 3),
(22, 26, '00:00:02', '4', '2024-08-17 05:36:24', '2024-08-17 05:36:24', 19, 3),
(23, 26, '00:00:01', '4', '2024-08-17 05:36:30', '2024-08-17 05:36:30', 18, 3),
(24, 26, '00:00:02', '4', '2024-08-17 06:29:20', '2024-08-17 06:29:20', 19, 3),
(25, 26, '00:00:01', '2', '2024-08-17 06:29:25', '2024-08-17 06:29:25', 18, 3),
(26, 26, '00:00:01', '1', '2024-08-17 06:31:36', '2024-08-17 06:31:36', 3, 5),
(27, 26, '00:00:01', '1', '2024-08-17 06:31:41', '2024-08-17 06:31:41', 4, 5),
(28, 26, '00:00:01', '5', '2024-08-17 06:32:01', '2024-08-17 06:32:01', 4, 5),
(29, 26, '00:00:09', '1', '2024-08-17 06:32:14', '2024-08-17 06:32:14', 11, 5),
(30, 26, '00:00:03', '1', '2024-08-17 06:32:56', '2024-08-17 06:32:56', 2, 17),
(31, 26, '00:00:03', '5', '2024-08-17 06:33:09', '2024-08-17 06:33:09', 7, 17),
(32, 26, '00:00:06', '1', '2024-08-17 06:34:29', '2024-08-17 06:34:29', 26, 14),
(33, 26, '00:00:01', '1', '2024-08-17 06:34:34', '2024-08-17 06:34:34', 23, 14),
(34, 26, '00:00:00', '1', '2024-08-17 06:36:26', '2024-08-17 06:36:26', 28, 11),
(35, 26, '00:00:01', '1', '2024-08-17 06:37:04', '2024-08-17 06:37:04', 29, 11),
(36, 26, '00:00:01', '1', '2024-08-17 06:37:08', '2024-08-17 06:37:08', 28, 11),
(37, 26, '00:00:01', '1', '2024-08-17 06:37:10', '2024-08-17 06:37:10', 30, 11),
(38, 26, '00:00:01', '1', '2024-08-17 06:37:15', '2024-08-17 06:37:15', 31, 11),
(39, 26, '00:00:01', '1', '2024-08-17 06:37:15', '2024-08-17 06:37:15', 32, 11),
(40, 26, '00:00:01', '1', '2024-08-17 06:37:16', '2024-08-17 06:37:16', 32, 11),
(41, 26, '00:00:01', '1', '2024-08-17 06:37:18', '2024-08-17 06:37:18', 32, 11),
(42, 26, '00:00:01', '2', '2024-08-17 06:37:25', '2024-08-17 06:37:25', 32, 11),
(43, 26, '00:00:01', '1', '2024-08-17 06:37:49', '2024-08-17 06:37:49', 32, 11),
(44, 26, '00:00:16', '1', '2024-08-17 06:39:10', '2024-08-17 06:39:10', 19, 3),
(45, 26, '00:00:16', '1', '2024-08-17 06:40:30', '2024-08-17 06:40:30', 18, 3),
(46, 26, '00:00:16', '1', '2024-08-17 06:40:46', '2024-08-17 06:40:46', 20, 3),
(47, 26, '00:00:01', '1', '2024-08-17 06:45:35', '2024-08-17 06:45:35', 21, 3),
(48, 26, '00:00:01', '1', '2024-08-17 06:47:06', '2024-08-17 06:47:06', 22, 3),
(49, 26, '00:00:01', '5', '2024-08-17 06:47:13', '2024-08-17 06:47:13', 18, 3),
(50, 26, '00:00:14', '2', '2024-08-17 06:55:13', '2024-08-17 06:55:13', 22, 3),
(51, 26, '00:00:01', '4', '2024-08-17 06:55:17', '2024-08-17 06:55:17', 19, 3),
(52, 26, '00:00:01', '4', '2024-08-17 06:56:08', '2024-08-17 06:56:08', 12, 8),
(53, 26, '00:00:00', '2', '2024-08-17 06:56:12', '2024-08-17 06:56:12', 14, 8),
(54, 26, '00:00:03', '5', '2024-08-17 06:56:56', '2024-08-17 06:56:56', 22, 3),
(55, 26, '00:00:01', '2', '2024-08-17 06:57:01', '2024-08-17 06:57:01', 19, 3),
(56, 26, '00:00:00', '5', '2024-08-17 06:57:22', '2024-08-17 06:57:22', 21, 3),
(57, 26, '00:00:01', '4', '2024-08-17 06:57:30', '2024-08-17 06:57:30', 19, 3),
(58, 26, '00:00:00', '4', '2024-08-17 06:59:10', '2024-08-17 06:59:10', 20, 3),
(59, 26, '00:00:01', '2', '2024-08-17 06:59:16', '2024-08-17 06:59:16', 19, 3),
(60, 26, '00:00:00', '4', '2024-08-17 07:00:46', '2024-08-17 07:00:46', 20, 3),
(61, 26, '00:00:00', '2', '2024-08-17 07:00:51', '2024-08-17 07:00:51', 19, 3),
(62, 26, '00:00:01', '4', '2024-08-17 07:03:27', '2024-08-17 07:03:27', 20, 3),
(63, 26, '00:00:01', '2', '2024-08-17 07:03:32', '2024-08-17 07:03:32', 19, 3),
(64, 26, '00:00:00', '1', '2024-08-17 07:05:12', '2024-08-17 07:05:12', 20, 3),
(65, 26, '00:00:00', '1', '2024-08-17 07:05:19', '2024-08-17 07:05:19', 19, 3),
(66, 26, '00:00:01', '4', '2024-08-17 07:11:00', '2024-08-17 07:11:00', 21, 45),
(67, 26, '00:00:01', '2', '2024-08-17 07:11:07', '2024-08-17 07:11:07', 18, 45);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('vbN3nzIcON7vtGOLrKPHU4ogxQ0IWxwvFF3cUX78', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1JhWm0wcmxXcmFSQURtWTd1WFRFSjhXejdFend2SFB3T1hIc2RHQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1722320532),
('WXvJstfhLiH8R4pKcVi9sIeMof6RVVt7LARPHpC2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXZLY3BaNlp5TXVXZ0ZSZDlGQ0RMV2V4Z1BvS09oNWJoQ1JiWFJQYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1719622392);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `level` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `blank_duration` time DEFAULT NULL,
  `tall` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `bmi` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `image`, `level`, `blank_duration`, `tall`, `weight`, `bmi`, `course_id`, `age`, `gender`, `is_admin`) VALUES
(1, 'admin', 'sameer@gamil.com', '$2y$12$iuM36R79m1kiAeLKntHqhundmMwG.zaETvO2nZ9OSDn.34q6DbV1i', NULL, '2024-06-28 21:28:11', '2024-06-28 21:28:11', NULL, '1', NULL, 0, 0, NULL, NULL, 0, 0, 0),
(2, 'test', 'beshr@gmail.com', '$2y$12$BymEZ/VLLdv35BHpvvDMAu7XiLAeYRWCatOHVATbLjfzg5pEHE2Iu', NULL, '2024-06-30 09:55:51', '2024-08-07 20:29:30', 'profiles/DEFAULT.png', '1', '04:10:00', 111, 10, 0, NULL, 22, 1, 0),
(7, 'sameer', 'sameer3@gmail.com', '$2y$12$3Q5kUgNWyIq04n81m5p7auP986d0zhFYtDfm3c.DmoPqZHk47upem', NULL, '2024-08-07 19:20:50', '2024-08-07 19:20:50', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(8, 'sameer', 'sameer23@gmail.com', '$2y$12$obTil20gdsYBQbqUNI/4luY4KeYZGZFgz5O./9wh0mh.uqL.7I...', NULL, '2024-08-07 19:24:54', '2024-08-07 19:24:54', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(9, 'sameer', 'sameer243@gmail.com', '$2y$12$glE0U/bcMYrtTN77le7KX.DZ00fx.yPtRWBbbHLwx5gk.lJtIeH7a', NULL, '2024-08-07 19:44:27', '2024-08-07 19:44:27', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(10, 'sameer', 'sameer2433@gmail.com', '$2y$12$LVLMeen8d0KEEZLu969oaODPH6hGhAS78nkoErPxYg3YbkEeo6siq', NULL, '2024-08-07 19:45:22', '2024-08-07 19:45:22', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(11, 'sameer', 'sameer243f3@gmail.com', '$2y$12$4K7lplFidwb6EZdE1mlgZ.c33HO6Y3AABlgS4OsV0j0Dv0g8djsJC', NULL, '2024-08-07 19:45:50', '2024-08-07 19:45:50', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(12, 'sameer', 'sameerf243f3@gmail.com', '$2y$12$Hm7cfSafkHEj06oP25m8H.GC9V87z.J8NbXMGA6kvjxDR6HCs.f2W', NULL, '2024-08-07 19:46:27', '2024-08-07 19:46:27', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(13, 'sameer', 'sameerf24d3f3@gmail.com', '$2y$12$frhjMMundiGka0DJyW./2enUjjOeaVDmwb6TC77ytZqfAILhOGCNq', NULL, '2024-08-07 19:46:47', '2024-08-07 19:46:47', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(14, 'sameer', 'sameefrf24d3f3@gmail.com', '$2y$12$M88OTBLRM3lf62jxPAykwemDuY4drQIhIG8eCKRtslVsNV9YRqsTi', NULL, '2024-08-07 19:47:16', '2024-08-07 19:47:16', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(15, 'sameer', 'sameefrf24fd3f3@gmail.com', '$2y$12$V2XZo0NMbf/773jsRUr3H.B6DWdCBRue0JhBS3xEnegWfh3qR8IuO', NULL, '2024-08-07 19:49:22', '2024-08-07 19:49:22', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(16, 'sameer', 'ggg@gmail.com', '$2y$12$XIbe4T1Fvs/f8ewpP7YANOGC3gzijMVhFo08sgWHTzvKF3I1sEGAC', NULL, '2024-08-07 19:49:51', '2024-08-07 19:49:51', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(17, 'sameer', 'gggf@gmail.com', '$2y$12$pF88UPsTF6IB3tI5PtlBBuJs0reKuImDdzICNMJVxy7Y3bbdJCMmC', NULL, '2024-08-07 19:51:36', '2024-08-07 19:51:36', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(18, 'sameer', 'gggff@gmail.com', '$2y$12$1za7Zre8/AYFouUfjblgXeHkMX0v1hqQlR3ZtvKOeVIveRMigIFyG', NULL, '2024-08-07 19:53:07', '2024-08-07 19:53:07', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(19, 'sameer', 'gggfff@gmail.com', '$2y$12$4v676VxnbJR8ElrnxBWNqubivcXKb0fO/j.E5tr22zEaIDaH0Txye', NULL, '2024-08-07 19:54:35', '2024-08-07 19:54:35', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(20, 'sameer', 'fgggfff@gmail.com', '$2y$12$MXrOvijcSVX42c84tfEmnOO7brocTtBeYxXi2Ju97rQX79RdcjB5O', NULL, '2024-08-07 19:55:05', '2024-08-07 19:55:05', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(21, 'sameer', 'fggggfff@gmail.com', '$2y$12$vvM6R47.9M5GLEu9EUPs5uwh8Fb4VL7pUWXMJlLcxxoVwYd/4QblS', NULL, '2024-08-07 19:56:16', '2024-08-07 19:56:16', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(22, 'test', 'sameerfggggfff@gmail.com', '$2y$12$qV2TnFGsRtD8x1jq7fg3ru1Ir2MCyIz3BOM3HGmrFG62IXGCwIR2y', NULL, '2024-08-09 03:17:09', '2024-08-14 01:59:08', 'profiles/DEFAULT.png', '1', '04:10:00', 111, 10, 0, 2, 22, 1, 1),
(23, 'new user', 'newuser@gmail.com', '$2y$12$MCQfG8GN7vDm5bVOQgHRXOgmTnFUesRp7bO3WpNu6LJdNEDiS4Iza', NULL, '2024-08-09 17:08:30', '2024-08-09 17:08:30', 'profiles/DEFAULT.png', '1', '00:04:02', 18, 90, 0, NULL, 30, 1, 0),
(24, 'sameer', 'newuser2@gmail.com', '$2y$12$ZIPUzug3Byyj5lk6RkqCV.oLvdCbV4GLhs.knBXDVvtyi07VRcvCi', NULL, '2024-08-10 01:08:00', '2024-08-10 01:08:00', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(25, 'sameer', 'newuser3@gmail.com', '$2y$12$itay3VMhklKS5nAOohqmkeMvnWItQAUlfvvNlochl6SIkO6V6QqQ.', NULL, '2024-08-10 01:23:04', '2024-08-10 01:23:04', 'profiles/DEFAULT.png', '1', '00:04:02', 185, 90, 0, NULL, 30, 1, 0),
(26, 'rami', 'ramizidan101@gmail.com', '$2y$12$CIJjJqTbG.JA6ofa0Qh1MuLxAc3Ftn1AyRFkms5dy11K/SDGZN.DW', NULL, '2024-08-17 03:31:11', '2024-08-17 07:10:50', 'profiles/DEFAULT.png', '1', '00:00:00', 170, 75, 0, 11, 21, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_muscles`
--

CREATE TABLE `user_muscles` (
  `id` int(11) UNSIGNED NOT NULL,
  `muscle_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `level` enum('1','2','3','4','5') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_muscles`
--

INSERT INTO `user_muscles` (`id`, `muscle_id`, `user_id`, `level`, `created_at`, `updated_at`) VALUES
(9, 2, 1, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(10, 2, 2, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(11, 2, 7, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(12, 2, 8, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(13, 2, 9, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(14, 2, 10, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(15, 2, 11, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(16, 2, 12, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(17, 2, 13, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(18, 2, 14, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(19, 2, 15, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(20, 2, 16, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(21, 2, 17, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(22, 2, 18, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(23, 2, 19, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(24, 2, 20, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(25, 2, 21, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(26, 2, 22, '1', '2024-08-10 02:36:55', '2024-08-14 02:00:50'),
(27, 2, 23, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(28, 2, 24, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(29, 2, 25, '1', '2024-08-10 02:36:55', '2024-08-10 02:36:55'),
(30, 2, 26, '1', '2024-08-17 03:31:11', '2024-08-17 06:33:09'),
(31, 3, 26, '2', '2024-08-17 03:31:11', '2024-08-17 07:11:07'),
(32, 4, 26, '4', '2024-08-17 03:31:11', '2024-08-17 06:32:14'),
(33, 5, 26, '3', '2024-08-17 03:31:11', '2024-08-17 06:34:34'),
(34, 6, 26, '2', '2024-08-17 03:31:11', '2024-08-17 06:56:12'),
(35, 7, 26, '4', '2024-08-17 03:31:11', '2024-08-17 06:37:10');

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_muscle_user1_idx` (`created_by`);

--
-- Indexes for table `course_days`
--
ALTER TABLE `course_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_day_course1_idx` (`course_id`);

--
-- Indexes for table `days_have_exercises`
--
ALTER TABLE `days_have_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_days_have_exercises_exercise1_idx` (`exercise_id`),
  ADD KEY `fk_days_have_exercises_day1_idx` (`day_id`);

--
-- Indexes for table `day_practices`
--
ALTER TABLE `day_practices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_practice_day_course1_idx` (`course_id`),
  ADD KEY `fk_practice_day_day1_idx` (`day_id`),
  ADD KEY `fk_practice_day_user1_idx` (`user_id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exercise_muscle1_idx` (`muscle_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muscles`
--
ALTER TABLE `muscles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `practices`
--
ALTER TABLE `practices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_practice_user1_idx` (`user_id`),
  ADD KEY `fk_practice_exercise1_idx` (`exercise_id`),
  ADD KEY `fk_practice_day1_idx` (`day_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `fk_user_course_idx` (`course_id`);

--
-- Indexes for table `user_muscles`
--
ALTER TABLE `user_muscles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_muscle_user1` (`user_id`),
  ADD KEY `fk_usermuscle_musce1` (`muscle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_days`
--
ALTER TABLE `course_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `days_have_exercises`
--
ALTER TABLE `days_have_exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `day_practices`
--
ALTER TABLE `day_practices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `muscles`
--
ALTER TABLE `muscles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practices`
--
ALTER TABLE `practices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_muscles`
--
ALTER TABLE `user_muscles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_muscle_user1_idx` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `course_days`
--
ALTER TABLE `course_days`
  ADD CONSTRAINT `fk_course_day_course1_idx` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `days_have_exercises`
--
ALTER TABLE `days_have_exercises`
  ADD CONSTRAINT `fk_days_have_exercises_day1_idx` FOREIGN KEY (`day_id`) REFERENCES `course_days` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_days_have_exercises_exercise1_idx` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `day_practices`
--
ALTER TABLE `day_practices`
  ADD CONSTRAINT `fk_practice_day_course1_idx` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_practice_day_day1_idx` FOREIGN KEY (`day_id`) REFERENCES `course_days` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_practice_day_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `fk_exercise_muscle1_idx` FOREIGN KEY (`muscle_id`) REFERENCES `muscles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `practices`
--
ALTER TABLE `practices`
  ADD CONSTRAINT `fk_practice_day1_idx` FOREIGN KEY (`day_id`) REFERENCES `course_days` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_practice_exercise1_idx` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_practice_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_course_idx` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `user_muscles`
--
ALTER TABLE `user_muscles`
  ADD CONSTRAINT `fk_muscle_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usermuscle_musce1` FOREIGN KEY (`muscle_id`) REFERENCES `muscles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
