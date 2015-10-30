<?php

$filename = __DIR__.'/../config/config.php';
if(!file_exists($filename)){
    echo "Config file doesn't exist: ".$filename;
}

$config = include($filename);

$client = new \BIMData\Intent\Client($config['client_id'], $config['client_secret'], new \BIMData\Intent\Token\Storage\Session());

$service = new \BIMData\Intent\Service\Site($config['site'], $client);

$activities = $service->activities();

dump($activities);

