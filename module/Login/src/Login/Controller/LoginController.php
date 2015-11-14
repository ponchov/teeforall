<?php
/*
 * @author Jimmy
 * 
 * Login Page Controller
 */

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Session\SessionManager;


use Login\Form\LoginForm;
use Login\Model\Login;


class LoginController extends AbstractActionController
{
    public function indexAction() 
    {
        return $this->redirect()->toUrl('/login/log');
    }
    
    
    public function logAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('login/login/layout');
        
        $form = new LoginForm();
        
        $form->get('submit')->setValue('Login');
        
        $messages = null;
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $form_filters = new Login();
            
            $form->setInputFilter($form_filters->getInputFilter());
            
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
            
            // now we will see if the form is valid
            // we check if it is valid by the LoginForm class we created
            if ($form->isValid()) {
                // it is valid
                // assign $data to hold all the form data in an assoc. array 
                // e.g. $data = $form->getData(); $data['name'];
                $data = $form->getData();
                
                // get the service locator
                // call the service Zend\Db\Adapter\Adapter
                // set the credentials
                // and verify with $auth->authenticate()
                $sm = $this->getServiceLocator();
                
                $db_adapter = $sm->get('Zend\Db\Adapter\Adapter');
                
                $auth_adapter = new AuthAdapter($db_adapter, 'admins', 'username', 'password');
                
                $auth_adapter->setIdentity($data['admin_username'])
                    ->setCredential(hash('sha512', $data['admin_password']));
                
                $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                
                $result = $auth->authenticate($auth_adapter);
                
                // get the returned code
                // if the code is equal to Result::SUCCESS
                // store the information in the storage session handler
                // insert session into the sessions table
                // and redirect to admin page
                switch ($result->getCode()) {
                    case Result::FAILURE_IDENTITY_NOT_FOUND:
                        return $this->redirect()->toUrl('/login/login-failure');
                
                    case Result::FAILURE_CREDENTIAL_INVALID:
                        return $this->redirect()->toUrl('/login/login-failure');
                
                    case Result::SUCCESS:
                        $storage = $auth->getStorage();
                
                        $storage->write($auth_adapter->getResultRowObject(null, 'password'));
                
                        try {
                            $this->getLoginTable()->insertSession($data['username'], hash('sha512', $data['password']), session_id());
                        } catch (\Exception $e) {
                            return $this->redirect()->toUrl('/login/login-failure');
                        }
                
                        if ($result->getCode() == 1) {
                            return $this->redirect()->toUrl('/admin');
                        }
                
                
                }
                
                foreach ($result->getMessages() as $message) {
                    $messages .= "$message\n";
                }
                
            
                $view = new ViewModel(array('form' => $form, 'messages' => $messages));
                
                return $view;
            }
        }
    }
    
    public function loginfailureAction()
    {
        $view = new ViewModel(array('error' => 'Login Error'));
         
        $view->setTerminal(true);
         
        return $view;
    }
    
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
         
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
    
            $this->getLoginTable()->deleteSession($identity->username);
        }
         
        $auth->clearIdentity();
         
        $session_manager = new SessionManager();
        $session_manager->forgetMe();
         
        return $this->redirect()->toUrl('/login/log');
    }
    
    
    public function getLoginTable()
    {
        if (!$this->login_table) {
            $sm = $this->getServiceLocator();
            $this->login_table = $sm->get('Login\Model\LoginModel');
        }
         
         
        return $this->login_table;
    }
}
