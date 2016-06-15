<?php

namespace App\Database\Schema;

class Row implements \Iterator
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * @var int
     */
    private $key;

    /**
     * @var bool|\stdClass
     */
    private $result;

    /**
     * @var int
     */
    private $total;

    /**
     * Row constructor.
     * 
     * @param \PDOStatement $statement
     */
    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
        $this->total = $statement->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        $this->result = $this->statement->fetch(
            \PDO::FETCH_ASSOC,
            \PDO::FETCH_ORI_ABS,
            $this->key
        );
        
        return $this->result;
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->key++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->key < $this->total;

    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->key = 0;
    }
}