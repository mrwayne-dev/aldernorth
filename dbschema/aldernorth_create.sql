-- ============================================================
-- Aldernorth Capital — Database Creation Script
-- File: dbschema/aldernorth_create.sql
--
-- Idempotent: drops & recreates all ANC tables and seeds the
-- plan catalog the platform needs to render its dashboards.
-- Safe to run on a fresh DB or to reset a stale one.
--
-- Usage:
--   mysql -u root -p aldernorth_db < dbschema/aldernorth_create.sql
--   (create the database first, or uncomment the block below)
-- ============================================================

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- ============================================================
-- DATABASE
-- ============================================================
-- CREATE DATABASE IF NOT EXISTS `aldernorth_db`
--   DEFAULT CHARACTER SET utf8mb4
--   COLLATE utf8mb4_unicode_ci;
-- USE `aldernorth_db`;

-- ============================================================
-- DROP RETIRED TABLES (HRC era + the TitanX X- product suite)
-- ============================================================
DROP TABLE IF EXISTS `charity_donations`;
DROP TABLE IF EXISTS `charities`;
DROP TABLE IF EXISTS `trustfund`;
DROP TABLE IF EXISTS `trustfund_plans`;
DROP TABLE IF EXISTS `maintenance`;
DROP TABLE IF EXISTS `maintenance_plans`;
DROP TABLE IF EXISTS `xrewards_orders`;
DROP TABLE IF EXISTS `xrewards_products`;
DROP TABLE IF EXISTS `xshares_holdings`;
DROP TABLE IF EXISTS `xshares_assets`;
DROP TABLE IF EXISTS `xweekly_programs`;
DROP TABLE IF EXISTS `xweekly_plans`;
DROP TABLE IF EXISTS `infrastructure_contributions`;
DROP TABLE IF EXISTS `infrastructure_plans`;
DROP TABLE IF EXISTS `infrastructure`;
DROP TABLE IF EXISTS `holdlock`;
DROP TABLE IF EXISTS `holdlock_plans`;
DROP TABLE IF EXISTS `investment_plans`;
DROP TABLE IF EXISTS `user_impacts`;

-- ============================================================
-- DROP ANC TABLES IN FK-SAFE ORDER (so re-runs are clean)
-- ============================================================
DROP TABLE IF EXISTS `investments`;
DROP TABLE IF EXISTS `plans`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `email_verifications`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `login_logs`;
DROP TABLE IF EXISTS `bank_details`;
DROP TABLE IF EXISTS `wallets`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `admins`;


-- ============================================================
-- CORE IDENTITY
-- ============================================================

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `full_name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `role` ENUM('user','admin') DEFAULT 'user',
  `status` ENUM('active','disabled') DEFAULT 'active',
  `profile_picture` VARCHAR(255) DEFAULT '/assets/images/avatar/default.png',
  `phone` VARCHAR(40) DEFAULT NULL,
  `country` VARCHAR(80) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `admins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `full_name` VARCHAR(150) DEFAULT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin','manager','support') DEFAULT 'manager',
  `status` ENUM('active','disabled') DEFAULT 'active',
  `profile_picture` VARCHAR(255) DEFAULT '/assets/images/avatar/admin_default.png',
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cash_mailing_address` TEXT,
  `wallet_deposit_address` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- WALLETS & PAYMENTS
-- ============================================================

CREATE TABLE `wallets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `balance` DECIMAL(12,2) DEFAULT 0.00,
  `total_deposited` DECIMAL(12,2) DEFAULT 0.00,
  `total_withdrawn` DECIMAL(12,2) DEFAULT 0.00,
  `total_investments` DECIMAL(12,2) DEFAULT 0.00,
  `total_earnings` DECIMAL(12,2) DEFAULT 0.00,
  `pending_withdrawals` DECIMAL(12,2) DEFAULT 0.00,
  `cash_mailing_address` TEXT,
  `wallet_deposit_address` TEXT,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_wallet` (`user_id`),
  CONSTRAINT `wallets_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `bank_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `method` ENUM('local_bank','wallet_address') NOT NULL,
  `details` JSON NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_bank_user` (`user_id`),
  CONSTRAINT `bank_details_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `method` ENUM('secure_exchange','cash_mailing','wire_transfer','local_bank','wallet_address','wallet','system') DEFAULT NULL,
  `details` JSON DEFAULT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `reference` VARCHAR(100) NOT NULL,
  `status` ENUM('pending','completed','failed') DEFAULT 'completed',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_txn_reference` (`reference`),
  KEY `idx_user_transaction` (`user_id`),
  KEY `idx_txn_method` (`method`),
  CONSTRAINT `transactions_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- AUTH / SESSION
-- ============================================================

CREATE TABLE `password_resets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `otp` VARCHAR(10) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_reset_user` (`user_id`),
  CONSTRAINT `resets_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `email_verifications` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `otp` VARCHAR(10) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_verify_user` (`user_id`),
  CONSTRAINT `verify_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `login_logs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_type` ENUM('user','admin') NOT NULL,
  `user_id` INT NOT NULL,
  `ip` VARCHAR(100) DEFAULT NULL,
  `browser` VARCHAR(255) DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_login_user` (`user_type`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- ANNOUNCEMENTS (admin-managed dashboard updates)
-- ============================================================

CREATE TABLE `announcements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `category` VARCHAR(50) DEFAULT 'general',
  `status` ENUM('published','draft') NOT NULL DEFAULT 'published',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- INVESTING — the platform's single product
--
-- Model: the member invests a lump sum into a plan. The plan
-- defines a payout cadence (weekly or monthly), an ROI percent
-- PER PAYOUT PERIOD, and a fixed term. Each period the cron
-- credits `amount * roi_percent / 100` to the wallet. At
-- maturity the principal is returned and the position closes.
-- ============================================================

CREATE TABLE `plans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `cadence` ENUM('weekly','monthly') NOT NULL,
  `roi_percent` DECIMAL(5,2) NOT NULL COMMENT 'ROI per payout period, not annualised',
  `duration_days` INT NOT NULL,
  `min_amount` DECIMAL(15,2) NOT NULL,
  `max_amount` DECIMAL(15,2) NOT NULL,
  `risk` VARCHAR(50) NOT NULL DEFAULT 'Low',
  `description` VARCHAR(255) NOT NULL,
  `summary` TEXT NOT NULL,
  `details` TEXT NOT NULL,
  `icon` VARCHAR(60) NOT NULL DEFAULT 'ph-chart-line-up' COMMENT 'Phosphor icon class',
  `accent` VARCHAR(20) NOT NULL DEFAULT 'orange',
  `status` ENUM('active','hidden') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_plans_cadence` (`cadence`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `investments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `plan_id` INT DEFAULT NULL,
  -- plan_name / cadence / roi_percent / duration_days are SNAPSHOTS taken at
  -- purchase time, so editing a plan in admin never retroactively rewrites
  -- the terms of a position a member already holds.
  `plan_name` VARCHAR(150) NOT NULL,
  `cadence` ENUM('weekly','monthly') NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `roi_percent` DECIMAL(5,2) NOT NULL,
  `duration_days` INT NOT NULL,
  `payouts_total` INT NOT NULL DEFAULT 0,
  `payouts_made` INT NOT NULL DEFAULT 0,
  `next_payout_date` DATE NOT NULL,
  `maturity_date` DATE NOT NULL,
  `roi_earned` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inv_user` (`user_id`),
  KEY `idx_inv_status` (`status`),
  KEY `idx_inv_next_payout` (`next_payout_date`),
  KEY `idx_inv_maturity` (`maturity_date`),
  CONSTRAINT `investments_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `investments_fk_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- SEED DATA — settings (single row, blank deposit/mailing)
-- ============================================================

INSERT INTO `settings` (`id`,`cash_mailing_address`,`wallet_deposit_address`) VALUES
  (1, NULL, NULL);


-- ============================================================
-- SEED DATA — plans
--
-- roi_percent is PER PERIOD. Every duration_days is an exact multiple of
-- its payout period (7 or 30), so no term ends with dead, unpaid days.
-- Sanity check on effective returns:
--   Alder Weekly     1.10% x 13 wk  = 14.3% over 91 days
--   Rowan Weekly     1.45% x 26 wk  = 37.7% over 182 days
--   Blackthorn Wkly  1.80% x 52 wk  = 93.6% over 364 days
--   Northwood Mthly  4.50% x 6 mo   = 27.0% over 180 days
--   Ironwood Mthly   5.75% x 12 mo  = 69.0% over 360 days
--   Aldercrest Mthly 7.20% x 24 mo  = 172.8% over 720 days
-- ============================================================

INSERT INTO `plans`
  (`title`,`cadence`,`roi_percent`,`duration_days`,`min_amount`,`max_amount`,`risk`,`description`,`summary`,`details`,`icon`,`accent`,`status`)
VALUES
  ('Alder Weekly','weekly',1.10,91,250.00,25000.00,'Low',
   'A 13-week entry position paying out every Friday.',
   'The lightest way in. Put capital to work for a quarter, take a payout every week, and get your principal back on day 90.',
   'Capital is deployed into short-duration fixed-income instruments. Payouts are credited to your Aldernorth wallet each week and are available to withdraw immediately. Principal returns in full at maturity.',
   'ph-plant','orange','active'),

  ('Rowan Weekly','weekly',1.45,182,1000.00,100000.00,'Low',
   'A 26-week position with a stronger weekly rate.',
   'Half a year, twenty-six payouts, and a materially better rate than the entry tier for committing the extra term.',
   'A blended book of fixed income and investment-grade credit. Weekly payouts are credited automatically; principal is returned at maturity. Early exit forfeits unpaid periods.',
   'ph-tree','orange','active'),

  ('Blackthorn Weekly','weekly',1.80,364,5000.00,500000.00,'Moderate',
   'A full-year weekly position at our highest weekly rate.',
   'Fifty-two payouts across a full year. The longest weekly commitment and the strongest weekly rate we publish.',
   'Backed by a diversified multi-strategy book including growth credit. Capital is at risk; the allocation report is issued quarterly. Weekly payouts continue uninterrupted through the term.',
   'ph-trend-up','orange','active'),

  ('Northwood Monthly','monthly',4.50,180,500.00,50000.00,'Low',
   'A 6-month position paying out on the same date each month.',
   'Six clean monthly payouts over half a year. Simple to forecast, easy to plan around.',
   'A conservative fixed-income allocation. Your payout lands on the same calendar day each month and is immediately withdrawable. Principal returns at maturity.',
   'ph-calendar-check','orange','active'),

  ('Ironwood Monthly','monthly',5.75,360,2500.00,250000.00,'Moderate',
   'A 12-month position with an elevated monthly rate.',
   'A full year of monthly income at a rate that rewards the longer commitment. Our most popular tier.',
   'A balanced allocation across fixed income and dividend equity. Monthly payouts are credited automatically and reported quarterly. Principal returns at maturity.',
   'ph-buildings','orange','active'),

  ('Aldercrest Monthly','monthly',7.20,720,25000.00,2000000.00,'High',
   'A 24-month position for the highest monthly rate we offer.',
   'Two years, twenty-four payouts, and our strongest published rate — for members allocating serious capital.',
   'A higher-risk vehicle built on structured products and growth equity. Capital is at risk and performance is disclosed before allocation. Monthly payouts run for the full term; principal returns at maturity.',
   'ph-crown-simple','orange','active');


-- ============================================================
-- POST-INSTALL
--   1. INSERT INTO admins ... (create your bootstrap admin, or
--      register via /admin.register with ADMIN_INVITE_CODE)
--   2. INSERT INTO users  ... (or sign up via /register)
-- ============================================================

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
