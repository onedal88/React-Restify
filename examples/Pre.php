<?php

require '../vendor/autoload.php';

$server = new oNeDaL\ReactRestify\Server("HelloWorldServer", "0.0.0.0");

$server->get('/hello/[name]:any', function ($request, $response, $args) {
    $response->write("Hello ".$args['name']);
});

$runner = new oNeDaL\ReactRestify\Runner($server);
$runner->listen(1337, "0.0.0.1");
