<?php
namespace KapitchiCalendar\Model;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Entry extends \KapitchiEntity\Model\GenericEntityModel
{
    public function getType()
    {
        return $this->getExt('type');
    }
}