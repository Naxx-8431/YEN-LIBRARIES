-- ═══════════════════════════════════════════════════════════
-- Yenepoya Libraries — Complete Database Schema
-- Run this ONCE in phpMyAdmin to set up all tables.
-- ═══════════════════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS `yenepoya_library`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `yenepoya_library`;

-- Drop old tables if they exist (safe fresh install)
DROP TABLE IF EXISTS `admin_users`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `book_recommendations`;
DROP TABLE IF EXISTS `journal_recommendations`;
DROP TABLE IF EXISTS `enquiries`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `e_resources`;
DROP TABLE IF EXISTS `repository_items`;
DROP TABLE IF EXISTS `research_tools`;
DROP TABLE IF EXISTS `gallery_images`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `hero_settings`;


-- ─── 1. ADMIN USERS ─────────────────────────────────────────
-- Stores admin login credentials
-- Default: admin / admin123
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `username`   VARCHAR(100) NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default admin (password: admin123, hashed with password_hash)
INSERT INTO `admin_users` (`username`, `password`) VALUES
('admin', '$2y$10$TlsZzPWLFnS9R9WMr.U4reeUw/mEyxfjqbVzhv455QOmyKh5P2qS.');


-- ─── 2. CONTACTS (Ask a Librarian) ─────────────────────────
-- Form submissions from contact page "Ask a Librarian"
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `contacts` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `subject`    VARCHAR(500) NOT NULL,
  `message`    TEXT         NOT NULL,
  `status`     VARCHAR(20)  DEFAULT 'unread',
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `contacts` (`name`, `email`, `subject`, `message`, `status`) VALUES
('Dr. Ramesh Sharma', 'ramesh.s@yenepoya.edu.in', 'Remote Access Issue', 'I am unable to access ClinicalKey from home. The proxy login is not working since last week.', 'unread'),
('Ms. Fatima K.', 'fatima.k@yenepoya.edu.in', 'Library Membership Query', 'I am a new PG student in Pharmacy. How can I get my library card and what documents are needed?', 'unread'),
('Dr. Anand Shetty', 'anand.shetty@yenepoya.edu.in', 'Suggestion for Library Hours', 'Can the Pharmacy Library extend its hours till 8 PM during exam season?', 'read');


-- ─── 3. BOOK RECOMMENDATIONS ────────────────────────────────
-- Form from contact page "Recommend a Book"
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `book_recommendations` (
  `id`             INT AUTO_INCREMENT PRIMARY KEY,
  `title`          VARCHAR(500) NOT NULL,
  `author`         VARCHAR(255) NOT NULL,
  `publisher`      VARCHAR(255) NOT NULL,
  `edition`        VARCHAR(100) DEFAULT NULL,
  `year_of_pub`    VARCHAR(10)  DEFAULT NULL,
  `num_copies`     INT          DEFAULT 1,
  `reason`         TEXT         DEFAULT NULL,
  `recommended_by` VARCHAR(255) NOT NULL,
  `requester_name` VARCHAR(255) NOT NULL,
  `campus_id`      VARCHAR(50)  DEFAULT NULL,
  `course`         VARCHAR(255) DEFAULT NULL,
  `college`        VARCHAR(255) DEFAULT NULL,
  `status`         VARCHAR(20)  DEFAULT 'pending',
  `created_at`     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `book_recommendations` (`title`, `author`, `publisher`, `edition`, `num_copies`, `reason`, `recommended_by`, `requester_name`, `college`, `status`) VALUES
('Harrison''s Principles of Internal Medicine, 21st Ed', 'Kasper, Fauci et al.', 'McGraw-Hill', '21st', 3, 'Essential reference for internal medicine PG students', 'Dr. HOD Medicine', 'Dr. Meera Nair', 'YMC', 'pending'),
('Robbins & Cotran Pathologic Basis of Disease', 'Kumar, Abbas, Aster', 'Elsevier', '10th', 5, 'Core pathology textbook needed for all MBBS batches', 'Dr. HOD Pathology', 'Dr. Priya D.', 'YMC', 'approved'),
('Essentials of Medical Pharmacology', 'KD Tripathi', 'Jaypee Brothers', '9th', 10, 'Standard pharmacology textbook required for UG and PG', 'Mr. Rohan K.', 'Mr. Rohan K.', 'YPC', 'pending');


-- ─── 4. JOURNAL RECOMMENDATIONS ─────────────────────────────
-- Form from contact page "Recommend a Journal"
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `journal_recommendations` (
  `id`              INT AUTO_INCREMENT PRIMARY KEY,
  `title`           VARCHAR(500) NOT NULL,
  `type_of_journal` VARCHAR(100) DEFAULT NULL,
  `publisher`       VARCHAR(255) DEFAULT NULL,
  `issn`            VARCHAR(20)  DEFAULT NULL,
  `description`     TEXT         DEFAULT NULL,
  `status`          VARCHAR(20)  DEFAULT 'pending',
  `created_at`      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `journal_recommendations` (`title`, `type_of_journal`, `publisher`, `issn`, `description`, `status`) VALUES
('Indian Journal of Medical Research', 'Print + Online', 'ICMR', '0971-5916', 'Premier Indian medical research journal, essential for faculty and PG students.', 'pending'),
('Journal of Prosthodontics', 'Online', 'Wiley', '1059-941X', 'Key journal for dental prosthodontics department research.', 'approved'),
('Annals of Ayurvedic Medicine', 'Print + Online', 'AAM Publications', '2278-4764', 'Important for Ayurveda college faculty publications.', 'pending');


-- ─── 5. ENQUIRIES (Sidebar form) ────────────────────────────
-- Quick enquiry sidebar form on multiple pages
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `enquiries` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) DEFAULT NULL,
  `phone`      VARCHAR(30)  NOT NULL,
  `message`    TEXT         NOT NULL,
  `status`     VARCHAR(20)  DEFAULT 'new',
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `enquiries` (`name`, `email`, `phone`, `message`, `status`) VALUES
('Mr. Ahmed Khan', 'ahmed.khan@gmail.com', '+91 9876543210', 'I want to know if external researchers can use the library facilities.', 'new'),
('Dr. Sunita Rao', 'sunita.rao@yenepoya.edu.in', '+91 9123456780', 'Request for inter-library loan from NIMHANS library for a rare publication.', 'replied'),
('Ms. Priya M.', 'priya.m@outlook.com', '+91 8765432109', 'Is there a virtual tour available? I am a prospective student wanting to see the library.', 'new');


-- ─── 6. EVENTS ──────────────────────────────────────────────
-- Library events, workshops, orientations
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `events` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(500) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `category`    VARCHAR(100) DEFAULT 'General',
  `event_date`  DATE         DEFAULT NULL,
  `location`    VARCHAR(255) DEFAULT NULL,
  `image`       VARCHAR(500) DEFAULT NULL,
  `status`      VARCHAR(20)  DEFAULT 'published',
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `events` (`title`, `description`, `category`, `event_date`, `location`, `status`) VALUES
('World Book Day Celebration', 'Annual celebration of World Book Day with book displays, reading sessions, and author interactions across all library branches.', 'Exhibition', '2024-04-23', 'Central Library', 'published'),
('PubMed & Scopus Search Workshop', 'Hands-on training session on advanced database searching techniques for PG students and research scholars.', 'Workshop', '2024-03-15', 'Digital Library Lab', 'published'),
('Library Orientation for MBBS Batch 2024', 'Comprehensive orientation program introducing new MBBS students to library services, resources, and facilities.', 'Orientation', '2024-02-10', 'Central Library Auditorium', 'published'),
('National Science Day Exhibition', 'Special exhibition of scientific publications and e-resources curated by the Science Library team.', 'Exhibition', '2024-02-28', 'Exhibition Hall', 'published'),
('Library Week 2024', 'Week-long celebration featuring book fairs, quizzes, author talks, and new database demos.', 'General', '2024-01-15', 'All Campuses', 'published'),
('Zotero Reference Management Training', 'Training faculty and PG students on using Zotero for managing research references and citations.', 'Workshop', '2024-01-08', 'Computer Lab 2', 'draft');


-- ─── 7. SERVICES ────────────────────────────────────────────
-- Library services displayed on services page
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `section`     VARCHAR(100) DEFAULT NULL,
  `link_url`    VARCHAR(500) DEFAULT NULL,
  `link_label`  VARCHAR(100) DEFAULT NULL,
  `visible`     TINYINT(1)   DEFAULT 1,
  `sort_order`  INT          DEFAULT 0,
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `services` (`title`, `description`, `section`, `link_url`, `link_label`, `visible`, `sort_order`) VALUES
('OPAC / Web-OPAC', 'Search our entire collection of books, journals, and multimedia resources using the Online Public Access Catalogue.', 'Search & Discovery', 'https://opac.yenepoya.edu.in', 'Access OPAC', 1, 1),
('Remote Access (MyLOFT / Knimbus)', 'Access all subscribed e-resources from anywhere using MyLOFT/Knimbus remote access platform.', 'Access Anywhere', 'https://knimbus.com', 'Access Now', 1, 2),
('Borrowing Facility', 'Borrow books, journals, and other materials from any of our six library branches with your valid library card.', 'Circulation', NULL, NULL, 1, 3),
('Article Request Service', 'Request specific research articles that are not available in our collection. We will procure them via inter-library loan.', 'Document Delivery', 'mailto:library@yenepoya.edu.in', 'Request Article', 1, 4);


-- ─── 8. E-RESOURCES ─────────────────────────────────────────
-- Databases, e-journals, e-books, open access resources
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `e_resources` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `category`    VARCHAR(50)  DEFAULT 'database',
  `provider`    VARCHAR(255) DEFAULT NULL,
  `access_url`  VARCHAR(500) DEFAULT NULL,
  `visible`     TINYINT(1)   DEFAULT 1,
  `sort_order`  INT          DEFAULT 0,
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `e_resources` (`title`, `description`, `category`, `provider`, `access_url`, `visible`, `sort_order`) VALUES
('ClinicalKey', 'Comprehensive clinical decision support resource with medical, nursing, and health professions content.', 'database', 'Elsevier', 'https://clinicalkey.com', 1, 1),
('ProQuest Medical Library', 'Dissertations, health & medical databases for researchers and students.', 'database', 'ProQuest', 'https://proquest.com', 1, 2),
('Scopus', 'Abstract and citation database covering science, technology, medicine, social sciences, and arts.', 'database', 'Elsevier', 'https://scopus.com', 1, 3),
('PubMed Central', 'Free full-text archive of biomedical and life sciences journal articles.', 'ejournal', 'NIH / NLM', 'https://ncbi.nlm.nih.gov/pmc', 1, 4),
('ClinicalKey E-Books', 'Over 1,100+ medical and surgical e-book titles available for online reading.', 'ebook', 'Elsevier', 'https://clinicalkey.com/#!/browse/book', 1, 5),
('DOAJ — Directory of Open Access Journals', 'Community-curated directory of open access, peer-reviewed journals across all disciplines.', 'openaccess', 'Community', 'https://doaj.org', 1, 6);


-- ─── 9. REPOSITORY ITEMS ────────────────────────────────────
-- Institutional repository sections and annual reports
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `repository_items` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `type`        VARCHAR(50)  DEFAULT 'repository',
  `url`         VARCHAR(500) DEFAULT NULL,
  `file_path`   VARCHAR(500) DEFAULT NULL,
  `visible`     TINYINT(1)   DEFAULT 1,
  `sort_order`  INT          DEFAULT 0,
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `repository_items` (`title`, `description`, `type`, `url`, `visible`, `sort_order`) VALUES
('Faculty Publications', 'Published research output of Yenepoya faculty deposited in DSpace institutional repository.', 'repository', 'https://dspace.yenepoya.edu.in', 1, 1),
('Theses & Dissertations', 'Full-text theses and dissertations submitted by PG and PhD students.', 'repository', 'https://dspace.yenepoya.edu.in', 1, 2),
('Question Papers', 'Previous year question papers for all courses archived digitally.', 'repository', 'https://dspace.yenepoya.edu.in', 1, 3),
('Annual Report 2023–24', 'Annual report covering library acquisitions, events, and usage statistics.', 'report', NULL, 1, 4),
('Annual Report 2022–23', 'Annual report with details on digital transformation initiatives.', 'report', NULL, 1, 5),
('Annual Report 2021–22', 'Annual report covering post-COVID library reopening protocols.', 'report', NULL, 1, 6);


-- ─── 10. RESEARCH TOOLS ─────────────────────────────────────
-- Research support services and tools
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `research_tools` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `link_url`    VARCHAR(500) DEFAULT NULL,
  `visible`     TINYINT(1)   DEFAULT 1,
  `sort_order`  INT          DEFAULT 0,
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `research_tools` (`title`, `description`, `link_url`, `visible`, `sort_order`) VALUES
('IRINS @ Yenepoya', 'Indian Research Information Network System — faculty research profiles and publication tracking.', 'https://irins.org/profile/yenepoya', 1, 1),
('Plagiarism Detection (Turnitin)', 'Similarity checking service for theses, dissertations, and research papers.', 'https://turnitin.com', 1, 2),
('Reference Management (Zotero)', 'Free reference manager for organizing, citing, and sharing research sources.', 'https://zotero.org', 1, 3),
('UGC-CARE Journals', 'Guidelines for identifying UGC-approved, quality peer-reviewed journals for publication.', 'https://ugc.ac.in/care', 1, 4);


-- ─── 11. GALLERY IMAGES ─────────────────────────────────────
-- Photo gallery with albums/categories
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `caption`    VARCHAR(255) DEFAULT NULL,
  `album`      VARCHAR(100) DEFAULT 'Central Library',
  `image_path` VARCHAR(500) NOT NULL,
  `visible`    TINYINT(1)   DEFAULT 1,
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data (using existing images from the project)
INSERT INTO `gallery_images` (`caption`, `album`, `image_path`) VALUES
('Central Library Reading Hall', 'Central Library', 'assets/images/about/about-central2.webp'),
('Central Library Book Collection', 'Central Library', 'assets/images/about/about-central3.webp'),
('Digital Resource Center', 'Central Library', 'assets/images/about/about-central4.webp');


-- ─── 12. NOTIFICATIONS ──────────────────────────────────────
-- Homepage sidebar notifications/announcements
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `notifications` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `title`      VARCHAR(255) NOT NULL,
  `message`    TEXT         DEFAULT NULL,
  `active`     TINYINT(1)   DEFAULT 1,
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data
INSERT INTO `notifications` (`title`, `message`, `active`) VALUES
('ClinicalKey Access Restored', 'Remote access to ClinicalKey is now working normally.', 1),
('New Books Added', '15 new medical and dental textbooks are now available in the Central Library.', 1),
('Library Hours Extended', 'During exams, Central Library will stay open until 2 AM.', 0);


-- ─── 13. HERO SETTINGS ─────────────────────────────────────
-- Homepage hero section content (only 1 row expected)
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `hero_settings` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `tagline`     VARCHAR(255) DEFAULT 'Yenepoya (Deemed to be University)',
  `heading`     VARCHAR(255) DEFAULT 'Discover. Learn. Grow.',
  `description` TEXT         DEFAULT NULL,
  `stat1_num`   VARCHAR(50)  DEFAULT '53,738+',
  `stat1_label` VARCHAR(100) DEFAULT 'Print Books',
  `stat2_num`   VARCHAR(50)  DEFAULT '2.1M+',
  `stat2_label` VARCHAR(100) DEFAULT 'E-Resources',
  `stat3_num`   VARCHAR(50)  DEFAULT '8,000+',
  `stat3_label` VARCHAR(100) DEFAULT 'E-Journals',
  `stat4_num`   VARCHAR(50)  DEFAULT '1,200+',
  `stat4_label` VARCHAR(100) DEFAULT 'Print Journals'
) ENGINE=InnoDB;

-- Insert default hero content
INSERT INTO `hero_settings` (`tagline`, `heading`, `description`) VALUES
('Yenepoya (Deemed to be University)', 'Discover. Learn. Grow.', 'Explore over 53,000+ books, 2.1 million+ e-resources, and 8,000+ e-journals across six specialized campus libraries.');

-- ─── 14. NEW ARRIVALS ──────────────────────────────────────
-- Homepage New Arrivals Section
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `new_arrivals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ─── 15. TRENDING PUBLICATIONS ─────────────────────────────
-- Homepage Trending Publications / Faculty section
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `trending_publications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `author_details` VARCHAR(255) DEFAULT NULL,
  `publish_date` VARCHAR(100) DEFAULT NULL,
  `link_url` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ─── 16. TRENDING NEWS ─────────────────────────────────────
-- Homepage Trending Subjects & News
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `trending_news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `category_tag` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `link_url` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ─── 17. LIBRARIES ──────────────────────────────────────────
-- Constituent libraries (dynamic content for homepage & about)
-- ─────────────────────────────────────────────────────────────

DROP TABLE IF EXISTS `library_gallery`;
DROP TABLE IF EXISTS `libraries`;

CREATE TABLE IF NOT EXISTS `libraries` (
  `id`                INT AUTO_INCREMENT PRIMARY KEY,
  `library_name`      VARCHAR(255) NOT NULL,
  `slug`              VARCHAR(100) NOT NULL UNIQUE,
  `section_label`     VARCHAR(100) DEFAULT 'Constituent Library',
  `short_description` TEXT DEFAULT NULL,
  `full_description`  TEXT DEFAULT NULL,
  `established_year`  VARCHAR(10) DEFAULT NULL,
  `campus`            VARCHAR(255) DEFAULT NULL,
  `subject_area`      VARCHAR(255) DEFAULT NULL,
  `programmes`        VARCHAR(500) DEFAULT NULL,
  `books_count`       VARCHAR(50) DEFAULT NULL,
  `journals_count`    VARCHAR(50) DEFAULT NULL,
  `back_volumes`      VARCHAR(50) DEFAULT NULL,
  `theses_count`      VARCHAR(50) DEFAULT NULL,
  `ejournals_count`   VARCHAR(50) DEFAULT NULL,
  `thumbnail`         VARCHAR(500) DEFAULT NULL,
  `card_meta`         VARCHAR(255) DEFAULT NULL,
  `icon_name`         VARCHAR(50) DEFAULT 'book',
  `working_hours`     TEXT DEFAULT NULL,
  `contact_info`      TEXT DEFAULT NULL,
  `contact_email`     VARCHAR(255) DEFAULT NULL,
  `display_order`     INT DEFAULT 0,
  `status`            ENUM('active','inactive') DEFAULT 'active',
  `created_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ─── 18. LIBRARY GALLERY ────────────────────────────────────
-- Per-library photo gallery images
-- ─────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `library_gallery` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `library_id`  INT NOT NULL,
  `image_path`  VARCHAR(500) NOT NULL,
  `caption`     VARCHAR(255) DEFAULT NULL,
  `sort_order`  INT DEFAULT 0,
  FOREIGN KEY (`library_id`) REFERENCES `libraries`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

