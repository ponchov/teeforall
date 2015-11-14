<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Login' => 'Login\Controller\LoginController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/login[/][:action]',
                	'constraints' => array(
                		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                	),
                		
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller'    => 'Login',
                        'action'        => 'index',
                    ),
                ),
            	
            	'may_terminate' => true,
            	'child_routes' => array(
            		'log' => array(
            			'type'    => 'Segment',
            			'options' => array(
            			'route'    => '/login/log',
            				'constraints' => array(
            					'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            					'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            				),
            				'defaults' => array(
            					'__NAMESPACE__' => 'Login\Controller',
            					'controller'    => 'Login',
            					'action'        => 'log',
            				),
            			),
            		),
            	),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Login' => __DIR__ . '/../view',
        ),
    ),
		
	'service_manager' => array(
		'aliases' => array(
			'Zend\Authentication\AuthenticationService' => 'teeforall_auth_service',
		),
			
		'invokables' => array(
			'teeforall_auth_service' => 'Zend\Authentication\AuthenticationService',
		),
	),
);
