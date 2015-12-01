<?php

namespace User\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator;
use Zend\Form\Factory;

class SignupFactory implements FactoryInterface
{
    /**
     * Makes the form of user registration
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\Form\Form
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formFactory = new Factory();

        $form = $formFactory->createForm(
            array(
                'elements' => array(
                    array(
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Text',
                            'name' => 'public_name',
                            'attributes' => array(
                                'class' => 'logintextbox',
                            ),
                            'options' => array(
                                'label' => 'Public name',
                            ),
                        ),
                    ),
                    array(
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Email',
                            'name' => 'username',
                            'attributes' => array(
                                'class' => 'logintextbox',
                            ),
                            'options' => array(
                                'label' => 'Email Id',
                            ),
                        ),
                    ),
                    array(
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Password',
                            'name' => 'password',
                            'attributes' => array(
                                'class' => 'logintextbox',
                            ),
                            'options' => array(
                                'label' => 'password',
                            )
                        ),
                    ),
                    array(
                        'spec' => array(
                            'type' => 'Zend\Form\Element\Password',
                            'name' => 'configmpassword',
                            'attributes' => array(
                                'class' => 'logintextbox',
                            ),
                            'options' => array(
                                'label' => 'password',
                            )
                        ),
                    ),
                    array(
                        'spec' => array(
                            'name' => 'send',
                            'attributes' => array(
                                'type'  => 'submit',
                                'class' => 'accbutton',
                                'value' => 'Sign In Now',
                            ),
                        ),
                    ),
                ),
                'input_filter' => array(
                    'public_name' => array(
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Zend\Filter\StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Public name is required',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'username' => array(
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Zend\Filter\StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Email Id is required',
                                    ),
                                ),
                            ),
                            new Validator\EmailAddress(),
                            $serviceLocator->get('ValidatorManager')->get('EmailNotInUse'),
                        ),
                    ),
                    'password' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Password is required',
                                    ),
                                ),
                            ),
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 0,
                                    'max' => 6,
                                    'messages' => array(
                                        'stringLengthTooShort' => 'Password must be atleast 6 characters',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'configmpassword' => array(
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Confirm password is required',
                                    ),
                                ),
                            ),
                            array(
                                'name'    => 'Identical',
                                'options' => array(
                                    'token' => 'password',
                                    'messages' => array(
                                        'notSame' => 'Password and confirm password are not matching.',
                                        'missingToken' => 'Password and confirm password are not matching.'
                                    )
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
