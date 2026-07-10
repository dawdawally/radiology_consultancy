<?php
/**
 * Database installer — run once:
 *   Local:      php database/install.php
 *   Production: APP_ENV=production php database/install.php
 */

require_once __DIR__ . '/../includes/bootstrap.php';

$config = config('db');
$dbName = $config['name'];

try {
    $pdo = connectDatabase($config);
} catch (PDOException $e) {
    echo "Installation failed: " . $e->getMessage() . "\n";
    exit(1);
}

try {
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    foreach (parseSqlStatements($schema) as $statement) {
        if (shouldSkipSchemaStatement($statement)) {
            continue;
        }
        $pdo->exec($statement);
    }

    require_once __DIR__ . '/SeedData.php';
    SeedData::run($pdo);

    $hash = password_hash('Admin@123456', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE username = ?');
    $stmt->execute([$hash, 'admin']);

    echo "Installation complete.\n";
    echo "Database: {$dbName}\n";
    echo "Admin login: admin / Admin@123456\n";
    echo "Change the password after first login.\n";
} catch (PDOException $e) {
    echo "Installation failed: " . $e->getMessage() . "\n";
    exit(1);
}

function connectDatabase(array $config): PDO
{
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    $dsnWithDb = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $config['host'],
        $config['port'],
        $config['name'],
        $config['charset']
    );

    try {
        return new PDO($dsnWithDb, $config['user'], $config['pass'], $options);
    } catch (PDOException $e) {
        // Local dev: create database if it does not exist yet
        if ((int) $e->getCode() !== 1049) {
            throw $e;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['charset']
        );
        $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
        $pdo->exec(
            'CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '', $config['name']) . '`'
            . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
        );

        return new PDO($dsnWithDb, $config['user'], $config['pass'], $options);
    }
}

function parseSqlStatements(string $sql): array
{
    return array_filter(array_map('trim', explode(';', $sql)));
}

function shouldSkipSchemaStatement(string $statement): bool
{
    if ($statement === '') {
        return true;
    }

    $upper = strtoupper(ltrim($statement));

    return str_starts_with($upper, 'CREATE DATABASE')
        || str_starts_with($upper, 'USE ');
}
