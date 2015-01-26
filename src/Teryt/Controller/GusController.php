<?php

namespace Teryt\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Teryt\Model\Teryt;
use Teryt\Model\Street;
use Teryt\Model\District;
use Zend\Console\Request as ConsoleRequest;

class GusController extends AbstractActionController
{
    protected $cityTable;
    protected $streetTable;
    
    public function actualizeAction()
    {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest)
            throw new \RuntimeException('You can only use this action from a console!');
        
        $verbose = $request->getParam('verbose');
        
        $xmlPath = getcwd() . '/../tmp/gus/';
        
        $teryt = new Teryt();
        
        $localityXmlData = $teryt->readXmlFile($xmlPath . 'SIMC.xml');
        if ($verbose) echo 'File with districts parsed.' . "\n";
        
        $citiesWithDistricts = $this->getCityTable()->getCitiesWithDistricts();
        
        $district = new District();
        $districtData = $district->readDistricts($citiesWithDistricts, $localityXmlData);
        if ($verbose) echo 'Districts list prepared.' . "\n";
        
        $streetXmlData = $teryt->readXmlFile($xmlPath . 'ULIC.xml');
        if ($verbose) echo 'File with streets parsed.' . "\n";
        
        $citiesWithoutDistricts = $this->getCityTable()->getCitiesWithoutDistricts();
        
        $street = new Street();
        $streetData1 = $street->readStreetsByDistricts($districtData, $streetXmlData);
        $streetData2 = $street->readStreetsByCities($citiesWithoutDistricts, $streetXmlData);
        $streetData = $streetData1 + $streetData2;
        if ($verbose) echo 'Street list ready to save into sql file.' . "\n";
        
        $street->saveStreetsIntoSqlFile($xmlPath, $streetData, $this->getStreetTable()->getTableGateway());
        if ($verbose) echo 'Street list saved into sql file.' . "\n";
        
        $selectedCities = array(918123);
        $district->saveDistrictsIntoSqlFile($xmlPath, $localityXmlData, $citiesWithDistricts, $selectedCities);
        if ($verbose) echo 'District list saved into sql file.' . "\n";
    }
    
    public function getCityTable()
    {
        if (!$this->cityTable) {
            $sm = $this->getServiceLocator();
            $this->cityTable = $sm->get('Teryt\Model\CityTable');
        }
        return $this->cityTable;
    }
    
    public function getStreetTable()
    {
        if (!$this->streetTable) {
            $sm = $this->getServiceLocator();
            $this->streetTable = $sm->get('Teryt\Model\StreetTable');
        }
        return $this->streetTable;
    }
}

?>
