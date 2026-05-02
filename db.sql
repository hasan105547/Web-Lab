CREATE DATABASE IF NOT EXISTS boi_ghor;
USE boi_ghor;

CREATE TABLE IF NOT EXISTS books (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(200)  NOT NULL,
    author        VARCHAR(100)  NOT NULL,
    subject       VARCHAR(100)  NOT NULL,
    department_id VARCHAR(100)  NOT NULL,
    type          ENUM('book','note') NOT NULL,
    file_type     VARCHAR(20)   NOT NULL,
    file_path     VARCHAR(255)  NOT NULL,
    filename      VARCHAR(255)  NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
