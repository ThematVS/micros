<?php
namespace Micros\Foundation;

use JsonSchema\SchemaStorage;
use JsonSchema\Validator as JsonValidator;
use JsonSchema\Constraints\Factory;

class Schema
{
    const PATH = 'schema/';
    private $className = '';
    private $schema = '';
    private $errors = [];
    private $validator = null;

    public function __construct(string $className)
    {
        $this->className = $className;
        $path = __DIR__ . '/../' . self::PATH . $className . '.json';

        $this->schema = json_decode(file_get_contents($path));

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \Exception('Cannot create schema (' . json_last_error_msg() . ')');
        }
        $this->validator = new JsonValidator();
    }

    public function valid($data)
    {
        return $this->validate($data);
    }

    public function getProperties()
    {
        //print_r($this->schema);
        return array_keys((array) $this->schema->properties);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Validate entity data
     * 
     * @param array|object|string $data Dataset to verify
     */
    private function validate($data)
    {
        $this->errors = [];

        if (is_string($data)) {
            $data = json_decode($data);
        } elseif (is_array($data)) {
            // this can be done recursively, but I haven't measured real timings
            $data = json_decode(json_encode($data));
        }
        // validator uses object type for both data and schema
        $this->validator->validate($data, $this->schema);

        if ($this->validator->isValid()) {
            return true;
        }
        $this->errors = $this->validator->getErrors();

        return false;
    }
}
