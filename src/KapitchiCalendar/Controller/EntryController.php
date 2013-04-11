<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\Controller;

use KapitchiEntity\Controller\AbstractEntityController;

class EntryController extends AbstractEntityController
{
    
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('calendar/entry', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('calendar/entry', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
}
