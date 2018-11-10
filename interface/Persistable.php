<?php
namespace Micros\Foundation;

/**
 * Allows storing and retrieving object data from a persistent storage
 * Parsistable object iterates over its associates and presents ready-to-go dataset
 */
interface Persistable
{
    public function export();
    public function import($data);
    public function update($data);
    public function replace($data);
}
