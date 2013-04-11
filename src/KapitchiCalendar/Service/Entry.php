<?php
namespace KapitchiCalendar\Service;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Entry extends \KapitchiEntity\Service\EntityService
{
    protected $typeManager;
    
    public function loadModel($entity, $options = array(), EntityModelInterface $model = null)
    {
        $model = new \KapitchiCalendar\Model\Entry($entity);
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