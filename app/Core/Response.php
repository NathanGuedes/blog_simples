<?php

namespace Core;

use Support\Flash;

class Response
{
    public function     __construct(
        private readonly mixed $body,
        private readonly int   $statusCode = 200,
        private array $data = [],
        private readonly array $headers = [],
    )
    {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        if (! empty($this->headers)) {
            foreach ($this->headers as $index => $value) {
                header("$index:$value");
            }
        }

        extract($this->data);

        echo $this->body;
    }

    public static function redirect(string $uri, array $flash = [], int $statusCode = 302): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        foreach ($flash as $key => $value) {
            $key === 'error' ?
                Flash::set($key, $value):
                Flash::set($key . 'Field', $value);
        }

        header("Location: $uri", true, $statusCode);
        exit;
    }
}