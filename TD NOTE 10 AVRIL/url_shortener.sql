CREATE DATABASE IF NOT EXISTS url_shortener CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE url_shortener;

CREATE TABLE IF NOT EXISTS short_urls (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          original_url TEXT NOT NULL,
                                          short_code VARCHAR(20) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    clicks INT NOT NULL DEFAULT 0
    );