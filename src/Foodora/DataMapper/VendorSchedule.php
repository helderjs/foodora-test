<?php

namespace Foodora\DataMapper;

use App\Database\Connection;
use App\Database\Schema\Row;
use Foodora\Entity\VendorSchedule as VendorScheduleEntity;

class VendorSchedule extends Datamapper
{
    /**
     * @var Connection
     */
    private $dbal;

    public function __construct(Connection $dbal)
    {
        $this->dbal = $dbal;
    }

    /**
     * @param array $criteria
     * @return VendorScheduleEntity[]
     */
    public function findBy(array $criteria = [])
    {
        $sql = 'SELECT * FROM vendor_schedule';

        if (!empty($criteria)) {
            $where = [];
            
            foreach (array_keys($criteria) as $value) {
                $where[] = "{$value} = :{$value}";
            }
            
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        $statement = $this->dbal->prepare($sql);
        
        foreach ($criteria as $key => $value) {
            $statement->bindValue(":{$key}", $value);
        }

        $this->dbal->exec($statement);

        return $this->hydrate(new Row($statement), VendorScheduleEntity::class);
    }

    /**
     * @param array $criteria
     * @return VendorScheduleEntity|null
     */
    public function findOneBy(array $criteria = [])
    {
        $result = $this->findBy($criteria);
        
        return !empty($result) ? $result[0] : null;
    }

    public function insert(VendorScheduleEntity $vendorSchedule)
    {

        $sql = <<<SQL
INSERT INTO vendor_schedule (`vendor_id`,`weekday`,`all_day`,`start_hour`,`stop_hour`)
VALUES (:vendorId, :weekDay, :allDay, :startHour, :stopHour);
SQL;

        $statement = $this->dbal->prepare($sql);

        $statement->bindValue(':vendorId', $vendorSchedule->getVendorId());
        $statement->bindValue(':weekDay', $vendorSchedule->getWeekDay());
        $statement->bindValue(':allDay', $vendorSchedule->getAllDay());
        $statement->bindValue(':startHour', $vendorSchedule->getStartHour()->format('H:i:s'));
        $statement->bindValue(':stopHour', $vendorSchedule->getStopHour()->format('H:i:s'));

        if (!$this->dbal->exec($statement)) {
            return false;
        }

        
        $result = $this->dbal->prepare('SELECT LAST_INSERT_ID()');
        $this->dbal->exec($result);
        
        return $result->fetch(\PDO::FETCH_NUM)[0];
    }

    public function update(VendorScheduleEntity $vendorSchedule)
    {
        $sql = <<<SQL
UPDATE vendor_schedule
  SET vendor_id = :vendorId, weekday = :weekDay, all_day = :allDay, start_hour = :startHour,  stop_hour = :stopHour
  WHERE id = :id
SQL;

        $statement = $this->dbal->prepare($sql);

        $statement->bindValue(':id', $vendorSchedule->getId());
        $statement->bindValue(':vendorId', $vendorSchedule->getVendorId());
        $statement->bindValue(':weekDay', $vendorSchedule->getWeekDay());
        $statement->bindValue(':allDay', $vendorSchedule->getAllDay());
        $statement->bindValue(
            ':startHour',
            $vendorSchedule->getAllDay() ?null : $vendorSchedule->getStartHour()->format('H:i:s')
        );
        $statement->bindValue(
            ':stopHour',
            $vendorSchedule->getAllDay() ? null : $vendorSchedule->getStopHour()->format('H:i:s')
        );

        return $this->dbal->exec($statement);
    }

    public function delete(VendorScheduleEntity $vendorSchedule)
    {
        $sql = 'DELETE FROM vendor_schedule WHERE id = :id';

        $statement = $this->dbal->prepare($sql);

        $statement->bindValue(':id', $vendorSchedule->getId());

        return $this->dbal->exec($statement);
    }
}