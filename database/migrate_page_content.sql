-- Migration: page_content table + homepage extra_data for hero/stats/features
-- Run: php database/migrate_page_content.php

CREATE TABLE IF NOT EXISTS page_content (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(50) NOT NULL UNIQUE,
    hero_title VARCHAR(255) DEFAULT NULL,
    hero_subtitle VARCHAR(500) DEFAULT NULL,
    breadcrumb_label VARCHAR(100) DEFAULT NULL,
    cta_title VARCHAR(255) DEFAULT NULL,
    cta_subtitle VARCHAR(500) DEFAULT NULL,
    cta_button_text VARCHAR(100) DEFAULT NULL,
    cta_button_url VARCHAR(255) DEFAULT NULL,
    extra_data JSON DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
