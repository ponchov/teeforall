<?php
/*
 * filter for the editin user form
*
* @author Jimmy
*/
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class EditUsers implements InputFilterAwareInterface
{
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $gender;
    public $address;
    public $city;
    public $state;
    public $zipcode;
    public $country;

    public $user_id;

    protected $input_filter;


    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;

        $this->username      = (!empty($data['username']))      ? $data['username']      : null;
        $this->password      = (!empty($data['password']))      ? $data['password']      : null;
        $this->first_name    = (!empty($data['first_name']))    ? $data['first_name']    : null;
        $this->last_name     = (!empty($data['last_name']))     ? $data['last_name']     : null;
        $this->gender        = (!empty($data['gender']))        ? $data['gender']        : null;
        $this->address       = (!empty($data['address']))       ? $data['address']       : null;
        $this->city          = (!empty($data['city']))          ? $data['city']          : null;
        $this->state         = (!empty($data['state']))         ? $data['state']         : null;
        $this->zipcode       = (!empty($data['zipcode']))       ? $data['zipcode']       : null;
        $this->country       = (!empty($data['country']))       ? $data['country']       : null;
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
                    array('name' => 'StringTrim'),
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
                'name'     => 'username',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 10,
                            'max'      => 75,
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

            
            // password
            $input_filter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 256,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Password is Required',
                            ),
                        ),
                    ),
                ),
            )));
             

            // gender form field (male or female) validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'gender',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 4,
                            'max'      => 7,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Gender is Required',
                            ),
                        ),
                    ),
                ),
            )));


            // address filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'address',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                ),

                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 10,
                            'max'      => 150,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Address field is required.',
                            ),
                        ),
                    ),
                ),
            )));


            // city filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'city',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                ),

                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 100,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'City field is required.',
                            ),
                        ),
                    ),
                ),
            )));



            // state filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'state',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper'),
                ),

                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max'      => 2,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'State field is required.',
                            ),
                        ),
                    ),
                ),
            )));


            // zipcode form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'zipcode',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Int'),
                ),

                'validators' => array(
                    array(
                        'name' => 'Between',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 9,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Zipcode field is required.',
                            ),
                        ),
                    ),
                ),
            )));


            // countries form field validator
            $input_filter->add($factory->createInput(array(
                'name'     => 'country',
                'required' => true,

                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 50,
                        ),

                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please select a country',
                            ),
                        ),
                    ),
                ),
            )));

             
            $this->input_filter = $input_filter;
        }

        return $this->input_filter;
    }

}