<?php

namespace Contracts;

interface EmailServiceInterface
{
    public function send(string $to, string $name, string $subject, string $message ): void;
}