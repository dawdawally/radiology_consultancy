<?php

declare(strict_types=1);

class HomepageModel extends BaseModel
{
    protected string $table = 'homepage';

    public function getActiveSections(): array
    {
        $stmt = $this->db->query('SELECT * FROM homepage WHERE is_active = 1 ORDER BY sort_order ASC');
        $rows = $stmt->fetchAll();
        $sections = [];
        foreach ($rows as $row) {
            $sections[$row['section_key']] = $row;
        }
        return $sections;
    }

    public function getByKey(string $key): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM homepage WHERE section_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateSection(string $key, array $data): bool
    {
        $fields = [];
        $values = [];
        foreach ($data as $field => $value) {
            $fields[] = "{$field} = ?";
            $values[] = $value;
        }
        $values[] = $key;
        $sql = 'UPDATE homepage SET ' . implode(', ', $fields) . ' WHERE section_key = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}
