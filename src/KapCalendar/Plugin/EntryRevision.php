<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class EntryRevision implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'This enables revision service for entries';
    }

    public function getName()
    {
        return '[KapCalendar] Revision enabler for Entry';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $em->getSharedManager()->attach('KapCalendar\Service\Entry', 'persist', function($e) use ($sm) {
            $revService = $sm->get('KapCalendar\Service\EntryRevision');
            $revision = $revService->createEntityRevision($e->getParam('entity'));
            
            $data = $e->getParam('data', false);
            if($data && isset($data['revision']['revisionLog'])) {
                $revision->setRevisionLog($data['revision']['revisionLog']);
                $revService->persist($revision);
            }
        }, 0);
    }
    
}