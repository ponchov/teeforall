<?php


namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CampaignController extends AbstractActionController
{
    public function indexAction()
    {
        $products = $this->getServiceLocator()
                ->get('Campaign\Storage\TShirt\Product')->getLive();
        $icons = $this->getServiceLocator()
                ->get('Campaign\Storage\TShirt\Icon')->getLive();

        $view = new ViewModel(compact('products', 'icons'));

        return $view;
    }

    public function trackorderAction()
    {
        $oid = $this->params()->getParam('oid');
        $form = $this->getServiceLocator()->get('Campaign\Form\TrackOrder');

        return new ViewModel(compact('oid', 'form'));
    }
}
