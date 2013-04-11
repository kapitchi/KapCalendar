<?php
namespace KapitchiCalendar\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Entry
{
    protected $id;
    protected $calendarId;
    protected $typeHandle;
    protected $fromTime;
    protected $untilTime;
    protected $data;
    protected $flag;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendarId()
    {
        return $this->calendarId;
    }

    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function getTypeHandle()
    {
        return $this->typeHandle;
    }

    public function setTypeHandle($typeHandle)
    {
        $this->typeHandle = $typeHandle;
    }

    public function getFromTime()
    {
        return $this->fromTime;
    }

    public function setFromTime($fromTime)
    {
        $this->fromTime = $fromTime;
    }

    public function getUntilTime()
    {
        return $this->untilTime;
    }

    public function setUntilTime($untilTime)
    {
        $this->untilTime = $untilTime;
    }
    
    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function getFlag()
    {
        return $this->flag;
    }

    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

}