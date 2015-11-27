<?php

namespace Campaign\Table;

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
}