<?php 
namespace App\Controllers;

require_once __DIR__."/../Domain/Storage.php";
require_once __DIR__."/../Domain/Product.php";

use App\Domain\Storage;
use App\Domain\Product;

class ProductController 
{

	private $storage;

	public function __construct()
	{
		$this->storage = new Storage();
	}

	public function get($request, $response, $next)
	{
	 	$response->writeJson((object) $this->storage->toArray());
		$next();
	}

	public function post($request, $response, $next)
	{
	 	$product = new Product($request->name);
	    $item = $storage->insert($product);

	    $response->writeJson((object) $item->toArray());
	    $next();
	}

	public function delete($request, $response, $next)
	{
	  	if( $storage->remove($request->id) )
	        $response->writeJson((object) [true]);

	    $next();
	}

	public function test() 
	{
		echo "class method \n";
	}
}