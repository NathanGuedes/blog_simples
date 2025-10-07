<?php

namespace Core;

class Request
{

    public function __construct(
        public array $get,
        public array $post,
        public array $server,
        public array $cookie,
    )
    {
    }

    public static function create(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_COOKIE);
    }
}