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
    

    protected $input_filter;


    public function exchangeArray($data)
    {
       /* come back to this */
    }


    public function setInputFilter(InputFilterInterface $input_filter)
    {
        throw new \ErrorException("Not used.");
    }

    /* come back to this */
    public function getInputFilter()
    {
        if (!$this->input_filter) {
            $input_filter = new InputFilter();
            $factory      = new InputFactory();
             
             
            $input_filter->add($factory->createInput(array(
                'name'     => 'site_title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
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
                'name'     => 'site_description',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 75,
                        ),
                    ),
                ),
            )));

            $input_filter->add($factory->createInput(array(
                'name'     => 'site_keywords',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 50,
                        ),
                    ),
                ),
            )));

            $input_filter->add($factory->createInput(array(
                'name'     => 'admin_email',
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
