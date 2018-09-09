<?php
namespace BookTest\Controller;

use Book\Controller\BookController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BookControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {

        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            // Grabbing the full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

	//This test checks that the route works properly, returns a 200 response and an empty json object 
	public function testRoutesRespond()
	{
		$this->dispatch('/book');		
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('Book');
		$this->assertControllerName(BookController::class);
		$this->assertControllerClass('BookController');
		$this->assertMatchedRouteName('book.restful');
		
		//Check if json object is empty
		$data = json_decode($this->getResponse()->getBody(), true);
		$this->assertArrayHasKey('nodata', $data[0]);
	}
	
	//Test if a valid request returns a book collection
	public function testBooksRespond()
	{
		$this->dispatch('/book/from/1995/to/2006');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('Book');
		$this->assertControllerName(BookController::class);
		$this->assertControllerClass('BookController');
		$this->assertMatchedRouteName('book.restful');
		//Check if json object has data
		$data = json_decode($this->getResponse()->getBody(), true);
		$this->assertArrayHasKey('books', $data[0]);
	
	}
	
	//Test if POST method return "Not Allowed"
	public function testPostAction()
	{
		$this->getRequest()->setMethod('POST');
		$this->dispatch('/book');
		$this->assertResponseStatusCode(405);
	}
	
	//Test if PUT method return "Not Allowed"
	public function testPutAction()
	{
		$this->getRequest()->setMethod('PUT');
		$this->dispatch('/book');
		$this->assertResponseStatusCode(405);
	}
	
	//Test if PATCH method return "Not Allowed"
	public function testPatchAction()
	{
		$this->getRequest()->setMethod('POST');
		$this->dispatch('/book');
		$this->assertResponseStatusCode(405);
	}
	
	
	//Test if DELETE method return "Not Allowed"
	public function testDeleteAction()
	{
		$this->getRequest()->setMethod('DELETE');
		$this->dispatch('/book');
		$this->assertResponseStatusCode(405);
	}
	
	//Check if a broken / non valid route returns a 404 as it should
	public function testInvalidRoute()
	{
		$this->dispatch('/bookdiue');
		$this->assertResponseStatusCode(404);
	}
	
}