<?php
// public/index.php — Front Controller (MVC Router)

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

// Autoload controllers and models
spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/'      . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Simple path-based router
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base   = rtrim(BASE_URL, '/');
$path   = $base !== '' ? preg_replace('#^' . preg_quote($base, '#') . '#', '', $uri) : $uri;
$path   = '/' . trim($path, '/');
$method = $_SERVER['REQUEST_METHOD'];

// Route table: [METHOD, path, Controller, action]
$routes = [
    // Dashboard
    ['GET',  '/',                    'DashboardController','index'],
    ['GET',  '/dashboard',           'DashboardController','index'],

    // Suppliers
    ['GET',  '/suppliers',           'SupplierController', 'index'],
    ['GET',  '/suppliers/create',    'SupplierController', 'create'],
    ['POST', '/suppliers/store',     'SupplierController', 'store'],
    ['GET',  '/suppliers/edit',      'SupplierController', 'edit'],
    ['POST', '/suppliers/update',    'SupplierController', 'update'],
    ['POST', '/suppliers/delete',    'SupplierController', 'delete'],

    // Orders
    ['GET',  '/orders',              'OrderController',    'index'],
    ['GET',  '/orders/create',       'OrderController',    'create'],
    ['POST', '/orders/store',        'OrderController',    'store'],
    ['GET',  '/orders/view',         'OrderController',    'view'],
    ['GET',  '/orders/edit',         'OrderController',    'edit'],
    ['POST', '/orders/update',       'OrderController',    'update'],
    ['POST', '/orders/delete',       'OrderController',    'delete'],
    ['GET',  '/orders/receipt',      'OrderController',    'receipt'],
    ['POST', '/orders/status',       'OrderController',    'updateStatus'],
];

$matched = false;
foreach ($routes as [$rMethod, $rPath, $controller, $action]) {
    if ($method === $rMethod && $path === $rPath) {
        $ctrl = new $controller();
        $ctrl->$action();
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    require __DIR__ . '/../app/views/404.php';
}
