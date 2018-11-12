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

    public function check()
    {
        if ($this->isValid()) {
            echo $this->className, ' valid', PHP_EOL;
        } else {
            echo $this->className, ' is not valid', PHP_EOL;
            print_r($this->getErrors());
            echo PHP_EOL;
        }
    }
}
