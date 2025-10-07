<?php

namespace Providers;

use Contracts\EmailServiceInterface;
use Contracts\SessionInterface;
use Contracts\UserRepositoryInterface;
use Core\Request;
use Database\DatabaseConnection;
use PDO;
use Repository\UserRepository;
use Services\RegisterService;
use Services\SessionService;
use Services\UserManagerService;
use Support\Mailer;
use Support\SessionManager;

class AppServiceProvider
{
    public static function definitions(): array
    {
        return [
            PDO::class => function () {
                return DatabaseConnection::connect();
            },
            UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
            SessionInterface::class => \DI\autowire(SessionManager::class),
            EmailServiceInterface::class => \DI\autowire(Mailer::class),

            RegisterService::class => \DI\autowire(),
            SessionService::class => \DI\autowire(),
            UserManagerService::class => \DI\autowire(),

            Request::class => function () {
                return Request::create();
            },
        ];
    }
}