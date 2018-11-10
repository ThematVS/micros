<?php
namespace Micros\Foundation;

abstract class AggregateEntity extends Entity implements Serializable
{
    public function __construct(Schema $schema, $data = null)
    {
        parent::__construct($schema);
    }

    /**
     * Build entity aggregates with all dependencies
     */
    protected function build($data)
    {
        echo 'build aggregate', PHP_EOL;
    }

    /**
     * Creates array of all entity properties that can be serialized
     *
     * It walks through schema and extracts persistable properties
     */
    public function export()
    {
        // get properties
        $data = parent::export();

        foreach ($data as $key => $entity) {
            if ($entity instanceof Entity) {
                $data[$key] = $entity->export();
            }
        }

        return $data;
    }

    /**
     * Deserialize entity properties with given data
     *
     * It walks through schema and extracts persistable things
     */
    public function import(array $data)
    {
        return $data;
    }
}
