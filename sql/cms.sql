-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2026 at 10:47 AM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'page', 'created', 'App\\Models\\Page', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"name\": \"\", \"image\": null, \"status\": \"3\", \"permalink\": \"\", \"seo_image\": null, \"seo_index\": null, \"seo_title\": null, \"created_at\": \"2026-03-09T09:39:52.000000Z\", \"updated_at\": \"2026-03-09T09:39:52.000000Z\", \"description\": null, \"is_breadcrumb\": 0, \"seo_description\": null, \"footer_component\": null, \"header_component\": null, \"page_text_content\": null, \"header_component_position\": null}}', NULL, '2026-03-09 09:39:52', '2026-03-09 09:39:52'),
(2, 'page', 'updated', 'App\\Models\\Page', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"\", \"status\": \"3\", \"permalink\": \"\", \"seo_index\": null, \"description\": null, \"page_text_content\": null}, \"attributes\": {\"name\": \"Home\", \"status\": \"1\", \"permalink\": \"/\", \"seo_index\": \"noindex\", \"description\": \"<p><br></p>\", \"page_text_content\": \"<p><br></p>\"}}', NULL, '2026-03-09 09:39:52', '2026-03-09 09:39:52'),
(3, 'general', 'created', 'App\\Models\\General', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"email\": null, \"footer\": null, \"header\": null, \"social\": null, \"contact\": null, \"fav_icon\": null, \"location\": null, \"created_at\": \"2026-03-09T09:40:14.000000Z\", \"updated_at\": \"2026-03-09T09:40:14.000000Z\", \"description\": null, \"cookie_title\": null, \"website_name\": null, \"footer_component\": null, \"google_analytics\": null, \"header_component\": \"header\", \"cookie_description\": null, \"header_component_position\": \"fix\"}}', NULL, '2026-03-09 09:40:14', '2026-03-09 09:40:14'),
(4, 'general', 'updated', 'App\\Models\\General', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"updated_at\": \"2026-03-09T09:40:14.000000Z\", \"footer_component\": null}, \"attributes\": {\"updated_at\": \"2026-03-09T09:40:18.000000Z\", \"footer_component\": \"footer\"}}', NULL, '2026-03-09 09:40:18', '2026-03-09 09:40:18'),
(5, 'page', 'updated', 'App\\Models\\Page', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"updated_at\": \"2026-03-09T09:39:52.000000Z\", \"footer_component\": null, \"header_component\": null}, \"attributes\": {\"updated_at\": \"2026-03-09T09:41:04.000000Z\", \"footer_component\": \"footer\", \"header_component\": \"header\"}}', NULL, '2026-03-09 09:41:04', '2026-03-09 09:41:04'),
(6, 'componentmaster', 'created', 'App\\Models\\ComponentMaster', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"name\": \"hero-section\", \"limit\": null, \"database\": null, \"position\": 1, \"set_from\": \"custom\", \"is_single\": false, \"created_at\": \"2026-03-09T10:04:31.000000Z\", \"updated_at\": \"2026-03-09T10:04:31.000000Z\", \"related_data\": null, \"relational_table\": null, \"schema_group_settings\": {\"1\": {\"name\": \"Group 1\", \"is_multiple\": false}}}}', NULL, '2026-03-09 10:04:31', '2026-03-09 10:04:31'),
(7, 'pagecomponentstatus', 'created', 'App\\Models\\PageComponentStatus', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"status\": 0, \"page_id\": 1, \"created_at\": \"2026-03-09T10:04:42.000000Z\", \"updated_at\": \"2026-03-09T10:04:42.000000Z\", \"component_id\": 1, \"data_view_no\": 1}}', NULL, '2026-03-09 10:04:42', '2026-03-09 10:04:42'),
(8, 'componentfield', 'created', 'App\\Models\\ComponentField', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"name\": \"title\", \"type\": \"text\", \"group\": \"1\", \"value\": null, \"colspan\": 6, \"page_id\": null, \"position\": 0, \"help_text\": null, \"created_at\": \"2026-03-09T10:05:18.000000Z\", \"updated_at\": \"2026-03-09T10:05:18.000000Z\", \"is_required\": 0, \"component_id\": 1, \"schema_group\": 1, \"show_in_table\": 1, \"display_column\": null, \"static_options\": null, \"schema_instance\": 1, \"related_component\": null, \"relationship_type\": null}}', NULL, '2026-03-09 10:05:18', '2026-03-09 10:05:18'),
(9, 'pagecomponentstatus', 'updated', 'App\\Models\\PageComponentStatus', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"updated_at\": \"2026-03-09T10:04:42.000000Z\", \"data_view_no\": 1}, \"attributes\": {\"updated_at\": \"2026-03-09T10:06:45.000000Z\", \"data_view_no\": 100}}', NULL, '2026-03-09 10:06:45', '2026-03-09 10:06:45'),
(10, 'widget', 'created', 'App\\Models\\widget', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 1, \"link\": \"/\", \"name\": \"Home\", \"type\": \"page\", \"ref_id\": 1, \"position\": 0, \"parent_id\": null, \"created_at\": \"2026-03-09T10:25:36.000000Z\", \"updated_at\": \"2026-03-09T10:25:36.000000Z\"}}', NULL, '2026-03-09 10:25:36', '2026-03-09 10:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_designation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `author_image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int NOT NULL,
  `job_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_job_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_exp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `career_categories`
--

CREATE TABLE `career_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `component_fields`
--

CREATE TABLE `component_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `component_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_component` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_column` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `static_options` json DEFAULT NULL,
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schema_group` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `schema_instance` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `position` int DEFAULT NULL,
  `show_in_table` tinyint(1) NOT NULL DEFAULT '1',
  `colspan` tinyint UNSIGNED NOT NULL DEFAULT '6',
  `page_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `component_fields`
--

INSERT INTO `component_fields` (`id`, `component_id`, `name`, `type`, `relationship_type`, `related_component`, `display_column`, `static_options`, `help_text`, `is_required`, `value`, `group`, `schema_group`, `schema_instance`, `position`, `show_in_table`, `colspan`, `page_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'title', 'text', NULL, NULL, NULL, NULL, NULL, 0, NULL, '1', 1, 1, 0, 1, 6, NULL, '2026-03-09 10:05:18', '2026-03-09 10:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `component_masters`
--

CREATE TABLE `component_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `set_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `database` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relational_table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_data` json DEFAULT NULL,
  `is_single` tinyint(1) NOT NULL DEFAULT '0',
  `limit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `schema_group_settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `component_masters`
--

INSERT INTO `component_masters` (`id`, `name`, `set_from`, `database`, `relational_table`, `related_data`, `is_single`, `limit`, `position`, `schema_group_settings`, `created_at`, `updated_at`) VALUES
(1, 'hero-section', 'custom', NULL, NULL, NULL, 0, NULL, 1, '{\"1\": {\"name\": \"Group 1\", \"is_multiple\": false}}', '2026-03-09 10:04:31', '2026-03-09 10:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `component_static_options`
--

CREATE TABLE `component_static_options` (
  `id` bigint UNSIGNED NOT NULL,
  `option_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribe` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ans` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` bigint UNSIGNED NOT NULL,
  `font_family` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `font_links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_frontend` tinyint(1) NOT NULL DEFAULT '0',
  `is_backend` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_groups`
--

CREATE TABLE `footer_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_group_details`
--

CREATE TABLE `footer_group_details` (
  `id` bigint UNSIGNED NOT NULL,
  `footer_group_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int NOT NULL,
  `caption_title` text COLLATE utf8mb4_unicode_ci,
  `caption_sub_title` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generals`
--

CREATE TABLE `generals` (
  `id` bigint UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` longtext COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social` text COLLATE utf8mb4_unicode_ci,
  `fav_icon` longtext COLLATE utf8mb4_unicode_ci,
  `header` longtext COLLATE utf8mb4_unicode_ci,
  `footer` longtext COLLATE utf8mb4_unicode_ci,
  `header_component` longtext COLLATE utf8mb4_unicode_ci,
  `header_component_position` longtext COLLATE utf8mb4_unicode_ci,
  `footer_component` longtext COLLATE utf8mb4_unicode_ci,
  `google_analytics` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generals`
--

INSERT INTO `generals` (`id`, `website_name`, `contact`, `email`, `location`, `description`, `social`, `fav_icon`, `header`, `footer`, `header_component`, `header_component_position`, `footer_component`, `google_analytics`, `cookie_title`, `cookie_description`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'header', 'fix', 'footer', NULL, NULL, NULL, '2026-03-09 09:40:14', '2026-03-09 09:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_rtl` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_06_054933_create_sliders_table', 1),
(6, '2024_02_07_054821_create_services_table', 1),
(7, '2024_02_07_072927_create_faqs_table', 1),
(8, '2024_02_11_184445_create_component_masters_table', 1),
(9, '2024_02_11_184506_create_component_fields_table', 1),
(10, '2024_02_17_085056_create_pages_table', 1),
(11, '2024_02_17_085201_create_page_components_table', 1),
(12, '2024_02_20_070455_create_companies_table', 1),
(13, '2024_02_20_145657_create_widgets_table', 1),
(14, '2024_02_22_055215_create_generals_table', 1),
(15, '2024_09_30_052527_create_gallery_categories_table', 1),
(16, '2024_09_30_104246_create_gallery_images_table', 1),
(17, '2024_10_01_182005_create_blog_categories_table', 1),
(18, '2024_10_01_182005_create_work_categories_table', 1),
(19, '2024_10_01_190122_create_blog_posts_table', 1),
(20, '2024_10_01_190122_create_work_posts_table', 1),
(21, '2024_10_03_070351_create_contacts_table', 1),
(22, '2024_10_05_024202_create_languages_table', 1),
(23, '2024_10_05_025527_create_translations_table', 1),
(24, '2024_10_11_065653_create_career_categories_table', 1),
(25, '2024_10_12_104035_create_careers_table', 1),
(26, '2024_10_22_034237_create_widget_children_table', 1),
(27, '2024_10_22_133341_create_visitor_logs_table', 1),
(28, '2024_11_21_110149_create_footer_groups_table', 1),
(29, '2024_11_21_112319_create_footer_group_details_table', 1),
(30, '2024_12_09_054222_create_page_component_statuses_table', 1),
(31, '2024_12_15_095120_create_notifications_table', 1),
(32, '2024_12_18_063135_create_subscribers_table', 1),
(33, '2025_01_08_074901_create_fonts_table', 1),
(34, '2025_01_31_000000_add_show_in_table_to_component_fields_table', 1),
(35, '2025_01_31_000001_add_colspan_to_component_fields_table', 1),
(36, '2025_01_31_000002_add_schema_group_to_component_fields_table', 1),
(37, '2025_01_31_120000_add_is_required_to_component_fields_table', 1),
(38, '2025_01_31_130000_add_position_to_component_masters_table', 1),
(39, '2025_01_31_150000_add_schema_group_names_and_is_multiple_to_component_masters', 1),
(40, '2025_01_31_160000_add_schema_group_settings_and_schema_instance', 1),
(41, '2025_01_31_170000_add_relationship_columns_to_component_fields_table', 1),
(42, '2025_06_15_081928_create_activity_log_table', 1),
(43, '2025_06_15_081929_add_event_column_to_activity_log_table', 1),
(44, '2025_06_15_081930_add_batch_uuid_column_to_activity_log_table', 1),
(45, '2026_01_31_120000_add_help_text_to_component_fields_table', 1),
(46, '2026_02_01_140322_create_component_static_options_table', 1),
(47, '2026_02_01_140922_add_static_options_to_component_fields_table', 1),
(48, '2026_02_09_000000_add_related_data_to_component_masters_table', 1),
(49, '2026_02_10_000100_add_is_single_to_component_masters_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `type_id` bigint UNSIGNED DEFAULT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permalink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `page_text_content` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_breadcrumb` tinyint(1) NOT NULL DEFAULT '0',
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` text COLLATE utf8mb4_unicode_ci,
  `seo_description` text COLLATE utf8mb4_unicode_ci,
  `seo_image` longtext COLLATE utf8mb4_unicode_ci,
  `seo_index` text COLLATE utf8mb4_unicode_ci,
  `header_component` longtext COLLATE utf8mb4_unicode_ci,
  `header_component_position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_component` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `permalink`, `description`, `page_text_content`, `status`, `is_breadcrumb`, `image`, `seo_title`, `seo_description`, `seo_image`, `seo_index`, `header_component`, `header_component_position`, `footer_component`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', '<p><br></p>', '<p><br></p>', '1', 0, NULL, NULL, NULL, NULL, 'noindex', 'header', NULL, 'footer', '2026-03-09 09:39:52', '2026-03-09 09:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `page_components`
--

CREATE TABLE `page_components` (
  `id` bigint UNSIGNED NOT NULL,
  `page_id` bigint UNSIGNED NOT NULL,
  `component_master_id` bigint UNSIGNED NOT NULL,
  `limit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_components`
--

INSERT INTO `page_components` (`id`, `page_id`, `component_master_id`, `limit`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '100', '2026-03-09 10:06:46', '2026-03-09 10:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `page_component_statuses`
--

CREATE TABLE `page_component_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `page_id` bigint UNSIGNED NOT NULL,
  `component_id` bigint UNSIGNED NOT NULL,
  `data_view_no` int DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_component_statuses`
--

INSERT INTO `page_component_statuses` (`id`, `page_id`, `component_id`, `data_view_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 0, '2026-03-09 10:04:42', '2026-03-09 10:06:45');

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_des` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation_value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Austen Senger', 'admin@gmail.com', '2026-03-09 08:19:56', '$2y$12$BTQllnkHndkFvkvEVd3hoek71PGsidJ6JHslOBQQXB.NQu4w/DUJq', NULL, 'qdGN1K60JS', '2026-03-09 08:19:56', '2026-03-09 08:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `url`, `browser`, `ip_address`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:20:20', NULL),
(2, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:21:09', NULL),
(3, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:21:16', NULL),
(4, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:21:16', NULL),
(5, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:21:17', NULL),
(6, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:23:10', NULL),
(7, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:24:28', NULL),
(8, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:26:23', NULL),
(9, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:26:44', NULL),
(10, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:26:48', NULL),
(11, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:27:47', NULL),
(12, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:27:50', NULL),
(13, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:27:54', NULL),
(14, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:27:57', NULL),
(15, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:28:02', NULL),
(16, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:28:39', NULL),
(17, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 08:28:41', NULL),
(18, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:16:55', NULL),
(19, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:17:29', NULL),
(20, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:17:39', NULL),
(21, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:29:17', NULL),
(22, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:29:19', NULL),
(23, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:29:36', NULL),
(24, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:29:38', NULL),
(25, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:31:05', NULL),
(26, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:31:07', NULL),
(27, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:08', NULL),
(28, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:09', NULL),
(29, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:14', NULL),
(30, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:16', NULL),
(31, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:19', NULL),
(32, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:32:20', NULL),
(33, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:35:20', NULL),
(34, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:39:17', NULL),
(35, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:39:57', NULL),
(36, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:40:20', NULL),
(37, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:41:07', NULL),
(38, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:43:07', NULL),
(39, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:43:20', NULL),
(40, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:43:24', NULL),
(41, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:43:24', NULL),
(42, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:43:25', NULL),
(43, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:44:27', NULL),
(44, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:46:44', NULL),
(45, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:47:03', NULL),
(46, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:49:37', NULL),
(47, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:49:39', NULL),
(48, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:49:40', NULL),
(49, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:49:50', NULL),
(50, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:50:10', NULL),
(51, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:50:17', NULL),
(52, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:50:19', NULL),
(53, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:50:19', NULL),
(54, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:50:44', NULL),
(55, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:52:09', NULL),
(56, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:57:10', NULL),
(57, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:57:23', NULL),
(58, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:59:44', NULL),
(59, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:59:52', NULL),
(60, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:59:53', NULL),
(61, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 09:59:53', NULL),
(62, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:11', NULL),
(63, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:11', NULL),
(64, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:33', NULL),
(65, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:35', NULL),
(66, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:35', NULL),
(67, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:40', NULL),
(68, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:40', NULL),
(69, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:48', NULL),
(70, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:00:48', NULL),
(71, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:02', NULL),
(72, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:03', NULL),
(73, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:06', NULL),
(74, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:07', NULL),
(75, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:11', NULL),
(76, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:23', NULL),
(77, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:27', NULL),
(78, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:27', NULL),
(79, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:28', NULL),
(80, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:01:30', NULL),
(81, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:03:44', NULL),
(82, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:04:17', NULL),
(83, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:04:23', NULL),
(84, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:04:32', NULL),
(85, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:04:34', NULL),
(86, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:04:46', NULL),
(87, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:05:00', NULL),
(88, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:05:09', NULL),
(89, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:06:05', NULL),
(90, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:06:34', NULL),
(91, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:06:48', NULL),
(92, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:07:13', NULL),
(93, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:07:14', NULL),
(94, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:07:17', NULL),
(95, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:08:03', NULL),
(96, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:08:55', NULL),
(97, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:09:13', NULL),
(98, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:09:13', NULL),
(99, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:09:19', NULL),
(100, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:09:23', NULL),
(101, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:09:53', NULL),
(102, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:10:36', NULL),
(103, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:10:36', NULL),
(104, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:00', NULL),
(105, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:01', NULL),
(106, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:01', NULL),
(107, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:01', NULL),
(108, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:02', NULL),
(109, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:28', NULL),
(110, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:42', NULL),
(111, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:11:57', NULL),
(112, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:05', NULL),
(113, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:14', NULL),
(114, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:19', NULL),
(115, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:46', NULL),
(116, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:47', NULL),
(117, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:48', NULL),
(118, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:48', NULL),
(119, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:48', NULL),
(120, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:48', NULL),
(121, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:49', NULL),
(122, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:49', NULL),
(123, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:12:49', NULL),
(124, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:13:05', NULL),
(125, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:13:11', NULL),
(126, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:18:19', NULL),
(127, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:18:22', NULL),
(128, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:18:45', NULL),
(129, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:19:16', NULL),
(130, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:19:17', NULL),
(131, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:19:36', NULL),
(132, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:20:00', NULL),
(133, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:20:01', NULL),
(134, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:20:24', NULL),
(135, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:20:24', NULL),
(136, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:21:50', NULL),
(137, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:21:53', NULL),
(138, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:21:57', NULL),
(139, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:01', NULL),
(140, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:18', NULL),
(141, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:19', NULL),
(142, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:25', NULL),
(143, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:27', NULL),
(144, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:29', NULL),
(145, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:38', NULL),
(146, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:47', NULL),
(147, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:49', NULL),
(148, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:22:54', NULL),
(149, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:24:32', NULL),
(150, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:07', NULL),
(151, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:07', NULL),
(152, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:12', NULL),
(153, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:20', NULL),
(154, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:22', NULL),
(155, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:33', NULL),
(156, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:36', NULL),
(157, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:25:38', NULL),
(158, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:26:21', NULL),
(159, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:28:04', NULL),
(160, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:28:10', NULL),
(161, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:28:25', NULL),
(162, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:28:26', NULL),
(163, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:31:06', NULL),
(164, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:31:08', NULL),
(165, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:31:22', NULL),
(166, 'http://127.0.0.1:8000', 'Chrome', '127.0.0.1', 'Linux', 'PC', '2026-03-09 10:33:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint UNSIGNED NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `position` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `link`, `name`, `type`, `ref_id`, `parent_id`, `position`, `created_at`, `updated_at`) VALUES
(1, '/', 'Home', 'page', 1, NULL, 0, '2026-03-09 10:25:36', '2026-03-09 10:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `widget_children`
--

CREATE TABLE `widget_children` (
  `id` bigint UNSIGNED NOT NULL,
  `page_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_categories`
--

CREATE TABLE `work_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_posts`
--

CREATE TABLE `work_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_categories`
--
ALTER TABLE `career_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component_fields`
--
ALTER TABLE `component_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_fields_component_id_foreign` (`component_id`);

--
-- Indexes for table `component_masters`
--
ALTER TABLE `component_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component_static_options`
--
ALTER TABLE `component_static_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `component_static_options_option_key_unique` (`option_key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_groups`
--
ALTER TABLE `footer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_group_details`
--
ALTER TABLE `footer_group_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generals`
--
ALTER TABLE `generals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_components`
--
ALTER TABLE `page_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_components_page_id_foreign` (`page_id`);

--
-- Indexes for table `page_component_statuses`
--
ALTER TABLE `page_component_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_component_statuses_page_id_foreign` (`page_id`);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget_children`
--
ALTER TABLE `widget_children`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_categories`
--
ALTER TABLE `work_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_posts`
--
ALTER TABLE `work_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `career_categories`
--
ALTER TABLE `career_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `component_fields`
--
ALTER TABLE `component_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `component_masters`
--
ALTER TABLE `component_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `component_static_options`
--
ALTER TABLE `component_static_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_groups`
--
ALTER TABLE `footer_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_group_details`
--
ALTER TABLE `footer_group_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generals`
--
ALTER TABLE `generals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_components`
--
ALTER TABLE `page_components`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `page_component_statuses`
--
ALTER TABLE `page_component_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `widget_children`
--
ALTER TABLE `widget_children`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_categories`
--
ALTER TABLE `work_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_posts`
--
ALTER TABLE `work_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `component_fields`
--
ALTER TABLE `component_fields`
  ADD CONSTRAINT `component_fields_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `component_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_components`
--
ALTER TABLE `page_components`
  ADD CONSTRAINT `page_components_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_component_statuses`
--
ALTER TABLE `page_component_statuses`
  ADD CONSTRAINT `page_component_statuses_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
