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
use Admin\Form\PagesForm;
use Admin\Model\Pages;




class AdminController extends AbstractActionController
{
    protected $configuration_service;
    protected $email_tpl_service;
    protected $pages_service;
    protected $users_service;
    
    
    public function indexAction()
    {
        // set the layout to be the admin layout
        $layout = $this->layout();
        $layout->setTemplate('admin/admin/layout');
    }

    /////////////////////////////////////////////
    // configuration actions
    /////////////////////////////////////////////
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
    
    
    /////////////////////////////////////////////
    // email template actions
    /////////////////////////////////////////////
    public function emailtemplatesAction()
    {
        return new ViewModel(array('email_tpls' => $this->getEmailTemplatesService()->getEmailTemplates()));
    }
    
    
    public function edittemplateAction()
    {
        // set the form to be used in the edit template view
        $form = new EmailTemplateForm();
    
        $tpl_id = !empty($this->getRequest()->getParam('id')) 
        ? $this->getRequest()->getParam('id') : null;
        
        $get_tpl = $this->getEmailTemplatesService()->getEmailTemplate($tpl_id);
        
        return new ViewModel(array('form' => $form, 'id' => $get_tpl['template_id'], 
            'subject' => $get_tpl['email_subject'], 'body' => $get_tpl['email_body']));
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
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $email->exchangeArray($form->getData());
        
                $tpl_id = !empty($this->getRequest()->getParam('id'))
                ? $this->getRequest()->getParam('id') : null;
                
                if ($this->getEmailTemplatesService()->modifyEmailTemplate($email, $tpl_id) === true) {
                    // the updated email template was inserted into the database successfully
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/email-template');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/email-template/' . $tpl_id);
                }
            }
        } 
    }

    
    public function deletetemplatesAction()
    {
        $id = $this->getRequest()->getParam('id');
        
        if (!empty($e_id)) {
            // delete the template
            $email = new EmailTemplates();
            
            if (false !== $this->getEmailTemplatesService()->deleteEmailTemplate($email, $id)) {
                // don't do anything, ajax call will handle redirect 
            }
        }
    }
    
    
    /////////////////////////////////////////////
    // pages actions
    /////////////////////////////////////////////
    public function pagesAction()
    {
        return new ViewModel(array('pages' => $this->getPagesService()->getPages()));
    }
    
    
    public function addpageAction()
    {
        $form = new PagesForm();
        
        return new ViewModel(array('form' => $form));
    }
    
    
    public function editpageAction()
    {
        // set the form to be used in the view
        $form = new PagesForm();
        
        $p_id = !empty($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : null;
        
        $get_page = $this->getPagesService()->getPage($p_id);
        
        $form->get('page_title')->setValue($get_page['page_title']);
        $form->get('page_content')->setValue($get_page['page_content']);
        
        return new ViewModel(array('form' => $form, 'id' => $get_page['id'],
            'page_title' => $get_page['page_title'], 'page_content' => $get_page['page_content'],
        ));
    }
    
    
    public function updatepageAction()
    {
        // set the form to be used in the pages view
        $form = new PagesForm();
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $page = new Pages();
        
            $form->setInputFilter($page->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $page->exchangeArray($form->getData());
        
                $p_id = !empty($this->getRequest()->getParam('id'))
                ? $this->getRequest()->getParam('id') : null;
        
                if ($this->getPagesService()->updatePage($page, $p_id) === true) {
                    // the updated page was inserted into the database successfully
                    // redirect to page view
                    return $this->redirect()->toUrl('/admin/pages');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to page view
                    return $this->redirect()->toUrl('/admin/pages/' . $p_id);
                }
            }
        }
    }
    
    
    public function deletepageAction()
    {
        $page_id = $this->getRequest()->getParam('id');
        
        if (false !== $this->getPagesService()->deletePage($page_id)) {
            return $this->redirect()->toUrl('/admin/pages');
        } else {
            return $this->redirect()->toUrl('/admin/pages/' . $page_id);
        }
    }
    
    
    public function savepageAction()
    {
        // set the form to be used in the save page view
        $form = new PagesForm();
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $pages  = new Pages();
        
            $form->setInputFilter($pages->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $pages->exchangeArray($form->getData());
        
                $p_id = !empty($this->getRequest()->getParam('id'))
                ? $this->getRequest()->getParam('id') : null;
                
                if ($this->getPagesService()->savePage($pages) === true) {
                    // the page  was inserted into the database successfully
                    // redirect to pages view
                    return $this->redirect()->toUrl('/admin/pages');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to pages view
                    return $this->redirect()->toUrl('/admin/pages/' . $p_id);
                }
            }
        }    
    }
    
   
    public function usersAction()
    {
        return new ViewModel(array('users' => $this->getUsersService()->getAllUsers()));
    }
    
    
    public function changeuserstatusAction()
    {
        $user_id = $this->getRequest()->getParam('id');
        $status  = $this->getRequest()->getParam('status');
        
        if ($this->getUsersService()->updateUser(array('user_id' => $user_id, 'user_status' => $status))) {
            return $this->redirect()->toUrl('/admin/users');
        } else {
            return new ViewModel(array('error' => 'Error changing the status of the user.'));
        }
    }
    
    
    public function deleteuserAction()
    {
        if (!empty($_REQUEST['id'])) {
            $this->getUsersService()->removeUser(array('user_id' => $_REQUEST['id'])); 
        }
    }
    
    
    public function contactuserAction()
    {
        
    }
    
    
    public function contactbuyersAction()
    {
        
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
    
    
    public function getPagesService() 
    {
        if (!$this->pages_service) {
            $sm = $this->getServiceLocator();
            
            $this->pages_service = $sm->get('Admin\Model\PagesModel');
        }
        
        return $this->pages_service;
    }
    
    
    public function getUsersService()
    {
        if (!$this->users_service) {
            $sm = $this->getServiceLocator();
            
            $this->users_service = $sm->get('Admin\Model\UsersModel');
        }
        
        return $this->users_service;
    }
}
