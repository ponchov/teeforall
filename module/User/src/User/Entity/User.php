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
     * @return string
     */
    public function getActivateHash()
    {
        return md5($this->id);
    }
}