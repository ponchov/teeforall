<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',
            'User\Controller\Account' => 'User\Controller\AccountController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'myaccount' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/myaccount[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
            'user' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);
