<?php

namespace Contracts;

interface SessionInterface
{
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @return SessionInterface
     */
    public function set(string $key, mixed $value): self;

    public function remove(string $key): void;

    public function has(string $key): bool;
}