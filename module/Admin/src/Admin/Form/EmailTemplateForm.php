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
        
        $this->add(array(
            'name' => 'email_subject',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'textInput',
                'id'    => 'email_subject',
                'style' => 'width: 400x; padding: 3px;',
            ),
        ));
        
        $this->add(array(
            'name' => 'email_body',
            'type' => 'Textarea',
            
            'attributes' => array(
                'class' => 'textInput',
                'id'    => 'elrte',
                'style' => 'width: 90%; height: 400px;',
                'cols'  => 'auto',
             ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            
            'attributes' => array(
                'value' => 'Update Template',
                'class' => 'mws-button red',
                'id'    => 'submit',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'add_template_submit',
            'type' => 'Submit',
            
            'attributes' => array(
                'value' => 'Add New Template',
                'class' => 'mws-button red',
                'id'    => 'add_template_submit',
            ),
        ));
    }
}