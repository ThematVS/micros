<?php
namespace Micros\Foundation;

class Entity implements Serializable
{
    private $schema;
    protected $className;

    public function __construct(Schema $schema = null, $data = [])
    {
        $this->className = $this->getClassName();

        if (!$schema) {
            // no schema provided, try to load proper one
            try {
                $schema = new Schema($this->className);
            } catch (Exception $e) {
                echo 'Cannot create ' . $this->className . ' schema', PHP_EOL;
                exit;
            }
        }
        $this->schema = $schema;
        // try to build object data
        $this->build($data);
    }

    public static function fromData(array $data)
    {
        // get fully qualified class name to avoid inclusion of multiple namespaces
        $class = '\\Micros\\Entity\\' . static::getClassName();
        return new $class(null, $data);
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
        return substr(static::class, strrpos(static::class, '\\') + 1);
//        return (new \ReflectionClass($this))->getShortName();
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
//        $properties = $this->schema->getProperties();

        $propClosure = function ($prop, $value) {
            $this->$prop = $value;
        };
        $setProp = $propClosure->bindTo($this);

        foreach ($data as $prop => $value) {
            $setProp($prop, $value);
        }
    }
}
