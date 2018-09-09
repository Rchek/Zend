<?php

namespace Book\Controller;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use Book\Model\BookTable; 
use SimpleXMLElement;

 
use Zend\Soap\AutoDiscover as SoapWsdlGenerator;
use Zend\Soap\Server as SoapServer;


class BookSoapController extends AbstractActionController
{
	private $table;
	private $paramsArray=array();
	private $route;
    private $soap;
    private $wsdlGenarator;
	
    public function __construct(BookTable $table, $route, SoapServer $soapServer, SoapWsdlGenerator $wsdlGenerator)
    {
		$this->table = $table;
        $this->route = $route;
        $this->soap = $soapServer;
        $this->wsdlGenerator = $wsdlGenerator;
    }
 
	
    public function soapAction()
    {
		$request  = $this->getRequest();
        $response = $this->getResponse();
        switch ($request->getMethod()) {
		
			//For a GET request, it returns a wsdl/xml response. This part is meant to be implemented in the future.
            case 'GET':
                $this->wsdlGenerator->setUri("/soap");
				$this->wsdlGenerator->setServiceName("soapservice");
                $wsdl = $this->wsdlGenerator->generate();
                $response->getHeaders()->addHeaderLine('Content-Type', 'application/wsdl+xml');
                $response->setContent($wsdl->toXml());
                break;
				
            case 'POST':
                $this->soap->setReturnResponse(true);				 
				$parameters=   new SimpleXMLElement($request->getContent());
				
				//I parse the XML data into a php array
				foreach($parameters->xpath('//v1:parameters') as $event) {					
					$this->paramsArray["from"]=  !empty($event->xpath('v1:from')[0]) ?  (string)$event->xpath('v1:from')[0] : null;
					$this->paramsArray["to"]=   !empty($event->xpath('v1:to')[0]) ?  (string)$event->xpath('v1:to')[0] : null;
					$this->paramsArray["author"]=  !empty($event->xpath('v1:author')[0]) ?  (string)$event->xpath('v1:author')[0] : null;
					$this->paramsArray["isbn"]=  !empty($event->xpath('v1:isbn')[0]) ?  (string)$event->xpath('v1:isbn')[0] : null;
					$this->paramsArray["title"]=  !empty($event->xpath('v1:title')[0]) ?  (string)$event->xpath('v1:title')[0] : null;
					$this->paramsArray["minrating"]=  !empty($event->xpath('v1:minrating')[0]) ?  (string)$event->xpath('v1:minrating')[0] : null;
				}
				//Get results from database
				$rawXml=$this->table->getBooks($this->paramsArray, "xml");
				$response->getHeaders()->addHeaderLine('Content-Type', 'application/xml');
				$response->setContent($rawXml);
				
				
				return $response;
                break;
				
				default:
                $response->setStatusCode(405);
                $response->getHeaders()->addHeaderLine('Allow', 'GET, POST');
                break;
        }
        return $response;


    }
}
