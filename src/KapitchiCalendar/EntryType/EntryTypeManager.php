<?php

namespace KapitchiCalendar\EntryType;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class EntryTypeManager extends AbstractPluginManager
{
    /**
     * TODO - implement according the spec of AbstractPluginManager
     */
    public function validatePlugin($plugin)
    {
        if(!$plugin instanceof EntryTypeInterface) {
            throw new \Exception("Not EntryTypeInterface object");
        }
        
    }
}