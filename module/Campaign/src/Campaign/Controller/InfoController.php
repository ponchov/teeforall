<?php

namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InfoController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

