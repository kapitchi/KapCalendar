<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\EntryType;

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