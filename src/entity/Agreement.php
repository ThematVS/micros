<?php
namespace Micros\Entity;

use Micros\Foundation\Entity;

/**
 * Agreement entity
 */
class Agreement extends Entity
{
    protected $createdAt;
    protected $type;
    protected $photo;
/*
    protected function build($data)
    {
        parent::build($data);
        echo 'build Agreement', PHP_EOL;
    }
*/
}
