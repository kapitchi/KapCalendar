<?php

namespace KapitchiCalendar;

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
                'KapitchiCalendar\Controller\Entry' => function($sm) {
                    $ins = new Controller\EntryController();
                    $ins->setEntityService($sm->getServiceLocator()->get('KapitchiCalendar\Service\Entry'));
                    return $ins;
                },
                //API
                'KapitchiCalendar\Controller\Api\Entry' => function($sm) {
                    $ins = new Controller\Api\EntryRestfulController($sm->getServiceLocator()->get('KapitchiCalendar\Service\Entry'));
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
                        $sm->getServiceLocator()->get('KapitchiCalendar\Service\Reminder')
                    );
                    return $ins;
                },
                'calendarEntry' => function($sm) {
                    $ins = new View\Helper\Entry(
                        $sm->getServiceLocator()->get('KapitchiCalendar\Service\Entry')
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
                'KapitchiCalendar\Entity\Calendar' => 'KapitchiCalendar\Entity\Calendar',
                'KapitchiCalendar\Entity\Entry' => 'KapitchiCalendar\Entity\Entry',
                'KapitchiCalendar\Entity\Birthday' => 'KapitchiCalendar\Entity\Birthday',
                'KapitchiCalendar\Entity\Reminder' => 'KapitchiCalendar\Entity\Reminder',
            ),
            'factories' => array(
                'KapitchiCalendar\EntryType\EntryTypeManager' => 'KapitchiCalendar\EntryType\EntryTypeManagerFactory',
                //Calendar
                'KapitchiCalendar\Service\Calendar' => function($sm) {
                    $ins = new Service\Calendar(
                        $sm->get('KapitchiCalendar\Mapper\CalendarDbAdapter'),
                        $sm->get('KapitchiCalendar\Entity\Calendar'),
                        $sm->get('KapitchiCalendar\Entity\CalendarHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapitchiAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapitchiCalendar\Mapper\CalendarDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiCalendar\Entity\CalendarHydrator'),
                            'entityPrototype' => $sm->get('KapitchiCalendar\Entity\Calendar'),
                        )),
                        $sm->get('KapitchiCalendar\Entity\Calendar'),
                        $sm->get('KapitchiCalendar\Entity\CalendarHydrator')
                    );
                },
                'KapitchiCalendar\Entity\CalendarHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                
                //Entry
                'KapitchiCalendar\Service\Entry' => function($sm) {
                    $ins = new Service\Entry(
                        $sm->get('KapitchiCalendar\Mapper\EntryDbAdapter'),
                        $sm->get('KapitchiCalendar\Entity\Entry'),
                        $sm->get('KapitchiCalendar\Entity\EntryHydrator')
                    );
                    $ins->setTypeManager($sm->get('KapitchiCalendar\EntryType\EntryTypeManager'));
                    //$s->setInputFilter($sm->get('KapitchiAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapitchiCalendar\Mapper\EntryDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiCalendar\Entity\EntryHydrator'),
                            'entityPrototype' => $sm->get('KapitchiCalendar\Entity\Entry'),
                        )),
                        $sm->get('KapitchiCalendar\Entity\Entry'),
                        $sm->get('KapitchiCalendar\Entity\EntryHydrator')
                    );
                },
                'KapitchiCalendar\Entity\EntryHydrator' => function ($sm) {
                    return new Entity\EntryHydrator(false);
                },
                //EntryRevision
                'KapitchiCalendar\Service\EntryRevision' => function ($sm) {
                    $s = new Service\EntryRevision(
                        $sm->get('KapitchiCalendar\Mapper\EntryRevisionDbAdapter'),
                        $sm->get('KapitchiCalendar\Service\Entry')
                    );
                    return $s;
                },
                'KapitchiCalendar\Mapper\EntryRevisionDbAdapter' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapitchiCalendar\Entity\Entry'),
                        $sm->get('KapitchiCalendar\Entity\EntryHydrator')
                    );
                },
                
                //Birthday
                'KapitchiCalendar\Service\Birthday' => function($sm) {
                    $ins = new Service\Birthday(
                        $sm->get('KapitchiCalendar\Mapper\BirthdayDbAdapter'),
                        $sm->get('KapitchiCalendar\Entity\Birthday'),
                        $sm->get('KapitchiCalendar\Entity\BirthdayHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapitchiAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapitchiCalendar\Mapper\BirthdayDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_entry_birthday',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiCalendar\Entity\BirthdayHydrator'),
                            'entityPrototype' => $sm->get('KapitchiCalendar\Entity\Birthday'),
                        )),
                        $sm->get('KapitchiCalendar\Entity\Birthday'),
                        $sm->get('KapitchiCalendar\Entity\BirthdayHydrator')
                    );
                },
                'KapitchiCalendar\Entity\BirthdayHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                //Reminder
                'KapitchiCalendar\Service\Reminder' => function($sm) {
                    $ins = new Service\Reminder(
                        $sm->get('KapitchiCalendar\Mapper\ReminderDbAdapter'),
                        $sm->get('KapitchiCalendar\Entity\Reminder'),
                        $sm->get('KapitchiCalendar\Entity\ReminderHydrator')
                    );
                    $ins->setEntryService($sm->get('KapitchiCalendar\Service\Entry'));
                    //$s->setInputFilter($sm->get('KapitchiAuction\Entity\AuctionInputFilter'));
                    return $ins;
                },
                'KapitchiCalendar\Mapper\ReminderDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'calendar_reminder',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiCalendar\Entity\ReminderHydrator'),
                            'entityPrototype' => $sm->get('KapitchiCalendar\Entity\Reminder'),
                        )),
                        $sm->get('KapitchiCalendar\Entity\Reminder'),
                        $sm->get('KapitchiCalendar\Entity\ReminderHydrator')
                    );
                },
                'KapitchiCalendar\Entity\ReminderHydrator' => function ($sm) {
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