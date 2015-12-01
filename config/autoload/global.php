<?php
// DO NOT EDIT unless you know what you are doing :) - Jimmy

function exception_error_handler($severity, $message, $file, $line)
{
    if (!error_reporting() & $severity) {
        return;
    }

    throw new ErrorException($message, 0, $severity, $file, $line);
}


set_error_handler("exception_error_handler");


return array(
    'db' => array(
    	'driver' => 'Pdo',
    	'dsn'    => 'mysql:dbname=blockta_teeforall2;host=127.0.0.1',	
	),
    
    'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'teeforall_auth_service'
        ),
        	
        'invokables' => array(
            'teeforall_auth_service' => 'Zend\Authentication\AuthenticationService',
        ),
        	
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            // 'Navigation'              => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),

    'mailer'    =>  array(
        'from' => 'some@some.com',
    ),
    
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'teeforall',
            ),
        ),
        	
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    ),
);
