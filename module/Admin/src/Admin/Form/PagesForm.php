<?php
/*
 * class to render the pages form
 *
 * @author Jimmy
 */

namespace Admin\Form;

use Zend\Form\Form;


class PagesForm extends Form
{
    public function __construct($name = null) 
    {
        parent::__construct('pages');
        
        // add the form attributes
        $this->setAttribute('method', 'post')
        ->setAttribute('id', 'mws-validate')
        ->setAttribute('novalidate', 'novalidate')
        ->setAttribute('class', 'mws-form');
        
        // add the form fields
        $this->add(array(
            'name' => 'page_title',
            'type' => 'Text',
            
            'attributes' => array(
                'class' => 'mws-textinput required',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'page_content',
            'type' => 'Textarea',
            
            'attributes' => array(
                'class' => 'mws-textinput required',
                'id'    => 'elrte',
                'style' => 'width: 90%;',
                'cols'  => 'auto',
            ),
        ));
        
        $this->add(array(
            'name'  => 'add_pages_submit',
            'type'  => 'Submit',
            
            'attributes' => array(
                'class' => 'mws-button red',  
            ),
        ));
    }
}