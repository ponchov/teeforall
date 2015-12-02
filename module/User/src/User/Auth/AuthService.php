<?php

namespace User\Auth;

use Zend\Authentication\AuthenticationService;
use Zend\Session\AbstractContainer;

use User\Table\User as UserTable;
use User\Entity\User as UserEntity;

class AuthService
{
    /**
     *
     * @var UserTable
     */
    protected $userTable = null;

    /**
     *
     * @var AuthenticationService
     */
    protected $authService = null;

    /**
     *
     * @var AbstractContainer
     */
    protected $sessionContainer = null;

    /**
     *
     * @var UserEntity
     */
    protected $authentificatedUser = null;

    /**
     *
     * @param UserTable $userTable
     * @param \Zend\Authentication\AuthenticationService $authService
     * @param \Zend\Session\AbstractContainer $container
     */
    public function __construct(
        UserTable $userTable,
        AuthenticationService $authService,
        AbstractContainer $container
    )
    {
        $this->userTable = $userTable;
        $this->authService = $authService;
        $this->sessionContainer = $container;
    }

    /**
     * Authentificate user by username/password pair
     *
     * @param string $username
     * @param string $password
     * @param boolean $remember
     * @return \Zend\Authentication\Result
     * @throws \Exception
     */
    public function authentificate($username, $password, $remember = false)
    {
        $adapter = $this->authService->getAdapter();
        if (!$adapter instanceof \Zend\Authentication\Adapter\DbTable) {
            throw new \Exception('invalid auth adapter type');
        }

        $adapter
            ->setIdentity($username)
            ->setCredential($password);

        $result = $this->authService->authenticate();

        if ($result->getCode() == \Zend\Authentication\Result::SUCCESS) {
            if ($remember) {
                $this->sessionContainer->getManager()->rememberMe();
            }
            $this->sessionContainer->userEntity = (array) $adapter->getResultRowObject();
        } else {
            $this->sessionContainer->userEntity = null;
        }

        return $result;
    }

    /**
     * Logging in with user email
     *
     * @param string $email
     * @return Auth
     */
    public function logIn($email)
    {
        $this->authService->getStorage()->write($email);

        return $this;
    }

    /**
     * Is user logged in?
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        if ($this->authService->hasIdentity()) {
            return true;
        }

        return false;
    }

    /**
     * Returns identity if user is logged in
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }

    /**
     * Logging out
     *
     * @return Auth
     */
    public function logout()
    {
        $this->authService->clearIdentity();
        $this->sessionContainer->userEntity = null;

        return $this;
    }

    /**
     * Returns logged user entity
     *
     * @return UserEntity|false
     */
    public function getAuthentificatedUserEntity()
    {
        if (!$this->sessionContainer->userEntity && $this->isLoggedIn()) {
            $user = $this->userTable->getByEmail($this->authService->getIdentity());
            if ($user) {
                $this->sessionContainer->userEntity = $user->getValues();
            }
        }

        if ($this->sessionContainer->userEntity) {
            if (null === $this->authentificatedUser) {
                $this->authentificatedUser = $this->userTable->create($this->sessionContainer->userEntity);
            }

            return $this->authentificatedUser;
        }

        return false;
    }
}