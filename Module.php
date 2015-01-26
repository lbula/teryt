<?php

namespace Teryt;

use Teryt\Model\City;
use Teryt\Model\CityTable;
use Teryt\Model\District;
use Teryt\Model\DistrictTable;
use Teryt\Model\Street;
use Teryt\Model\StreetTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Teryt\Model\CityTable' => function($sm) {
                    $tableGateway = $sm->get('CityTableGateway');
                    $table = new CityTable($tableGateway);
                    return $table;
                },
                'Teryt\Model\DistrictTable' => function($sm) {
                    $tableGateway = $sm->get('DistrictTableGateway');
                    $table = new DistrictTable($tableGateway);
                    return $table;
                },
                'Teryt\Model\StreetTable' => function($sm) {
                    $tableGateway = $sm->get('StreetTableGateway');
                    $table = new StreetTable($tableGateway);
                    return $table;
                },
                'CityTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('3rd_party');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new City());
                    return new TableGateway('city', $dbAdapter, null, $resultSetPrototype);
                },
                'DistrictTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('3rd_party');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new District());
                    return new TableGateway('district', $dbAdapter, null, $resultSetPrototype);
                },
                'StreetTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('3rd_party');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Street());
                    return new TableGateway('street', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
            // available commands
            'gus actualize [--verbose|-v]'      => 'Update streets database using Teryt xml files (GUS database)',
            
            // expected parameters
            array('--verbose|-v', '(optional) turn on verbose mode'),
        );
    }
}

?>
