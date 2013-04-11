<?php
namespace KapitchiCalendar\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ReminderHydrator extends \Zend\Stdlib\Hydrator\ClassMethods
{
    public function extract($object) {
        $data = parent::extract($object);
        if($data['triggerTime'] instanceof \DateTime) {
            $data['triggerTime'] = $data['triggerTime']->format('Y-m-d\TH:i:sP');//UTC
        }
        if($data['readTime'] instanceof \DateTime) {
            $data['readTime'] = $data['readTime']->format('Y-m-d\TH:i:sP');//UTC
        }
        return $data;
    }

    public function hydrate(array $data, $object) {
        if(!empty($data['triggerTime']) && !$data['triggerTime'] instanceof \DateTime) {
            $data['triggerTime'] = new \DateTime($data['triggerTime']);
        }
        if(!empty($data['readTime']) && !$data['readTime'] instanceof \DateTime) {
            $data['readTime'] = new \DateTime($data['readTime']);
        }
        return parent::hydrate($data, $object);
    }
}