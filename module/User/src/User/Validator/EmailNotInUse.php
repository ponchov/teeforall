<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;

use User\Table\User as UserStorage;
use User\Auth\AuthService as AuthService;

class EmailNotInUse extends AbstractValidator
{
    const EMAIL_IN_USE = 'emailInUse';

    /**
     *
     * @var UserStorage
     */
    protected $storage = null;

    /**
     *
     * @var AuthService
     */
    protected $authService = null;

    /**
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::EMAIL_IN_USE => "This email is already in use",
    );

    /**
     *
     * @param UserStorage $storage
     * @param AuthService $authService
     */
    public function __construct(UserStorage $storage, AuthService $authService = null)
    {
        $this->storage = $storage;
        $this->authService = $authService;
        parent::__construct();
    }

    /**
     * Returns true if and only if email not exists in users table
     *
     * @param string $value
     * @return boolean
     * @throws \Exception
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if (null !== $this->authService) {
            $user = $this->authService->getAuthentificatedUserEntity();
            if ($user && $user->username == $value) {
                return true;
            }
        }

        $user = $this->storage->getByEmail($value);
        if ($user) {
            $this->error(self::EMAIL_IN_USE);
            return false;
        }

        return true;
    }
}