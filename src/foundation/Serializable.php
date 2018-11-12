<?php
namespace Micros\Foundation;

/**
 * Allows storing object data in a compact way
 */
interface Serializable
{
    public function export($asArray = true);
    public function import(array $data);
}
