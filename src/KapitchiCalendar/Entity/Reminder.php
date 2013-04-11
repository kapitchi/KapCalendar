<?php
namespace KapitchiCalendar\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Reminder
{
    protected $id;
    protected $entryId;
    protected $typeHandle;
    protected $timeSpan;//minutes before Entry::startTime
    protected $triggerTime;
    protected $readTime;
    protected $enabled;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEntryId()
    {
        return $this->entryId;
    }

    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;
    }

    public function getTypeHandle()
    {
        return $this->typeHandle;
    }

    public function setTypeHandle($typeHandle)
    {
        $this->typeHandle = $typeHandle;
    }
    
    public function getTimeSpan()
    {
        return $this->timeSpan;
    }

    public function setTimeSpan($timeSpan)
    {
        $this->timeSpan = $timeSpan;
    }
    
    public function getTriggerTime()
    {
        return $this->triggerTime;
    }

    public function setTriggerTime($triggerTime)
    {
        $this->triggerTime = $triggerTime;
    }
    
    public function getReadTime()
    {
        return $this->readTime;
    }

    public function setReadTime($readTime)
    {
        $this->readTime = $readTime;
    }
        
    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}