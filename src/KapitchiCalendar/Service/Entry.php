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
class Entry extends \KapitchiEntity\Service\EntityService
{
    protected $typeManager;
    
    public function loadModel($entity, $options = array(), EntityModelInterface $model = null)
    {
        $model = new \KapCalendar\Model\Entry($entity);
        $type = $this->getTypeManager()->get($entity->getTypeHandle());
        //$typeEntity = $ser->findOneBy(array(
            //'entryId' => $entity->getId()
        //));
        $model->setExt('type', $type);
        
        parent::loadModel($entity, $options, $model);
        
        return $model;
    }
    
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    public function setTypeManager($typeManager)
    {
        $this->typeManager = $typeManager;
    }
}