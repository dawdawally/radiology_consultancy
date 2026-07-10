<?php

declare(strict_types=1);

class SeoModel extends BaseModel
{
    protected string $table = 'seo';

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM seo ORDER BY page_key ASC')->fetchAll();
    }

    public function upsert(string $pageKey, array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO seo (page_key, meta_title, meta_description, meta_keywords)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE meta_title=VALUES(meta_title), meta_description=VALUES(meta_description), meta_keywords=VALUES(meta_keywords)'
        );
        return $stmt->execute([
            $pageKey, $data['meta_title'] ?? null, $data['meta_description'] ?? null, $data['meta_keywords'] ?? null,
        ]);
    }
}
