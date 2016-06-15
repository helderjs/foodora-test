<?php

namespace Foodora\Entity;

class VendorSchedule
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var int
     */
    private $vendorId;

    /**
     * @var int
     */
    private $weekDay;

    /**
     * @var int
     */
    private $allDay;

    /**
     * @var \DateTime
     */
    private $startHour;

    /**
     * @var \DateTime
     */
    private $stopHour;

    public function __construct(array $data)
    {
        $this->setId($data['id']);
        $this->setVendorId($data['vendor_id']);
        $this->setWeekDay($data['weekday']);
        $this->setAllDay($data['all_day']);
        $this->setStartHour(is_null($data['start_hour']) ? null : new \DateTime($data['start_hour']));
        $this->setStopHour(is_null($data['stop_hour']) ? null : new \DateTime($data['stop_hour']));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param int $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return int
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    /**
     * @param int $weekDay
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;
    }

    /**
     * @return int
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * @param int $allDay
     */
    public function setAllDay($allDay)
    {
        $this->allDay = $allDay;
    }

    /**
     * @return \DateTime
     */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /**
     * @param \DateTime $startHour
     */
    public function setStartHour(\DateTime $startHour = null)
    {
        $this->startHour = $startHour;
    }

    /**
     * @return \DateTime
     */
    public function getStopHour()
    {
        return $this->stopHour;
    }

    /**
     * @param \DateTime $stopHour
     */
    public function setStopHour(\DateTime $stopHour = null)
    {
        $this->stopHour = $stopHour;
    }
}
