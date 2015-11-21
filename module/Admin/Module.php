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

use Admin\Model\Configuration;
use Admin\Model\ConfigurationModel;

use Admin\Model\EmailTemplatesModel;
use Admin\Model\EmailTemplates;

use Admin\Model\Pages;
use Admin\Model\PagesModel;
use Admin\Model\CategoriesModel;
use Admin\Model\Categories;


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
                
                'Admin\Model\CategoriesModel' => function($sm) {
                    $table_gateway = $sm->get('CategoriesService');
                    $table = new CategoriesModel($table_gateway);
                    return $table;
                },
                
                'CategoriesService' => function($sm) {
                    $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $result_set_prototype = new ResultSet();
                    $result_set_prototype->setArrayObjectPrototype(new Categories());
                    return new TableGateway('categories', $db_adapter, null, $result_set_prototype);
                },
                
                
             ),
         );
    }
}
