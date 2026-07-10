<?php

declare(strict_types=1);

class SettingsModel extends BaseModel
{
    protected string $table = 'website_settings';

    public function getAll(): array
    {
        $rows = $this->db->query('SELECT setting_key, setting_value FROM website_settings')->fetchAll();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function set(string $key, ?string $value): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO website_settings (setting_key, setting_value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );
        return $stmt->execute([$key, $value]);
    }

    public function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }
}
