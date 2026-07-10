<?php

declare(strict_types=1);

class EquipmentModel extends BaseModel
{
    protected string $table = 'equipment';

    public function getPublishedGrouped(): array
    {
        $stmt = $this->db->query('SELECT * FROM equipment WHERE is_published = 1 ORDER BY category ASC, sort_order ASC');
        $rows = $stmt->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['category']][] = $row;
        }
        return $grouped;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO equipment (category, name, description, icon, sort_order, is_published) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['category'], $data['name'], $data['description'],
            $data['icon'] ?? 'fa-microscope', $data['sort_order'] ?? 0, $data['is_published'] ?? 1,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE equipment SET category=?, name=?, description=?, icon=?, sort_order=?, is_published=? WHERE id=?');
        return $stmt->execute([
            $data['category'], $data['name'], $data['description'],
            $data['icon'] ?? 'fa-microscope', $data['sort_order'] ?? 0, $data['is_published'] ?? 1, $id,
        ]);
    }
}
