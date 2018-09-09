<?php
namespace Book;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Soap\AutoDiscover as SoapWsdlGenerator;
use Zend\Soap\Server as SoapServer;


class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
	
	public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\BookTable::class => function($container) {
                    $tableGateway = $container->get(Model\BookTableGateway::class);
                    return new Model\BookTable($tableGateway);
                },
                Model\BookTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
					//The Album Entity (table) instance 
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Book());
                    return new TableGateway('books', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
	
	public function getControllerConfig()
    {
        return [
            'factories' => [
				//Restful Controller
                Controller\BookController::class => function($container) {
                    return new Controller\BookController(
                        $container->get(Model\BookTable::class)
                    );
                },
				
				
				//Rpc-Json Controller
				
				Controller\BookRpcController::class => function($rpc_container) {
                    return new Controller\BookRpcController(
                        $rpc_container->get(Model\BookTable::class)
                    );
                },
				
				
				//SOAP Controller
				
				 Controller\BookSoapController::class => function($soap_container) {
                    return new Controller\BookSoapController(
                        $soap_container->get(Model\BookTable::class),"/soap", new SoapServer(), new SoapWsdlGenerator()
                    );
                },
				 
            ],
        ];
    }
	
}