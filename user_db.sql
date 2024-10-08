CREATE DATABASE user_db;  -- Create a new database with a valid name
USE user_db;              -- Select the newly created database

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    otp VARCHAR(6),
    otp_expiry DATETIME
);
