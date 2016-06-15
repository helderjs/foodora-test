<?php

namespace Foodora\DataMapper;

use App\Database\Connection;
use App\Database\Schema\Row;

class VendorSpecialDay extends Datamapper
{
    /**
     * @var Connection
     */
    private $dbal;

    public function __construct(Connection $dbal)
    {
        $this->dbal = $dbal;
    }

    public function findByPeriod(\DateTime $from, \DateTime $to)
    {
        $sql = 'SELECT * FROM vendor_special_day WHERE special_date BETWEEN :fromDate AND :toDate';
        
        $statement = $this->dbal->prepare($sql);

        $fromDate = $from->format('Y-m-d');
        $statement->bindParam(':fromDate', $fromDate);
        $toDate = $to->format('Y-m-d');
        $statement->bindParam(':toDate', $toDate);
        
        $this->dbal->exec($statement);
        
        return $this->hydrate(new Row($statement), \Foodora\Entity\VendorSpecialDay::class);
    }
}