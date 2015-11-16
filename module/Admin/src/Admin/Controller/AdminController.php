<?php
/*
 * @author Jimmy
 * 
 * Admin Page Controller
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        // set the layout to be the admin layout
        $layout = $this->layout();
        $layout->setTemplate('admin/admin/layout');
    }

    
    public function configurationAction()
    {
        
    }
}
