<?php

namespace User\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator;
use Zend\Form\Factory;

class LoginFactory implements FactoryInterface
{
    /**
     * Makes the form of user login
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
                            'type' => 'Zend\Form\Element\Email',
                            'name' => 'username',
                            'attributes' => array(
                                'class' => 'logintextbox',
                            ),
                            'options' => array(
                                'label' => 'email',
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
                    'username' => array(
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Zend\Filter\StringTrim'),
                        ),
                        'validators' => array(
                            new Validator\EmailAddress(),
                        ),
                    ),
                    'password' => array(
                        'required' => true,
                    ),
                ),
            )
        );

        $form->setAttribute(
            'action',
            $serviceLocator->get('Router')->assemble(array('action' => 'login'), array('name' => 'user'))
        );
        $form->setAttribute('method', 'post');
        $form->setAttribute('name', 'login');

        return $form;
    }
}
