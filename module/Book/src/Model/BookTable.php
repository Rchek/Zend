<?php 

namespace Book\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Where;
use SimpleXMLElement;

class BookTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }


	public function getBooks($params, $format)
    {

		foreach($params as $key =>$val){
			$$key = $val;
		}

		$where = new Where(); 
		//If isbn provided it needs to match exactly
		if(isset($isbn)){
			$subWhereForIsbn = clone $where;
			$subWhereForIsbn->like('isbn', $isbn);
			$where->addPredicate($subWhereForIsbn);
		}

		//Minimum rating 
		if(isset($minrating)){
			 $subWhereForRating = clone $where;
			 $subWhereForRating->equalTo('rating', $minrating);
			 $subWhereForRating->or;
			 $subWhereForRating->greaterThan('rating', $minrating);
			 $where->addPredicate($subWhereForRating);
			
		}
		
		//Title needs to partially match
		if(isset($title)){
			$subWhereForTitle = clone $where;
			$subWhereForTitle->like('title', '%'.$title.'%');
			$where->addPredicate($subWhereForTitle);
		}
 
		
		//From Date
		if(isset($from)){
			 $subWhereForFromDate = clone $where;
			 $subWhereForFromDate->equalTo('publicationdate', $from);
			 $subWhereForFromDate->or;
			 $subWhereForFromDate->greaterThan('publicationdate', $from);
			 $where->addPredicate($subWhereForFromDate);
		}
		
		//To Date
		if(isset($to)){
			 $subWhereForToDate = clone $where;
			 $subWhereForToDate->equalTo('publicationdate', $to);
			 $subWhereForToDate->or;
			 $subWhereForToDate->lessThan('publicationdate', $to);
			 $where->addPredicate($subWhereForToDate);
		}
		
		//Author needs to partially match
		if(isset($author)){
			$subWhereForAuthor = clone $where;
			$subWhereForAuthor->like('author', '%'.$author.'%');
			$where->addPredicate($subWhereForAuthor);
		}
		
		//Return Json or XML response
		return $this->generateResponse($this->tableGateway->select($where), $format);
 
    }
	
	private function generateResponse($data, $format){
		if($format=="json"){
			$finalArray=array();
			foreach($data as $result){
				//echo "result for id {$result->id}<br>";
				$finalArray[]=array(
				"id"=>$result->id, 
				"isbn"=>$result->isbn , 
				"author"=>$result->author , 
				"title"=>$result->title,
				"description"=>$result->description,
				"publicationdate"=>$result->publicationdate,
				"rating"=>$result->rating
				
				);
			}
			
			return $finalArray;
		}
		else if($format=="xml"){
				$rawXml = new SimpleXMLElement('<xml/>');
				$rawXml->addChild('books_collection');
				
				foreach($data as $result){
					$book= $rawXml->addChild('book');
					$book->addChild('id',$result->id);
					$book->addChild('isbn',$result->isbn);
					$book->addChild('author',$result->author);
					$book->addChild('title',$result->title);
					$book->addChild('description',$result->description);
				}
		
				$rawXml=$rawXml->asXML();
				return $rawXml;
		}
		 
	}

}