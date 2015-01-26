<?php

namespace Teryt\Model;

class City
{
    public $id;
    public $name;
    public $has_districts;
    public $region;
    public $county;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->has_districts = (!empty($data['has_districts'])) ? $data['has_districts'] : 0;
        $this->region = (!empty($data['region'])) ? $data['region'] : null;
        $this->county = (!empty($data['county'])) ? $data['county'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

?>
