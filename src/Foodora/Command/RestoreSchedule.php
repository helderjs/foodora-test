<?php

namespace Foodora\Command;

use Foodora\DataMapper\VendorSchedule;
use Foodora\Entity\VendorSchedule as VendorScheduleEntity;

class RestoreSchedule implements Command
{
    /**
     * @var VendorSchedule
     */
    private $scheduleMapper;

    /**
     * @var string
     */
    private $backupFile;

    private $scheduleMap = [
        'id',
        'vendor_id',
        'weekday',
        'all_day',
        'start_hour',
        'stop_hour',
    ];

    /**
     * FixSchedule constructor.
     *
     * @param VendorSchedule $scheduleMapper
     * @param string $backupFile
     */
    public function __construct(
        VendorSchedule $scheduleMapper,
        $backupFile
    )
    {
        $this->scheduleMapper = $scheduleMapper;
        $this->backupFile = $backupFile;
    }
    
    public function restore()
    {
        $fp = fopen($this->backupFile, 'r');

        while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
            $operation = $data[0];

            unset($data[0]);
            $vendorSchedule = new VendorScheduleEntity(array_combine($this->scheduleMap, $data));
            
            if ($operation == 'I') {
                $this->scheduleMapper->insert($vendorSchedule);
            } elseif ($operation == 'U') {
                $this->scheduleMapper->update($vendorSchedule);
            } else {                
                $this->scheduleMapper->delete($vendorSchedule);
            }
        }
        
        fclose($fp);
    }
    
    public function execute()
    {
        $this->restore();
    }
}