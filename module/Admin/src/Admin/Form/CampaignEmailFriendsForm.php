<?php
/*
 * email friends about campaign form
 * 
 * @author Jimmy
 */

namespace Admin\Form;


use Zend\Form\Form;


class CampaignEmailFriendsForm extends Form
{
 
    public function __construct($name = null)
    {
        parent::__construct('email_friends');
        
        // set the form attributes
        $this->setAttribute('id', 'mws-validate')
        ->setAttribute('method', 'post');
        
        // add the input fields to the form
        $this->add(array(
            'name' => 'email_address',
            'type' => 'Text',
            
            'options' => array(
                'label' => 'Your email address',  
            ),
            
            'attributes' => array(
                'class' => 'changeaddress',
                'style' => 'width: 300px; height: 30px;',
            ),
        ));
        
        $this->add(array(
            'name' => 'friends_email_address',
            'type' => 'Hidden',
            
            'attributes' => array(
                'class' => 'changepasstextbox',
                'style' => 'width: 300px; height: 30px;',
            ),
        ));
        
        $this->add(array(
            'name' => 'subject',
            'type' => 'Text',
            
            'options' => array(
                'label' => 'Subject',  
            ),
            
            'attributes' => array(
                'class' => 'changeaddress',
                'style' => 'width: 300px; height: 30px;'
            ),
        ));
        
        $this->add(array(
            'name' => 'content',
            'type' => 'Textarea',
            
            'options' => array(
                'label' => 'Content',  
            ),
            
            'attributes' => array(
                'class' => 'changeaddress',
                'style' => 'width: 300px; height: 150px;',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            
            'attributes' => array(
                'class' => 'mws-button red',  
            ),
        ));
    }
}