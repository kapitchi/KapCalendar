<?php
return array(
    'kap-calendar' => array(
        'entry_types' => array(
            'factories' => array(
                'birthday' => function($sm) {
                    $ins = $sm->getServiceLocator()->get('KapCalendar\Service\Birthday');
                    return $ins;
                }
            )
        )
    ),
    'plugin_manager' => array(
        'invokables' => array(
            //TODO disabled until fully implemented
            //'Calendar/UiReminder' => 'KapCalendar\Plugin\UiReminder',
            //'Calendar/EntryRevision' => 'KapCalendar\Plugin\EntryRevision',
        ),
    ),
    'controller_plugins' => array(
        'classes' => array(
            //'test' => 'Test\Controller\Plugin\Test'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            //'test/index/index'   => __DIR__ . '/../view/test/index/index.phtml',
        ),
        'template_path_stack' => array(
            //'test' => __DIR__ . '/../view',
        ),
        'helper_map' => array(
            //'js'        => 'Test\View\Helper\Js',
        ),

    ),
    'router' => array(
        'routes' => array(
            'calendar' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/calendar',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapCalendar\Controller',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'entry' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/entry[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Entry',
                            ),
                        ),
                    ),
                    'api' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/api',
                            'defaults' => array(
                                '__NAMESPACE__' => 'KapCalendar\Controller\Api',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'entry' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/entry[/:id][/:action]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Entry',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
