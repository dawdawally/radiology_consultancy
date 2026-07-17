<?php

declare(strict_types=1);

class PageContentModel extends BaseModel
{
    protected string $table = 'page_content';

    /**
     * Create page_content table and seed defaults if missing (Hostinger-safe, no CLI required).
     */
    public function ensureReady(): void
    {
        $this->db->exec("
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $count = (int) $this->db->query('SELECT COUNT(*) FROM page_content')->fetchColumn();
        if ($count === 0) {
            require_once ROOT_PATH . '/database/SeedData.php';
            SeedData::seedPageContent($this->db);
            SeedData::seedHomepageExtras($this->db);
        }
    }

    public function getByKey(string $key): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM page_content WHERE page_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getAllKeyed(): array
    {
        $rows = $this->findAll('page_key ASC');
        $keyed = [];
        foreach ($rows as $row) {
            $keyed[$row['page_key']] = $row;
        }
        return $keyed;
    }

    public function updatePage(string $key, array $data): bool
    {
        $fields = [];
        $values = [];
        foreach ($data as $field => $value) {
            $fields[] = "{$field} = ?";
            $values[] = $value;
        }
        $values[] = $key;
        $sql = 'UPDATE page_content SET ' . implode(', ', $fields) . ' WHERE page_key = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function upsert(string $key, array $data): bool
    {
        if ($this->getByKey($key)) {
            return $this->updatePage($key, $data);
        }

        $columns = array_merge(['page_key'], array_keys($data));
        $placeholders = array_fill(0, count($columns), '?');
        $values = array_merge([$key], array_values($data));
        $sql = 'INSERT INTO page_content (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}
