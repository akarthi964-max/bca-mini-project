CREATE DATABASE IF NOT EXISTS hall_booking_db;
USE hall_booking_db;

CREATE TABLE IF NOT EXISTS halls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hall_name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hall_id INT NOT NULL,
    applicant_name VARCHAR(100) NOT NULL,
    event_name VARCHAR(150) NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE
);

-- Insert dummy halls for BCU Campus
INSERT INTO halls (hall_name, capacity) VALUES 
('Auditorium A', 300),
('Seminar Hall 1', 100),
('Computer Lab 3', 60);