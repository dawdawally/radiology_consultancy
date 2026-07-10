<?php

declare(strict_types=1);

class TestimonialModel extends BaseModel
{
    protected string $table = 'testimonials';

    public function getPublished(): array
    {
        $stmt = $this->db->query('SELECT * FROM testimonials WHERE is_published = 1 ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO testimonials (client_name, organization, role, content, outcome_metric, rating, is_published, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['client_name'], $data['organization'], $data['role'] ?? null,
            $data['content'], $data['outcome_metric'] ?? null, $data['rating'] ?? 5,
            $data['is_published'] ?? 1, $data['sort_order'] ?? 0,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE testimonials SET client_name=?, organization=?, role=?, content=?, outcome_metric=?, rating=?, is_published=?, sort_order=? WHERE id=?'
        );
        return $stmt->execute([
            $data['client_name'], $data['organization'], $data['role'] ?? null,
            $data['content'], $data['outcome_metric'] ?? null, $data['rating'] ?? 5,
            $data['is_published'] ?? 1, $data['sort_order'] ?? 0, $id,
        ]);
    }
}
