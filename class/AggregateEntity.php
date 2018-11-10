<?php
namespace Micros\Foundation;

abstract class AggregateEntity implements Serializable
{
    private $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
        $this->build();
    }

    /**
     * Build entity aggregates with all dependencies
     */
    protected function build()
    {
    }

    /**
     * Check whether entity is valid
     */
    protected function isValid()
    {
        $data = $this->export();

        return $this->schema->validate($data);
    }

    /**
     * Creates array of all entity properties that can be serialized
     */
    public function export()
    {
        $data = [];
        return $data;
    }

    /**
     * Deserialize entity properties with given data
     */
    public function import(array $data)
    {
        return $data;
    }
}
