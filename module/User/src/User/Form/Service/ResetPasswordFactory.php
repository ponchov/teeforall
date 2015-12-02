<?php

namespace User\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator;
use Zend\Form\Factory;

class ResetPasswordFactory implements FactoryInterface
{
    /**
     * Creates the form of password reset
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
                ),
                'input_filter' => array(
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
                                    'min' => 6,
                                    'max' => 256,
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
