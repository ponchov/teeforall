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
                         * New Adress
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
                    array(
                        /**
                         * New City
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'newcity',
                            'options' => array(
                                'label' => 'City',
                            ),
                            'attributes' => array(
                                'onkeypress' => 'return checkcharonly(event);',
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * State
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Select',
                            'name' => 'newstate',
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
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:33px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * New Zip code
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'newzipcode',
                            'options' => array(
                                'label' => 'Zip code',
                            ),
                            'attributes' => array(
                                'onkeypress' => 'return checknummsp(event);',
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Instruction
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Textarea',
                            'name' => 'instruction',
                            'options' => array(
                                'label' => 'Instruction',
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'style' => 'width:450px; height:120px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Address
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'address',
                            'options' => array(
                                'label' => 'Address',
                            ),
                            'attributes' => array(
                                'readonly' => 'readonly',
                                'class' => 'changepasstextbox',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Address1
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'address1',
                            'options' => array(
                            ),
                            'attributes' => array(
                                'readonly' => 'readonly',
                                'class' => 'changepasstextbox',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * City
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'city',
                            'options' => array(
                                'label' => 'City',
                            ),
                            'attributes' => array(
                                'readonly' => 'readonly',
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:30px;',
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
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:33px;',
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
                            'options' => array(
                                'label' => 'Zip code',
                            ),
                            'attributes' => array(
                                'readonly' => 'readonly',
                                'class' => 'changeaddress',
                                'style' => 'width:100px; height:30px;',
                            ),
                        ),
                    ),
                    array(
                        /**
                         * Campaign category
                         */
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Select',
                            'name' => 'campaign_category',
                            'options' => array(
                                'label' => 'Campaign category',
                                'value_options' => array(
                                    1 => 'Discover',
                                    2 => 'Support',
                                ),
                            ),
                            'attributes' => array(
                                'class' => 'setgoaltxt',
                                'style' => 'width:150px; height:30px;',
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
                    'newcity' => array(
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
                    'newstate' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'State is required.',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'newzipcode' => array(
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
                    'instruction' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Instruction is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'address' => array(
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