<?php
/*
 * @author Jimmy
 * 
 * Admin Page Controller
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Admin\Form\ConfigurationForm;
use Admin\Model\Configuration;



class AdminController extends AbstractActionController
{
    protected $configuration_service;
    
    public function indexAction()
    {
        // set the layout to be the admin layout
        $layout = $this->layout();
        $layout->setTemplate('admin/admin/layout');
    }

    
    public function configurationAction()
    {
        // set the form to be displayed in the configuration view
        $form = new ConfigurationForm();
        
        $messages = null;
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $config = new Configuration();
            
            $form->setInputFilter($config->getInputFilter());
            
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
           
            // now we will see if the form is valid
            // we check if it is valid by the ConfigurationForm class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $config->exchangeArray($form->getData());
                
                if ($this->getConfigurationService()->handleConfiguration($config) === true) {
                    // the configuration data was inserted into the database successfully
                    // redirect to configuration success view
                    return $this->redirect()->toUrl('/admin/configuration-success');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to configuration failure view
                    return $this->redirect()->toUrl('/admin/configuration-failure');
                }
            }
        }
        
        return new ViewModel(array('form' => $form, 'messages' => $messages));
    }
    
    
    public function configurationsuccessAction()
    {
        // don't really need to do anything here
        // just here so we can call the view
    }
    
    
    public function configurationfailureAction()
    {
        // don't really need to do anything here
        // just here so we can call the view
    }
    public function getConfigurationService()
    {
        if (!$this->configuration_service) {
            $sm = $this->getServiceLocator();
            
            $this->configuration_service = $sm->get('Admin\Model\AdminModel');
        }
        
        return $this->configuration_service;
    }
}
