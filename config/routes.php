<?php

use Slim\Routing\RouteCollectorProxy;

// Auth routes
$app->group('/authserver', function (RouteCollectorProxy $group) {
    $group->post('/authenticate', 'App\Controllers\AuthController:authenticate');
    $group->post('/refresh', 'App\Controllers\AuthController:refresh');
    $group->post('/validate', 'App\Controllers\AuthController:validate');
    $group->post('/invalidate', 'App\Controllers\AuthController:invalidate');
    $group->post('/signout', 'App\Controllers\AuthController:signout');
});

// Session routes
$app->group('/sessionserver/session/minecraft', function (RouteCollectorProxy $group) {
    $group->post('/join', 'App\Controllers\SessionController:join');
    $group->get('/hasJoined', 'App\Controllers\SessionController:hasJoined');
    $group->get('/profile/{uuid}', 'App\Controllers\ProfileController:getProfile');
});

// API routes
$app->group('/api', function (RouteCollectorProxy $group) {
    $group->post('/profiles/minecraft', 'App\Controllers\ProfileController:batchProfiles');
    $group->put('/user/profile/{uuid}/{textureType}', 'App\Controllers\ProfileController:uploadTexture');
    $group->delete('/user/profile/{uuid}/{textureType}', 'App\Controllers\ProfileController:deleteTexture');
});

// Meta endpoint
$app->get('/', 'App\Controllers\MetaController:index');
