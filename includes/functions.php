<?php

declare(strict_types=1);

function config(?string $key = null, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];
    if ($key === null) {
        return $config;
    }
    $parts = explode('.', $key);
    $value = $config;
    foreach ($parts as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function url(string $path = ''): string
{
    $base = rtrim(config('app_url', ''), '/');
    $path = ltrim($path, '/');
    return $path === '' ? $base . '/' : $base . '/' . $path;
}

/** Admin dashboard URL — always targets index.php (avoids 403 on /admin/ directory). */
function adminUrl(string $query = ''): string
{
    $path = 'admin/dashboard.php';
    if ($query === '') {
        return url($path);
    }
    return url($path . '?' . ltrim($query, '?'));
}

function linkUrl(?string $path): string
{
    if (!$path) {
        return url();
    }
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }
    return url(ltrim($path, '/'));
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function logoUrl(): string
{
    return asset('images/rmc_logo.png');
}

function uploadUrl(?string $filename): string
{
    if (!$filename) {
        return asset('images/placeholder.svg');
    }
    return url('uploads/' . ltrim($filename, '/'));
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-') ?: 'item';
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function verifyCsrf(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['old_input'][$key] ?? $default);
}

function storeOldInput(array $data): void
{
    $_SESSION['old_input'] = $data;
}

function clearOldInput(): void
{
    unset($_SESSION['old_input']);
}

function truncate(string $text, int $length = 160): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $length)) . '…';
}

function formatDate(?string $date, string $format = 'd M Y'): string
{
    if (!$date) {
        return '';
    }
    return date($format, strtotime($date));
}

function logActivity(string $action, ?string $entityType = null, ?int $entityId = null, ?string $details = null): void
{
    if (!isLoggedIn()) {
        return;
    }
    $db = Database::getInstance();
    $stmt = $db->prepare(
        'INSERT INTO activity_logs (admin_id, action, entity_type, entity_id, details) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([currentUserId(), $action, $entityType, $entityId, $details]);
}

function render(string $view, array $data = [], ?string $layout = 'main'): void
{
    extract($data);
    $viewFile = INCLUDES_PATH . '/views/pages/' . $view . '.php';
    if (!file_exists($viewFile)) {
        http_response_code(404);
        $viewFile = INCLUDES_PATH . '/views/pages/404.php';
    }

    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    if ($layout) {
        require INCLUDES_PATH . '/views/layouts/' . $layout . '.php';
    } else {
        echo $content;
    }
}

function renderAdmin(string $view, array $data = []): void
{
    extract($data);
    $viewFile = INCLUDES_PATH . '/views/admin/' . $view . '.php';
    if (!file_exists($viewFile)) {
        die('Admin view not found: ' . e($view));
    }

    ob_start();
    require $viewFile;
    $content = ob_get_clean();
    require INCLUDES_PATH . '/views/admin/layout.php';
}

function jsonResponse(array $data, int $code = 200): never
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function getSetting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        try {
            $db = Database::getInstance();
            $rows = $db->query('SELECT setting_key, setting_value FROM website_settings')->fetchAll();
            foreach ($rows as $row) {
                $cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable) {
            $cache = [];
        }
    }
    return $cache[$key] ?? $default;
}

function getSeo(string $pageKey): array
{
    static $cache = [];
    if (!isset($cache[$pageKey])) {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM seo WHERE page_key = ? LIMIT 1');
        $stmt->execute([$pageKey]);
        $cache[$pageKey] = $stmt->fetch() ?: [];
    }
    return $cache[$pageKey];
}

function parseJsonField(?string $json): array
{
    if (!$json) {
        return [];
    }
    $decoded = json_decode($json, true);
    return is_array($decoded) ? $decoded : [];
}

function currentRoute(): string
{
    return trim($_GET['route'] ?? 'home', '/');
}

function isActiveNav(string $route): string
{
    $current = currentRoute();
    if ($route === 'home' && ($current === '' || $current === 'home')) {
        return 'active';
    }
    if ($route !== 'home' && str_starts_with($current, $route)) {
        return 'active';
    }
    return '';
}
