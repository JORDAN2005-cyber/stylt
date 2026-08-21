CREATE DATABASE IF NOT EXISTS stylt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE stylt;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS portfolios;
DROP TABLE IF EXISTS professional_services;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS professionals;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;
CREATE TABLE users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 role ENUM('CLIENT','PROFESSIONNEL','ADMIN') NOT NULL DEFAULT 'CLIENT',
 full_name VARCHAR(120) NOT NULL,
 phone VARCHAR(30) NOT NULL UNIQUE,
 email VARCHAR(190) NULL,
 password_hash VARCHAR(255) NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE professionals (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL UNIQUE,
 bio TEXT NULL,
 city VARCHAR(80) NOT NULL,
 zone VARCHAR(100) NOT NULL,
 photo_path VARCHAR(255) NOT NULL,
 status ENUM('pending','approved','suspended','rejected') NOT NULL DEFAULT 'pending',
 verified TINYINT(1) NOT NULL DEFAULT 0,
 rating DECIMAL(3,2) NOT NULL DEFAULT 0,
 review_count INT UNSIGNED NOT NULL DEFAULT 0,
 created_at DATETIME NOT NULL,
 CONSTRAINT fk_prof_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 INDEX idx_prof_city_zone(city,zone), INDEX idx_prof_status(status)
) ENGINE=InnoDB;

CREATE TABLE services (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 category VARCHAR(80) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 duration_minutes SMALLINT UNSIGNED NOT NULL
) ENGINE=InnoDB;

CREATE TABLE professional_services (
 professional_id INT UNSIGNED NOT NULL,
 service_id INT UNSIGNED NOT NULL,
 PRIMARY KEY(professional_id,service_id),
 FOREIGN KEY(professional_id) REFERENCES professionals(id) ON DELETE CASCADE,
 FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE portfolios (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 professional_id INT UNSIGNED NOT NULL,
 image_path VARCHAR(255) NOT NULL,
 created_at DATETIME NOT NULL,
 FOREIGN KEY(professional_id) REFERENCES professionals(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE bookings (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 professional_id INT UNSIGNED NOT NULL,
 service_id INT UNSIGNED NOT NULL,
 appointment_date DATE NOT NULL,
 appointment_time TIME NOT NULL,
 mode VARCHAR(50) NOT NULL,
 zone VARCHAR(100) NOT NULL,
 status ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
 created_at DATETIME NOT NULL,
 FOREIGN KEY(professional_id) REFERENCES professionals(id) ON DELETE CASCADE,
 FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE RESTRICT,
 UNIQUE KEY uq_professional_slot(professional_id,appointment_date,appointment_time),
 INDEX idx_booking_date(appointment_date,status)
) ENGINE=InnoDB;

INSERT INTO users(role,full_name,phone,email,password_hash,created_at) VALUES
('PROFESSIONNEL','Junior Barber','+237690000001','junior@stylt.cm',NULL,NOW());
SET @uid=LAST_INSERT_ID();
INSERT INTO professionals(user_id,bio,city,zone,photo_path,status,verified,rating,review_count,created_at)
VALUES(@uid,'Spécialiste des dégradés et de la barbe. Se déplace à Bonamoussadi et Makepe.','Douala','Bonamoussadi','assets/uploads/professionals/junior-barber.jpg','approved',1,4.70,28,NOW());
SET @pid=LAST_INSERT_ID();
INSERT INTO services(name,category,price,duration_minutes) VALUES
('Dégradé homme','Coupe',3500,45),('Coupe + barbe','Barbe',5000,60),('Locks','Locks',6000,75),('Soins du visage','Soins',7000,60);
INSERT INTO professional_services(professional_id,service_id) SELECT @pid,id FROM services WHERE name IN ('Dégradé homme','Coupe + barbe','Locks');
INSERT INTO portfolios(professional_id,image_path,created_at) VALUES
(@pid,'assets/images/portfolio1.jpg',NOW()),(@pid,'assets/images/portfolio2.jpg',NOW()),(@pid,'assets/images/portfolio3.jpg',NOW());
