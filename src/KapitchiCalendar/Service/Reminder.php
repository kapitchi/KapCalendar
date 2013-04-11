<?php
namespace KapitchiCalendar\Service;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Reminder extends \KapitchiEntity\Service\EntityService
{
    protected $entryService;
    
    /**
     * 
     * @param \KapitchiCalendar\Entity\Entry $entry
     * @param \KapitchiCalendar\Entity\Reminder $reminder
     */
    public function persistForEntry(\KapitchiCalendar\Entity\Entry $entry, \KapitchiCalendar\Entity\Reminder $reminder)
    {
        $triggerTime = $this->createTriggerTime($entry->getFromTime(), $reminder->getTimeSpan());
        
        $reminder->setEntryId($entry->getId());
        $reminder->setTriggerTime($triggerTime);
        
        $this->persist($reminder);
    }
    
    public function syncReminders(\KapitchiCalendar\Entity\Entry $entry)
    {
        $reminders = $this->getPaginator(array(
            'entryId' => $entry->getId()
        ));
        
        foreach($reminders as $reminder) {
            $triggerTime = $this->createTriggerTime($entry->getFromTime(), $reminder->getTimeSpan());
            $reminder->setTriggerTime($triggerTime);
            $this->persist($reminder);
        }
    }
    
    public function setEnabledAllEntryReminders(\KapitchiCalendar\Entity\Entry $entry, $enable = true)
    {
        $entities = $this->getPaginator(array(
            'entryId' => $entry->getId()
        ));
        
        foreach($entities as $entity) {
            $entity->setEnabled($enable);
            $this->persist($entity);
        }
    }


    protected function createTriggerTime(\DateTime $dateTime, $timeSpan)
    {
        $timeSpanAbs = abs($timeSpan);
        $timeInterval = new \DateInterval("PT{$timeSpanAbs}M");
        if($timeSpan < 0) {
            $timeInterval->invert = 1;
        }

        $triggerTime = clone $dateTime;
        $triggerTime->add($timeInterval);
        return $triggerTime;
    }

    public function triggerAllReminders()
    {
        $now = date('Y-m-d H:i:s');
        $paginator = $this->getPaginator(array(
            'triggerTime <= ?' => $now,
            'enabled' => true
        ));
        
        foreach($paginator as $reminder) {
            $this->triggerReminder($reminder);
        }
    }
    
    public function triggerReminder(\KapitchiCalendar\Entity\Reminder $reminder)
    {
        
        $this->triggerEvent('triggerReminder', array(
            'reminder' => $reminder
        ));
        
    }
    
    public function getEntryService()
    {
        return $this->entryService;
    }

    public function setEntryService($entryService)
    {
        $this->entryService = $entryService;
    }
    
}