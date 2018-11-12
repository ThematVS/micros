<?php
namespace Micros\Foundation;

class Entity implements Serializable
{
    private $schema;
    protected $className;
    protected $errors = [];

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

        if ($this->hasErrors()) {
            print_r($this->getErrors());
//            throw new \Exception('Bad data passed to build');
        }
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
        // check passed data before build
        // so something external wouldn't be able to overwrite non-storable properties
        if (!$this->isValid($data)) {
            $this->errors['build'] = $data;
            return false;
        }
        foreach ($data as $prop => $value) {
            $this->$prop = $value;
        }
        echo 'build entity ', static::class, PHP_EOL;
    }

    /**
     * Check whether entity is valid
     *
     * *@param array $data External data to check
     */
    public function isValid($data = null)
    {
        $data = $data ?: $this->export();

        $valid = $this->schema->valid($data);

        if (!$valid) {
            $this->errors['schema'] = $this->schema->getErrors();
        }
        return $valid;
    }

    public function hasErrors()
    {
        return sizeof($this->errors);
    }

    public function getErrors($scope = null)
    {
        return $scope && isset($this->errors[$scope]) ? $this->errors[$scope] : $this->errors;
    }

    /**
     * Get class name to determine descendant class name
     */
    protected function getClassName()
    {
        return substr(static::class, strrpos(static::class, '\\') + 1);
//        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Creates array of all entity properties that can be serialized
     *
     * It walks through schema and extracts persistable properties
     * @return array Ready-to-store array
     */
    public function export($asArray = true)
    {
        $properties = $this->schema->getProperties();

        $propClosure = function ($prop) {
            return $this->$prop;
        };
        $getProp = $propClosure->bindTo($this);

        $data = $asArray ? [] : new \stdClass();

        foreach ($properties as $prop) {
            $value = $getProp($prop);

            if ($asArray) {
                $data[$prop] = $value;
            } else {
                $data->$prop = $value;
            }

        }
        // if it's a service array, like for collections, get rid of it
        if (is_array($data) && isset($data['_data'])) {
            $data = $data['_data'];
        } elseif (isset($data->_data)) {
            $data = $data->_data;
        }
        return $data;
    }

    /**
     * Deserialize entity properties with given data
     *
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
