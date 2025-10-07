<?php

global $container;

use Core\Request;
use Core\Router;
use Http\Controllers\Auth\RegisterController;
use Http\Controllers\Auth\SessionController;
use Http\Controllers\Auth\UserManagerController;
use Http\Controllers\HomeController;

try {
    $router = $container->get(Router::class);

    // Home
    $router->add('GET', '/', [HomeController::class, 'index']);

    // Register
    $router->add('GET', '/register', [RegisterController::class, 'index'], ['guest']);

    $router->add('POST', '/register', function () use ($container) {
        $controller = $container->get(RegisterController::class);
        $request = $container->get(Request::class)->post;
        $controller->register($request);
    }, ['guest']);

    // Login
    $router->add('GET', '/login', [SessionController::class, 'index'], ['guest']);

    $router->add('POST', '/login', function () use ($container) {
        $controller = $container->get(SessionController::class);
        $request = $container->get(Request::class)->post;
        $controller->store($request);
    }, ['guest']);

    // Logout
    $router->add('POST', '/logout', [SessionController::class, 'destroy'], ['auth']);

    // Email Activation
    $router->add('GET', '/email/activation/send', function () use ($container){
        $controller = $container->get(UserManagerController::class);
        $userEmail = $_SESSION['user']['email'] ?? null;
        $controller->startSendEmailActivation($userEmail);
    }, ['auth', 'notActive']);

    $router->add('GET', '/email/activation/{token:\w+}', [UserManagerController::class, 'confirmEmailActivation']);

    // Forgot Password
    $router->add('GET', '/forgot/password/email', [UserManagerController::class, 'showForgotPasswordEmailForm'], ['guest']);

    $router->add('POST', '/forgot/password/email/send', function () use ($container){
        $controller = $container->get(UserManagerController::class);
        $data = (Request::create())->post;
        $controller->startSendEmailForgotPassword($data);
    }, ['guest']);

    $router->add('GET', '/forgot/password/email/recovery/{token:\w+}', [UserManagerController::class, 'showForgotPasswordRecoveryForm']);

    $router->add('POST', '/password/update', function () use ($container){
        $controller = $container->get(UserManagerController::class);
        $data = (Request::create())->post;
        $controller->updatePassword($data);
    }, ['guest']);

    $router->run();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}