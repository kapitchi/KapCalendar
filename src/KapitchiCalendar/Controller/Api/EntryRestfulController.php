<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\Controller\Api;

use Zend\View\Model\JsonModel,
    KapitchiEntity\Controller\EntityRestfulController;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class EntryRestfulController extends EntityRestfulController
{
    public function flagswitchAction()
    {
        $id = $this->getEntityId();
        if(!$this->getRequest()->isPut()) {//update
            throw new \Exception("Put method only");
        }
        $service = $this->getEntityService();
        $entity = $service->find($id);
        if(!$entity) {
            throw new \Exception("No entity found");
        }
        
        $value = $this->getPut()->get('value');
        
        $entity->setFlag($value);
        
        $service->persist($entity);
        
        $jsonModel = new JsonModel(array(
            'id' => $id,
            'entity' => $service->createArrayFromEntity($entity)
        ));
        
        return $jsonModel;
    }
    
    
}