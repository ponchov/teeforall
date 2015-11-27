<?php

namespace App\Storage\Table;

use Zend\Db\ResultSet\ResultSetInterface;

use App\Entity\EntitySetInterface;

interface TableEntitySetInterface extends ResultSetInterface, EntitySetInterface
{
}
