<?php
use Micros\Entity\Patient;
use Micros\Foundation\Schema;

$schema = new Schema('Patient');

$patient = new Patient($schema);
