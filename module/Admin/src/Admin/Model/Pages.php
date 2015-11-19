<?php
/*
 * filter for the pages form
 *
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Pages implements InputFilterAwareInterface
{
    public $page_title;
    public $page_content;

    protected $input_filter;


    public function exchangeArray($data)
    {
        $this->page_title      = (!empty($data['site_title']))       ? $data['site_title']       : null;
        $this->page_content    = (!empty($data['site_description'])) ? $data['site_description'] : null;
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
                'name'     => 'page_title',
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
                            'max'      => 50,
                        ),
                    ),
                ),
            )));
             
             
            $input_filter->add($factory->createInput(array(
                'name'     => 'page_content',
                'required' => true,
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 50,
                        ),
                    ),
                ),
            )));

            
             
            $this->input_filter = $input_filter;
        }

        return $this->input_filter;
    }
}