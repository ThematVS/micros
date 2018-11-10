<?php
namespace Micros\Entity;

use Micros\Foundation\Entity;
use Micros\Foundation\AggregateEntity;
use Micros\Entity\Agreement;

/**
 * Agreement collection entity
 */
class AgreementCollection extends AggregateEntity
{
    protected $_data = [];

    /**
     * Build entity aggregates with all dependencies
     */
    protected function build($data)
    {
        foreach ($data as $item) {
            $this->add($item);
        }
    }

    public function add($obj)
    {
        if ($obj instanceof Agreement) {
            $this->_data[] = $obj;
            return true;
        }
        if (is_array($obj)) {
            $this->_data[] = Agreement::fromData($obj);
            return true;
        }
        return false;
    }
}
