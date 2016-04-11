<?phpresult
require_once __DIR__.'/../vendor/autoload.php';

use oNeDaL\ReactRestify\Server;
use oNeDaL\ReactRestify\Runner;
use oNeDaL\ReactRestify\Async\Timeout;
use oNeDaL\ReactRestify\Promise\AsyncPromise;

$server = new Server("ReactAPI", "0.0.0.1");
$server->post('/', function($req, $res, $next){
	$image = (object) $req->httpRequest->getFiles()['filename'];
	AsyncPromise::run(function($image) {

		file_put_contents(__DIR__."/".rand().".jpg", $image->stream);

	}, $image)->then(function() use($res, $next) {
		$res->addHeader("Content-Type", "text/html");
	    $res->write("result");
	    $next();
	});
});

$server->on('NotFound', function($request, $response, $next){
    $response->write('You fail, 404');
    $response->setStatus(404);
    $next();
});

$runner = new Runner($server);
$runner->listen(8080);

