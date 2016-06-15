<?php

namespace App\Database\Driver;

class MySql implements Driver
{
    /**
     * @param array $params
     * @return \App\Database\MySql
     * @throws \Exception
     */
    public function connect(array $params)
    {
        try {
            $pdo = new \PDO($this->buildDsn($params), $params['username'], $params['password']);
        } catch (\PDOException $e) {
            throw new \Exception('Fail to connect database', $e->getCode(), $e);
        }

        return new \App\Database\MySql($pdo);
    }

    /**
     * @return string
     */
    private function buildDsn(array $params)
    {
        $dsn = "mysql:host={$params['hostname']};port={$params['port']};dbname={$params['dbname']}";
        
        return $dsn;
    }
}