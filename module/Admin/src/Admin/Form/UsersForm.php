<?php
/*
 * user form
 * 
 * @author Jimmy
 */

namespace Admin\Form;

use Zend\Form\Form;


class UsersForm extends Form
{
    public function __construct($name = null)
    {
        
        // set the name of the form
        parent::__construct('user_form');
        
        // set the attributes of the form
        $this->setAttribute('method', 'post')
        ->setAttribute('class', 'mws-form')
        ->setAttribute('id', 'mws-validate')
        ->setAttribute('novalidate', 'no validate');
        
        // input fields
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username',  
            ),
            
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'username',
                'placeholder' => 'Username',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Text',
            'options' => array(
                'label' => 'Password',
            ),
            
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'password',
                'placeholder' => 'Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'first_name',
                'placeholder' => 'First Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'last_name',
                'placeholder' => 'Last Name',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'gender',
            'type' => 'Text',
            'options' => array(
                'label' => 'Gender',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'gender',
                'placeholder' => 'Gender',
            ),
        ));
        
        $this->add(array(
            'name' => 'address',
            'type' => 'Text',
            'options' => array(
                'label' => 'Address',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'address',
                'placeholder' => 'Address',
            ),
        ));
        
        $this->add(array(
            'name' => 'city',
            'type' => 'Text',
            'options' => array(
                'label' => 'City',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'city',
                'placeholder' => 'City',
            ),
        ));
        
        $this->add(array(
            'name' => 'state',
            'type' => 'Text',
            'options' => array(
                'label' => 'State',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'state',
                'placeholder' => 'State',
            ),
        ));
        
        $this->add(array(
            'name' => 'zipcode',
            'type' => 'Text',
            'options' => array(
                'label' => 'Zipcode',
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'zipcode',
                'placeholder' => 'Zipcode',
            ),
        ));
        
        /*
        $this->add(array(
            'name' => 'country',
            'type' => 'Select',
            'options' => array(
                'label' => 'Country',
                'value_options' => array(
                    '0' => 'Male',
                    '1' => 'Female',
                ),
            ),
        
            'attributes' => array(
                'class'       => 'mws-textinput required',
                'id'          => 'country',
            ),
        )); */
        
        
        $this->add(array(
            'name'  => 'add_user_submit',
            'type'  => 'Submit',
        
        
            'attributes' => array(
                'class' => 'mws-button red',
                'value' => 'Add User',
            ),
        ));
    }
}