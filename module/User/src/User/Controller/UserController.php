<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    /**
     *
     * @return ViewModel
     */
    public function loginAction()
    {
        $formLogin = $this->getServiceLocator()->get('User\Form\Login');
        $formSignup = $this->getServiceLocator()->get('User\Form\Signup');
        if ($this->getRequest()->isPost()) {
            $formLogin->setData($this->getRequest()->getPost());
            if ($formLogin->isValid()) {
                $rurl = $this->params()->fromQuery('rurl', null);
                $authService = $this->getServiceLocator()->get('User\AuthService');
                $values = $formLogin->getData();
                $result = $authService->authentificate($values['username'], $values['password'], true);
                if ($result->getCode() == \Zend\Authentication\Result::SUCCESS) {
                    if (null === $rurl) {
                        return $this->redirect()->toRoute('myaccount', array('action' => 'profile'));
                    } else {
                        return $this->redirect()->toUrl(urldecode($rurl));
                    }
                } else {
                    $storage = $this->getServiceLocator()->get('User\Storage\User');
                    $user = $storage->getByEmail($values['username']);
                    if ($user) {
                        if (!$user->activeStatus) {
                            $this->flashMessenger()->addMessage('Activate your account by clicking on the link sent to your mail');
                        } elseif (!$user->userStatus) {
                            $this->flashMessenger()->addMessage('Your Account is inactivated by admin');
                        }
                    } else {
                        $this->flashMessenger()->addMessage('Invalid Email Address & Password');
                    }
                }
            }
        }

        return new ViewModel(compact('formLogin', 'formSignup'));
    }

    /**
     *
     * @return type
     */
    public function signupAction()
    {
        $formSignup = $this->getServiceLocator()->get('User\Form\Signup');
        if ($this->getRequest()->isPost()) {
            $formSignup->setData($this->getRequest()->getPost());

            if ($formSignup->isValid()) {
                $storage = $this->getServiceLocator()->get('User\Storage\User');
                $mails = $this->getServiceLocator()->get('User\Service\Mail');

                $values = $formSignup->getData();
                $user = $storage->create($values);
                $user->save();

                $mails->noticeOfCreation(
                    $user,
                    $values['password'],
                    'TeeForAll',
                    $this->url()->fromRoute(
                        'user',
                        array(
                            'action' => 'activate',
                            'data' => $user->getActivateHash()
                        )
                    )
                );

                $this->flashMessenger()->addMessage(
                    'An Activation link sent to your email address. '
                    . 'Please follow the link in the email to verify your '
                    . 'email address and activate your account.'
                );
                return $this->redirect()->toRoute('user', array('action' => 'login'));
            }
        }

        return $this->redirect()->toRoute('user', array('action' => 'login'));
    }

    /**
     *
     * @return type
     */
    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('User\AuthService');
        if ($authService->isLoggedIn()) {
            $authService->logout();
        }

        return $this->redirect()->toRoute('user', array('action' => 'login'));
    }

    /**
     *
     * @return ViewModel
     * @throws \Exception
     */
    public function activateAction()
    {
        $hash = $this->params()->fromRoute('data', false);

        if (false === $hash ) {
            throw new \Exception('hash is not sent');
        }

        $storage = $this->getServiceLocator()->get('User\Storage\User');

        $status = 0;
        if (($user = $storage->getByIdHash($hash))) {
            if ($user->activeStatus == 0) {
                $user->activeStatus = '1';
                $user->userStatus = '1';
                $user->save();
                $status = 1;
            } else {
                $status = 2;
            }
        } else {
            $status = 3;
        }

        return new ViewModel(compact('status', 'hash', 'user'));
    }
}

