<?php

function showError(int $code, string $message): void
{
    http_response_code($code);
    $errorCode = $code;
    $errorMessage = $message;
    $view = __DIR__ . '/views/Error.php';
    require __DIR__ . '/views/Main.php';
    exit;
}

$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$allowedControllers = [
    'home' => 'HomeController',
    'product' => 'ProductController',
    'cart' => 'CartController',
];

if (!isset($allowedControllers[$controllerName])) {
    showError(404, 'Controller not found');
}

$controllerClass = $allowedControllers[$controllerName];
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    showError(500, 'Controller file not found');
}

require_once $controllerFile;

$controller = new $controllerClass();

if (!is_callable([$controller, $action])) {
    showError(404, 'Action not found');
}

$controller->$action();
