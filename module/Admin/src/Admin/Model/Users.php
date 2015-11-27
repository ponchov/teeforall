<?php
/*
 * filter for the user related form
 *
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Users implements InputFilterAwareInterface
{
    public $first_name;
    public $last_name;
    public $email_address;
    public $user_photo;
    public $gender;
    public $country;
    public $location;
    public $occupation;
    public $about_me;
    public $blog_url;
    public $website_url;

    protected $input_filter;


    public function exchangeArray($data)
    {
        $this->first_name     = (!empty($data['first_name']))    ? $data['first_name']     : null;
        $this->last_name      = (!empty($data['last_name']))     ? $data['last_name']      : null;
        $this->email_address  = (!empty($data['email_address'])) ? $data['email_address']  : null;
        $this->user_photo     = (!empty($data['user_photo']))    ? $data['user_photo']     : null;
        $this->gender         = (!empty($data['gender']))        ? $data['gender']         : null;
        $this->country        = (!empty($data['country']))       ? $data['country']        : null;
        $this->location       = (!empty($data['location']))      ? $data['location']       : null;
        $this->occupation     = (!empty($data['occupation']))    ? $data['occupation']     : null;
        $this->about_me       = (!empty($data['about_me']))      ? $data['about_me']       : null;
        $this->blog_url       = (!empty($data['blog_url']))      ? $data['blog_url']       : null;
        $this->website_url    = (!empty($data['website_url']))   ? $data['website_url']    : null;
    }


    public function setInputFilter(InputFilterInterface $input_filter)
    {
        throw new \ErrorException("Not used.");
    }

    
    public function getInputFilter()
    {
        if (!$this->input_filter) {
            $input_filter = new InputFilter();
            $factory      = new InputFactory();
             
             
            // first name validation
            $input_filter->add($factory->createInput(array(
                'name'     => 'first_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 30,
                        ),
                        
                        'name' => 'Not Empty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'First Name is Required', 
                            ), 
                        ),
                    ),
                ),
            )));
             
            
            // last name validation
            $input_filter->add($factory->createInput(array(
                'name'     => 'last_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 75,
                        ),
                        
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Last Name is Required',
                            ),
                        ),
                    ),
                ),
            )));

            
            // email address validation
            $input_filter->add($factory->createInput(array(
                'name'     => 'email_address',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 15,
                            'max'      => 50,
                        ),
                        
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Email Address is Required',
                            ),
                        ),
                    ),
                ),
            )));

            
            // user photo validation
            $input_filter->add($factory->createInput(array(
                'name'     => 'user_photo',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please select a photo',
                            ),
                        ),
                    ),
                ),
            )));
           
            
            // gender form field (male or female) validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'gender',
                'required' => true,
            )));
            
            
            // countries form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'country',
                'required' => true,
            )));
            
            
            // location form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'location',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 15,
                            'max'      => 75,
                        ),
                        
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please enter a location',
                            ),
                        ),
                    ),
                ),
            )));
            
            
            // occupation form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'occupation',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 10,
                            'max'      => 75,
                        ),
            
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please enter a occupation',
                            ),
                        ),
                    ),
                ),
            )));
            
            
            // about me form field validator 
            $input_filter->add($factory->createInput(array(
                'name'     => 'about_me',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 15,
                            'max'      => 500,
                        ),
                    ),
                ),
            )));
            
            
            // blog url form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'blog_url',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 15,
                            'max'      => 75,
                        ),
                    ),
                ),
            )));
            
            
            // website url form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'website_url',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 15,
                            'max'      => 75,
                        ),
                    ),
                ),
            )));
            
             
            $this->input_filter = $input_filter;
        }

        return $this->input_filter;
    }
    
}
