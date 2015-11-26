<?php
/*
 * filter for the email template form
 *
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class EmailTemplates implements InputFilterAwareInterface
{
    public $email_subject;
    public $email_body;
    public $template_id;
    public $template_title;

    protected $input_filter;


    public function exchangeArray($data)
    {
        $this->email_subject  = (!empty($data['email_subject']))  ? $data['email_subject']  : null;
        $this->email_body     = (!empty($data['email_body']))     ? $data['email_body']     : null;
        $this->template_id    = (!empty($data['template_id']))    ? $data['template_id']    : null;
        $this->template_title = (!empty($data['template_title'])) ? $data['template_title'] : null;
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
                'name'     => 'email_subject',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
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
                                'isEmpty' => 'Page Title is Required', 
                            ), 
                        ),
                    ),
                ),
            )));
             
             
            $input_filter->add($factory->createInput(array(
                'name'     => 'email_body',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                ),
                 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 50,
                        ),
                        
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Page Content is Required', 
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
