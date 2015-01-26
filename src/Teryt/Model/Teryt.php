<?php

namespace Teryt\Model;

class Teryt
{
    public function readXmlFile($file)
    {
        $reader = new \XMLReader();
        $reader->open($file);
        $counter = 0;
        $out = array();
        while($reader->read()) {
            if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'row') {
                $out[$counter] = array();
                while($reader->read()) {
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'col') {
                        $key = $reader->getAttribute('name');
                    }
                    if($reader->nodeType == \XMLReader::TEXT || $reader->nodeType == \XMLReader::CDATA) {
                        $out[$counter][$key] = $reader->value;
                    }
                    if($reader->nodeType == \XMLReader::END_ELEMENT && $reader->name == 'row') {
                        break;
                    }
                }
                $counter++;
            }
        }
        return $out;
    }
}

?>
