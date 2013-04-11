<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapCalendar;

use Zend\EventManager\EventInterface,
    Zend\ModuleManager\Feature\ControllerProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface,
	KapitchiBase\ModuleManager\AbstractModule,
    KapitchiEntity\Mapper\EntityDbAdapterMapper,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions;

class Module extends AbstractModule
    implements ServiceProviderInterface, ControllerProviderInterface, ViewHelperProviderInterface
{

	public function onBootstrap(EventInterface $e) {
		parent::onBootstrap($e);
		
        
	}
    
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'KapCalendar\Controller\Entry' => function($sm) {
                    $ins = new Controller\EntryController();
                    $ins->setEntityService($sm->getServiceLocator()->get('KapiCalendar\Service\Entry'));
                    return $ins;
                },
                //API
                'KapCalendar\Controller\Api\Entry' => function($sm) {
                    $ins = new Controller\Api\EntryRestfulController($sm->getServiceLocator()->get('KapCalendar\Service\Entry'));
                    return $ins;
                },
            )
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'calendarReminder' => function($sm) {
                    $ins = new View\Helper\Reminder(
                        $sm->getServiceLocator()->get('KapCalendar\Service\Reminder')
                    );
                    return $ins;
                },
                'calendarEntry' => function($sm) {
                    $ins = new View\Helper\Entry(
                        $sm->getServiceLocator()->get('KapCalendar\Service\Entry')
                    );
                    return $ins;
                },
            )
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'KapCalendar\Entity\Calendar' => 'KapCalendar\Entity\Calendar',
                'KapCalendar\Entity\Entry' => 'KapCalendar\Entity\Entry',
                'KapCalendar\Entity\Birthday' => 'KapCalendar\Entity\Birthday',
                'KapCalendar\Entity\Reminder' => 'KapCalendar\Entity\Reminder',
            ),
            'factories' => array(
                'KapCalendar\EntryType\EntryTypeManager' => 'KapCalendar\EntryType\EntryTypeManagerFactory',
                //Calendar
                'KapCalendar\Service\Calendar' => function($sm) {
                    $ins = new Service\Calendar(
                        $sm->get('KapCalendar\Mapper\CalendarDbAdapter'),
                        $sm->get('KapCalendar\Entity\Calendar'),
                        $sm->get('KapCalendar\Entity\CalendarHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapCalendar\Mapper\CalendarDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapCalendar\Entity\CalendarHydrator'),
                            'entityPrototype' => $sm->get('KapCalendar\Entity\Calendar'),
                        )),
                        $sm->get('KapCalendar\Entity\Calendar'),
                        $sm->get('KapCalendar\Entity\CalendarHydrator')
                    );
                },
                'KapCalendar\Entity\CalendarHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                
                //Entry
                'KapCalendar\Service\Entry' => function($sm) {
                    $ins = new Service\Entry(
                        $sm->get('KapCalendar\Mapper\EntryDbAdapter'),
                        $sm->get('KapCalendar\Entity\Entry'),
                        $sm->get('KapCalendar\Entity\EntryHydrator')
                    );
                    $ins->setTypeManager($sm->get('KapCalendar\EntryType\EntryTypeManager'));
                    //$s->setInputFilter($sm->get('KapAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapCalendar\Mapper\EntryDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapCalendar\Entity\EntryHydrator'),
                            'entityPrototype' => $sm->get('KapCalendar\Entity\Entry'),
                        )),
                        $sm->get('KapCalendar\Entity\Entry'),
                        $sm->get('KapCalendar\Entity\EntryHydrator')
                    );
                },
                'KapCalendar\Entity\EntryHydrator' => function ($sm) {
                    return new Entity\EntryHydrator(false);
                },
                //EntryRevision
                'KapCalendar\Service\EntryRevision' => function ($sm) {
                    $s = new Service\EntryRevision(
                        $sm->get('KapCalendar\Mapper\EntryRevisionDbAdapter'),
                        $sm->get('KapCalendar\Service\Entry')
                    );
                    return $s;
                },
                'KapCalendar\Mapper\EntryRevisionDbAdapter' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapCalendar\Entity\Entry'),
                        $sm->get('KapCalendar\Entity\EntryHydrator')
                    );
                },
                
                //Birthday
                'KapCalendar\Service\Birthday' => function($sm) {
                    $ins = new Service\Birthday(
                        $sm->get('KapCalendar\Mapper\BirthdayDbAdapter'),
                        $sm->get('KapCalendar\Entity\Birthday'),
                        $sm->get('KapCalendar\Entity\BirthdayHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapCalendar\Mapper\BirthdayDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry_birthday',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapCalendar\Entity\BirthdayHydrator'),
                            'entityPrototype' => $sm->get('KapCalendar\Entity\Birthday'),
                        )),
                        $sm->get('KapCalendar\Entity\Birthday'),
                        $sm->get('KapCalendar\Entity\BirthdayHydrator')
                    );
                },
                'KapCalendar\Entity\BirthdayHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                //Reminder
                'KapCalendar\Service\Reminder' => function($sm) {
                    $ins = new Service\Reminder(
                        $sm->get('KapCalendar\Mapper\ReminderDbAdapter'),
                        $sm->get('KapCalendar\Entity\Reminder'),
                        $sm->get('KapCalendar\Entity\ReminderHydrator')
                    );
                    $ins->setEntryService($sm->get('KapCalendar\Service\Entry'));
                    //$s->setInputFilter($sm->get('KapAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapCalendar\Mapper\ReminderDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_reminder',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapCalendar\Entity\ReminderHydrator'),
                            'entityPrototype' => $sm->get('KapCalendar\Entity\Reminder'),
                        )),
                        $sm->get('KapCalendar\Entity\Reminder'),
                        $sm->get('KapCalendar\Entity\ReminderHydrator')
                    );
                },
                'KapCalendar\Entity\ReminderHydrator' => function ($sm) {
                    return new Entity\ReminderHydrator(false);
                },
                
            )
        );
    }
    
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}