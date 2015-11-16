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
                'id'          => 'site_title',
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
                'id'          => 'site_description',
                'placeholder' => 'Site Description',
            ),
        ));
        
        $this->add(array(
            'name'     => 'site_keywords',
            'type'     => 'Text',
            'options'  => array(
                'label' => 'Site Keyword(s)',  
            ),
            
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'site_keywords',
                'placeholder' => 'Site Keyword(s)',
            ),
        ));
        
        $this->add(array(
            'name'     => 'admin_email',
            'type'     => 'Text',
            'options'  => array(
                'label' => 'Admin Email',  
            ),
            
            'attributes' => array(
                'id'          => 'admin_email',
                'class'       => 'mws-textinput required',
                'placeholder' => 'Admin Email',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'options' => array(
                'label' => 'Submit',
            ),
            
            'attributes' => array(
                'class' => 'mws-button red',
                'id'    => 'submit',
            ),
        ));
        
        
    }
}