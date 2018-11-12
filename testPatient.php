<?php
require_once 'vendor/autoload.php';

use Micros\Entity\Patient;
use Micros\Entity\Agreement;
use Micros\Foundation\Schema;

try {
    $schema = new Schema('Patient');
} catch (Exception $e) {
    echo 'Cannot create Patient schema', PHP_EOL;
    exit;
}

$patient = new Patient($schema);
//$patient->export();
/*
$patient->addAgreement(new Agreement(new Schema('Agreement'), [
    'createdAt' => '2018-09-23',
    'type' => 'Surgery',
    'photo' => 'scan_surgery.jpg',
]));
*/
/*
$patient->addAgreement(Agreement::fromData([
    'createdAt' => '2018-09-23',
    'type' => 'Surgery',
    'photo' => 'scan_surgery.jpg',
]));
*/

$patient->addAgreement([
    'createdAt' => '2018-09-23T00:00:00z',
    'type' => 'Surgery',
    'photo' => 'scan_surgery.jpg',
]);

print_r($patient->export());
