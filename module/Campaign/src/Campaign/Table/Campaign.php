<?php

namespace Campaign\Table;

use Zend\Db\Sql;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Campaign extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'campaign_id',
        'slider_status',
        'user_id',
        'admin_status',
        'campaign_status',
        'title',
        'base_price',
        'tee_image',
        'goal',
        'sold',
        'selling_price',
        'description',
        'campaign_length',
        'url',
        'launch_date',
        'shipping_option',
        'new_address',
        'draft_status',
        'draft_date',
        'order_process',
        'mail_sent',
        'campaign_category',
        'profit',
        'tee_back_image',
        'normalImageData',
        'dataURLDbBack',
        'dataURLDbFront',
        'SelectedProduct',
        'customimage',
        'selling_share',
        'campaign_identifire',
    );

    /**
     * Returns set of campaigns for user
     * also can be customized by campaign status and draft status
     *
     * @param integer $userId
     * @param integer $status
     * @param integer|null $draftStatus
     * @return TableEntitySetInterface
     */
    public function getForUser($userId, $status = null, $draftStatus = null)
    {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $where = array(
            'user_id = ?' => $userId,
        );

        if (null !== $status) {
            $where['campaign_status'] = $status;
        }

        if (null !== $draftStatus) {
            $where['draft_status'] = $draftStatus;
        }

        $select->where($where);

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Returns count of campaigns launched for $userId
     * and that are active(if $campaignStatus = 1) or not ($campaignStatus = 0)
     *
     * @param integer $userId
     * @param integer $campaignStatus
     * @return integer
     */
    public function getCountForUser($userId, $campaignStatus)
    {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $select->columns(array('mycount' => new Sql\Expression('count(*)')));
        $select->where(
            array(
                'user_id = ?' => $userId,
                'campaign_status = ?' => $campaignStatus,
                'draft_status = ?' => 1,
            )
        );

        $result = $this->tableGateway->selectWith($select)->current();
        if (!$result) {
            return 0;
        }

        return $result->mycount;
    }
}