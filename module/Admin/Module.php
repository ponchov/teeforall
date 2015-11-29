<?php
/*
 * DO NOT EDIT (unless you know what you are doing) - Jimmy :)
 *
 */

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Http;

use Admin\Model\Configuration;
use Admin\Model\ConfigurationModel;

use Admin\Model\EmailTemplatesModel;
use Admin\Model\EmailTemplates;

use Admin\Model\Pages;
use Admin\Model\PagesModel;

use Admin\Model\UsersModel;
use Admin\Model\Users;

use Admin\Model\TShirtDiscountModel;
use Admin\Model\TShirtDiscount;

use Admin\Model\TShirtIconsModel;
use Admin\Model\TShirtIcons;
use Admin\Model\TShirtPriceModel;
use Admin\Model\TShirtPrice;
use Admin\Model\TShirtProductsModel;
use Admin\Model\TShirtProducts;
use Admin\Model\TShirtSizeModel;
use Admin\Model\TShirtSize;


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

        $app = $e->getParam('application');
        $layout = $app->getMvcEvent()->getViewModel();

        $controller = $matches->getParam('controller');
        $module = strtolower(explode('\\', $controller)[0]);

        if ('admin' === $module) {
            $user = $app->getServiceManager()->get('teeforall_auth_service')->getIdentity();
            if (!$user) {
                $response = $e->getResponse();
                $response->setStatusCode(302);
                $response->getHeaders()->addHeaderLine('Location', '/login/log');

                return $response;
            }

            $layout->user1 = $user->username;
            $layout->setTemplate('admin/admin/layout');
        }
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Model\ConfigurationModel' => function($sm) {
                    $table_gateway = $sm->get('ConfigurationService');
                    $table = new ConfigurationModel($table_gateway);
                    return $table;
                },
                 
                'ConfigurationService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new Configuration());
                    return new TableGateway('admin_configurations', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\EmailTemplatesModel' => function($sm) {
                    $table_gateway = $sm->get('EmailTemplatesService');
                    $table = new EmailTemplatesModel($table_gateway);
                    return $table;
                },
                
                'EmailTemplatesService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new EmailTemplates());
                    return new TableGateway('email_templates', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\PagesModel' => function($sm) {
                    $table_gateway = $sm->get('PagesService');
                    $table = new PagesModel($table_gateway);
                    return $table;
                },
                
                'PagesService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new Pages());
                    return new TableGateway('pages', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\UsersModel' => function($sm) {
                    $table_gateway = $sm->get('UsersService');
                    $table = new UsersModel($table_gateway);
                    return $table;
                },
                
                'UsersService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new Users());
                    return new TableGateway('users', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\TShirtDiscountModel' => function($sm) {
                    $table_gateway = $sm->get('TShirtDiscountService');
                    $table = new TShirtDiscountModel($table_gateway);
                    return $table;
                },
                
                'TShirtDiscountService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new TShirtDiscount());
                    return new TableGateway('tshirt_discount', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\TShirtIconsModel' => function($sm) {
                    $table_gateway = $sm->get('TShirtIconsService');
                    $table = new TShirtIconsModel($table_gateway);
                    return $table;
                },
                
                'TShirtIconsService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new TShirtIcons());
                    return new TableGateway('tshirt_icons', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\TShirtPriceModel' => function($sm) {
                    $table_gateway = $sm->get('TShirtPriceService');
                    $table = new TShirtPriceModel($table_gateway);
                    return $table;
                },
                
                'TShirtPriceService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new TShirtPrice());
                    return new TableGateway('tshirt_price', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\TShirtProductsModel' => function($sm) {
                    $table_gateway = $sm->get('TShirtProductsService');
                    $table = new TShirtProductsModel($table_gateway);
                    return $table;
                },
                
                'TShirtProductsService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new TShirtProducts());
                    return new TableGateway('tshirt_products', $db_adapter, null, $result_set_prototype);
                },
                
                'Admin\Model\TShirtSizeModel' => function($sm) {
                    $table_gateway = $sm->get('TShirtSizeService');
                    $table = new TShirtSizeModel($table_gateway);
                    return $table;
                },
               
                'TShirtSizeService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new TShirtSize());
                    return new TableGateway('tshirt_sizes', $db_adapter, null, $result_set_prototype);
                },
            )
        );
    }
}
