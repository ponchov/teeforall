<?php
/*
 * class to build categories form
 */

namespace Admin\Form;

use Zend\Form\Form;


class CategoriesForm extends Form
{
    public function __construct($name = null) 
    {
        parent::__construct('categories');
        
        // set the attributes for the form
        $this->setAttribute(array('class' => 'mws-form'))
        ->setAttribute(array('id' => 'mws-validate'))
        ->setAttribute(array('novalidate' => 'novalidate'));
        
        
        // add the input fields to the form
        $this->add(array(
            'name' => 'cat_name',
            'type' => 'Select',
            'options' => array(
                'label' => 'Select Category', 
            ),
            
            'attributes' => array(
                'class' => 'mws-textinput required',
                'style' => 'width: 300px; height: 30px;',
            ),
        ));
        
        $this->add(array(
            'name'  => 'question',
            'type'  => 'Text',
            
            'attributes' => array(
                'class' => 'mws-textinput required',  
            ),
        ));
        
        $this->add(array(
           'name' => '', 
        ));
    }
}