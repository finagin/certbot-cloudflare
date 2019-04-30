#!/usr/bin/env php
<?php

require implode(DIRECTORY_SEPARATOR, [__DIR__, 'vendor', 'autoload.php']);

use Finagin\CertBotCloudFlare\CloudFlare;

$config = json_decode(file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__, 'config.json'])), true);

CloudFlare::init(...$config['auth']);

$records = json_decode(file_get_contents(
    implode(DIRECTORY_SEPARATOR, [__DIR__, 'auth-output.json'])), true
);

$output = ['txt' => []];

foreach ($records['txt'] as $record) {
    $output['txt'][] = CloudFlare::delete('dns_records/'.$record['result']['id']);
}

file_put_contents(
    implode(DIRECTORY_SEPARATOR, [__DIR__, 'cleanup-output.json']),
    json_encode($output, JSON_PRETTY_PRINT)
);
