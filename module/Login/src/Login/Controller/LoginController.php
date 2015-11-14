<?php
/*
 * @author Jimmy
 * 
 * Login Page Controller
 */

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Login\Form\LoginForm;
use Login\Model\Login;


class LoginController extends AbstractActionController
{
    public function indexAction()
    {
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
                
            }
        }
    }
}
