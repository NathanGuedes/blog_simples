<?php

namespace Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var array<string, string>
     */
    private array|string $errors;

    /**
     * @param array<string, string> $errors
     * @param string $message
     * @param int $code
     */
    public function __construct(array|string $errors, string $message = "Validation failed", int $code = 0)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array|string
    {
        return $this->errors;
    }
}
