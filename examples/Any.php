<?php
require_once '../vendor/autoload.php';

class IndexController 
{

    private $todoList;

    public function __construct()
    {
        $this->todoList = [
            ["name" => "Build a todo list example", "value" => "done"]
        ];
    }

    public function get($request, $response, $next) 
    {   
        $id = filter_var($request->id, FILTER_SANITIZE_NUMBER_INT);

        if( is_numeric($id) ) 
            $response->writeJson((object) $this->todoList[$id]);
        else 
            $response->writeJson((object) $this->todoList);
        
        $next();
    }

    public function post($request, $response, $next) 
    {   
        if (! $request->name) {
            $response->setStatus(500);
            return $next();
        }

        $this->todoList[] = ["name" => $request->name, "value" => "waiting"];
        $id = count($this->todoList)-1;

        $response->writeJson((object)array("id" => $id));
        $next();
    }


}

$server = new CapMousse\ReactRestify\Server("ReactAPI", "0.0.0.1");

$server->any('/{id}', 'IndexController')->where('id', '[0-9]?');
$server->on('NotFound', function($request, $response, $next){
    $response->write('You fail, 404');
    $response->setStatus(404);
    $next();
});

$runner = new CapMousse\ReactRestify\Runner($server);
$runner->listen("9000");