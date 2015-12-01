<?php

namespace Campaign\Table;

use Zend\Db\Sql;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Draft extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'draft_id',
        'campaign_id',
        'user_id',
        'resume_status',
    );

    /**
     * Returns all drafts with status $status for user $userId
     *
     * @param integer $userId
     * @param integer $status
     * @return integer
     */
    public function getCountForUser($userId, $status = 0)
    {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $select->columns(array('draftcnt' => new Sql\Expression('count(*)')));
        $select->where(
            array(
                'user_id = ?' => $userId,
                'resume_status = ?' => $status,
            )
        );

        $result = $this->tableGateway->selectWith($select)->current();
        if (!$result) {
            return 0;
        }

        return $result->draftcnt;
    }
}