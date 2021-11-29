<?php

use Test\App;

require 'vendor/autoload.php';

$app = new App;

$container = $app->getContainer();

$container['errorHandler'] = function () {
    return function ($response) {
        return $response->setBody('Page not found test')->withStatus(404);
    };
};

$container['config'] = function () {
    return [
        'db_driver' => 'mysql',
        'db_host' => 'db',
        'db_name' => 'inchoo',
        'db_user' => 'inchoo',
        'db_password' => 'inchoo'
    ];
};

$container['db'] = function ($c) {
    return new PDO(
        $c->config['db_driver'] . ':host=' . $c->config['db_host'] . ';dbname=' . $c->config['db_name'],
        $c->config['db_user'],
        $c->config['db_password']
    );
};

$app->get('/', [Test\Controllers\HomeController::class, 'index']);
$app->get('/users', [new Test\Controllers\UserController($container->db), 'index']);

$app->run();