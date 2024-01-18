<?php

require 'vendor/autoload.php';

use React\EventLoop\Loop;
use React\Http\Browser;
use Psr\Http\Message\ResponseInterface;

$loop = Loop::get();
$client = new Browser($loop);

$sites = [
    'https://google.com',
    'https://teste.com',
    'https://brtech.dev',
    'https://brdocs.com',
];
$interval = 5;

$checkSite = function () use ($client, $sites) {
    foreach ($sites as $site) {
        $client->get($site)->then(function (ResponseInterface $response) use ($site) {
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                echo "\nO site $site está no ar!";
            } else {
                echo "\nO site $site está FORA do ar.\nStatusCode: $statusCode";
            }
        }, function (Exception $e) {
            echo "\nError: " . $e->getMessage() . PHP_EOL;
        });
    }
};

$loop->addPeriodicTimer($interval, $checkSite);

echo "Monitoramento iniciado. Pressione Ctrl+C para sair";
$loop->run();
