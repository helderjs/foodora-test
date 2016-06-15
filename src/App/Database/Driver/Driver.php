<?php

namespace App\Database\Driver;

use App\Database\Connection;

interface Driver
{
    /**
     * @param array $params
     * 
     * @return Connection
     */
    public function connect(array $params);
}