<?php

namespace Book\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Zend\View\Model\ViewModel;
use Book\Model\BookTable;

class BookController extends AbstractRestfulController
{
    private $table;
	private $isbn;
	private $author;
	private $paramsArray=array();
	private $allowedMethods = array('GET');
	
    public function __construct(BookTable $table)
    {
        $this->table = $table;
    }
 
 
    public function getList()
    {	

		$this->paramsArray["author"]= $this->params("author");
		$this->paramsArray["minrating"]= $this->params("minrating");
		$this->paramsArray["title"]= $this->params("title");
		$this->paramsArray["isbn"]= $this->params("isbn");
		$this->paramsArray["from"]= $this->params("from");
		$this->paramsArray["to"]= $this->params("to");
		
		if(
			is_null($this->paramsArray["author"]) &&
			is_null($this->paramsArray["minrating"]) &&
			is_null($this->paramsArray["title"]) &&
			is_null($this->paramsArray["isbn"]) &&
			is_null($this->paramsArray["from"]) &&
			is_null($this->paramsArray["to"])
		){
			return new JsonModel(array(
				array('nodata' => "please provide at least one of the following parameters : isbn, author, title, minrating, publicationdate")
			));
		}
		
		$resultSet=$this->table->getBooks($this->paramsArray, "json");

		return new JsonModel(array(
            array('books' => $resultSet)
        ));
 
	 
    }
	
	
	//Sends an error if the client tries to post data
	public function create($data){
		 $response = $this->getResponse();
		 $response->setStatusCode(405); // Method Not Allowed
		 return $response;
	} 
	
	public function patchList($data){
		 $response = $this->getResponse();
		 $response->setStatusCode(405); // Method Not Allowed
		 return $response;
	} 
	
	
	public function deleteList($data){
		 $response = $this->getResponse();
		 $response->setStatusCode(405); // Method Not Allowed
		 return $response;
	}
	
	public function replaceList($data){
		 $response = $this->getResponse();
		 $response->setStatusCode(405); // Method Not Allowed
		 return $response;
	}
	
	public function updateList($data){
		 $response = $this->getResponse();
		 $response->setStatusCode(405); // Method Not Allowed
		 return $response;
	}
}