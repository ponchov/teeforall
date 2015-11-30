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
use Zend\Http;

use App;

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

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'configureLayout'));
    }

    public function configureLayout(MvcEvent $e)
    {
        $request = $e->getRequest();
        if (!$request instanceof Http\Request || $request->isXmlHttpRequest()) {
            return $e;
        }

        $matches = $e->getRouteMatch();
        if (!$matches) {
            return $e;
        }

        $controller = $matches->getParam('controller');
        $action = $matches->getParam('action');
        $module = strtolower(explode('\\', $controller)[0]);

        if ('campaign' === $module) {
            $app = $e->getParam('application');
            $layout = $app->getMvcEvent()->getViewModel();

            $layout->controller = $controller;
            $layout->action = $action;
            $layout->loggedId = false;

            switch ($action) {
                case 'recreation':
                    break;
                default:
                    $layout->setTemplate('campaign/campaign/myaccount');
                    break;
            }
        }
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Campaign\Form\TrackOrder' => 'Campaign\Form\Service\TrackOrderFactory',
                'Campaign\Form\AddDescription' => 'Campaign\Form\Service\AddDescriptionFactory',
                'Campaign\Form\Edit' => 'Campaign\Form\Service\EditFactory',
                'Campaign\Form\Setgoal' => 'Campaign\Form\Service\SetgoalFactory',
                'Campaign\Form\Buy' => 'Campaign\Form\Service\BuyFactory',
                'Campaign\States' => function($sm) {
                    return $sm->get('Campaign\Storage\State')->getOrderedByName();
                },
                'Campaign\Storage\Campaign' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\Campaign());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('launchcampaign', $sm->get('db'), null, $proto);
                    return new Table\Campaign($tableGateway);
                },
                'Campaign\Storage\State' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\State());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('state', $sm->get('db'), null, $proto);
                    return new Table\State($tableGateway);
                },
                'Campaign\Storage\TShirt\Discount' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\TShirt\Discount());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('tshirt_discount', $sm->get('db'), null, $proto);
                    return new Table\TShirt\Discount($tableGateway);
                },
                'Campaign\Storage\TShirt\Icon' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\TShirt\Icon());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('tshirt_icons', $sm->get('db'), null, $proto);
                    return new Table\TShirt\Icon($tableGateway);
                },
                'Campaign\Storage\TShirt\Price' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\TShirt\Price());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('tshirt_price', $sm->get('db'), null, $proto);
                    return new Table\TShirt\Price($tableGateway);
                },
                'Campaign\Storage\TShirt\Product' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\TShirt\Product());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('tshirt_products', $sm->get('db'), null, $proto);
                    return new Table\TShirt\Product($tableGateway);
                },
                'Campaign\Storage\TShirt\Size' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\TShirt\Size());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('tshirt_size', $sm->get('db'), null, $proto);
                    return new Table\TShirt\Size($tableGateway);
                },
            ),
        );
    }
}
