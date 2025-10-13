<?php

namespace Http\Middleware;
class Auth
{
    public function handle(): void
    {
        if (! array_key_exists('user', $_SESSION)) {
            header('Location: /login');
            exit();
        }
    }
}