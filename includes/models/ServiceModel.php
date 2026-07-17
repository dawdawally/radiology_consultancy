<?php

declare(strict_types=1);

class ServiceModel extends BaseModel
{
    protected string $table = 'services';

    public function getPublished(): array
    {
        $stmt = $this->db->query('SELECT * FROM services WHERE is_published = 1 ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }

    public function countPublished(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM services WHERE is_published = 1')->fetchColumn();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE slug = ? AND is_published = 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO services (slug, title, icon, short_description, intro, challenge, approach, deliverables, benefits, meta_title, meta_description, sort_order, is_published)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['slug'], $data['title'], $data['icon'] ?? 'fa-cog',
            $data['short_description'], $data['intro'], $data['challenge'],
            $data['approach'], $data['deliverables'], $data['benefits'],
            $data['meta_title'], $data['meta_description'],
            $data['sort_order'] ?? 0, $data['is_published'] ?? 1,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE services SET slug=?, title=?, icon=?, short_description=?, intro=?, challenge=?, approach=?, deliverables=?, benefits=?, meta_title=?, meta_description=?, sort_order=?, is_published=? WHERE id=?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['slug'], $data['title'], $data['icon'] ?? 'fa-cog',
            $data['short_description'], $data['intro'], $data['challenge'],
            $data['approach'], $data['deliverables'], $data['benefits'],
            $data['meta_title'], $data['meta_description'],
            $data['sort_order'] ?? 0, $data['is_published'] ?? 1, $id,
        ]);
    }
}
