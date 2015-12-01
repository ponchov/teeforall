<?php
/*
 * filter for the campaign module/form
 * 
 * @author Jimmy
 */


namespace Admin\Model;


use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Campaign implements InputFilterAwareInterface
{
    // add more objects when they come to mind when the campaign module is progressing
    public $campaign_id;
    
    protected $input_filter;
    
    
    public function exchangeArray($data)
    {
        // pass the campaign id so it is available through the campaign module (controller, campaign model, etc)
        $this->campaign_id = (!empty($data['campaign_id']))  ? $data['campaign_id'] : null;
    }
    
    
    public function setInputFilter(InputFilterInterface $input_filter)
    {
        throw new \ErrorException("Not used.");
    }
    
    
    public function getInputFilter() 
    {
        // if input filter is false or no value
        // since it will be ($this->input_filter is not assigned any value)
        // we build a custom input filter relevant to the campaign form(s)
        if (!$this->input_filter) {
            $input_filter = new InputFilter();
            $factory = new InputFactory();
            
            $input_filter->add();
        }
    }
}