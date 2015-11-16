<?php
/*
 * Configuration Form class
 * 
 * @author Jimmy
 */

namespace Admin\Form;

use Zend\Form\Form;


class ConfigurationForm extends Form
{
    public function __construct($name = null) 
    {
        parent::__construct('configuration');
        
        // set the form attributes
        $this->setAttribute('method', 'post')
        ->setAttribute('class', 'mw-form')
        ->setAttribute('id', 'mws-validate')
        ->setAttribute('novalidate', 'novalidate');
        
        // input fields
        $this->add(array(
            'name'     => 'site_title',
            'type'     => 'Text',
            'options'  => array(
                'label' => 'Site Title',  
            ),
            
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'placeholder' => 'Site Title',
            ),
        ));
        
        $this->add(array(
            'name'     => 'site_description',
            'type'     => 'Text',
            'options'  => array(
                'label' => 'Site Description',  
            ),
            
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'placeholder' => 'Site Description',
            ),
        ));
        
        
    }
}