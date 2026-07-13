<?php

declare(strict_types=1);

/**
 * One-time migration: contact topic field + FAQ table.
 * Run: APP_ENV=production php database/migrate_contact_faq.php
 */

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/SeedData.php';

$db = Database::getInstance();

try {
    $columns = $db->query("SHOW COLUMNS FROM messages LIKE 'topic'")->fetch();
    if (!$columns) {
        $db->exec('ALTER TABLE messages ADD COLUMN topic VARCHAR(150) DEFAULT NULL AFTER phone');
        echo "Added messages.topic column.\n";
    } else {
        echo "messages.topic column already exists.\n";
    }

    $db->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_faqs_published (is_published, sort_order)
) ENGINE=InnoDB
SQL);
    echo "faqs table ready.\n";

    $count = (int) $db->query('SELECT COUNT(*) FROM faqs')->fetchColumn();
    if ($count === 0) {
        SeedData::seedFaqs($db);
        echo "Seeded FAQ content.\n";
    } else {
        echo "FAQs already present ({$count} items).\n";
    }

    $seoStmt = $db->prepare('SELECT COUNT(*) FROM seo WHERE page_key = ?');
    $seoStmt->execute(['faq']);
    if ((int) $seoStmt->fetchColumn() === 0) {
        $insertSeo = $db->prepare(
            'INSERT INTO seo (page_key, meta_title, meta_description, meta_keywords) VALUES (?, ?, ?, ?)'
        );
        $insertSeo->execute([
            'faq',
            'Frequently Asked Questions | Radiation Equipment Consultancy',
            'Answers to common questions about our radiation equipment consultancy services, commissioning, compliance, and how we work with healthcare facilities.',
            'radiation equipment FAQ, commissioning questions, regulatory compliance FAQ, hospital equipment consultancy',
        ]);
        echo "Added FAQ SEO entry.\n";
    }
} catch (PDOException $e) {
    echo 'Migration failed: ' . $e->getMessage() . "\n";
    exit(1);
}
