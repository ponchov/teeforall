<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController',
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
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Campaign' => __DIR__ . '/../view',
        ),
    ),
);
