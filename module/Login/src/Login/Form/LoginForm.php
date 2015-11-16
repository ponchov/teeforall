<?php
/*
 * @author Jimmy
 * 
 * This is the login form class, it builds the login form for viewing 
 * on the view
 */
namespace Login\Form;

use Zend\Form\Form;


class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('login');
		
		$this->setAttribute('method', 'post')
		->setAttribute('class', 'mws-form')
		->setAttribute('id', 'myform');
		
		
		// add the fields required (username & password)
		$this->add(array(
			'name'    => 'admin_username',
			'type'    => 'Text',
			'options' => array(
				'label' => 'Admin Username',
			),
				
			'attributes' => array('id' => 'admin_username', 
			    'class' => 'mws-login-username mws-textinput required', 
			    'placeholder' => 'Admin Username'
			),
		));
		
		
		$this->add(array(
			'name'    => 'admin_password',
			'type'    => 'Password',
			'options' => array(
				'label' => 'Admin Password',
			),
				
			'attributes' => array('id' => 'admin_password',
			    'class' => 'mws-login-password mws-textinput required', 
			    'placeholder' => 'Password'
			),
		));
		
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			
			'attributes' => array(
				'id'     => 'submit',
				'value'  => 'Login',
				'class'  => 'mws-button green mws-login-button',
			),
		));
	}
}