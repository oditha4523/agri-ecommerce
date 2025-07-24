-- MySQL Dump for agriecom Database
-- Version: 8.0.42-0ubuntu0.24.04.2
-- Host: 127.0.0.1

-- Set environment
SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET unique_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- Drop existing tables if they exist
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `sellers`;
DROP TABLE IF EXISTS `users`;

-- Create `products` table
CREATE TABLE `products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `seller_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `category` ENUM('Utilized','UnderUtilized') NOT NULL,
  `video_url` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into `products`
INSERT INTO `products` (`product_id`, `seller_id`, `name`, `category`, `video_url`) VALUES
(1, 1, 'Premium Ceylon Cinnamon Sticks', 'Utilized', 'Cylon Spices.mp4');

-- Create `sellers` table
CREATE TABLE `sellers` (
  `seller_id` INT NOT NULL AUTO_INCREMENT,
  `seller_name` VARCHAR(100) NOT NULL,
  `phone_number` VARCHAR(20) DEFAULT NULL,
  `address` TEXT,
  PRIMARY KEY (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into `sellers`
INSERT INTO `sellers` (`seller_id`, `seller_name`, `phone_number`, `address`) VALUES
(1, 'Ceylon Spice Co.', '+94112345678', 'Colombo, Sri Lanka');

-- Create `users` table
CREATE TABLE `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `user_type` VARCHAR(45) DEFAULT 'admin',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- (No data inserted into `users` yet)

-- Restore environment
SET foreign_key_checks = 1;
SET unique_checks = 1;
