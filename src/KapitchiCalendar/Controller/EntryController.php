<?php
namespace KapitchiCalendar\Controller;

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
