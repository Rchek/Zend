<?php

namespace Book\Controller;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use Book\Model\BookTable;


class BookRpcController extends AbstractActionController
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
	
    public function indexAction()
    {
		$data   = $this->getRequest()->getContent(); 
		foreach(json_decode($data)->params[0] as $key =>$val){
			$this->paramsArray[$key]=$val;
		}
 
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
}
