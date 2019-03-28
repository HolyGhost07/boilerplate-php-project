<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

define('ROOT_PATH', __DIR__);

if (!file_exists($file = ROOT_PATH . '/vendor/autoload.php')) {
    throw new RuntimeException('Install dependencies to run this script.');
}

require_once $file;

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) {
    phpinfo();
});

$app->get('/ping', function (Request $request, Response $response) {
    $response = $response->withHeader('Content-Type', 'application/json')
        ->withStatus(200)
        ->withJson(['ping' => 'pong', 'code' => 200]);

    return $response;
});

$app->get('/check-mysql', function (Request $request, Response $response) {
    $host = getenv('MYSQL_HOST', 'mysql');
    $db = getenv('MYSQL_DATABASE', 'test');
    $port = getenv('MYSQL_PORT', 3306);
    $username = getenv('MYSQL_USER', '');
    $password = getenv('MYSQL_PASSWORD', '');

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$db";
        $conn = new \PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $response = $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withJson([
                'dsn' => $dsn,
                'message' => 'Connected successfully',
                'code' => 200,
            ]);
    } catch(PDOException $e) {
        $response = $response->withHeader('Content-Type', 'application/json')
            ->withStatus(503)
            ->withJson([
                'dsn' => $dsn,
                'message' => 'Connection failed: ' . $e->getMessage(),
                'code' => 503,
            ]);
    }

    return $response;
});

$app->run();
