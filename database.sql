CREATE DATABASE IF NOT EXISTS asams_db;
USE asams_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(30) NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_name VARCHAR(150) NOT NULL,
    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    reference VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('pending','successful','failed') NOT NULL DEFAULT 'successful',
    paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_payments_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_name VARCHAR(150) NOT NULL,
    payment_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_course (user_id, course_name),
    CONSTRAINT fk_enrollments_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_enrollments_payment
        FOREIGN KEY (payment_id) REFERENCES payments(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
