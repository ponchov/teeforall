<?php

namespace User\Entity;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;
use App\Entity\Simple;

class User extends Simple implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'user_id';

    /**
     *
     * @var array
     */
    protected $data = array(
        'username' => '',
        'password' => '',
        'userStatus' => '',
        'activeStatus' => '',
        'passReset' => '',
        'publicName' => '',
        'bio' => '',
        'profileImage' => '',
        'address' => '',
        'city' => '',
        'state' => '',
        'zipcode' => '',
        'country' => '',
    );

    /**
     * Returns the hash that identificates the user while activation
     *
     * @todo need some salt
     * @return string
     */
    public function getActivateHash()
    {
        return md5($this->id);
    }

    /**
     * Returns the hash that indicates user that requested password reset process
     *
     * @todo need some salt
     * @return string
     */
    public function getResetPasswordHash()
    {
        return substr(md5($this->id), rand(0, 20), 11);
    }

    /**
     * Generates the password from given string
     *
     * @todo need some salt
     * @param string $value
     * @return string
     */
    public function getPasswordHash($value)
    {
        return md5($value);
    }
}