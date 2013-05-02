<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar\EntryType;

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