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
		
		$this->setAttribute('method', 'post');
		
		
		// add the fields required (username & password)
		$this->add(array(
			'name'    => 'username',
			'type'    => 'Text',
			'options' => array(
				'label' => 'Username',
			),
				
			'attributes' => array('id' => 'username', 
			    'class' => 'form-control', 
			    'placeholder' => 'Username'),
		));
		
		
		$this->add(array(
			'name'    => 'password',
			'type'    => 'Password',
			'options' => array(
				'label' => 'Password',
			),
				
			'attributes' => array('id' => 'password',
			    'class' => 'form-control', 
			    'placeholder' => 'Password'),
		));
		
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			
			'attributes' => array(
				'id'     => 'submit',
				'value'  => 'Login',
				'class'  => 'btn btn-default',
			),
		));
	}
}