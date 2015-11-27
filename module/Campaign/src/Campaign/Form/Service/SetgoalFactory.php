<?php

namespace Campaign\From\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Factory;

class SetgoalFactory implements FactoryInterface
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Zend\Form\ElementInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formFactory = new Factory();

        $form = $formFactory->createForm(
            array(
                'elements' => array(
                    array(
                        /**
                         * Selling price
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'sellingprice',
                            'options' => array(
                                'label' => 'Selling price',
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'onchange' => 'assignprice(event,this.value);',
                                'onkeyup' => 'assignprice(this.value);',
                                'onkeypress' => 'return checknummsp(event,this.value);',
                                'onchange' => 'calculate();',
                                'onfocus' => 'checkprice(this.value);',
                                'onchange' => 'checkprice(this.value);',
                                'style' => 'width:100px; height:30px;',
                            ),
                        ),
                    ),
                ),
                'input_filter' => array(
                    'sellingprice' => array(
                        'required' => true,
                    ),
                ),
            )
        );

        $form->setAttribute('method', 'post');

        return $form;
    }
}