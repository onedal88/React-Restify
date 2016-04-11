<?php

require '../vendor/autoload.php';

$server = new oNeDaL\ReactRestify\Server("HelloWorldServer", "0.0.0.1");

$server->get('/hello/{name}', function ($request, $response, $next) {
    $response->write("Hello {$request->name}");
    $response->end();
});

$runner = new oNeDaL\ReactRestify\Runner($server);
$runner->listen(1337);
