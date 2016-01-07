<?php 
namespace CapMousse\ReactRestify\Async;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use CapMousse\ReactRestify\Runner;

class Timeout 
{

	public function run(callable $callback, $time)
	{
		$promise = new Promise();
		$loop = Runner::getLoop();
        $loop->addTimer($time, function () use ($promise, $callback){
             if ($promise->getState() === PromiseInterface::PENDING) {
                try {
                    $promise->resolve($callback());
                } catch (\Exception $e) {
                    $promise->reject($e);
                }
            }
        });

        return $promise;
	}

}
