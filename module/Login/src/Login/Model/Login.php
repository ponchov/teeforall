<?php
/*
 * @author Jimmy
 * 
 * This class passes the form values, filters them for use by the LoginModel class
 */

namespace Login\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Login implements InputFilterAwareInterface
{
	public $username;
	public $password;
	
	protected $input_filter;
	
	
	public function exchangeArray($data)
	{
		$this->username = (!empty($data['username'])) ? $data['username'] : null;
		$this->password = (!empty($data['password'])) ? $data['password'] : null;
	}
	
	
	public function setInputFilter(InputFilterInterface $input_filter)
	{
		throw new \Exception("Not used.");
	}
	
	
	public function getInputFilter()
	{
		if (!$this->input_filter) {
			$input_filter = new InputFilter();
			$factory      = new InputFactory();
			
			
			$input_filter->add($factory->createInput(array(
				'name'     => 'username',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
					
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 6,
							'max'      => 30,
						),
					),
				),
			)));
			
			
			$input_filter->add($factory->createInput(array(
				'name'     => 'password',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
					
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 6,
							'max'      => 15,
						),
					),
				),
			)));
			
			$this->input_filter = $input_filter;
		}
		
		return $this->input_filter;
	}
}	
