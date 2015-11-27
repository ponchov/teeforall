<?php

namespace Campaign\From\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EditFactory implements FactoryInterface
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Zend\Form\ElementInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = $serviceLocator->newInstance('Campaign\Form\AddDescription');
        
        $form
            ->remove('no_ofdays')
            ->remove('url')
            ->remove('add_checkbox')
            ->remove('newcheckbx')
            ->remove('address')
            ->remove('address1')
            ->remove('city')
            ->remove('state')
            ->remove('zipcode')
            ->remove('campaign_category');
        
        /**
        * Url
        */
        $form->add(
            array(
                'spec' => array(
                    'type' => 'Zend\Form\Element\Hidden',
                    'name' => 'url',
                ),
            )
        );
        /**
        * Shipping address
        */
        $form->add(
            array(
                'spec' => array(
                    'type' => 'Zend\Form\Element\Checkbox',
                    'name' => 'shippingaddr',
                    'attributes' => array(
                        'onclick' => 'opendiv(this.id);',
                    ),
                ),
            )
        );

        return $form;
    }
}