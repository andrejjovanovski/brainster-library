# ************************************************************
# Sequel Ace SQL dump
# Version 20065
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.28-MariaDB)
# Database: library
# Generation Time: 2024-06-23 15:08:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table authors
# ------------------------------------------------------------

CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;

INSERT INTO `authors` (`id`, `name`, `last_name`, `bio`, `is_archived`, `created_at`)
VALUES
	(2,'Haruki','Murakami','Haruki Murakami (born 1949) is a Japanese author known for his surreal and dreamlike narratives that often blend elements of magical realism with contemporary themes. His novels, such as \"Norwegian Wood,\" \"Kafka on the Shore,\" and \"1Q84,\" have gained international acclaim for their introspective exploration of loneliness, identity, and the human condition. Murakami\'s distinctive writing style and imaginative storytelling have made him one of the most celebrated contemporary writers globally.',0,'2024-06-19 01:27:20'),
	(3,'Gabriel Garcia','Marquez','Gabriel Garcia Marquez (1927-2014) was a Colombian novelist and Nobel Prize winner in Literature. He is best known for his magical realism style, blending fantastical elements with realistic settings and themes. Marquez\'s masterpiece, \"One Hundred Years of Solitude,\" is widely regarded as a landmark in 20th-century literature. His works often explore Latin American culture, politics, and human relationships in a unique and captivating manner.',0,'2024-06-19 19:24:21'),
	(5,'Jane','Austen','Jane Austen (1775-1817) was an English novelist known for her witty and insightful portrayals of English middle-class life during the early 19th century. Her notable works include \"Pride and Prejudice,\" \"Sense and Sensibility,\" and \"Emma.\" Austen\'s writing often explores themes of love, marriage, and social status, and her keen observation of society continues to captivate readers worldwide.',1,'2024-06-20 17:22:49');

/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table books
# ------------------------------------------------------------

CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `published_in` int(11) DEFAULT NULL,
  `total_pages` int(11) DEFAULT NULL,
  `cover_img_url` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_books_author` (`author_id`),
  KEY `fk_books_category` (`category_id`),
  CONSTRAINT `fk_books_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;

INSERT INTO `books` (`id`, `title`, `author_id`, `published_in`, `total_pages`, `cover_img_url`, `category_id`, `created_at`)
VALUES
	(1,'zoki poki',2,2022,90,'https://t3.ftcdn.net/jpg/00/53/73/42/360_F_53734293_rs3bkrl9n1EJZBj2CdogkmeF6W5aOhy5.jpg',3,'2024-06-19 13:06:25'),
	(5,'Andrej',3,1893,2932,'https://img.freepik.com/free-vector/hand-drawn-flat-design-stack-books_23-2149342941.jpg',2,'2024-06-20 19:08:52'),
	(6,'Jovanvski',3,2001,23232,'https://t3.ftcdn.net/jpg/00/53/73/42/360_F_53734293_rs3bkrl9n1EJZBj2CdogkmeF6W5aOhy5.jpg',9,'2024-06-20 19:31:30'),
	(7,'Pajazinata na klementina',3,1998,123,'https://img.freepik.com/free-vector/hand-drawn-flat-design-stack-books_23-2149342941.jpg',10,'2024-06-21 10:43:27');

/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `title`, `is_archived`, `created_at`)
VALUES
	(2,'Drama',0,'2024-06-18 00:34:06'),
	(3,'Comedy',0,'2024-06-19 00:24:17'),
	(8,'Crime',0,'2024-06-20 16:07:44'),
	(9,'Action',0,'2024-06-20 16:07:55'),
	(10,'Thriler',0,'2024-06-20 17:19:03'),
	(11,'Comedy',1,'2024-06-20 17:37:41'),
	(12,'Si-Fi',0,'2024-06-20 18:00:32');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table clients
# ------------------------------------------------------------

CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;

INSERT INTO `clients` (`id`, `name`, `last_name`, `email`, `username`, `password`, `created_at`, `is_admin`)
VALUES
	(5,'Admin','Admin','admin@admin.com','admin','$2y$10$QMHNPfuDoSxWfjXwUQaFEOJGmhwRzK.17hBUChxOYlA.i0rtjL4da','2024-06-08 12:46:19',1),
	(6,'Client','Client','client@client.com','client','$2y$10$6otmzP5yVbOBqdY.e0B2ueW/tOSQptQaluWeK/IVT1ou4CT6z34UG','2024-06-08 12:49:52',0),
	(7,'Test','Test','test@gmail.com','test','$2y$10$dzMyKMYSvCmyBzAmrHGfKu2ub2v5AuysRm3KUu6UddHmXTygpWbXm','2024-06-13 21:19:29',0),
	(8,'Andrej','Jovanovski','andrej@andrej.com','andrej','$2y$10$U0cvp8pkcAj5/mI3w5wz9.a5f6afuCWC/yoiwx1o0zbB3bFmvYid6','2024-06-23 16:19:42',1);

/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table comments
# ------------------------------------------------------------

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `book_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_approved` tinyint(2) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_comments_client` (`client_id`),
  KEY `fk_comments_book` (`book_id`),
  CONSTRAINT `fk_comments_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `fk_comments_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `client_id`, `book_id`, `comment`, `is_approved`, `created_at`)
VALUES
	(11,7,1,'Drug client test',1,'2024-06-23 11:29:19'),
	(12,7,1,'test za approval',1,'2024-06-23 11:58:57'),
	(13,6,1,'test za komentar',1,'2024-06-23 12:06:09'),
	(14,6,1,'josh edn test',1,'2024-06-23 12:06:18'),
	(15,7,6,'testest',1,'2024-06-23 12:09:43'),
	(16,7,5,'testiram',2,'2024-06-23 12:10:17'),
	(18,7,6,'josh end test',0,'2024-06-23 12:11:27'),
	(20,5,1,'test',2,'2024-06-23 14:31:38'),
	(21,5,6,'test\r\n',1,'2024-06-23 14:44:24'),
	(22,5,7,'decline me',2,'2024-06-23 14:56:31'),
	(23,7,7,'test123123',0,'2024-06-23 15:01:43');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notes
# ------------------------------------------------------------

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_notes_book` (`book_id`),
  KEY `fk_notes_client` (`client_id`),
  CONSTRAINT `fk_notes_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `fk_notes_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;

INSERT INTO `notes` (`id`, `client_id`, `book_id`, `note`, `created_at`)
VALUES
	(7,7,7,'test123','2024-06-23 13:39:50'),
	(8,7,5,'mn dobr kjnuga','2024-06-23 13:40:03'),
	(10,7,1,'testandrej','2024-06-23 14:00:31'),
	(13,7,1,'test','2024-06-23 15:18:35');

/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
