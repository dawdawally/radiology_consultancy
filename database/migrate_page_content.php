<?php
/**
 * Create page_content table and seed editable page heroes/CTAs + homepage extras.
 * Safe to re-run (upserts / merges missing keys only).
 *
 * Usage: php database/migrate_page_content.php
 */
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/bootstrap.php';

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Run from command line only.\n");
    exit(1);
}

$pdo = Database::getInstance();

echo "Creating page_content table...\n";
$pdo->exec("
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
) ENGINE=InnoDB
");

require_once __DIR__ . '/SeedData.php';
SeedData::seedPageContent($pdo);
SeedData::seedHomepageExtras($pdo);

echo "Done. Edit content in Admin → Homepage and Admin → Pages.\n";
