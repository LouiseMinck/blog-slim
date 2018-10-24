<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

//-------------Rendre la route ADMIN

$app->get('/admin/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'admin.html', [
        'name' => $args['name']
    ]);
})->setName('admin'); //Nom de la route

//-------------Rendre la route BLOG

$app->get('/', App\Controller\BlogController::class . ':home');
$app->get('/blog', App\Controller\BlogController::class . ':show');
$app->get('/blog/{slug}', App\Controller\BlogController::class . ':single');
$app->get('/insert', App\Controller\AdminController::class . ':insert');
$app->get('/edit/{slug}', App\Controller\AdminController::class . ':edit');

$app->post('/insert', App\Controller\AdminController::class . ':insertpost');
$app->post('/delete/{slug}', App\Controller\AdminController::class . ':supp');


// API
$app->get('/api/single/{slug}', App\Controller\AdminController::class . ':apiSingle');
$app->post('/api/edit/{slug}', App\Controller\AdminController::class . ':editPost');

