<?php
/*
 * form to handle editing/adding/deleting of t-shirts
 * 
 * @author Jimmy
 */
namespace Admin\Form;

use Zend\Form\Form;


class TShirtForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('t-shirts');
        
        // set the attributes of the form
        $this->setAttribute('method', 'post')
        ->setAttribute('id', 't-shirts');
        
        
        // set the input fields for the form
        $this->add(array(
            'name' => 'color-code',
            'type' => 'Text',
           
            'attributes' => array(
                'id'         => 'color-code',
                'class'      => 'Expandable mws-textinput required',
                'onkeypress' => 'return checknummspK(event);'
            ),
        ));
        
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'mws-textinput required',
                'id'    => 'title',
            ),
        ));
        
        $this->add(array(
            'name' => 'image',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox', 
                'id'    => 'image',
            ),
        ));
        
        $this->add(array(
            'name' => 'front_height',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox',
                'id'   => 'front_height',
            ),
        ));
        
        $this->add(array(
            'name' => 'front-shadow',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox',
                'id'   => 'front-shadow',
            ),
        ));
        
        $this->add(array(
            'name' => 'back-height',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox', 
                'id'   => 'back-height',
            ),
        ));
        
        $this->add(array(
            'name' => 'back-shadow',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox',
                'id'    => 'back-shadow',
            ),
        ));
        
        $this->add(array(
            'name' => 'back-image',
            'type' => 'Zend\Form\Element\File',
            
            'attributes' => array(
                'class' => 'textbox',
                'id'    => 'back-image',
            ),
        ));
        
        $this->add(array(
            'name' => 'base-price',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'mws-textinput required',
                'id'    => 'base-price',
            ),
        ));
        
        $this->add(array(
            'name' => 'shipping-price',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'mws-textinput required',
                'id'    => 'shipping-price',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'options' => array(
                'label' => 'Submit',
            ),
            
            'attributes' => array(
                'class' => 'mws-button red',  
            ),
        ));
    }
}