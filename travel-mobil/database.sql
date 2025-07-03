-- --------------------------------------------------------
-- Database: `travel_mobil`
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `travel_mobil`;
USE `travel_mobil`;

-- Table structure for `users`
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,  -- Kolom email ditambahkan di sini
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
);

-- Table structure for `vehicles`
CREATE TABLE `vehicles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `type` VARCHAR(50),
  `license_plate` VARCHAR(20),
  PRIMARY KEY (`id`)
);

-- Table structure for `services`
CREATE TABLE `services` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `origin` VARCHAR(100) NOT NULL,
  `destination` VARCHAR(100) NOT NULL,
  `type` ENUM('carter', 'reguler', 'cargo', 'pelayanan') NOT NULL,
  `price` INT NOT NULL,
  PRIMARY KEY (`id`)
);

-- Table structure for `bookings`
CREATE TABLE `bookings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  `booking_date` DATE NOT NULL,
  `status` ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`)
);

-- Table structure for `admins`
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Menambahkan admin
INSERT INTO admins (username, password) VALUES ('AdminVirta', '$2y$10$EixZ1Z1Z1Z1Z1Z1Z1Z1Z1Oe1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1');