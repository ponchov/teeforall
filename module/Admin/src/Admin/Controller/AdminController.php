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

use Admin\Form\UsersForm;
use Admin\Model\Users;

use Admin\Form\TShirtSizeForm;
use Admin\Model\TShirtSize;
use Admin\Form\TShirtForm;


class AdminController extends AbstractActionController
{
    protected $configuration_service;
    
    protected $email_tpl_service;
    
    protected $pages_service;
    
    protected $users_service;
    
    protected $tshirt_discount_service;
    protected $tshirt_icons_service;
    protected $tshirt_price_service;
    protected $tshirt_products_service;
    protected $tshirt_size_service;
    
    
    public function indexAction()
    {
        
    }

    /////////////////////////////////////////////
    // configuration actions
    /////////////////////////////////////////////
    public function configurationAction()
    {
        // set the form to be displayed in the configuration view
        $form = new ConfigurationForm();
        
        $messages = null;
        
        // set value + attributes of the form
        $form->get('submit')->setValue('Submit');
        
        
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
    public function addtemplateAction()
    {
        $form = new EmailTemplateForm();
        
        return new ViewModel(array('form' => $form));
    }
 
    
    public function savetemplateAction()
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
        
                if ($this->getEmailTemplatesService()->saveEmailTemplate($email) === true) {
                    // the updated email template was inserted into the database successfully
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/email-templates');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/add-template');
                }
            }
        }
    }
    
    
    public function emailtemplatesAction()
    {
        return new ViewModel(array('email_tpls' => $this->getEmailTemplatesService()->getEmailTemplates()));
    }
    
    
    public function edittemplateAction()
    {
        // set the form to be used in the edit template view
        $form = new EmailTemplateForm();
    
        $tpl_id = !empty($this->params('id')) 
        ? $this->params('id') : null;
        
        $get_tpl = $this->getEmailTemplatesService()->getEmailTemplate($tpl_id);
        
        //var_dump($get_tpl);
        //exit;
        
        return new ViewModel(array('form' => $form, 'id' => $get_tpl->template_id, 
            'subject' => $get_tpl->email_subject, 'body' => $get_tpl->email_body));
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
        
                $tpl_id = !empty($this->params('id'))
                ? $this->params('id') : null;
                
                if ($this->getEmailTemplatesService()->modifyEmailTemplate($email, $tpl_id) === true) {
                    // the updated email template was inserted into the database successfully
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/email-templates');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to email template view
                    return $this->redirect()->toUrl('/admin/email-templates/' . $tpl_id);
                }
            } 
        } 
    }

    
    public function deletetemplatesAction()
    {
        // get the id passed by the ajax request
        $id = $this->params()->fromPost('id');

        $this->getEmailTemplatesService()->deleteEmailTemplates($id);
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
        // set the form to be used
        $form = new PagesForm();
        
        return new ViewModel(array('form' => $form));
    }
    
    
    public function editpageAction()
    {
        // set the form to be used in the view
        $form = new PagesForm();
        
        $p_id = !empty($this->params('id')) ? $this->params('id') : null;
        
        $get_page = $this->getPagesService()->getPage($p_id);
        
        $form->get('page_title')->setValue($get_page->page_title);
        $form->get('page_content')->setValue($get_page->page_content);
        
        return new ViewModel(array('form' => $form, 'id' => $get_page->page_id,
            'page_title' => $get_page->page_title, 'page_content' => $get_page->page_content,
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
        
                $p_id = !empty($this->params('id'))
                ? $this->params('id') : null;
        
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
        $page_id = $this->params()->fromPost('id');
        
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
        
        $form->get('add_pages_submit')->setValue('Add New Page');
        
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $pages = new Pages();
        
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
        
                $p_id = !empty($this->params('id'))
                ? $this->params('id') : null;
                
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

    
    
    ///////////////////////////////
    // user actions
    ///////////////////////////////
    public function usersAction()
    {
        return new ViewModel(array('users' => $this->getUsersService()->getAllUsers()));
    }
    
    
    public function changeuserstatusAction()
    {
        $user_id = $this->params()->fromPost('id');
        $status  = $this->params()->fromPost('status');
        
        if (false !== $this->getUsersService()->updateUserStatus(array('user_id' => $user_id, 'user_status' => $status))) {
            return $this->redirect()->toUrl('/admin/users');
        }
     
    }
    
    
    public function deleteuserAction()
    {
        if (!empty($_REQUEST['id'])) {
            $this->getUsersService()->removeUser($_REQUEST['id']); 
        }
    }
    
    
    public function adduserAction()
    {
        // set the form to be used
        $form = new UsersForm($this->getServiceLocator()->get('Admin\Model\UsersModel'));
        
        $form->get('add_user_submit')->setValue('Add New User');
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $users = new Users();
        
            $form->setInputFilter($users->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $users->exchangeArray($form->getData());
        
                if ($this->getUsersService()->addUser($users) === true) {
                    // the user was inserted into the database successfully
                    // redirect to users view
                    return $this->redirect()->toUrl('/admin/users');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to add users view
                    return $this->redirect()->toUrl('/admin/add-user');
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
    }
    
    
    public function edituserAction()
    {
        $id = $this->params('id');

        $get_user = $this->getUsersService()->getUser($id);

        foreach ($get_user as $usr) {
            $data = $usr;
        }

        //var_dump($data['country']);
        //exit;

        $form = new UsersForm($this->getServiceLocator()->get('Admin\Model\UsersModel'));
        
        // set the form fields with the values in the users table
        // based on the user id fetched
        $form->get('username')->setValue($data['username']);
        $form->get('password')->setValue($data['password']);
        $form->get('first_name')->setValue($data['first_name']);
        $form->get('last_name')->setValue($data['last_name']);
        $form->get('gender')->setValue($data['gender']);
        $form->get('address')->setValue($data['address']);
        $form->get('city')->setValue($data['city']);
        $form->get('state')->setValue($data['state']);
        $form->get('zipcode')->setValue($data['zipcode']);
        $form->get('country')->setValue($data['country']);
        $form->get('add_user_submit')->setValue('Edit User');

        $request = $this->getRequest();

        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $users = new Users();

            $form->setInputFilter($users->getInputFilter());

            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());

            // now we will see if the form is valid
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $users->exchangeArray($form->getData());

                if ($this->getUsersService()->editUser($users, $id) === true) {
                    // the user was inserted into the database successfully
                    // redirect to users view
                    return $this->redirect()->toUrl('/admin/users');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to add users view
                    return $this->redirect()->toUrl('/admin/edit-user/' . $id);
                }
            }
        }


        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    
    
    public function contactuserAction()
    {
        return new ViewModel(array('contact_users' => $this->getUsersService()->getUsersToContact()));
    }
    
    
    public function contactbuyersAction()
    {
        return new ViewModel(array('contact_buyers' => $this->getUsersService()->getBuyersToContact()));
    }
    
    
    public function userssendmailAction()
    {
        $this->getUsersService()->sendMailtoUsers(array('allusers' => $this->params()->fromPost('allusers'),
            'rightValues' => $this->params()->fromPost('rightValues')
        ));
        
        return $this->redirect()->toUrl('/admin/contact-users');
    }
    
    
    public function buyersendmailAction()
    {
        $this->getUsersService()->sendMailToBuyers(array('allusers' => $this->params()->fromPost('allusers'),
            'rightValues' => $this->params()->fromPost('rightValues')
        ));
        
        return $this->redirect()->toUrl('/admin/contact-buyers');
    }

    
    
    
    ///////////////////////////////////
    // tshirt size actions
    //////////////////////////////////
    public function tshirtsizeAction()
    {
        
        return new ViewModel(array('tshirt_sizes' => $this->getTShirtSizeService()->listTShirtSizes()));
    }
    
    
    public function deletetshirtsizeAction()
    {
        if (!empty($_REQUEST['id'])) {
            $this->getTShirtSizeService()->deleteTShirtSize($_REQUEST['id']);
        }
    }
    
    
    public function edittshirtsizeAction()
    {
        $id = $this->params('id');
        
        $get_user = $this->getTShirtSizeService()->getOneTShirtSize($id);
        
        foreach ($get_user as $usr) {
            $data = $usr;
        }
        
        $form = new TShirtSizeForm($this->serviceLocator->get('Admin\Model\TShirtSizeModel'));
        
        $form->get('size')->setValue($data['size']);
        $form->get('size_inch')->setValue($data['size_inch']);
        
        $form->get('submit')->setValue('Edit Size');
        
        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    
    
    public function updatesizeAction()
    {
        // set the form to be used in the pages view
        $form = new TShirtSizeForm($this->serviceLocator->get('Admin\Model\TShirtSizeModel'));
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $tshirt = new TShirtSize();
        
            $form->setInputFilter($tshirt->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the email form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $tshirt->exchangeArray($form->getData());
        
                $p_id = !empty($this->params('id'))
                ? $this->params('id') : null;
        
                if ($this->getTShirtSizeService()->editTShirtSize($tshirt, $p_id) === true) {
                    // the updated page was inserted into the database successfully
                    // redirect to page view
                    return $this->redirect()->toUrl('/admin/tshirt-size');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to tshirt size view
                    return $this->redirect()->toUrl('/admin/tshirt-size');
                }
            }
        }
    }
    
    
    public function addtshirtsizeAction()
    {
        // set the form to be used
        $form = new TShirtSizeForm($this->getServiceLocator()->get('Admin\Model\TShirtSizeModel'));
        
        $form->get('submit')->setValue('Add New T-Shirt Size');
        
        // gets the form method request (usually post)
        $request = $this->getRequest();
        
        // check to see if the request was a POST form request
        if ($request->isPost()) {
            // good to go
            // filter the form values now
            $tshirt = new TShirtSize();
        
            $form->setInputFilter($tshirt->getInputFilter());
        
            // set the form data to hold all the values supplied by the form
            // via $request->getPost()
            $form->setData($request->getPost());
             
            // now we will see if the form is valid
            // we check if it is valid by the tshirt form class we created
            if ($form->isValid()) {
                // it is valid
                // pass the form to data to the filter class via exchangeArray()
                $tshirt->exchangeArray($form->getData());
        
                if ($this->getTShirtSizeService()->addTShirtSize($tshirt) === true) {
                    // the user was inserted into the database successfully
                    // redirect to users view
                    return $this->redirect()->toUrl('/admin/tshirt-size');
                } else {
                    // error occured..
                    // the error is logged automatically
                    // redirect to tshirt size view
                    return $this->redirect()->toUrl('/admin/tshirt-size');
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
    }
    
    
    
    
   
    //////////////////////////////////
    // tshirt products actions
    //////////////////////////////////
    public function productsAction()
    {
        
    }
    
  
    public function tshirtproductAction()
    {
        
    }
  
    
    public function saveproductAction()
    {
        
    }
    
    
    public function deletenewproductAction()
    {
        
    }
    
    
    public function changeproductstatusAction()
    {
        
    }
    
    
   
    
    ////////////////////////
    // price actions
    ///////////////////////
    public function priceAction()
    {
        
    }
    
    
    public function editpriceAction()
    {
    
    }
    
    
    public function updatepriceAction()
    {
    
    }
    
    
    
    ////////////////////////
    // discount actions
    ////////////////////////
    public function discountAction()
    {
        
    }
    
    
    public function editdiscountAction()
    {
        
    }
    
    
    public function updatediscountAction()
    {
        
    }
    
    
    // update record listings action
    public function updaterecordslistingsAction()
    {
        
    }
    
    
    
    /////////////////////////
    // campaign actions
    ////////////////////////
    public function campaignAction()
    {
        
    }
    
    
    public function campaignliveAction()
    {
        
    }
    
    
    public function campaignsuccessAction()
    {
        
    }
    
    
    public function campaignprofitAction()
    {
        
    }
    
    
    public function campaignsaveprofitAction()
    {
        
    }
    
    
    public function campaignunsuccessfulAction()
    {
        
    }
    
    
    public function campaignxlsAction()
    {
        
    }
    
    
    public function campaignemailfriendsAction()
    {
        
    }
    
    
    public function campaignsendmailAction()
    {
        
    }
    
    
    public function campaigndeleteAction()
    {
        
    }
    
    
    public function campaignviewAction()
    {
        
    }
    
    
    public function campaignorderrecordsAction()
    {
        
    }
    
    
    public function campaignchangestatusAction()
    {
        
    }
    
    
    public function campaignsliderstatusAction()
    {
        
    }
    
    
    public function campaignslidstatusAction()
    {
        
    }
    
    
    public function campaignprocessorderAction()
    {
        
    }
    
    
    public function campaigninstructionsAction()
    {
        
    }
    
    
    public function campaignaddinstructionsAction()
    {
        
    }
    
    
    
    /////////////////////////////
    // payment actions
    ////////////////////////////
    public function paymentAction()
    {
        
    }
    
    
    public function paymentexpireAction()
    {
        
    }
    
    
    public function paymentactiveAction()
    {
        
    }
    
    
    public function paymentchargedAction()
    {
        
    }
    
    
    public function paymentcaptureAction()
    {
        
    }
    
    
    
    ////////////////////////////
    // export to cvs actions  
    ////////////////////////////
    public function exportAction()
    {
        
    }
    
    
    public function exportcsvAction()
    {
        
    }
    
    
    
    
    
    
    
    /* DO NOT CHANGE THE CODE BELOW UNLESS YOU KNOW WHAT YOU ARE DOING!! */
    
    public function getConfigurationService()
    {
        if (!$this->configuration_service) {
            $sm = $this->getServiceLocator();
            
            $this->configuration_service = $sm->get('Admin\Model\ConfigurationModel');
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
    
    
    public function getTShirtDiscountService()
    {
        if (!$this->tshirt_discount_service) {
            $sm = $this->getServiceLocator();
            
            $this->tshirt_discount_service = $sm->get('Admin\Model\TShirtDiscountModel');
        }
        
        return $this->tshirt_discount_service;
    }
    
    
    public function getTShirtIconsService()
    {
        if (!$this->tshirt_icons_service) {
            $sm = $this->getServiceLocator();
            
            $this->tshirt_icons_service = $sm->get('Admin\Model\TShirtIconsModel');
        }
        
        return $this->tshirt_icons_service;
    }
    
    
    public function getTShirtPriceService()
    {
        if (!$this->tshirt_price_service) {
            $sm = $this->getServiceLocator();
            
            $this->tshirt_price_service = $sm->get('Admin\Model\TShirtPriceModel');
        }
        
        return $this->tshirt_price_service;
    }
    
    
    public function getTShirtProductsService()
    {
        if (!$this->tshirt_products_service) {
            $sm = $this->getServiceLocator();
            
            $this->tshirt_products_service = $sm->get('Admin\Model\TShirtProductsModel');
        }
        
        return $this->tshirt_products_service;
    }
    
    
    public function getTShirtSizeService()
    {
        if (!$this->tshirt_size_service) {
            $sm = $this->getServiceLocator();
            
            $this->tshirt_size_service = $sm->get('Admin\Model\TShirtSizeModel');
        }
        
        return $this->tshirt_size_service;
    }
}
