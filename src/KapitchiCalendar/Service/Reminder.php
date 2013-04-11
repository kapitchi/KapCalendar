<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\Service;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Reminder extends \KapitchiEntity\Service\EntityService
{
    protected $entryService;
    
    /**
     * 
     * @param \KapCalendar\Entity\Entry $entry
     * @param \KapCalendar\Entity\Reminder $reminder
     */
    public function persistForEntry(\KapCalendar\Entity\Entry $entry, \KapCalendar\Entity\Reminder $reminder)
    {
        $triggerTime = $this->createTriggerTime($entry->getFromTime(), $reminder->getTimeSpan());
        
        $reminder->setEntryId($entry->getId());
        $reminder->setTriggerTime($triggerTime);
        
        $this->persist($reminder);
    }
    
    public function syncReminders(\KapCalendar\Entity\Entry $entry)
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
    
    public function setEnabledAllEntryReminders(\KapCalendar\Entity\Entry $entry, $enable = true)
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
    
    public function triggerReminder(\KapCalendar\Entity\Reminder $reminder)
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