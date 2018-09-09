<?php
namespace Book\Model;

class Book
{
    public $id;
    public $isbn;
    public $author;
    public $title;
    public $description;
    public $publicationdate;
    public $rating;
	private $tableColumns;
	
    public function exchangeArray(array $data)
    {
		$this->tableColumns=array("id","isbn","author","title","description","publicationdate", "rating" );
		foreach($this->tableColumns as $colname){
			 $this->$colname   = !empty($data[$colname]) ? $data[$colname] : null;
		}
    }
}