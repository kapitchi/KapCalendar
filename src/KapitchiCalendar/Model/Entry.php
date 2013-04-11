<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\Model;

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