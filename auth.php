#!/usr/bin/env php
<?php

require implode(DIRECTORY_SEPARATOR, [__DIR__, 'vendor', 'autoload.php']);

use Finagin\CertBotCloudFlare\CloudFlare;

$config = json_decode(file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__, 'config.json'])), true);

CloudFlare::init(...$config['auth']);

$output = json_decode(file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__, 'auth-output.json'])), true);

$output['txt'][] = CloudFlare::post('dns_records', [
    'type' => 'TXT',
    'name' => '_acme-challenge',
    'content' => getenv('CERTBOT_VALIDATION'),
]);

file_put_contents(
    implode(DIRECTORY_SEPARATOR, [__DIR__, 'auth-output.json']),
    json_encode($output, JSON_PRETTY_PRINT)
);

sleep(5);
