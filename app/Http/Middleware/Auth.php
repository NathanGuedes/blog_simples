<?php

namespace Http\Middleware;
class Auth
{
    public function handle(): void
    {
        if (! $_SESSION['user'] ?? false) {
            header('Location: /');
            exit();
        }
    }
}