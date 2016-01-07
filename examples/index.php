<?php
require_once __DIR__.'/../vendor/autoload.php';

use CapMousse\ReactRestify\Server;
use CapMousse\ReactRestify\Runner;
use CapMousse\ReactRestify\Async\{Interval, Timeout};

require_once __DIR__."/src/Controllers/ProductController.php";

$server = new Server("ReactAPI", "0.0.0.1");

Interval::run([new App\Controllers\ProductController, 'test'], 1);
Interval::run(function(){
	echo "closure method \n";
}, 1);

$server->any('/products', 'App\Controllers\ProductController')->where('id', '[0-9]?');
$server->on('NotFound', function($request, $response, $next){
	
	(new Timeout())->run(function(){
		echo "hello";
	}, 4);

    $response->write('You fail, 404');
    $response->setStatus(404);
    $next();
});

$runner = new Runner($server);
$runner->listen(1337);

