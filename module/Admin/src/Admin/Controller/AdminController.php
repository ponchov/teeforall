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
use Admin\Model\EmailTemplates;
use Admin\Form\EmailTemplateForm;



class AdminController extends AbstractActionController
{
    protected $configuration_service;
    protected $email_tpl_service;
    
    
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
    
    
    public function emailtemplatesAction()
    {
        return new ViewModel(array('email_tpls' => $this->getEmailTemplatesService()->getEmailTemplates()));
    }
    
    
    public function edittemplateAction()
    {
        // set the form to be used in the edit template view
        $form = new EmailTemplateForm();
    
        return new ViewModel(array('form' => $form, 'id' => $this->params()->fromPost('eID')));
    }
    
    public function updatetemplatesAction()
    {
        // set the form to be used in the update templates view
        $form = new EmailTemplateForm();
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $email = new EmailTemplates();
        
            $form->setInputFilter($email->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the ConfigurationForm class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $email->exchangeArray($form->getData());
        
                if ($this->getEmailTemplatesService()->modifyEmailTemplate($email,
                    $this->params()->fromPost('eID')) === true) {
                        // the updated email template was inserted into the database successfully
                        // redirect to email template view
                        return $this->redirect()->toUrl('/admin/email-template');
                    } else {
                        // error occured..
                        // the error is logged automatically
                        // redirect to email template view
                        return $this->redirect()->toUrl('/email-template');
                    }
            }
        }
        
        return new ViewModel(array('template_id' => $this->params()->fromPost('eID')));
    }

    
    
    public function deletetemplatesAction()
    {
        $e_id = $this->params()->fromPost('eID');
        
        if (!empty($e_id)) {
            // delete the template
            $email = new EmailTemplates();
            
            if (false !== $this->getEmailTemplatesService()->deleteEmailTemplate($email, $e_id)) {
                // don't do anything, ajax call will handle redirect 
            }
        }
    }
    
    
   
    
    
    
    
    /* DO NOT CHANGE THE BELOW CODE UNLESS YOU KNOW WHAT YOU ARE DOING!! */
    
    public function getConfigurationService()
    {
        if (!$this->configuration_service) {
            $sm = $this->getServiceLocator();
            
            $this->configuration_service = $sm->get('Admin\Model\AdminModel');
        }
        
        return $this->configuration_service;
    }
    
    
    public function getEmailTemplatesService()
    {
        if (!$this->email_tpl_service) {
            $sm = $this->getServiceLocator();
            
            $this->email_tpl_service = $sm->get('Admin\Model\EmailTemplatesModel');
        }
        
        return $this->email_tpl_service;
    }
}
