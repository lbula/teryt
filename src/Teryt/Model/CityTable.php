<?php

namespace Teryt\Model;

use Zend\Db\TableGateway\TableGateway;

class CityTable
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
    
    public function getCities()
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
    
    public function getCitiesWithDistricts()
    {
        $result = array();
        
        $resultSet = $this->tableGateway->select(function ($select) {
            $select->columns(array('id', 'name', 'region', 'county'));
            $select->where(array('has_districts' => 1));
        });
        
        if (!empty($resultSet))
			foreach($resultSet as $row)
				$result[$row->id] = array('name' => $row->name,
										  'region' => $row->region,
										  'county' => $row->county);
        
        return $result;
    }
    
    public function getCitiesWithoutDistricts()
    {
        $result = array();
        
        $resultSet = $this->tableGateway->select(function ($select) {
            $select->columns(array('id', 'name'));
            $select->where(array('has_districts' => 0));
        });
        
        if (!empty($resultSet))
			foreach($resultSet as $row)
				$result[$row->id] = $row->name;
        
        return $result;
    }
    
    public function getCityIdByName($cityName)
    {
        $rowSet = $this->tableGateway->select(array('name' => $cityName));
        $row = $rowSet->current();
        return $row->id;
    }
}

?>
