<?php
/*
 * filter for the configuration form
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Configuration implements InputFilterAwareInterface
{
    public $site_title;
    public $site_description;
    public $site_keywords;
    public $admin_email;
    
    protected $input_filter;
    
    
    public function exchangeArray($data)
    {
        $this->site_title       = (!empty($data['site_title']))       ? $data['site_title']       : null;
        $this->site_description = (!empty($data['site_description'])) ? $data['site_description'] : null;
        $this->site_keywords    = (!empty($data['site_keywords']))    ? $data['site_keywords']    : null;
        $this->admin_email      = (!empty($data['admin_email']))      ? $data['admin_email']      : null;
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
    