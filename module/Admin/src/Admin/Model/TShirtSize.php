<?php
/*
 * filter for the tshirt form
 * come back to this and change 
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class TShirtSize implements InputFilterAwareInterface
{
    public $size;
    public $size_inch;

    public $size_id;
    
    protected $input_filter;


    public function exchangeArray($data)
    {
        $this->size_id          = (!empty($data['size_id']))          ? $data['size_id']          : null;
        $this->size             = (!empty($data['size']))             ? $data['size']             : null;
        $this->size_inch        = (!empty($data['size_inch']))        ? $data['size_inch']        : null;
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
                'name'     => 'size',
                'required' => true
            )));

            $input_filter->add($factory->createInput(array(
                'name'     => 'size_inch',
                'required' => true
            )));

          
             
            $this->input_filter = $input_filter;
        }

        return $this->input_filter;
    }
}