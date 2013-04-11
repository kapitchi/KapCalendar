<?php
namespace KapitchiCalendar\EntryType;

use Zend\ServiceManager\Config as ServiceConfig,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class EntryTypeManagerFactory implements FactoryInterface
{
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $pluginConfig = empty($config['kapitchi-calendar']['entry_types']) ? array() : $config['kapitchi-calendar']['entry_types'];
        
        $manager = new EntryTypeManager();
        
        $serviceConfig = new ServiceConfig($pluginConfig);
        $serviceConfig->configureServiceManager($manager);
        
        return $manager;
    }
}