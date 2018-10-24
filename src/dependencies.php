<?php
// DIC configuration

$container = $app->getContainer();

//----------------ELOUENT----------------//

// Service factory for the ORM
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

//----------------TWIG----------------//

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig($container['settings']['renderer']['twig_template_path'], [
        'cache' => $container['settings']['renderer']['twig_cache_path']
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

//----------------Logs----------------//

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//----------------BlogController----------------//

$container[App\Controller\BlogController::class] = function($c) { //step1 j'ajoute la class au container
    $view = $c->get("view"); // retrieve the 'view' from the container
    $tableData = $c->get('db')->table('articles');
    return new App\Controller\BlogController($view, $tableData);
};

$container[App\Controller\AdminController::class] = function($c) { //step1 j'ajoute la class au container
    $view = $c->get("view"); // retrieve the 'view' from the container
    $tableData = $c->get('db')->table('articles');
    return new App\Controller\AdminController($view, $tableData);
};