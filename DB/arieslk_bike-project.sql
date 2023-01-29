/*
 Navicat Premium Data Transfer

 Source Server         : WOW Hosting
 Source Server Type    : MySQL
 Source Server Version : 100517
 Source Host           : 109.70.148.33:3306
 Source Schema         : arieslk_bike-project

 Target Server Type    : MySQL
 Target Server Version : 100517
 File Encoding         : 65001

 Date: 29/01/2023 12:36:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bikes
-- ----------------------------
DROP TABLE IF EXISTS `bikes`;
CREATE TABLE `bikes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` bigint UNSIGNED NOT NULL,
  `mac_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1-Active / 2-Inactive',
  `available` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1-Not available / 0-Available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bikes
-- ----------------------------
INSERT INTO `bikes` VALUES (1, 2, '1232SDDK2K3M3M', '#ref0001', '1', '0', '2023-01-21 14:57:05', '2023-01-21 14:57:05');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for histories
-- ----------------------------
DROP TABLE IF EXISTS `histories`;
CREATE TABLE `histories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bike` bigint UNSIGNED NOT NULL,
  `reservation` bigint UNSIGNED NOT NULL,
  `lng` double(8, 2) NOT NULL,
  `ltd` double(8, 2) NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1-Active / 2-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of histories
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2021_12_21_044250_create_routes_table', 1);
INSERT INTO `migrations` VALUES (6, '2021_12_21_045534_create_user_types_table', 1);
INSERT INTO `migrations` VALUES (7, '2021_12_21_060615_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (8, '2023_01_19_152831_create_stores_table', 1);
INSERT INTO `migrations` VALUES (9, '2023_01_19_152901_create_bikes_table', 1);
INSERT INTO `migrations` VALUES (10, '2023_01_19_152926_create_histories_table', 1);
INSERT INTO `migrations` VALUES (11, '2023_01_29_044831_create_reservations_table', 2);
INSERT INTO `migrations` VALUES (12, '2023_01_29_045132_change_histories_store_column_to_reservation', 2);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `route` int NOT NULL,
  `usertype` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `permissions` VALUES (2, 2, 1, NULL, NULL);
INSERT INTO `permissions` VALUES (3, 3, 1, NULL, NULL);
INSERT INTO `permissions` VALUES (4, 4, 1, NULL, NULL);
INSERT INTO `permissions` VALUES (5, 5, 1, NULL, NULL);
INSERT INTO `permissions` VALUES (6, 1, 2, '2023-01-21 14:55:30', '2023-01-21 14:55:30');
INSERT INTO `permissions` VALUES (7, 4, 2, '2023-01-21 14:55:33', '2023-01-21 14:55:33');
INSERT INTO `permissions` VALUES (8, 5, 2, '2023-01-21 14:55:34', '2023-01-21 14:55:34');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for reservations
-- ----------------------------
DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bike` bigint UNSIGNED NOT NULL,
  `user` bigint UNSIGNED NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1-Active / 2-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reservations
-- ----------------------------
INSERT INTO `reservations` VALUES (2, 1, 4, '1', '2023-01-29 06:09:28', '2023-01-29 06:09:28');

-- ----------------------------
-- Table structure for routes
-- ----------------------------
DROP TABLE IF EXISTS `routes`;
CREATE TABLE `routes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of routes
-- ----------------------------
INSERT INTO `routes` VALUES (1, 'Dashboard', '/home', 1, NULL, NULL);
INSERT INTO `routes` VALUES (2, 'User Management', '/users', 1, NULL, NULL);
INSERT INTO `routes` VALUES (3, 'Usertype Management', '/usertypes', 1, NULL, NULL);
INSERT INTO `routes` VALUES (4, 'Stores Management', '/stores', 1, NULL, NULL);
INSERT INTO `routes` VALUES (5, 'Bikes Management', '/bikes', 1, NULL, NULL);

-- ----------------------------
-- Table structure for stores
-- ----------------------------
DROP TABLE IF EXISTS `stores`;
CREATE TABLE `stores`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` double(8, 2) NOT NULL,
  `ltd` double(8, 2) NOT NULL,
  `informations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1-Active / 2-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stores
-- ----------------------------
INSERT INTO `stores` VALUES (1, 2, 'Store Owner 1', '115/3 Dutugamunu Street, Colombo 06', 6.87, 79.87, 'Mobile : 0779778269', '1', '2023-01-21 14:50:30', '2023-01-21 14:50:30');

-- ----------------------------
-- Table structure for user_types
-- ----------------------------
DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `usertype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_types
-- ----------------------------
INSERT INTO `user_types` VALUES (1, 'Administrator', '1', NULL, NULL);
INSERT INTO `user_types` VALUES (2, 'Store Owner', '1', NULL, NULL);
INSERT INTO `user_types` VALUES (3, 'Users', '1', NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3',
  `status` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$u2ktH1eK/1ao8BB.uuqctuEIk7k5nMvVqq6ph.PDkDMmhMFFd5z1q', '1', '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'Store1', 'store1@gmail.com', NULL, '$2y$10$aG2f40f7CujOiqrFkUIjrOPHHyAaltlC6sFUJQDrl2xwYP7q889F.', '2', '1', NULL, '2023-01-21 14:47:17', '2023-01-21 14:47:17');
INSERT INTO `users` VALUES (3, 'Pasindu', 'pasindu@gmail.com', NULL, '$2y$10$kM4YnI1asDaw1BVcwXWoCuicJBPHvl/pMHFg/9xlfPKSfQqJB4ih.', '3', '1', NULL, '2023-01-27 18:03:40', '2023-01-27 18:03:40');
INSERT INTO `users` VALUES (4, 'User', 'user@gmail.com', NULL, '$2y$10$1NCJXC/RE.M0yHNOWtaobOOhy9BBV/RbryiFYRZ8Jz573w3eUDTH6', '3', '1', NULL, '2023-01-27 18:07:54', '2023-01-27 18:07:54');

SET FOREIGN_KEY_CHECKS = 1;
