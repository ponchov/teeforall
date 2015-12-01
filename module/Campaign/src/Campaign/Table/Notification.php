<?php

namespace Campaign\Table;

use Zend\Db\Sql;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Notification extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'n_id',
        'n_camp_id',
        'n_user_id',
        'n_date',
    );

    /**
     * Returns all notifications for user $userId
     *
     * @param integer $userId
     * @return TableEntitySetInterface
     */
    public function getForUser($userId)
    {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select();

        $select->from(array('main' => $this->tableGateway->getTable()));
        $select->join(
            array('lc' => 'launchcampaign'),
            'main.n_camp_id = lc.campaign_id',
            array(
                'uid' => 'user_id',
            ),
            Sql\Select::JOIN_LEFT
        );

        $select->join(
            array('u' => 'users'),
            'u.user_id = lc.user_id',
            array(),
            Sql\Select::JOIN_LEFT
        );

        $select->where(
            new Sql\Expression(
                sprintf("FIND_IN_SET(%d, n_user_id)", $userId)
            )
        );

        return $this->tableGateway->selectWith($select);
    }
}