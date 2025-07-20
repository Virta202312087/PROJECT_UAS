-- -----------------------------------------------------
-- Database: travel_mobil
-- -----------------------------------------------------

CREATE DATABASE IF NOT EXISTS `travel_mobil`;
USE `travel_mobil`;

-- -------------------------------
-- Tabel: users (admin & customer)
-- -------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    username VARCHAR(100) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun default
INSERT INTO users (name, username, email, password, role) VALUES 
('Admin Virta', 'Virta_Admin', 'virtayosephinebarito@gmail.com', '$2y$10$bYFKMLdIN8NTnicqA4EB8u7RVZ1NyEjMy.JzwPc1FSauTv6UZT7.i', 'admin'),
('Customer Virta', 'Virta_Customer', 'virta7721@gmail.com', '$2y$10$bYFKMLdIN8NTnicqA4EB8u7RVZ1NyEjMy.JzwPc1FSauTv6UZT7.i', 'user');

-- ---------------------
-- Tabel: services
-- ---------------------
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL -- carter, pelayanan, reguler, cargo
);

INSERT INTO services (type) VALUES
('carter'), ('pelayanan'), ('reguler'), ('cargo');

-- ---------------------
-- Tabel: routes
-- ---------------------
CREATE TABLE IF NOT EXISTS routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    origin VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL
);

INSERT INTO routes (origin, destination) VALUES
('Bontang', 'Samarinda'),
('Samarinda', 'Bontang'),
('Bontang', 'Balikpapan'),
('Balikpapan', 'Bontang'),
('Bontang', 'Sangatta'),
('Samarinda', 'Balikpapan'),
('Balikpapan', 'Samarinda'),
('Dalam', 'Kota'); -- Untuk pelayanan

-- ---------------------
-- Tabel: prices
-- ---------------------
CREATE TABLE IF NOT EXISTS prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    route_id INT NOT NULL,
    posisi ENUM('depan', 'tengah', 'belakang') DEFAULT NULL,
    price INT NOT NULL,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);

-- ---------------------
-- Tabel: vehicles
-- ---------------------
CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plate_number VARCHAR(20) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    capacity INT NOT NULL,
    status ENUM('tersedia', 'digunakan', 'perbaikan') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------
-- Tabel: schedules
-- ---------------------
CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    route_id INT NOT NULL,
    departure_time DATETIME NOT NULL,
    status ENUM('aktif', 'selesai', 'dibatalkan') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);

-- ---------------------
-- Tabel: bookings
-- ---------------------
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    route_id INT NOT NULL,
    seat_position ENUM('depan', 'tengah', 'belakang') DEFAULT NULL,
    price INT DEFAULT 0,
    cargo_photo VARCHAR(255) DEFAULT NULL,
    transfer_proof VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (route_id) REFERENCES routes(id)
);

-- ---------------------
-- Tabel: feedback
-- ---------------------
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ---------------------
-- Tabel: settings
-- ---------------------
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO settings (setting_key, setting_value) VALUES
('nama_perusahaan', 'Travel Mobil'),
('no_whatsapp', '08123456789'),
('alamat_kantor', 'Jl. Contoh No. 123, Bontang'),
('jam_operasional', '08.00 - 20.00 WITA');
