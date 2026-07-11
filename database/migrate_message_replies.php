<?php

declare(strict_types=1);

/**
 * One-time migration: add message_replies table for admin reply thread history.
 * Run: APP_ENV=production php database/migrate_message_replies.php
 */

require_once __DIR__ . '/../includes/bootstrap.php';

$db = Database::getInstance();

$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS message_replies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_id INT UNSIGNED NOT NULL,
    admin_id INT UNSIGNED NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    email_sent TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_message_replies_message (message_id, created_at)
) ENGINE=InnoDB
SQL;

try {
    $db->exec($sql);
    echo "message_replies table ready.\n";
} catch (PDOException $e) {
    echo 'Migration failed: ' . $e->getMessage() . "\n";
    exit(1);
}
