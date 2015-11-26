<?php

namespace Campaign\From\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Factory;

class TrackOrderFactory implements FactoryInterface
{
    /**
     * 
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
                         * Order No.
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'orderno',
                            'options' => array(
                                'label' => 'Order No.',
                            ),
                            'attributes' => array(
                                'class' => 'changeaddress',
                                'style' => 'width:200px; height:30px;',
                            ),
                        ),
                    ),
                ),
                'input_filter' => array(
                    'orderno' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Order No. is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            )
        );

        $form->setAttribute('method', 'post');

        return $form;
    }
}