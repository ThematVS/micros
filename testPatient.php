<?php
require_once 'vendor/autoload.php';

use Micros\Entity\Patient;
use Micros\Foundation\Schema;

try {
    $schema = new Schema('Patient');
} catch (Exception $e) {
    echo 'Cannot create Patient schema', PHP_EOL;
    exit;
}

$patient = new Patient($schema);
//$patient->export();
print_r($patient->export());
