<?php

namespace Foodora\DataMapper;

use App\Database\Schema\Row;

abstract class Datamapper
{
    /**
     * @param Row $row
     * @param string $class
     * @return array
     */
    protected function hydrate(Row $row, $class)
    {
        $collection = [];
        foreach ($row as $data) {
            $collection[] = new $class($data);
        }

        return $collection;
    }
}