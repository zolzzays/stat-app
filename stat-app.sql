-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.14.0.7170
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for stat-app
CREATE DATABASE IF NOT EXISTS `stat-app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `stat-app`;

-- Dumping structure for table stat-app.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.cache: ~0 rows (approximately)

-- Dumping structure for table stat-app.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.cache_locks: ~0 rows (approximately)

-- Dumping structure for table stat-app.energy_sales
CREATE TABLE IF NOT EXISTS `energy_sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `power_plant_id` bigint(20) unsigned NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `before_month` float NOT NULL DEFAULT 0,
  `this_month` float NOT NULL DEFAULT 0,
  `year_usage` float NOT NULL DEFAULT 0,
  `this_musage` float NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `org_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `energy_sales_power_plant_id_foreign` (`power_plant_id`),
  KEY `energy_sales_org_id_foreign` (`org_id`),
  CONSTRAINT `energy_sales_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `energy_sales_power_plant_id_foreign` FOREIGN KEY (`power_plant_id`) REFERENCES `power_plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.energy_sales: ~2 rows (approximately)
REPLACE INTO `energy_sales` (`id`, `power_plant_id`, `year`, `month`, `product_name`, `unit_name`, `before_month`, `this_month`, `year_usage`, `this_musage`, `created_at`, `updated_at`, `org_id`) VALUES
	(1, 1, 2026, 3, 'Цахилгаан', 'мян.кВт.цаг', 145, 45245, 552, 2252, '2026-03-31 17:28:12', '2026-03-31 17:28:12', 1),
	(2, 3, 2026, 3, 'Цахилгаан', 'мян.кВт.цаг', 145, 152, 15, 145, '2026-03-31 17:31:01', '2026-03-31 17:31:01', 2);

-- Dumping structure for table stat-app.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table stat-app.hr_count
CREATE TABLE IF NOT EXISTS `hr_count` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `power_plant_id` bigint(20) unsigned NOT NULL,
  `org_id` bigint(20) unsigned DEFAULT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `emp_male` int(11) NOT NULL DEFAULT 0,
  `emp_female` int(11) NOT NULL DEFAULT 0,
  `work_male` int(11) NOT NULL DEFAULT 0,
  `work_female` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hr_count_power_plant_id_foreign` (`power_plant_id`),
  KEY `hr_count_org_id_foreign` (`org_id`),
  CONSTRAINT `hr_count_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hr_count_power_plant_id_foreign` FOREIGN KEY (`power_plant_id`) REFERENCES `power_plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.hr_count: ~0 rows (approximately)
REPLACE INTO `hr_count` (`id`, `power_plant_id`, `org_id`, `year`, `month`, `emp_male`, `emp_female`, `work_male`, `work_female`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 2026, 3, 183, 95, 42, 0, '2026-04-01 23:14:34', '2026-04-01 23:14:34');

-- Dumping structure for table stat-app.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.job_batches: ~0 rows (approximately)

-- Dumping structure for table stat-app.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.jobs: ~0 rows (approximately)

-- Dumping structure for table stat-app.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.migrations: ~18 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_03_25_022510_create_power_plant_types_table', 2),
	(5, '2026_03_29_045834_create_power_plants_table', 3),
	(6, '2026_03_29_060740_create_plant_output_table', 4),
	(7, '2026_03_29_065216_change_plant_output_columns_to_float', 5),
	(8, '2026_03_31_063910_create_roles_table', 6),
	(9, '2026_03_31_064308_add_role_id_to_users_table', 7),
	(10, '2026_03_31_071257_add_username_to_users_table', 8),
	(11, '2026_03_31_073051_add_power_plant_id_to_users_table', 9),
	(12, '2026_03_31_083512_add_year_month_to_plant_output_table', 10),
	(13, '2026_04_01_011544_create_energy_sales_table', 11),
	(14, '2026_04_01_023953_create_organizations_table', 12),
	(15, '2026_04_01_080851_create_reg_types_table', 13),
	(16, '2026_04_02_024315_add_org_reg_type_to_power_plants_table', 14),
	(17, '2026_04_02_060749_add_org_id_to_plant_output_and_energy_sales_table', 15),
	(18, '2026_04_02_070914_create_hr_count_table', 16);

-- Dumping structure for table stat-app.organizations
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `org_name` varchar(255) NOT NULL,
  `org_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_org_code_unique` (`org_code`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.organizations: ~52 rows (approximately)
REPLACE INTO `organizations` (`id`, `org_name`, `org_code`, `created_at`, `updated_at`) VALUES
	(1, 'ДЦС-2 ТӨХК', '1', '2026-03-31 18:43:46', '2026-03-31 23:42:53'),
	(2, 'ДЦС-3  ТӨХК', '2', '2026-03-31 18:43:59', '2026-03-31 23:43:04'),
	(3, 'ДЦС-4 ТӨХК', '3', '2026-03-31 18:44:21', '2026-03-31 18:44:21'),
	(4, 'ДДЦС ТӨХК', '4', '2026-03-31 18:44:34', '2026-03-31 18:44:34'),
	(5, 'ЭДЦС ТӨХК', '5', '2026-03-31 18:44:53', '2026-03-31 18:44:53'),
	(6, 'Эрдэнэт үйлдвэр ТӨҮГ', '6', '2026-03-31 18:45:06', '2026-03-31 18:45:06'),
	(7, 'Даланзадгад ДЦС ТӨХК', '7', '2026-03-31 18:45:21', '2026-03-31 18:45:21'),
	(8, 'Тосон энержи  ХХК', '8', '2026-03-31 18:45:40', '2026-03-31 18:45:40'),
	(9, 'ДБЭХС ТӨХК', '9', '2026-03-31 18:48:43', '2026-03-31 18:48:43'),
	(10, 'Амгалан ДС ХХК', '10', '2026-03-31 18:48:58', '2026-03-31 18:49:07'),
	(11, 'Багануур ДС ТӨХК', '11', '2026-03-31 18:49:21', '2026-03-31 18:49:21'),
	(12, 'Налайх ДС ТӨХК', '12', '2026-03-31 18:49:38', '2026-03-31 18:49:38'),
	(13, 'Дулаан Шарын гол ТӨХК', '13', '2026-03-31 18:49:54', '2026-03-31 18:49:54'),
	(14, 'Хөвсгөл  ДС ТӨХК', '14', '2026-03-31 18:50:09', '2026-03-31 18:50:09'),
	(15, 'Ховд ДС ТӨХК', '15', '2026-03-31 18:50:28', '2026-03-31 18:50:28'),
	(16, 'Улаангомын дулааны 2-р станц ТӨХК', '16', '2026-03-31 18:50:48', '2026-03-31 18:50:48'),
	(17, 'М-Си-Эс интернэйшнл ХХК', '17', '2026-03-31 18:51:17', '2026-03-31 18:51:17'),
	(18, 'Цэцэнс майнинг энд энержи ХХК', '18', '2026-03-31 18:51:32', '2026-03-31 18:51:32'),
	(19, 'Клин энержи ХХК', '19', '2026-03-31 18:51:52', '2026-03-31 18:51:52'),
	(20, 'Клин энержи Ази ХХК', '20', '2026-03-31 18:52:07', '2026-03-31 18:52:07'),
	(21, 'Сайншанд салхин парк ХХК', '21', '2026-03-31 18:52:23', '2026-03-31 18:52:23'),
	(22, 'Солар повер интерэйншл ХХК', '22', '2026-03-31 18:52:41', '2026-03-31 18:52:41'),
	(23, 'Эвридэй ферм ХХК', '23', '2026-03-31 18:52:56', '2026-03-31 18:52:56'),
	(24, 'Нарантээг ХХК', '24', '2026-03-31 18:53:10', '2026-03-31 18:53:10'),
	(25, 'И Эс Би солар энержи ХХК', '25', '2026-03-31 18:53:26', '2026-03-31 18:53:26'),
	(26, 'Тэнүүнгэрэл констракшн  ХХК', '26', '2026-03-31 18:53:41', '2026-03-31 23:42:35'),
	(27, 'Дезерт солар пауэр вуан ХХК', '27', '2026-03-31 18:53:55', '2026-03-31 18:53:55'),
	(28, 'Солар повер Монголиа ХХК', '28', '2026-03-31 18:54:08', '2026-03-31 18:54:08'),
	(29, 'Тайшир ногоон эрчим ТӨХК', '29', '2026-03-31 18:54:24', '2026-03-31 18:54:24'),
	(30, 'Алтай улиастай ЦТС ТӨХК', '30', '2026-03-31 18:54:43', '2026-03-31 18:54:43'),
	(31, 'Баруун бүсийн ЦТС ТӨХК', '31', '2026-03-31 18:55:00', '2026-03-31 18:55:00'),
	(32, 'УБДС ТӨХК', '32', '2026-03-31 23:40:38', '2026-03-31 23:40:38'),
	(33, 'ДДС ТӨХК', '33', '2026-03-31 23:40:55', '2026-03-31 23:40:55'),
	(34, 'ДСЦТС ХХК', '34', '2026-03-31 23:48:19', '2026-03-31 23:48:30'),
	(35, 'ЭБЦТС ТӨХК', '35', '2026-03-31 23:48:49', '2026-03-31 23:48:49'),
	(36, 'Эрдэнэт ус ДТС ОНӨХК', '36', '2026-03-31 23:49:11', '2026-03-31 23:49:11'),
	(37, 'БЗӨБЦТС ТӨХК', '37', '2026-03-31 23:49:42', '2026-03-31 23:49:42'),
	(38, 'ӨБЦТС ТӨХК', '38', '2026-03-31 23:50:10', '2026-03-31 23:50:10'),
	(39, 'УБ төмөр зам ЭХУХ', '39', '2026-03-31 23:50:31', '2026-03-31 23:50:31'),
	(40, 'Титан грид ХХК', '40', '2026-03-31 23:50:59', '2026-03-31 23:50:59'),
	(41, 'Эрчим сүлжээ ХХК', '41', '2026-03-31 23:51:23', '2026-03-31 23:51:23'),
	(42, 'Хөвсгөл ЭХ ХХК', '42', '2026-03-31 23:52:10', '2026-03-31 23:52:20'),
	(43, 'Баянхонгор ЭХ ЦТС ХХК', '43', '2026-03-31 23:52:44', '2026-03-31 23:52:44'),
	(45, 'Баян-Өлгийн ЦШСГ', '44', '2026-03-31 23:56:55', '2026-03-31 23:56:55'),
	(46, 'Пауэр юнит ХХК', '45', '2026-03-31 23:57:40', '2026-03-31 23:57:40'),
	(47, 'Эс Жи И Эн ХХК', '46', '2026-03-31 23:58:15', '2026-03-31 23:58:15'),
	(48, 'Электрикком ХХК', '47', '2026-03-31 23:59:45', '2026-03-31 23:59:45'),
	(49, 'Ухаалаг эрчим хүч ХХК', '48', '2026-04-01 00:00:06', '2026-04-01 00:00:06'),
	(50, 'Улаанбаатар сүлжээ ХХК', '49', '2026-04-01 00:00:25', '2026-04-01 00:00:25'),
	(51, 'Биндэгноров ХХК', '50', '2026-04-01 00:01:33', '2026-04-01 00:01:33'),
	(52, 'Эрин энержи консалтинг', '51', '2026-04-01 00:01:49', '2026-04-01 00:01:49'),
	(53, 'Нийслэл түгээх сүлжээ', '52', '2026-04-01 00:02:04', '2026-04-01 00:02:04'),
	(54, 'Ти Эс Эм Энержи ХХК', '53', '2026-04-01 00:02:25', '2026-04-01 00:02:25'),
	(55, 'Нью УБ Интер-л Эйрпорт', '54', '2026-04-01 00:02:47', '2026-04-01 00:02:47'),
	(56, 'Нолго ХХК', '55', '2026-04-01 00:03:19', '2026-04-01 00:03:19');

-- Dumping structure for table stat-app.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table stat-app.plant_output
CREATE TABLE IF NOT EXISTS `plant_output` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `power_plant_id` bigint(20) unsigned NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `before_month` float NOT NULL DEFAULT 0,
  `this_month` float NOT NULL DEFAULT 0,
  `year_usage` float NOT NULL DEFAULT 0,
  `this_musage` float NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `org_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plant_output_power_plant_id_foreign` (`power_plant_id`),
  KEY `plant_output_org_id_foreign` (`org_id`),
  CONSTRAINT `plant_output_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `plant_output_power_plant_id_foreign` FOREIGN KEY (`power_plant_id`) REFERENCES `power_plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.plant_output: ~2 rows (approximately)
REPLACE INTO `plant_output` (`id`, `power_plant_id`, `year`, `month`, `product_name`, `unit_name`, `before_month`, `this_month`, `year_usage`, `this_musage`, `created_at`, `updated_at`, `org_id`) VALUES
	(1, 1, 2026, 3, 'Цахилгаан', 'мян.кВт.цаг', 16198, 16978, 2119, 166051, '2026-03-28 23:08:45', '2026-03-31 00:39:51', 1),
	(4, 3, 2026, 3, 'Цахилгаан', 'мян.кВт.цаг', 1, 1, 1, 1, '2026-03-30 23:35:13', '2026-03-31 17:02:28', 2);

-- Dumping structure for table stat-app.power_plant_types
CREATE TABLE IF NOT EXISTS `power_plant_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.power_plant_types: ~4 rows (approximately)
REPLACE INTO `power_plant_types` (`id`, `t_name`, `created_at`, `updated_at`) VALUES
	(1, 'Цахилгаан, дулаан үйлдвэрлэлт', '2026-03-28 19:50:10', '2026-03-28 19:50:10'),
	(2, 'Дулаан үйлдвэрлэл', '2026-03-28 19:50:26', '2026-03-28 19:50:26'),
	(3, 'Цахилгаан үйлдвэрлэл', '2026-03-28 19:50:41', '2026-03-28 19:50:41');

-- Dumping structure for table stat-app.power_plants
CREATE TABLE IF NOT EXISTS `power_plants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plant_name` varchar(255) NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `org_id` bigint(20) unsigned DEFAULT NULL,
  `reg_type_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `power_plants_type_id_foreign` (`type_id`),
  KEY `power_plants_org_id_foreign` (`org_id`),
  KEY `power_plants_reg_type_id_foreign` (`reg_type_id`),
  CONSTRAINT `power_plants_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `power_plants_reg_type_id_foreign` FOREIGN KEY (`reg_type_id`) REFERENCES `reg_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `power_plants_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `power_plant_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.power_plants: ~42 rows (approximately)
REPLACE INTO `power_plants` (`id`, `plant_name`, `type_id`, `created_at`, `updated_at`, `org_id`, `reg_type_id`) VALUES
	(1, 'ДЦС-2', 1, '2026-03-28 21:36:59', '2026-04-01 18:48:23', 1, 1),
	(3, 'ДЦС-3', 1, '2026-03-28 21:38:54', '2026-04-01 18:48:15', 2, 1),
	(4, 'ДЦС-4', 1, '2026-03-28 21:39:06', '2026-04-01 18:48:37', 3, 1),
	(5, 'ДДЦС', 1, '2026-03-28 21:39:27', '2026-04-01 18:49:18', 4, 1),
	(6, 'ЭДЦС', 1, '2026-03-28 21:39:40', '2026-04-01 18:49:43', 5, 1),
	(7, 'ЭҮДЦС', 1, '2026-03-31 18:00:06', '2026-04-01 18:50:22', 6, 1),
	(8, 'Тосон ДЦС', 1, '2026-03-31 18:00:21', '2026-04-01 18:51:09', 8, 2),
	(9, 'Даланзадгад ДЦС', 1, '2026-03-31 18:04:10', '2026-04-01 18:52:08', 7, 1),
	(10, 'Чойбалсан ДЦС', 2, '2026-03-31 18:04:28', '2026-04-01 18:52:57', 9, 1),
	(11, 'Амгалан ДС', 2, '2026-03-31 18:04:45', '2026-04-01 18:53:52', 10, 1),
	(12, 'Багануур ДС', 2, '2026-03-31 18:05:04', '2026-04-01 18:55:26', 11, 1),
	(13, 'Налайх ДС', 2, '2026-03-31 18:15:04', '2026-04-01 18:56:37', 12, 1),
	(14, 'Дулаан Шарын гол', 2, '2026-03-31 18:15:29', '2026-04-01 18:57:22', 13, 1),
	(15, 'Хөвсгөл  ДС', 2, '2026-03-31 18:15:43', '2026-04-01 18:58:02', 14, 1),
	(16, 'Ховд ДС', 2, '2026-03-31 18:16:01', '2026-04-01 18:58:54', 15, 1),
	(17, 'Улаангомын дулааны 2-р станц', 2, '2026-03-31 18:16:18', '2026-04-01 19:00:02', 16, 1),
	(19, 'Ухаахудаг ЦС', 2, '2026-03-31 18:18:57', '2026-04-01 19:00:46', 17, 2),
	(20, 'Бөөрөлжүүт ЦС', 3, '2026-04-01 19:01:27', '2026-04-01 19:01:27', 18, 2),
	(21, 'Салхит СЦС', 3, '2026-04-01 19:02:32', '2026-04-01 19:02:32', 19, 2),
	(22, 'Цэций СЦС', 3, '2026-04-01 19:03:17', '2026-04-01 19:03:17', 20, 2),
	(23, 'Шанд СЦС', 3, '2026-04-01 19:03:55', '2026-04-01 19:03:55', 21, 2),
	(24, 'Нар НЦС', 3, '2026-04-01 19:10:17', '2026-04-01 19:10:17', 22, 2),
	(25, 'Моннаран НЦС', 3, '2026-04-01 19:10:47', '2026-04-01 19:10:47', 23, 2),
	(26, 'Гэгээн НЦС', 3, '2026-04-01 21:27:08', '2026-04-01 21:27:08', 24, 2),
	(27, 'Сүмбэр НЦС', 3, '2026-04-01 21:27:42', '2026-04-01 21:27:42', 25, 2),
	(28, 'Бөхөг НЦС', 3, '2026-04-01 21:28:20', '2026-04-01 21:28:20', 26, 2),
	(29, 'Говь НЦС', 3, '2026-04-01 21:28:41', '2026-04-01 21:28:41', 27, 2),
	(30, 'Эрдэнэ НЦС', 3, '2026-04-01 21:29:09', '2026-04-01 21:29:09', 28, 2),
	(31, 'Борх НЦС', 3, '2026-04-01 21:29:54', '2026-04-01 21:29:54', 29, 2),
	(32, 'Дэлгэрэх НЦС', 3, '2026-04-01 21:30:11', '2026-04-01 21:30:11', 29, 2),
	(33, 'Сэрвэн НЦС', 3, '2026-04-01 21:30:36', '2026-04-01 21:30:36', 29, 2),
	(34, 'Сумдын НЦС', 3, '2026-04-01 21:31:02', '2026-04-01 21:31:02', 29, 2),
	(35, 'Тайшир УЦС', 3, '2026-04-01 21:31:37', '2026-04-01 21:31:37', 29, 2),
	(36, 'Гуулин УЦС', 3, '2026-04-01 21:31:55', '2026-04-01 21:31:55', 29, 2),
	(37, 'Богдын гол УЦС', 3, '2026-04-01 21:32:16', '2026-04-01 21:32:16', 29, 2),
	(38, 'Тосонцэнгэл УЦС', 3, '2026-04-01 21:32:47', '2026-04-01 21:32:47', 29, 2),
	(39, 'Галуутай УЦС', 3, '2026-04-01 21:33:10', '2026-04-01 21:33:10', 29, 2),
	(40, 'Хүнгүй УЦС', 3, '2026-04-01 21:33:30', '2026-04-01 21:33:30', 29, 2),
	(41, 'Есөнбулаг ДиЦС', 3, '2026-04-01 21:34:02', '2026-04-01 21:34:02', 30, 1),
	(42, 'Улиастай ДиС', 3, '2026-04-01 21:36:42', '2026-04-01 21:36:42', 30, 1),
	(43, 'АлтайсумДиС', 3, '2026-04-01 21:37:25', '2026-04-01 21:37:25', 30, 1),
	(44, 'Дөргөн УЦС', 3, '2026-04-01 21:37:58', '2026-04-01 21:37:58', 31, 1),
	(45, 'Ховд НЦС', 3, '2026-04-01 21:38:20', '2026-04-01 21:38:20', 31, 1);

-- Dumping structure for table stat-app.reg_types
CREATE TABLE IF NOT EXISTS `reg_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.reg_types: ~2 rows (approximately)
REPLACE INTO `reg_types` (`id`, `type_name`, `created_at`, `updated_at`) VALUES
	(1, 'Үйлдвэрлэл, Борлуулалт', NULL, NULL),
	(2, 'Үйлдвэрлэл', NULL, NULL),
	(3, 'Борлуулалт', NULL, NULL);

-- Dumping structure for table stat-app.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.roles: ~2 rows (approximately)
REPLACE INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'admin', NULL, NULL, NULL),
	(2, 'user', NULL, NULL, NULL);

-- Dumping structure for table stat-app.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.sessions: ~2 rows (approximately)
REPLACE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('TIc1m74HBa2OsI8vYkDMdPU960bbb84L8DW2uVcd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiT1NCMVBjclAwdVlQSTUwUjdPZU0yZUtVNjdQb25sWW5CNFl4SXFiNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775119503),
	('WC3aVdUcTXkYh1AC1t2PvtlWMjKKGcHY7Vla5Nu4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicmZWZjkweFZnY3dmeGdKdVdHRGpOUGR2OVdlUjVUYjdlYkJVbXlDVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775119557);

-- Dumping structure for table stat-app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `power_plant_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_power_plant_id_foreign` (`power_plant_id`),
  CONSTRAINT `users_power_plant_id_foreign` FOREIGN KEY (`power_plant_id`) REFERENCES `power_plants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table stat-app.users: ~3 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `power_plant_id`) VALUES
	(1, 'ДЦС-2', 'ДЦС-2', 'pp2@gmail.com', NULL, '$2y$12$FreDyR0QFy.6EjTl1YUuRutM13XJuHp56Vekm7jp7qLGSMk8Bsl8u', NULL, '2026-02-02 20:04:52', '2026-03-30 23:33:58', 2, 1),
	(2, 'zolzaya', 'zolzaya', 'zolzzays@gmail.com', '2026-03-24 01:31:18', '$2y$12$oOdsXEGDYpISrXQ5ULvkHOHQuIdKDfrACKXDFEChPkcDcDwKOUltO', NULL, NULL, '2026-03-30 23:15:20', 1, NULL),
	(3, 'ДЦС-3', 'ДЦС-3', 'tpp3@gmail.com', NULL, '$2y$12$fVruco9Egyh29bIM4Jb5U.NUhs5vCZ5ccLM2Bl03gH7vO6lHiLZXy', NULL, '2026-03-31 17:29:53', '2026-03-31 17:29:53', 2, 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
