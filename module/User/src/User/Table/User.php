<?php

namespace User\Table;

use Zend\Db\Sql;

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
     * Returns user that has the email
     *
     * @param string $email
     * @return User\Entity\User|false
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
     * @param string $hash
     * @return User\Entity\User|false
     */
    public function getByIdHash($hash)
    {
        $set = $this->tableGateway->select(
            array(
                new Sql\Predicate\Expression('md5(user_id) = ?', $hash)
            )
        );
        $user = $set->current();
        if (!$user) {
            return false;
        }

        return $user;
    }

    /**
     * Creates new user and initialize it with params $data
     *
     * @param array $data
     * @return User\Entity\User
     */
    public function create(array $data)
    {
        $data['user_status'] = '0';
        $data['active_status'] = '0';
        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        return $this->createItemSet()->add($data)->current();
    }
}