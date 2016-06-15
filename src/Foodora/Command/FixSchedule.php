<?php

namespace Foodora\Command;

use Foodora\DataMapper\VendorSchedule;
use Foodora\DataMapper\VendorSpecialDay;
use Foodora\Entity\VendorSchedule as VendorScheduleEntity;

class FixSchedule implements Command
{
    /**
     * @var \DateTime
     */
    private $from;

    /**
     * @var \DateTime
     */
    private $to;

    /**
     * @var VendorSchedule
     */
    private $scheduleMapper;

    /**
     * @var VendorSpecialDay
     */
    private $specialDayMapper;

    /**
     * @var string
     */
    private $backupFile;

    /**
     * FixSchedule constructor.
     *
     * @param VendorSchedule $scheduleMapper
     * @param VendorSpecialDay $specialDayMapper
     * @param \DateTime $from
     * @param \DateTime $to
     * @param string $backupFile
     */
    public function __construct(
        VendorSchedule $scheduleMapper,
        VendorSpecialDay $specialDayMapper,
        \DateTime $from,
        \DateTime $to,
        $backupFile
    )
    {
        $this->from = $from;
        $this->to = $to;
        $this->scheduleMapper = $scheduleMapper;
        $this->specialDayMapper = $specialDayMapper;
        $this->backupFile = $backupFile;
    }
    
    public function updateSchedule()
    {
        /**
         * @var \Foodora\Entity\VendorSpecialDay[] $specialDays
         */
        $specialDays = $this->specialDayMapper->findByPeriod($this->from, $this->to);

        if (empty($specialDays)) {
            return;
        }

        $fp = fopen($this->backupFile, 'w');

        foreach ($specialDays as $specialDay) {
            $vendorSchedule = $this->scheduleMapper->findOneBy(
                [
                    'vendor_id' => $specialDay->getVendorId(),
                    'weekday' => (int)$specialDay->getSpecialDate()->format('w') + 1,
                ]
            );

            if (!is_null($vendorSchedule)) {
                $backup = [
                    'U',
                    $vendorSchedule->getId(),
                    $vendorSchedule->getVendorId(),
                    $vendorSchedule->getWeekDay(),
                    $vendorSchedule->getAllDay(),
                    $vendorSchedule->getAllDay() ? null: $vendorSchedule->getStartHour()->format('H:i:s'),
                    $vendorSchedule->getAllDay() ? null : $vendorSchedule->getStopHour()->format('H:i:s'),
                ];

                if ($specialDay->getEventType() == "opened") {
                    $vendorSchedule->setAllDay($specialDay->getAllDay());
                    $vendorSchedule->setStartHour($specialDay->getStartHour());
                    $vendorSchedule->setStopHour($specialDay->getStopHour());

                    $this->scheduleMapper->update($vendorSchedule);
                } else {
                    $backup[0] = 'I';
                    $this->scheduleMapper->delete($vendorSchedule);
                }
            } else {
                $data = [
                    'id' => null,
                    'vendor_id' => $specialDay->getVendorId(),
                    'weekday' => (int)$specialDay->getSpecialDate()->format('w') + 1,
                    'all_day' => $specialDay->getAllDay(),
                    'start_hour' => $specialDay->getAllDay() ? null: $specialDay->getStartHour()->format('H:i:s'),
                    'stop_hour' => $specialDay->getAllDay() ? null : $specialDay->getStopHour()->format('H:i:s'),
                ];

                $vendorSchedule = new VendorScheduleEntity($data);
                $data['id'] = $this->scheduleMapper->insert($vendorSchedule);

                $backup = array_values($data);
                array_unshift($backup, 'D');
            }

            fputcsv(
                $fp,
                $backup
            );
        }

        fclose($fp);
    }
    
    public function execute()
    {
        $this->updateSchedule();
    }
}