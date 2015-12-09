<?php 
namespace CapMousse\ReactRestify\Promise;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use CapMousse\ReactRestify\Runner;

class AsyncPromise 
{

	public static function run(callable $callback, $value = null) 
	{
		$promise = new FulfilledPromise($value);
        return $promise->then($callback);
	}

	public static function timeout(callable $callback, $value, $time)
	{			
		$promise = new Promise();
		$loop = Runner::getLoop();
        $loop->addTimer($time, function () use ($promise, $value, $callback){
             if ($promise->getState() === PromiseInterface::PENDING) {
                try {
                    $promise->resolve($callback($value));
                } catch (\Exception $e) {
                    $promise->reject($e);
                }
            }
        });

        return $promise;
	}
}