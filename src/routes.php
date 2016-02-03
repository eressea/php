<?php
// Routes

$app->put('/upload', function ($request, $response, $args) {
    $this->logger->info("Eressea '/upload' route");
    $text = $request->getBody();
    do {
        $rng = uniqid();
        $filename = 'upload/' . $rng . '.txt';
    } while (file_exists($filename));
    $f = fopen($filename, "w");
    if ($f) {
        fwrite($f, $text);
        echo $rng . "\n";
        fclose($f);
    } else {
        return $response->withStatus(500);
    }
    return $response;
});

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
