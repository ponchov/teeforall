<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function loginAction()
    {
        $form = $this->getServiceLocator()->get('User\Form\Login');

        return new ViewModel(compact('form'));
    }
}

