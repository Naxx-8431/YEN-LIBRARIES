<?php
$conn = mysqli_connect("localhost", "root", "", "yenepoya_library");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
DROP TABLE IF EXISTS `new_arrivals`;
CREATE TABLE `new_arrivals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `new_arrivals` (`title`, `author`, `category`, `image`, `visible`) VALUES
('Harrison''s Principles of Internal Medicine, 21st Edition', 'Fauci, Kasper, Hauser et al.', 'Medicine', 'images/e-books/ydc-e-book3.jpg', 1),
('Gray''s Anatomy for Students, 4th Edition', 'Drake, Vogl & Mitchell', 'Anatomy', 'images/e-books/ydc-e-book2.jpg', 1),
('Pharmacology and Pharmacotherapeutics', 'Satoskar, Bhandarkar & Ainapure', 'Pharmacy', 'images/e-books/ydc-e-book1.jpg', 1);

DROP TABLE IF EXISTS `trending_publications`;
CREATE TABLE `trending_publications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `author_details` VARCHAR(255) DEFAULT NULL,
  `publish_date` VARCHAR(100) DEFAULT NULL,
  `link_url` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `trending_publications` (`title`, `author_details`, `publish_date`, `link_url`, `visible`, `sort_order`) VALUES
('Advances in Maxillofacial Surgery Techniques', 'Dr. Rajesh Shetty, Dental College', 'Mar 2026', 'repository.php#publications', 1, 1),
('Efficacy of Ayurvedic Formulations in Post-COVID Care', 'Dr. Asha K, Ayurveda Medical College', 'Feb 2026', 'repository.php#publications', 1, 2),
('Nanotechnology in Targeted Drug Delivery', 'Prof. Suresh Rao, Pharmacy College', 'Jan 2026', 'repository.php#publications', 1, 3);

DROP TABLE IF EXISTS `trending_news`;
CREATE TABLE `trending_news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `category_tag` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `link_url` VARCHAR(500) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `trending_news` (`title`, `category_tag`, `image`, `link_url`, `visible`, `sort_order`) VALUES
('New Breakthrough in Oncology Treatments Published in Lancet', 'Health & Medicine', 'images/edzter/Edzter Magazine Cover.webp', 'e-resources.php#newspapers-magazines', 1, 1),
('Yenepoya Ranked Top 100 in NIRF National Framework', 'University News', 'images/edzter/Newspaper clipping.webp', 'e-resources.php#newspapers-magazines', 1, 2),
('AI''s Role in Diagnosing Rare Diseases Faster', 'Technology & Science', 'images/edzter/Edzter Magazine Cover.webp', 'e-resources.php#newspapers-magazines', 1, 3);
";

if (mysqli_multi_query($conn, $sql)) {
    echo "Tables created and seeded successfully!\n";
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);
?>
