<?php

//echo(''."\n\n");
require __DIR__ . "/petstock/vendor/autoload.php";

$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8888',
    'defaults' => [
        'exception' => false,
    ]
]);

$response = $client->post('/petstock/web/test');
die('#');//echo "#$$$";
echo $response;
echo "\n\n";