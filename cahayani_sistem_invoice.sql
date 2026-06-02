/*
 Navicat Premium Data Transfer

 Source Server         : Grafis Media Website
 Source Server Type    : MySQL
 Source Server Version : 80045 (8.0.45-cll-lve)
 Source Host           : localhost:3306
 Source Schema         : cahayani_sistem_invoice

 Target Server Type    : MySQL
 Target Server Version : 80045 (8.0.45-cll-lve)
 File Encoding         : 65001

 Date: 02/06/2026 19:02:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com||2404:c0:31ac:2614:18b1:ddf4:f261:abb8', 'i:1;', 1779532694);
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com||2404:c0:31ac:2614:18b1:ddf4:f261:abb8:timer', 'i:1779532694;', 1779532694);
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com|1|114.10.30.223', 'i:2;', 1779515414);
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com|1|114.10.30.223:timer', 'i:1779515414;', 1779515414);
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com|2|114.10.30.223', 'i:1;', 1779515494);
INSERT INTO `cache` VALUES ('sipen-cache-admin@gmail.com|2|114.10.30.223:timer', 'i:1779515494;', 1779515494);
INSERT INTO `cache` VALUES ('sipen-cache-admin1@gmail.com|1|114.10.30.223', 'i:1;', 1779515463);
INSERT INTO `cache` VALUES ('sipen-cache-admin1@gmail.com|1|114.10.30.223:timer', 'i:1779515463;', 1779515463);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||103.111.83.70', 'i:1;', 1779277090);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||103.111.83.70:timer', 'i:1779277090;', 1779277090);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||103.144.169.222', 'i:1;', 1779969133);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||103.144.169.222:timer', 'i:1779969133;', 1779969133);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||2404:c0:31ac:2614:18b1:ddf4:f261:abb8', 'i:1;', 1779532466);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com||2404:c0:31ac:2614:18b1:ddf4:f261:abb8:timer', 'i:1779532466;', 1779532466);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com|1|103.144.169.222', 'i:1;', 1779969170);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com|1|103.144.169.222:timer', 'i:1779969170;', 1779969170);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com|2|114.10.30.223', 'i:2;', 1779515472);
INSERT INTO `cache` VALUES ('sipen-cache-admin2@gmail.com|2|114.10.30.223:timer', 'i:1779515472;', 1779515472);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `job` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `attn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customers_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `customers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 275 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (250, 1, 'PT Manna Berkat Solusindo', 'boby@mail.com', '519078165', 'Jakarta Barat', 'Owner', 'Boby', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (251, 1, 'PT Manna Berkat Solusindo', 'yuni@mail.com', '-369815835', 'Jakarta Barat', 'Sales Executive', 'Yuni', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (252, 1, 'PT Manna Berkat Solusindo', 'Iskandar@mail.com', '-369811235', 'Jakarta Timur', 'PIC Werehouse', 'Yuda', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (253, 1, 'PT Manna Berkat Solusindo', 'Iskandar@mail.com', '-369811235', 'Jakarta Barat', 'Finance', 'Nur Iskandar', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (254, 1, 'PT Swissindo Perkasa', 'swissindo@mail.com', '-478823481', 'Jakarta Selatan', 'Sales Executive', 'Nita Paradina', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (255, 1, 'PT Mizu Teknologi', 'mizu@mail.com', '-367712370', 'Depok', 'Owner', 'Harry Permadi', '2026-05-03 09:12:49', '2026-05-03 09:12:49');
INSERT INTO `customers` VALUES (273, 2, 'PT Manna Berkat Solusindo', 'boby@mail.com', '519078165', 'Jakarta Barat', 'Staff', 'Boby', '2026-05-20 15:06:57', '2026-05-20 15:06:57');
INSERT INTO `customers` VALUES (274, 1, 'PT. Manna Berkat Solusindo', 'finance@mannasolutions.co.id', '08174854807', 'Graha Kencana 8c, 8th Floor, Jl. Raya Perjuangan No. 88 Kebon Jeruk, Jakarta Barat, DKI Jakarta, 11530', 'Finance', 'Nur Iskandar', '2026-05-26 06:26:13', '2026-05-26 06:26:13');

-- ----------------------------
-- Table structure for delivery_order_items
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_items`;
CREATE TABLE `delivery_order_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `delivery_order_id` bigint UNSIGNED NOT NULL,
  `part_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `delivery_order_items_delivery_order_id_foreign`(`delivery_order_id` ASC) USING BTREE,
  CONSTRAINT `delivery_order_items_delivery_order_id_foreign` FOREIGN KEY (`delivery_order_id`) REFERENCES `delivery_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 103 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of delivery_order_items
-- ----------------------------
INSERT INTO `delivery_order_items` VALUES (101, 18, 'SW-003', 'VMware vSphere Standard', 1, NULL, '2026-05-26 06:32:38', '2026-05-26 06:32:38');
INSERT INTO `delivery_order_items` VALUES (102, 19, 'SV-001', 'Server Installation Service', 1, NULL, '2026-05-26 06:39:02', '2026-05-26 06:39:02');

-- ----------------------------
-- Table structure for delivery_orders
-- ----------------------------
DROP TABLE IF EXISTS `delivery_orders`;
CREATE TABLE `delivery_orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `do_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NULL DEFAULT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `invoice_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `delivery_date` date NULL DEFAULT NULL,
  `po_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `attn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shipper_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `recipient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `print_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `delivery_orders_do_number_tenant_unique`(`do_number` ASC, `tenant_id` ASC) USING BTREE,
  INDEX `delivery_orders_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `delivery_orders_invoice_id_foreign`(`invoice_id` ASC) USING BTREE,
  INDEX `delivery_orders_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `delivery_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `delivery_orders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `delivery_orders_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of delivery_orders
-- ----------------------------
INSERT INTO `delivery_orders` VALUES (18, 1, 'DO-20260526-0001', 253, 24, NULL, NULL, '2026-05-26', NULL, 'Website Company Profile', 'Nur Iskandar', NULL, NULL, '2026-05-26 06:31:37', '2026-05-26 06:31:37', '2026-05-26');
INSERT INTO `delivery_orders` VALUES (19, 2, 'DO-20260526-0001', 273, 25, NULL, NULL, '2026-05-26', NULL, 'Sistem ERP UMKM', 'Boby', NULL, NULL, '2026-05-26 06:39:02', '2026-05-26 06:39:02', '2026-05-26');

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for invoice_items
-- ----------------------------
DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE `invoice_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `item_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15, 2) NOT NULL,
  `qty` int NOT NULL,
  `amount` decimal(15, 2) NOT NULL,
  `uom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoice_items_invoice_id_foreign`(`invoice_id` ASC) USING BTREE,
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 185 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoice_items
-- ----------------------------
INSERT INTO `invoice_items` VALUES (180, 22, 'SW-003', 'VMware vSphere Standard', 30000000.00, 1, 30000000.00, 'License', '2026-05-25 04:16:18', '2026-05-25 04:16:18');
INSERT INTO `invoice_items` VALUES (181, 22, 'SW-004', 'Antivirus ESET Endpoint', 4200000.00, 1, 4200000.00, 'Device', '2026-05-25 04:16:18', '2026-05-25 04:16:18');
INSERT INTO `invoice_items` VALUES (183, 24, 'SW-003', 'VMware vSphere Standard', 30000000.00, 1, 30000000.00, 'License', '2026-05-26 06:29:22', '2026-05-26 06:29:22');
INSERT INTO `invoice_items` VALUES (184, 25, 'SV-001', 'Server Installation Service', 30000000.00, 1, 30000000.00, 'Job', '2026-05-26 06:37:24', '2026-05-26 06:37:24');

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `quotation_id` bigint UNSIGNED NULL DEFAULT NULL,
  `po_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `so_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `due_date` date NULL DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `subtotal` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `vat_amount` decimal(10, 2) NULL DEFAULT NULL,
  `total_amount` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `amount_in_words` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank_account_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank_account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `print_date` date NULL DEFAULT NULL,
  `customer_invoice_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `invoices_invoice_number_tenant_unique`(`invoice_number` ASC, `tenant_id` ASC) USING BTREE,
  INDEX `invoices_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `invoices_quotation_id_foreign`(`quotation_id` ASC) USING BTREE,
  INDEX `invoices_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `invoices_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `invoices_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoices
-- ----------------------------
INSERT INTO `invoices` VALUES (22, 1, 'INV-20260525-0001', 250, NULL, NULL, 'SO/2026/0001', '<p>PO NOMOR 3254100</p>', '2026-06-25', 'IDR', 34200000.00, 11.00, 3762000.00, 37962000.00, 'TIGA PULUH TUJUH JUTA SEMBILAN RATUS ENAM PULUH DUA RIBU RUPIAH', NULL, NULL, NULL, '2026-05-25 04:15:36', '2026-05-25 04:16:18', '2026-05-25', 250);
INSERT INTO `invoices` VALUES (24, 1, 'INV-20260526-0002', 253, NULL, NULL, 'SO/2026/0002', '<p><br></p>', '2026-06-26', 'IDR', 30000000.00, 11.00, 3300000.00, 33300000.00, 'TIGA PULUH TIGA JUTA TIGA RATUS RIBU RUPIAH', NULL, NULL, NULL, '2026-05-26 06:29:22', '2026-05-26 06:29:22', '2026-05-26', 253);
INSERT INTO `invoices` VALUES (25, 2, 'INV-20260526-0001', 273, NULL, NULL, 'SO/2026/0001', '<p><br></p>', '2026-06-26', 'IDR', 30000000.00, 11.00, 3300000.00, 33300000.00, 'TIGA PULUH TIGA JUTA TIGA RATUS RIBU RUPIAH', NULL, NULL, NULL, '2026-05-26 06:37:24', '2026-05-26 06:37:24', '2026-05-26', 273);

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `type` enum('Hardware','Service','Software','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `items_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `items_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (49, 1, 'SW-003', 'VMware vSphere Standard', 'License', 0.00, 'Software', '2026-05-03 08:25:58', '2026-05-03 08:25:58');
INSERT INTO `items` VALUES (50, 1, 'SW-004', 'Antivirus ESET Endpoint', 'Device', 0.00, 'Software', '2026-05-03 08:25:58', '2026-05-03 08:25:58');
INSERT INTO `items` VALUES (52, 1, 'SV-001', 'Server Installation Service', 'Job', 0.00, 'Service', '2026-05-03 08:25:58', '2026-05-03 08:25:58');
INSERT INTO `items` VALUES (53, 1, 'SV-002', 'Network Setup Service', 'Job', 0.00, 'Service', '2026-05-03 08:25:58', '2026-05-03 08:25:58');
INSERT INTO `items` VALUES (54, 1, 'SV-003', 'IT Maintenance Monthly', 'Month', 0.00, 'Service', '2026-05-03 08:25:58', '2026-05-03 08:25:58');
INSERT INTO `items` VALUES (63, 2, 'SV-001', 'Server Installation Service', 'Job', 0.00, 'Service', '2026-05-20 15:40:38', '2026-05-20 15:40:38');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
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
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (14, '2026_05_19_000001_create_tenants_table', 99);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for positions
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` int NULL DEFAULT NULL,
  `position_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES (35, 1, 'Staff', '2026-05-03 08:16:15', '2026-05-03 08:16:15');
INSERT INTO `positions` VALUES (36, 1, 'Admin', '2026-05-03 08:16:15', '2026-05-03 08:16:15');
INSERT INTO `positions` VALUES (37, 1, 'Finance', '2026-05-03 08:16:15', '2026-05-03 08:16:15');
INSERT INTO `positions` VALUES (38, 1, 'HRD', '2026-05-03 08:16:15', '2026-05-03 08:16:15');
INSERT INTO `positions` VALUES (39, 1, 'Sales Executive', '2026-05-03 08:16:15', '2026-05-03 08:16:15');
INSERT INTO `positions` VALUES (41, 1, 'Owner', '2026-05-03 08:16:26', '2026-05-03 08:16:36');
INSERT INTO `positions` VALUES (43, 1, 'PIC Werehouse', '2026-05-03 08:35:04', '2026-05-03 08:35:04');
INSERT INTO `positions` VALUES (44, 2, 'Staff', '2026-05-20 11:50:34', '2026-05-20 11:50:34');

-- ----------------------------
-- Table structure for projects
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `projects_code_tenant_unique`(`code` ASC, `tenant_id` ASC) USING BTREE,
  INDEX `projects_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `projects_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES (2, 1, 'PRJ001', 'Sistem ERP Perusahaan', '2026-05-03 08:19:29', '2026-05-03 08:19:29');
INSERT INTO `projects` VALUES (3, 1, 'PRJ002', 'Website Company Profile', '2026-05-03 08:19:29', '2026-05-03 08:19:29');
INSERT INTO `projects` VALUES (4, 1, 'PRJ003', 'Aplikasi Inventory Gudang', '2026-05-03 08:19:29', '2026-05-03 08:19:29');
INSERT INTO `projects` VALUES (18, 2, 'PRJ001', 'Sistem ERP UMKM', '2026-05-20 15:36:46', '2026-05-20 15:37:54');

-- ----------------------------
-- Table structure for quotation_items
-- ----------------------------
DROP TABLE IF EXISTS `quotation_items`;
CREATE TABLE `quotation_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint UNSIGNED NOT NULL,
  `type` enum('Hardware','Software','Service','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `uom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price` decimal(15, 2) NOT NULL,
  `total_price` decimal(10, 2) NULL DEFAULT NULL,
  `discount_percent` int NOT NULL DEFAULT 0,
  `amount` decimal(15, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `quotation_items_quotation_id_foreign`(`quotation_id` ASC) USING BTREE,
  CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 174 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotation_items
-- ----------------------------
INSERT INTO `quotation_items` VALUES (159, 24, 'Hardware', 'HW-001', 'HPE ProLiant DL380 Gen12 Server', 1, 'Unit', 3000000.00, 3000000.00, 0, 3000000.00, '2026-05-03 13:33:58', '2026-05-03 13:33:58');
INSERT INTO `quotation_items` VALUES (160, 24, 'Hardware', 'HW-004', 'Mikrotik CCR1009 Router', 1, 'Unit', 3000000.00, 3000000.00, 0, 3000000.00, '2026-05-03 13:33:58', '2026-05-03 13:33:58');
INSERT INTO `quotation_items` VALUES (171, 27, 'Service', 'SV-001', 'Server Installation Service', 20, 'Job', 100000.00, 2000000.00, 0, 2000000.00, '2026-05-20 15:55:01', '2026-05-20 15:55:01');
INSERT INTO `quotation_items` VALUES (173, 28, 'Service', 'SV-001', 'Server Installation Service', 20, 'Job', 100000.00, 2000000.00, 0, 2000000.00, '2026-05-20 15:55:16', '2026-05-20 15:55:16');

-- ----------------------------
-- Table structure for quotations
-- ----------------------------
DROP TABLE IF EXISTS `quotations`;
CREATE TABLE `quotations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `quotation_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `valid_until` date NULL DEFAULT NULL,
  `project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `attn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `subtotal` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `vat_amount` decimal(10, 2) NULL DEFAULT NULL,
  `grand_total` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `remark` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `print_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `quotations_quotation_number_tenant_unique`(`quotation_number` ASC, `tenant_id` ASC) USING BTREE,
  INDEX `quotations_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `quotations_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotations
-- ----------------------------
INSERT INTO `quotations` VALUES (24, 1, 'QT-20260520-0001', 250, '2026-05-31', 'Aplikasi Inventory Gudang', NULL, 6000000.00, 10.00, 600000.00, 6600000.00, '<p><strong>Terms &amp; Conditions</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Validitas:</strong> Penawaran berlaku selama 14 hari.</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pembayaran:</strong> DP 50% di awal, pelunasan 50% setelah pekerjaan selesai.</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pengerjaan:</strong> Dimulai segera setelah konfirmasi/DP diterima.</li></ol><p><br></p><p><strong>Remark</strong></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Harga sudah termasuk biaya kirim.</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Garansi pengerjaan/barang selama 30 hari.</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Terima kasih atas kepercayaan Anda.</li></ol>', '2026-05-03 09:45:27', '2026-05-03 13:33:58', '2026-05-20');
INSERT INTO `quotations` VALUES (27, 2, 'QT-20260520-0001', 273, '2026-05-31', 'Sistem ERP UMKM', NULL, 2000000.00, 11.00, 220000.00, 2220000.00, '<p><br></p>', '2026-05-20 15:42:55', '2026-05-20 15:55:01', '2026-05-20');
INSERT INTO `quotations` VALUES (28, 2, 'QT-20260520-0002', 273, '2026-05-31', 'Sistem ERP UMKM', NULL, 2000000.00, 11.00, 220000.00, 2220000.00, '<p><br></p>', '2026-05-20 15:55:13', '2026-05-20 15:55:16', '2026-05-20');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('1COoRrmfBcwPJLC6cmJ4AgUn4nzHee6UNrDbpg0d', 5, '103.144.169.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmZJM0oxWmJTQnA4dzJDWnhIWVRFa1hFR3M4d1lHd3lqTHlWWlNHMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vaW52b2ljZS5ncmFmaXNtZWRpYXdlYnNpdGUuY29tIjtzOjU6InJvdXRlIjtOO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1780389501);

-- ----------------------------
-- Table structure for template_pdfs
-- ----------------------------
DROP TABLE IF EXISTS `template_pdfs`;
CREATE TABLE `template_pdfs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','non-active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'non-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blade_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `template_pdfs_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `template_pdfs_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of template_pdfs
-- ----------------------------
INSERT INTO `template_pdfs` VALUES (1, 1, 'MTI', 'PT. Mizu Teknologi Indonesia', 'active', '2026-05-07 15:55:40', '2026-05-19 12:50:12', 'mti_pdf');
INSERT INTO `template_pdfs` VALUES (2, 2, 'DWI', 'PT Dwipantara Selaras Nusantara', 'active', '2026-05-07 15:56:51', '2026-05-19 08:35:25', 'dwi_pdf');

-- ----------------------------
-- Table structure for tenants
-- ----------------------------
DROP TABLE IF EXISTS `tenants`;
CREATE TABLE `tenants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama perusahaan tenant',
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifier unik, contoh: grafis-media',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `subscription_start` date NULL DEFAULT NULL,
  `subscription_end` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tenants_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tenants
-- ----------------------------
INSERT INTO `tenants` VALUES (1, 'PT. Mizu Teknologi Indonesia', 'pt-mizu-teknologi-indonesia', 'doni@mizutech.co.id', '(021) 39710244', 'Gd. Graha Surveyor Indonesia 15th Floor Suite 1503, Jl. Gatot Subroto No.Kav. 56, RT.1/RW.4, Kuningan Tim., Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950', NULL, 'active', '2026-05-19', '2100-05-19', '2026-05-19 16:59:41', '2026-05-19 12:37:38');
INSERT INTO `tenants` VALUES (2, 'PT Dwipantara Selaras Nusantara', 'pt-dwipantara-selaras-nusantara', 'dwi@dwipantara.com', '6221 3971 0244', 'South Quarter Tower A 18th Floor Jl. R.A. Kartini Kav 8 Cilandak Jakarta Selatan', NULL, 'active', '2026-05-19', '2100-05-19', '2026-05-19 12:42:48', '2026-05-19 12:42:48');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_tenant_unique`(`email` ASC, `tenant_id` ASC) USING BTREE,
  INDEX `users_tenant_id_index`(`tenant_id` ASC) USING BTREE,
  CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (3, 2, 'Dwipantara', 'admin2@gmail.com', NULL, '$2y$12$0RX9oUMjShlTp6BsbYv1O.bUvNu3UOw0Efoiq2SgWkiiXpPybqSpi', 'admin', NULL, '2026-05-03 08:13:01', '2026-05-23 10:36:51', 'PT Dwipantara Selaras Nusantara');
INSERT INTO `users` VALUES (5, 1, 'Mizutech', 'admin@gmail.com', NULL, '$2y$12$887UzIYyaYJ3yPbIdL36tec8QfY8nGs4aWSMzUNw5QERpXnXT1iYe', 'admin', NULL, '2026-05-03 14:10:21', '2026-05-23 10:38:37', 'PT. Mizu Teknologi Indonesia');
INSERT INTO `users` VALUES (6, NULL, 'Super Admin', 'superadmin@system.com', NULL, '$2y$12$EjsOFLof1p6EwvWC1qURKuPV.mzkqqUVp/YlkxT3jW/dUvup/F3JO', 'superadmin', NULL, '2026-05-19 18:08:47', '2026-05-19 18:08:47', NULL);

SET FOREIGN_KEY_CHECKS = 1;
