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
        if (is_object($obj) && !$obj instanceof Agreement) {
            throw new \Exception('Instance of Agreement required');
        }
        if (is_array($obj)) {
            $obj = Agreement::fromData($obj);
        }
//$obj->check();
        $this->_data[] = $obj;
        return true;
    }
}
