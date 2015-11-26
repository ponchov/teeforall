<?php

namespace Campaign\From\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Factory;

class AddDescriptionFactory implements FactoryInterface
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
                         * Campaign title
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'camptitle',
                            'options' => array(
                                'label' => 'Campaign title',
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'style' => 'width:450px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Description of campaign
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Textarea',
                            'name' => 'description',
                            'options' => array(
                                'label' => 'Campaign description',
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'style' => 'width:450px; height:120px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Number of days
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Select',
                            'name' => 'no_ofdays',
                            'options' => array(
                                'label' => 'Number of days',
                                'value_options' => array(
                                    3 => '3 Days',
                                    7 => '7 Days',
                                    10 => '10 Days',
                                    14 => '14 Days',
                                    21 => '21 Days',
                                ),
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'style' => 'width:150px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Url
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'url',
                            'options' => array(
                                'label' => 'Url',
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'onblur' => 'uniqueurl(this.value);',
                                'style' => 'width:100px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Checkbox
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Checkbox',
                            'name' => 'add_checkbox',
                            'options' => array(
                                'label' => '',
                            ),
                            'attributes' => array(
                                'onclick' => 'opendiv(this.id);',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Another checkbox
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Checkbox',
                            'name' => 'newcheckbx',
                            'options' => array(
                                'label' => '',
                            ),
                            'attributes' => array(
                                'onclick' => 'newdivaddr(this.id);',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * First name
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'firstname',
                            'options' => array(
                                'label' => 'First name',
                            ),
                            'attributes' => array(
                                'onkeypress' => 'return checkcharonly(event);',
                                'class' => 'changeaddress',
                                'style' => 'width:180px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Last name
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'lastname',
                            'options' => array(
                                'label' => 'First name',
                            ),
                            'attributes' => array(
                                'onkeypress' => 'return checkcharonly(event);',
                                'class' => 'changeaddress',
                                'style' => 'width:180px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Adress
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'newaddress',
                            'options' => array(
                                'label' => 'Adress',
                            ),
                            'attributes' => array(
                                'class' => 'changepasstextbox',
                            ),
                        ),
                    ),
                ),
                'input_filter' => array(
                    'camptitle' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                            ),
                        ),
                    ),
                    'url' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                            ),
                        ),
                    ),
                    'firstname' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'First name is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'lastname' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Last name is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'newaddress' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Address is required',
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