<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';

// Create DI container
$container = new Container();

// Configure logger
$logger = new Logger('yggdrasil-mock');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
$container->set('logger', $logger);

// Configure controllers
$container->set('App\Controllers\AuthController', function($container) {
    return new App\Controllers\AuthController($container->get('logger'));
});

$container->set('App\Controllers\SessionController', function($container) {
    return new App\Controllers\SessionController($container->get('logger'));
});

$container->set('App\Controllers\ProfileController', function($container) {
    return new App\Controllers\ProfileController($container->get('logger'));
});

$container->set('App\Controllers\MetaController', function($container) {
    return new App\Controllers\MetaController($container->get('logger'));
});

// Create Slim app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add middleware
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

// Load routes
require __DIR__ . '/../config/routes.php';

// Run app
$app->run();
