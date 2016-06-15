<?php

namespace App\Database;

use App\Database\Driver\Driver;

class MySql implements Connection
{
    /**
     * @var Driver
     */
    private $driver;

    /**
     * MySql constructor.
     *
     * @param \PDO $driver
     */
    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $query
     *
     * @return \PDOStatement
     */
    public function prepare($query)
    {
        return $this->driver->prepare($query, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
    }

    /**
     * @param string|\Traversable $statement
     * 
     * @return bool
     */
    public function exec($statement)
    {
        if (is_string($statement)) {
            $statement = $this->prepare($statement);
        }

        return $statement->execute();
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->driver->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->driver->commit();
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->driver->rollBack();
    }
}