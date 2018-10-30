<?php
require __DIR__ . '/vendor/autoload.php';

use Pachico\SlimSwoole\BridgeManager;
use Slim\Http;

// Get settings.
$config = require __DIR__ . '/config.php';

// Boot slim.
$app = new \Slim\App($config);

// Set up dependencies
require __DIR__ . '/dependencies.php';

// Register routes
require __DIR__ . '/routes.php';


$app->add(function (Http\Request $request, Http\Response $response, callable $next) {
    $response = $next($request, $response);
    return $response;
});

/**
 * We instanciate the BridgeManager (this library)
 */
$bridgeManager = new BridgeManager($app);

/**
 * We start the Swoole server
 */
$http = new swoole_http_server("127.0.0.5", 9501);

/**
 * We register the on "start" event
 */
$http->on("start", function (\swoole_http_server $server) {
    echo sprintf('Swoole http server is started at http://%s:%s', $server->host, $server->port), PHP_EOL;
});

/**
 * We register the on "request event, which will use the BridgeManager to transform request, process it
 * as a Slim request and merge back the response
 *
 */
$http->on(
    "request",
    function (swoole_http_request $swooleRequest, swoole_http_response $swooleResponse) use ($bridgeManager) {
        $bridgeManager->process($swooleRequest, $swooleResponse)->end();
    }
);

$http->start();
