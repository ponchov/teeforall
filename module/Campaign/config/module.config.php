<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController',
            'Campaign\Controller\Info' => 'Campaign\Controller\InfoController',
            'Campaign\Controller\Account' => 'Campaign\Controller\AccountController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'campaign' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/campaign[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Campaign\Controller',
                        'controller'    => 'Campaign',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
            'info' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/:action',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Campaign\Controller',
                        'controller'    => 'Info',
                    ),
                    'constraints' => array(
                        'action'     => 'privacypolicy|termsofservice|shippingrates|contactus',
                    ),
                ),
            ),
            'myaccount' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/myaccount[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Campaign\Controller',
                        'controller'    => 'Account',
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
        'template_map' => array(
            'campaign/layout/myaccount' => __DIR__ . '/../view/layout/myaccount.phtml',
            'campaign/layout/header_1' => __DIR__ . '/../view/layout/header_1.phtml',
            'campaign/layout/footer_1' => __DIR__ . '/../view/layout/footer_1.phtml',
            'campaign/layout/left' => __DIR__ . '/../view/layout/left.phtml',
        ),
        'template_path_stack' => array(
            'Campaign' => __DIR__ . '/../view',
        ),
    ),
);
