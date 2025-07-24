CREATE DATABASE tedbus_db;
USE tedbus_db;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    story TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cab_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pickup VARCHAR(100),
    drop_location VARCHAR(100),
    cab_type VARCHAR(50),
    booking_date DATE
);

CREATE TABLE bus_hires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    start_location VARCHAR(100),
    destination VARCHAR(100),
    hire_date DATE,
    bus_size VARCHAR(20),
    amenities VARCHAR(100),
    route TEXT
);
