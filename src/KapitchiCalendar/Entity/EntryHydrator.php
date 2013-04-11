<?php
namespace KapitchiCalendar\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class EntryHydrator extends \Zend\Stdlib\Hydrator\ClassMethods
{
    public function extract($object) {
        $data = parent::extract($object);
        if($data['fromTime'] instanceof \DateTime) {
            $data['fromTime'] = $data['fromTime']->format('Y-m-d\TH:i:sP');//UTC
        }
        if($data['untilTime'] instanceof \DateTime) {
            $data['untilTime'] = $data['untilTime']->format('Y-m-d\TH:i:sP');//UTC
        }
        return $data;
    }

    public function hydrate(array $data, $object) {
        if(!empty($data['fromTime']) && !$data['fromTime'] instanceof \DateTime) {
            $data['fromTime'] = new \DateTime($data['fromTime']);
        }
        if(!empty($data['untilTime']) && !$data['untilTime'] instanceof \DateTime) {
            $data['untilTime'] = new \DateTime($data['untilTime']);
        }
        return parent::hydrate($data, $object);
    }
}