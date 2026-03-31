-- ═══════════════════════════════════════════════════════════
-- Yenepoya Libraries — Database Schema
-- Run this once to set up the MySQL database and tables.
-- ═══════════════════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS `yenepoya_library`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `yenepoya_library`;

-- ─── 1. Sidebar Enquiries ───────────────────────────────────
-- Source: "Quick Enquiry" sidebar on index, services, 
--         e-resources, repository, about pages
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `enquiries` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(255)  NOT NULL,
  `email`      VARCHAR(255)  DEFAULT NULL,
  `phone`      VARCHAR(30)   NOT NULL,
  `message`    TEXT          NOT NULL,
  `ip_address` VARCHAR(45)   DEFAULT NULL,
  `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  `is_read`    TINYINT(1)    DEFAULT 0,
  INDEX `idx_created` (`created_at`),
  INDEX `idx_read` (`is_read`)
) ENGINE=InnoDB;


-- ─── 2. Contact / Ask a Librarian ───────────────────────────
-- Source: contact.html → "Ask a Librarian" form
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `contacts` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(255)  NOT NULL,
  `email`      VARCHAR(255)  NOT NULL,
  `subject`    VARCHAR(500)  NOT NULL,
  `message`    TEXT          NOT NULL,
  `ip_address` VARCHAR(45)   DEFAULT NULL,
  `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  `status`     ENUM('new','replied','closed') DEFAULT 'new',
  INDEX `idx_status` (`status`),
  INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;


-- ─── 3. Book Recommendations ────────────────────────────────
-- Source: contact.html → "Recommend a Book" form
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `book_recommendations` (
  `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`           VARCHAR(500)  NOT NULL,
  `author`          VARCHAR(255)  NOT NULL,
  `publisher`       VARCHAR(255)  NOT NULL,
  `edition`         VARCHAR(100)  DEFAULT NULL,
  `year_of_pub`     VARCHAR(10)   DEFAULT NULL,
  `num_copies`      INT UNSIGNED  DEFAULT 1,
  `reason`          TEXT          DEFAULT NULL,
  `recommended_by`  VARCHAR(255)  NOT NULL,
  `requester_name`  VARCHAR(255)  NOT NULL,
  `campus_id`       VARCHAR(50)   DEFAULT NULL,
  `course`          VARCHAR(255)  DEFAULT NULL,
  `college`         VARCHAR(255)  DEFAULT NULL,
  `ip_address`      VARCHAR(45)   DEFAULT NULL,
  `created_at`      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  `status`          ENUM('pending','approved','ordered','received') DEFAULT 'pending',
  INDEX `idx_status` (`status`),
  INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;


-- ─── 4. Journal Recommendations ─────────────────────────────
-- Source: contact.html → "Recommend a Journal" form
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `journal_recommendations` (
  `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`           VARCHAR(500)  NOT NULL,
  `type_of_journal` VARCHAR(100)  DEFAULT NULL,
  `publisher`       VARCHAR(255)  DEFAULT NULL,
  `issn`            VARCHAR(20)   DEFAULT NULL,
  `description`     TEXT          DEFAULT NULL,
  `ip_address`      VARCHAR(45)   DEFAULT NULL,
  `created_at`      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  `status`          ENUM('pending','under_review','approved','rejected') DEFAULT 'pending',
  INDEX `idx_status` (`status`),
  INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;
