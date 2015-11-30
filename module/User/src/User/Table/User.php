<?php

namespace User\Table;

use App\Storage\Table\Simple;

class User extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'user_id',
        'username',
        'password',
        'user_status',
        'active_status',
        'pass_reset',
        'public_name',
        'bio',
        'profile_image',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
    );

    /**
     *
     * @param string $email
     * @return boolean
     */
    public function getByEmail($email)
    {
        $set = $this->tableGateway->select(
            array(
                'username' => $email
            )
        );
        $user = $set->current();
        if (!$user) {
            return false;
        }

        return $user;
    }

    /**
     *
     * @param array $data
     * @return User\Entity\User
     */
    public function create(array $data)
    {
        return $this->createItemSet()->add($data)->current();
    }
}