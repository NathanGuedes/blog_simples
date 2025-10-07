<?php

use DI\ContainerBuilder;
use Predis\Autoloader;
use Predis\Client;
use Providers\AppServiceProvider;

date_default_timezone_set('America/Sao_Paulo');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

Autoloader::register();
$client = new Client([
    'scheme' => 'tcp',
    'host'   => $_ENV['REDIS_HOST'],
    'port'   => $_ENV['REDIS_PORT'],
]);


$builder = new ContainerBuilder();
$builder->addDefinitions(AppServiceProvider::definitions());
$container = $builder->build();

require basePath() . '/app/Routes/web.php';