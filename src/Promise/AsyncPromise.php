<?php 
namespace CapMousse\ReactRestify\Promise;

use GuzzleHttp\Promise\FulfilledPromise;
use CapMousse\ReactRestify\Async\Timeout;

class AsyncPromise 
{

	public static function run(callable $callback, $value = null) 
	{
		$promise = new FulfilledPromise($value);
        return $promise->then($callback);
	}

	public static function timeout(callable $callback, $time)
	{			
		return (new Timeout())->run($callback, $time);
	}
    
}