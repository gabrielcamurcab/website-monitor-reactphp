<?php

require 'vendor/autoload.php';

use React\EventLoop\Loop;
use React\Http\Browser;

$loop = Loop::get();
$client = new Browser($loop);

$siteUrl = 'https://brtech.dev';
$interval = 5;

$checkSite = function () use ($client, $siteUrl) {
    $client->get($siteUrl)->then(function (Psr\Http\Message\ResponseInterface $response) use ($siteUrl) {
        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            echo "\nO site $siteUrl está no ar!";
        } else {
            echo "\nO site $siteUrl está FORA do ar.\nStatusCode: $statusCode";
        }
    }, function (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    });
};

$loop->addPeriodicTimer($interval, $checkSite);

echo "Monitoramento iniciado para $siteUrl. Pressione Ctrl+C para sair";
$loop->run();
