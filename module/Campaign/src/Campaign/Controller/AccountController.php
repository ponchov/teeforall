<?php

namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use User\Entity\User as UserEntity;

class AccountController extends AbstractActionController
{
    /**
     * The user currently logged in
     *
     * @var UserEntity
     */
    protected $user = null;

    /**
     *
     * @param UserEntity $user
     */
    public function __construct(UserEntity $user)
    {
        $this->user = $user;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function activecampaignAction()
    {
        $campaigns = $this->getServiceLocator()
                ->get('Campaign\Storage\Campaign')->getForUser($this->user->userId, 1);

        return new ViewModel(compact('campaigns'));
    }

    public function endedcampaignAction()
    {
        $campaigns = $this->getServiceLocator()
                ->get('Campaign\Storage\Campaign')
                ->getForUser($this->user->userId, 0, 1);

        return new ViewModel(compact('campaigns'));
    }

    public function draftsAction()
    {
        $campaigns = $this->getServiceLocator()
                ->get('Campaign\Storage\Campaign')
                ->getForUser($this->user->userId, null, 0);

        return new ViewModel(compact('campaigns'));
    }

    public function profileAction()
    {
        return new ViewModel();
    }
}

