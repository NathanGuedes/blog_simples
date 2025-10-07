<?php

namespace Http\Middleware;
class Active
{
    public function handle(): void
    {
        if ($_SESSION['user']['active'] !== 1) {
            header('Location: /email/activation/send');
            exit();
        }
    }
}