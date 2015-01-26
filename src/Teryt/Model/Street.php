<?php

namespace Teryt\Model;

class Street
{
    public $id;
    public $prefix;
    public $name_1;
    public $name_2;
    public $city_id_fk;
    public $district_id_fk;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->prefix = (!empty($data['prefix'])) ? $data['prefix'] : null;
        $this->name_1 = (!empty($data['name_1'])) ? $data['name_1'] : null;
        $this->name_2 = (!empty($data['name_2'])) ? $data['name_2'] : null;
        $this->city_id_fk = (!empty($data['city_id_fk'])) ? $data['city_id_fk'] : null;
        $this->district_id_fk = (!empty($data['district_id_fk'])) ? $data['district_id_fk'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function readStreetsByDistricts($districts, $streetXmlData)
    {
        $streets = array();
        foreach ($districts as $cityId => $districtIds){
            foreach ($districtIds as $districtId){
                foreach ($streetXmlData as $record){
                    if (array_key_exists('SYM', $record) && $record['SYM'] == $districtId){
                        $name2 = array_key_exists('NAZWA_2', $record) ? $record['NAZWA_2'] : '';
                        $streets[$cityId][$districtId][$record['SYM_UL']]['prefix'] = $record['CECHA'];
                        $streets[$cityId][$districtId][$record['SYM_UL']]['name_1'] = $record['NAZWA_1'];
                        $streets[$cityId][$districtId][$record['SYM_UL']]['name_2'] = $name2;
                    }
                }
            }
        }
        // One street could belong to more then one district
        // Because SYM_UL id is array key -> there is no duplicates
        return $streets;
    }
    
    public function readStreetsByCities($cities, $streetXmlData)
    {
        $result = array();
        foreach ($cities as $cityId => $foo)
        {
            foreach ($streetXmlData as $record)
            {
                if (array_key_exists('SYM', $record) && $record['SYM'] == $cityId)
                {
                    $name2 = array_key_exists('NAZWA_2', $record) ? ' ' . $record['NAZWA_2'] : '';
                    $result[$cityId][0][$record['SYM_UL']]['prefix'] = $record['CECHA'];
                    $result[$cityId][0][$record['SYM_UL']]['name_1'] = $record['NAZWA_1'];
                    $result[$cityId][0][$record['SYM_UL']]['name_2'] = $name2;
                }
            }
        }
        // One street could belong to more then one district
        // Because SYM_UL id is array key -> there is no duplicates
        return $result;
    }
    
    public function saveStreetsIntoSqlFile($destinationDir, $streetData, $streetsTableGateway)
    {
        $file = fopen($destinationDir . 'streets.sql', 'w');
        
        $dbPlatform = $streetsTableGateway->getAdapter()->getPlatform();
        
        foreach ($streetData as $cityId => $city)
        {
            foreach ($city as $districtId => $district)
            {
                foreach ($district as $streetId => $street)
                {
                    $prefix = $dbPlatform->quoteValue($street['prefix']);
                    $name1 = $dbPlatform->quoteValue($street['name_1']);
                    $name2 = $dbPlatform->quoteValue($street['name_2']);
                    $line = 'insert into street (id,prefix,name_1,name_2,city_id_fk,district_id_fk) ';
                    $line .= 'values (' . $streetId . ',' . $prefix . ',' . $name1 . ',' . $name2 . ',' . $cityId . ',' . $districtId . ');';
                    fwrite($file, $line."\n");
                }
            }
        }

        fclose($file);
    }
}

?>
