<?php

namespace User;

use Zend\Authentication;
use Zend\Session;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;
use Zend\Http;
use Zend\Mvc\ModuleRouteListener;

use App;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
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

    public function getValidatorConfig()
    {
        return array(
            'factories' => array(
                'EmailNotInUse' => function($sm) {
                    return new Validator\EmailNotInUse(
                        $sm->getServiceLocator()->get('User\Storage\User'),
                        $sm->getServiceLocator()->get('User\AuthService')
                    );
                },
            ),
        );
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
        
        $app = $e->getParam('application');
        $layout = $app->getMvcEvent()->getViewModel();
        $layout->loggedId = $app->getServiceManager()->get('User\AuthService')->getIdentity();

        if ('user' === $module) {
            $layout->controller = $controller;
            $layout->action = $action;

            /**
             * @todo set pagetitle in view of action
             */
            switch ($action) {
                case 'login':
                    $title = 'Login';
                    break;
                default:
                    $title = '';
                    break;
            }

            $layout->pageTitle = $title;

            switch ($action) {
                default:
                    $layout->setTemplate('campaign/layout/myaccount');
                    break;
            }
        }
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'User\Form\Login' => 'User\Form\Service\LoginFactory',
                'User\Form\Signup' => 'User\Form\Service\SignupFactory',
                'User\Form\ForgotPassword' => 'User\Form\Service\ForgotPasswordFactory',
                'User\Form\ResetPassword' => 'User\Form\Service\ResetPasswordFactory',
                'User\Storage\User' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\User());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('users', $sm->get('Zend\Db\Adapter\Adapter'), null, $proto);
                    return new Table\User($tableGateway);
                },
                'User\Storage\MailTemplate' => function($sm) {
                    $factory = new App\Entity\Service\SimpleFactory(new Entity\MailTemplate());
                    $proto = new App\Storage\Table\TableSimpleSet(null, $factory);
                    $tableGateway = new TableGateway('email_templates', $sm->get('Zend\Db\Adapter\Adapter'), null, $proto);
                    return new Table\MailTemplate($tableGateway);
                },
                'User\Service\Mail' => function($sm) {
                    $config = $sm->get('config');
                    return new Service\Mail(
                        $sm->get('User\Storage\MailTemplate'),
                        $config['mailer']['from']
                    );
                },
                'User\AuthService' => function($sm) {
                    $service = new Authentication\AuthenticationService();

                    $authAdapter = new Authentication\Adapter\DbTable(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        'users',
                        'username',
                        'password',
                        'md5(?) AND user_status = 1 AND active_status = 1'
                    );

                    $authStorage = new Authentication\Storage\Session('teeforall_user', null, $sm->get('User\SessionManager'));

                    $service->setAdapter($authAdapter);
                    $service->setStorage($authStorage);

                    return new Auth\AuthService(
                        $sm->get('User\Storage\User'),
                        $service,
                        $sm->get('User\SessionContainer')
                    );
                },
                'User\SessionContainer' => function($sm) {
                    $container = new Session\Container('user', $sm->get('User\SessionManager'));
                    return $container;
                },
                'User\SessionManager' => function($sm) {
                    $manager = new Session\SessionManager(null, new Session\Storage\SessionArrayStorage());
                    return $manager;
                },
            ),
        );
    }
}
