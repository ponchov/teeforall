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
        $this->setAttribute('method', 'post')
        ->setAttribute('id', 'myForm');
        
       
        // set the attributes of the input field checkbox
        $this->add(array(
           'name' => 'checkbox[]',
           'type' => 'Checkbox',
            
           'attributes' => array(
              'id'      => 'checkbox[]',
              'onClick' => 'return check1();',
           ),
        ));
    }
}