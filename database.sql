CREATE DATABASE IF NOT EXISTS lab3;
USE lab3;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    bg_color VARCHAR(7) DEFAULT '#ffffff',
    text_color VARCHAR(7) DEFAULT '#000000',
    font_size VARCHAR(10) DEFAULT '16px',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Test user (optional)
INSERT INTO users (username, email, password, bg_color, text_color, font_size) 
VALUES ('test', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '#f0f8ff', '#333333', '18px');