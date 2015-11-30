<?php
/*
 * tshirt size form
 * 
 * @author Jimmy
 */

namespace Admin\Form;


use Zend\Form\Form;

use Admin\Model\TShirtSizeModel;


class TShirtSizeForm extends Form
{
    protected $table;
    
    
    public function __construct(TShirtSizeModel $model)
    {
        $this->setTable($model);
        
        // set the name of the form
        parent::__construct('tshirt-size');
        
        // set the attributes of the form
        $this->setAttribute('method', 'post')
        ->setAttribute('class', 'mws-form')
        ->setAttribute('id', 'mws-validate');
        
        // input fields
        $this->add(array(
            'name' => 'size',
            'type' => 'Select',
            'options' => array(
                'label' => 'T-Shirt Size',
                'value_options' => $this->getTShirtSizes(),
                'empty_option' => 'Please choose a T-Shirt Size',
            ),
            
            'attributes' => array(
                'class'         => 'mws-textinput required',
                'id'            => 'size',
                'placeholder'   => 'T-Shirt Size',
            ),
        ));
        
        $this->add(array(
            'name' => 'size_inch',
            'type' => 'Select',
            'options' => array(
                'label' => 'T-Shirt Size in Inches',
                'value_options' => $this->getTShirtSizeInches(),
                'empty_option' => 'Please select a T-Shirt Size in Inches',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            
            'attributes' => array(
                'class' => 'mws-button red',
                'value' => 'Add T-Shirt',
            )
        ));
    }
    
    
    public function getTShirtSizes()
    {
        $table = $this->getTable();
        
        $data = $table->getTShirtSizeAvailableList();
        
        $select_data = array();
        
        foreach ($data as $value) {
            $select_data[trim($value->size)] = $value->size;
        }
        
        return $select_data;
    }
    
    
    public function getTShirtSizeInches()
    {
        $table = $this->getTable();
        
        $data = $table->getTShirtSizeInchListAvailable();
        
        $select_data = array();
        
        foreach ($data as $value) {
            $select_data[trim($value->size_inch)] = $value->size_inch;
        }
        
        return $select_data;
    }
    
    
    public function setTable($table)
    {
        $this->table = $table;
        
        return $this;
    }
    
    
    public function getTable()
    {
        return $this->table;
    }
}