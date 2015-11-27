<?php

namespace Campaign\Table;

use App\Storage\Table\Simple;

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
}