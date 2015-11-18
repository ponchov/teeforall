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
        
        // set the attributes of the email subject text field
        $this->add(array(
            'name' => 'email_subject',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'textInput',
                'style' => 'width: 400px; padding: 3px;',
            ),
        ));
        
        // set the attributes of the email body textarea field
        $this->add(array(
            'name' => 'email_body',
            'type' => 'Textarea',
            
            'attributes' => array(
                'class' => 'textInput',
                'style' => 'width: 90%; height: 400px;',
                'id'    => 'elrte',
                'cols'  => 'auto',
            ),
        ));
       
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