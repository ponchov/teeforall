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
        /**
         * everytime set action of login form to current uri because
         * maybe some arguments were set
         */
        $formLogin->setAttribute('action', $this->getRequest()->getUriString());

        $formSignup = $this->getServiceLocator()->get('User\Form\Signup');
        if ($this->getRequest()->isPost()) {
            $formLogin->setData($this->getRequest()->getPost());
            if ($formLogin->isValid()) {
                /**
                 * url to redirect to after successfuly login
                 */
                $rurl = $this->params()->fromQuery('rurl', null);
                $authService = $this->getServiceLocator()->get('User\AuthService');
                $values = $formLogin->getData();
                $result = $authService->authentificate($values['username'], $values['password'], true);
                /**
                 * if user is valid user
                 */
                if ($result->getCode() == \Zend\Authentication\Result::SUCCESS) {
                    if (null === $rurl) {
                        /**
                         * redirect to profile after login
                         */
                        return $this->redirect()->toRoute('myaccount', array('action' => 'profile'));
                    } else {
                        /**
                         * if redirect url was set, redirect to it
                         */
                        return $this->redirect()->toUrl(urldecode($rurl));
                    }
                } else {
                    $storage = $this->getServiceLocator()->get('User\Storage\User');
                    $user = $storage->getByEmail($values['username']);
                    /**
                     * maybe user is banned or is not activated?
                     */
                    if ($user) {
                        if (!$user->activeStatus) {
                            $this->flashMessenger()->addMessage('Activate your account by clicking on the link sent to your mail');
                        } elseif (!$user->userStatus) {
                            $this->flashMessenger()->addMessage('Your Account is inactivated by admin');
                        }
                    } else {
                        /**
                         * user with that credentials was not found
                         */
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
            /**
             * If user sent all data and the data is valid new user will created
             * and email with notation about it and activation url will be sent
             * If not the errors will be displayed
             */
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

        $formLogin = $this->getServiceLocator()->get('User\Form\Login');
        $register = true;

        $view = new ViewModel(compact('formLogin', 'formSignup', 'register'));
        $view->setTemplate('user/user/login');

        return $view;
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

        /**
         * If user is found by recieved hash we see if user is already activated or not
         * If user is not found the message about it will be displayed
         */
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

    /**
     *
     * @return ViewModel
     */
    public function forgotpasswordAction()
    {
        $form = $this->getServiceLocator()->get('User\Form\ForgotPassword');
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                /**
                 * if form is valid requested, trying to find the user with
                 * specified email. If user exists, we'll send the email to him
                 * where the reset process is described. If user wasn't found
                 * then special message will be displayed
                 */
                $storage = $this->getServiceLocator()->get('User\Storage\User');
                $values = $form->getData();
                $user = $storage->getByEmail($values['username']);
                if ($user) {
                    $mails = $this->getServiceLocator()->get('User\Service\Mail');

                    $hash = $user->getResetPasswordHash();
                    $mails->noticeOfForgotPassword(
                        $user,
                        'TeeForAll',
                        $this->url()->fromRoute(
                            'user',
                            array(
                                'action' => 'resetpassword',
                                'data' => $hash
                            )
                        )
                    );
                    $user->passReset = $hash;
                    $user->save();

                    $this->flashMessenger()->addMessage('Your password reset information has been sent to your email address.');

                    return $this->redirect()->toRoute('user', array('action' => 'login'));
                } else {
                    $this->flashMessenger()->addMessage('Email Address you entered is not registered.');
                }
            }
        }

        return new ViewModel(compact('form'));
    }

    public function resetpasswordAction()
    {
        $hash = $this->params()->fromRoute('data', false);

        if (false === $hash) {
            throw new \Exception('hash is not sent');
        }

        $storage = $this->getServiceLocator()->get('User\Storage\User');
        $user = $storage->getByPassReset($hash);

        $view = new ViewModel(compact('hash'));

        /**
         * if user is found by requested hash form is created and checked for post request
         * if request is post, form is valid the new password will be set and message
         * displayed, redirect client to login form
         */
        if ($user) {
            $form = $this->getServiceLocator()->get('User\Form\ResetPassword');
            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());
                if ($form->isValid()) {
                    $values = $form->getData();
                    $user->password = $user->getPasswordHash($values['password']);
                    $user->passReset = '';
                    $user->save();

                    $this->flashMessenger()->addMessage('Your new password reset successfully.');
                    return $this->redirect()->toRoute('user', array('action' => 'login'));
                }
            }

            $view->setVariable('form', $form);
        } else {
            $this->flashMessenger()->addMessage('Expired.');
        }

        return $view;
    }
}

