<?php
// Routes

$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Eressea '/' route");
    // Render index view
    $app->render('index.html');
});

function store_orders($text) {
    do {
        $rng = uniqid();
        $filename = __DIR__ . '/../upload/' . $rng . '.txt';
    } while (file_exists($filename));
    $f = fopen($filename, "w");
    if ($f) {
        fwrite($f, $text);
        fclose($f);
        return $rng;
    }
    return null;
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
