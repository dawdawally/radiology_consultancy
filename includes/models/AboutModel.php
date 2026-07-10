<?php

declare(strict_types=1);

class AboutModel extends BaseModel
{
    protected string $table = 'about';

    public function getSections(): array
    {
        $stmt = $this->db->query('SELECT * FROM about ORDER BY sort_order ASC');
        $rows = $stmt->fetchAll();
        $sections = [];
        foreach ($rows as $row) {
            $sections[$row['section_key']] = $row;
        }
        return $sections;
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
        $sql = 'UPDATE about SET ' . implode(', ', $fields) . ' WHERE section_key = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}
