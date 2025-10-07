<?php

namespace Http\Middleware;
class NotActive
{
    public function handle(): void
    {
        if ($_SESSION['user']['active'] === 1) {
            header('Location: /');
            exit();
        }
    }
}