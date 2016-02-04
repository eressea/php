<?php
require __DIR__ . '/../vendor/autoload.php';

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => __DIR__ . '/../templates',
));

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath(__DIR__ . '/../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Eressea '/' route");
    // Render index view
    $app->render('index.html');
});

function store_orders($text) {
    return uniqid();
}

$app->put('/upload', function() use ($app) {
    $app->log->info("Eressea '/' upload");
    $body = $app->request->getBody();
    $uid = store_orders($body);
    if ($uid) {
        $app->response->setBody($uid . "\n");
    } else {
        $app->response->setStatus(500);
    }
});

// Run app
$app->run();
