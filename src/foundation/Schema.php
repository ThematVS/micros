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
            throw new \Exception(json_last_error_msg());
        }
        $this->validator = new JsonValidator();
    }

    public function validateFromString(string $data)
    {
        return $this->validate(json_decode($data));
    }

    public function validateFromArray(array $data)
    {
        return $this->validate($data);
    }

    public function getProperties()
    {
        //print_r($this->schema);
        return array_keys((array) $this->schema->properties);
    }

    private function validate(array $data)
    {
        $this->errors = [];

        $this->validator->validate($data, (object) $this->schema);

        if ($validator->isValid()) {
            return true;
        }
        $this->errors = $validator->getErrors();

        return false;
    }
}
