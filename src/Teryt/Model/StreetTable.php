<?php

namespace Teryt\Model;

use Zend\Db\TableGateway\TableGateway;

class StreetTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}

?>
