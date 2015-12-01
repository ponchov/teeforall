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
    public $email_address;
    public $friends_email_address;
    public $subject;
    public $content;
    
    
    protected $input_filter;
    
    
    public function exchangeArray($data)
    {
        // pass the campaign id so it is available through the campaign module (controller, campaign model, etc)
        $this->campaign_id           = (!empty($data['campaign_id']))           ? $data['campaign_id']           : null;
        $this->email_address         = (!empty($data['email_address']))         ? $data['email_address']         : null;
        $this->friends_email_address = (!empty($data['friends_email_address'])) ? $data['friends_email_address'] : null;
        $this->subject               = (!empty($data['subject']))               ? $data['subject']               : null;
        $this->content               = (!empty($data['content']))               ? $data['content']               : null;
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
            $factory      = new InputFactory();
            
            // email address filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'email_address',
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
                            'min'      => 10,
                            'max'      => 75,
                        ),
                
                        'name' => 'Not Empty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Email Address is Required',
                            ),
                        ),
                    ),
                ),
            )));
            
            // friends email address filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'friends_email_address',
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
                            'min'      => 10,
                            'max'      => 75,
                        ),
            
                        'name' => 'Not Empty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Friend\'s Email Address is Required',
                            ),
                        ),
                    ),
                ),
            )));
            
            // subject filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'subject',
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
                            'min'      => 10,
                            'max'      => 150,
                        ),
            
                        'name' => 'Not Empty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Subject is Required',
                            ),
                        ),
                    ),
                ),
            )));
            
            // content filter
            $input_filter->add($factory->createInput(array(
                'name'     => 'content',
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
                            'min'      => 50,
                            'max'      => 500,
                        ),
            
                        'name' => 'Not Empty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Content is Required',
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