<?php

namespace Campaign\From\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Factory;

class BuyFactory implements FactoryInterface
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
                         * qty
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'qty',
                            'value' => 1,
                            'attributes' => array(
                                'onchange' => 'return calcurate(this.value);',
                                'onkeypress' => 'return checknummsp(event,this.value);',
                                'style' => 'width:50px; height:20px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Size
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Select',
                            'name' => 'size',
                            'options' => array(
                                'label' => 'Size',
                                'value_options' => array(
                                    /**
                                     * @todo
                                     */
                                ),
                            ),
                            'attributes' => array(
                                'style' => 'width:50px; height:20px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Payment method
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Radio',
                            'name' => 'paypalchk',
                            'value' => 1,
                            'options' => array(
                                'label' => 'Payment method',
                                'value_options' => array(
                                    '1' => 'PayPal',
                                    '2' => 'Credit Card',
                                ),
                            ),
                            'attributes' => array(
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Price
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'price',
                            'attributes' => array(
                                'style' => 'width:50px; height:20px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Email
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'cemail',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * First name
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'cfname',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Last name
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'clname',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Street 1
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'street1',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Street 2
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'street2',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * city
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'city',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Zip code
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'zipcode',
                            'attributes' => array(
                                'style' => 'width:250px; height:25px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * State
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Select',
                            'name' => 'state',
                            'options' => array(
                                'label' => 'State',
                                'value_options' => array(
                                    /**
                                     * @todo
                                     */
                                ),
                            ),
                            'attributes' => array(
                                'onchange' => 'getneighborhoodcities(this.value);',
                                'style' => 'width:100px; height:33px;',
                            ),
                        ),
                    ),
                ),
                'input_filter' => array(
                    'qty' => array(
                        'required' => true,
                    ),
                    'paypalchk' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Payment Mode is required.',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'price' => array(
                        'required' => true,
                    ),
                    'cemail' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Email is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'cfname' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'First Name is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'clname' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Last Name is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'street1' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Street is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'city' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'City is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'zipcode' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Zip code is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'state' => array(
                        'required' => true,
                    ),
                ),
            )
        );

        $form->setAttribute('method', 'post');

        return $form;
    }
}