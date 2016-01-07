<?php

namespace CapMousse\ReactRestify;

use React\EventLoop\Factory;
use React\Socket\Server as SocketServer;
use React\Http\Server as HttpServer;
use CapMousse\ReactRestify\Async\Interval;

class Runner
{
    private $app;

    private static $loop;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function getLoop() 
    {
        return self::$loop;
    }

    public function listen($port, $host = '127.0.0.1')
    {
        self::$loop = Factory::create();
        $socket = new SocketServer(self::$loop);
        $http = new HttpServer($socket);

        $queue = \GuzzleHttp\Promise\queue();
        $queue->run();
        
        self::$loop->addPeriodicTimer(0, [$queue, 'run']);
        
        //Add Intervals
        $intervals = Interval::getIntervals();
        if($intervals instanceof \ArrayIterator) {

            foreach ($intervals as $interval) 
                self::$loop->addPeriodicTimer($interval->getTime(), $interval->getCallback());
        }
        
        $http->on('request', $this->app);
        echo("Server running on {$host}:{$port}\n");

        $socket->listen($port, $host);
        self::$loop->run();
    }
}
