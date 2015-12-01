<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:action][/:data]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'User',
                        'action'        => 'login',
                    ),
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
        ),
    ),
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div id="myInformationDiv" style="position:absolute; width:100%%; top:133px; "><div id="myInformationDiv2" align="center" style="position:absolute; width:100%%; display:block; color:#000;background-color:#319ebc; height:36px; font-family:Verdana, Geneva, sans-serif;">',
            'message_close_string'     => '</div></div>',
            'message_separator_string' => '</div><div id="myInformationDiv2" align="center" style="position:absolute; width:100%%; display:block; color:#000;background-color:#319ebc; height:36px; font-family:Verdana, Geneva, sans-serif;">'
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);
