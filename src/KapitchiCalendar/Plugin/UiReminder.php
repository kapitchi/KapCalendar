<?php
namespace KapitchiCalendar\Plugin;

use Zend\EventManager\EventInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class UiReminder implements \KapitchiApp\PluginManager\PluginInterface
{
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'TODO';
    }

    public function getName()
    {
        return '[KapitchiCalendar] UI calendar reminder';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $em->getSharedManager()->attach('KapitchiCalendar\Service\Reminder', 'triggerReminder', function ($e) {
                    
        });
    }
}