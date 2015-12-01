<?php

namespace User\Table;

use App\Storage\Table\Simple;

class MailTemplate extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'template_id',
        'template_title',
        'email_subject',
        'email_body',
    );
}