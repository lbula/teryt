<?php

namespace Teryt\Model;

class District
{
    public $id;
    public $name;
    public $city_id_fk;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->city_id_fk = (!empty($data['city_id_fk'])) ? $data['city_id_fk'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function readDistricts($cities, $localityXmlData)
    {
        $result = array();
        
        foreach ($cities as $cityId => $cityDetails)
        {
            $districts = array();
            foreach ($localityXmlData as $record)
                if ((array_key_exists('WOJ', $record) && $record['WOJ'] == $cityDetails['region']) && (array_key_exists('POW', $record) && $record['POW'] == $cityDetails['county']))
                    $districts[] = $record['SYM'];
            
            // In SIMC database are records with the same SYM id (with different SYMPOD id).
            // To get streets we need SYM id -> so we need to remove duplicates.
            $result[$cityId] = array_unique($districts);
        }
        
        return $result;
    }
    
    public function saveDistrictsIntoSqlFile($destinationDir, $localityXmlData, $citiesWithDistricts, $selectedCities)
    {
        $districts = array();
        foreach ($citiesWithDistricts as $cityId => $cityDetails)
        {
            if (!in_array($cityId, $selectedCities)) continue;
            
            foreach ($localityXmlData as $record)
            {
                if ((array_key_exists('WOJ', $record) && $record['WOJ'] == $cityDetails['region']) && (array_key_exists('POW', $record) && $record['POW'] == $cityDetails['county']))
                {
                    $districts[$cityId][$record['SYM']]['name'] = $record['NAZWA'];
                    $districts[$cityId][$record['SYM']]['district_id_fk'] = $record['SYMPOD'];
                }
            }
        }
        
        $file = fopen($destinationDir . 'districts.sql', 'w');
        
        foreach ($selectedCities as $cityId)
        {
            $cityDistricts = $districts[$cityId];
            foreach ($cityDistricts as $districtId => $districtDetails)
            {
                if (($districtId == $districtDetails['district_id_fk']) && ((int) $districtDetails['district_id_fk'] != $cityId))
                {
                    $line = 'insert into district (id,name,city_id_fk) ';
                    $line .= 'values (' . $districtId . ",'" . $districtDetails['name'] . "'," . $cityId . ');';
                    fwrite($file, $line."\n");
                }
            }
        }
        
        fclose($file);
    }
}

?>
