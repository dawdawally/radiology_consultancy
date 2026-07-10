<?php
/**
 * Database installer — run once: php database/install.php
 * Creates schema, seeds content, and admin user.
 */

require_once __DIR__ . '/../includes/bootstrap.php';

$config = config('db');
$dsn = sprintf('mysql:host=%s;port=%s;charset=%s', $config['host'], $config['port'], $config['charset']);

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $schema = file_get_contents(__DIR__ . '/schema.sql');
    foreach (array_filter(array_map('trim', explode(';', $schema))) as $statement) {
        if ($statement !== '') {
            $pdo->exec($statement);
        }
    }

    require_once __DIR__ . '/SeedData.php';
    SeedData::run($pdo);
    $hash = password_hash('Admin@123456', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE username = ?');
    $stmt->execute([$hash, 'admin']);

    echo "Installation complete.\n";
    echo "Admin login: admin / Admin@123456\n";
    echo "Change the password after first login.\n";
} catch (PDOException $e) {
    echo "Installation failed: " . $e->getMessage() . "\n";
    exit(1);
}
