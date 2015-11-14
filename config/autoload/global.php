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
    	'dsn'    => 'mysql:dbname=blocka_teeforall2;host=localhost',	
	),
    
    'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'teeforall-auth'
        ),
        	
        'invokables' => array(
            'teeforall-auth' => 'Zend\Authentication\AuthenticationService',
        ),
        	
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            // 'Navigation'              => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
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
