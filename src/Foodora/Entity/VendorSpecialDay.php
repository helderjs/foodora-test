<?php

namespace Foodora\Entity;

class VendorSpecialDay
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
     * @var \DateTime
     */
    private $specialDate;

    /**
     * @var string
     */
    private $eventType;

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

    /**
     * VendorSpecialDay constructor.
     * 
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setId($data['id']);
        $this->setVendorId($data['vendor_id']);
        $this->setSpecialDate(new \DateTime($data['special_date']));
        $this->setEventType($data['event_type']);
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
     * @return \DateTime
     */
    public function getSpecialDate()
    {
        return $this->specialDate;
    }

    /**
     * @param \DateTime $specialDate
     */
    public function setSpecialDate(\DateTime $specialDate)
    {
        $this->specialDate = $specialDate;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
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
