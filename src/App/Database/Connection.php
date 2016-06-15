<?php

namespace App\Database;

use App\Database\Schema\Row;

interface Connection
{
    /**
     * @param string $query
     * @return \Traversable
     */
    public function prepare($query);

    /**
     * @param string|\Traversable $statement
     * @return Row
     */
    public function exec($statement);

    /**
     * @return bool
     */
    public function beginTransaction();

    /**
     * @return bool
     */
    public function commit();

    /**
     * @return bool
     */
    public function rollback();
}