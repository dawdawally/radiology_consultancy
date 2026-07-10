<?php

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/SeedData.php';

$ref = new ReflectionClass('SeedData');
$method = $ref->getMethod('seedEquipment');
$method->setAccessible(true);
$method->invoke(null, Database::getInstance());

echo "Equipment data re-seeded successfully.\n";
