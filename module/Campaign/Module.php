<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Campaign for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Campaign;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Campaign\Form\TrackOrder' => 'Campaign\Form\Service\TrackOrderFactory',
                'Campaign\Form\AddDescription' => 'Campaign\Form\Service\AddDescriptionFactory',
                'Campaign\Form\Edit' => 'Campaign\Form\Service\EditFactory',
                'Campaign\Form\Setgoal' => 'Campaign\Form\Service\SetgoalFactory',
                'Campaign\Storage\Users' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\User());
                    $proto = App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('users', $sm->get('db'), null, $proto);
                    return Table\User($tableGateway);
                },
                'Campaign\Storage\Campaign' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\Campaign());
                    $proto = App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('launchcampaign', $sm->get('db'), null, $proto);
                    return Table\Campaign($tableGateway);
                },
            ),
        );
    }
}
