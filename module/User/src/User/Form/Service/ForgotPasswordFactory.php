<?php

namespace User\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator;
use Zend\Form\Factory;

class ForgotPasswordFactory implements FactoryInterface
{
    /**
     * Makes the form for user to restore forgotten password
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
                ),
            )
        );

        $form->setAttribute('method', 'post');

        return $form;
    }
}
