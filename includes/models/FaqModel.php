<?php

declare(strict_types=1);

class FaqModel extends BaseModel
{
    protected string $table = 'faqs';

    public function getPublished(): array
    {
        $stmt = $this->db->query('SELECT * FROM faqs WHERE is_published = 1 ORDER BY sort_order ASC, id ASC');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO faqs (question, answer, sort_order, is_published) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['question'],
            $data['answer'],
            $data['sort_order'] ?? 0,
            $data['is_published'] ?? 1,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE faqs SET question=?, answer=?, sort_order=?, is_published=? WHERE id=?'
        );
        return $stmt->execute([
            $data['question'],
            $data['answer'],
            $data['sort_order'] ?? 0,
            $data['is_published'] ?? 1,
            $id,
        ]);
    }
}
