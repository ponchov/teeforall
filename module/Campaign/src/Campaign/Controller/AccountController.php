<?php

namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function profileAction()
    {
        return new ViewModel();
    }
}

