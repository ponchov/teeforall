<?php
/*
 * class to render the email template form
 * 
 * @author Jimmy
 */
namespace Admin\Form;

use Zend\Form\Form;


class EmailTemplateForm extends Form 
{
    public function __construct($name = null)
    {
        parent::__construct('email_template');
        
        // set the attributes of the form
        
    }
}