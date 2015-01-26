<?php

namespace Teryt\Model;

use Zend\Db\TableGateway\TableGateway;

class DistrictTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getDistricts()
    {
        $result = array();
        
        $resultSet = $this->tableGateway->select(function ($select) {
            $select->columns(array('id', 'name'));
        });
        
        if (!empty($resultSet))
			foreach($resultSet as $row)
				$result[$row->id] = $row->name;
        
        asort($result);
        return $result;
    }
    
    public function getDistrictIdByName($districtName)
    {
        $rowSet = $this->tableGateway->select(array('name' => $districtName));
        $row = $rowSet->current();
        return $row->id;
    }
}

?>
