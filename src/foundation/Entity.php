<?php
namespace Micros\Foundation;

abstract class Entity implements Serializable
{
    private $schema;
    protected $className;

    public function __construct(Schema $schema, $data = null)
    {
        $this->schema = $schema;
        $this->className = $this->getClassName();

        $this->build($data);
    }

    /**
     * Build entity
     */
    protected function build($data)
    {
        foreach ($data as $prop => $value) {
            $this->$prop = $value;
        }
        echo 'build entity ', static::class, PHP_EOL;
    }

    /**
     * Check whether entity is valid
     */
    protected function isValid()
    {
        $data = $this->export();

        return $this->schema->validate($data);
    }

    protected function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Creates array of all entity properties that can be serialized
     *
     * It walks through schema and extracts persistable properties
     */
    public function export()
    {
        $properties = $this->schema->getProperties();

        $propClosure = function ($prop) {
            return $this->$prop;
        };
        $getProp = $propClosure->bindTo($this);

        $data = [];

        foreach ($properties as $prop) {
            $data[$prop] = $getProp($prop);
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
