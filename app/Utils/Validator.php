<?php

namespace Utils;

use Support\Csrf;

class Validator
{
    private array $errors = [];

    /**
     * Valida token csrf
     */
    public function csrf(): self
    {
        if (Csrf::validateToken()) {
            $this->errors['error'] = Csrf::validateToken();
        }
        return $this;
    }

    /**
     * Valida campo obrigatório
     */
    public function required(string $field, $value, ?string $label = null): self
    {
        if (empty($value) && $value !== '0') {
            $this->errors[$field] = ($label ?? $field) . ' is required';
        }
        return $this;
    }

    /**
     * Valida email
     */
    public function email(string $field, $value, ?string $label = null): self
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = ($label ?? $field) . ' must be a valid email';
        }
        return $this;
    }

    /**
     * Valida tamanho mínimo
     */
    public function minLength(string $field, $value, int $min, ?string $label = null): self
    {
        if (!empty($value) && strlen($value) < $min) {
            $this->errors[$field] = ($label ?? $field) . " must be at least {$min} characters";
        }
        return $this;
    }

    /**
     * Valida tamanho máximo
     */
    public function maxLength(string $field, $value, int $max, ?string $label = null): self
    {
        if (!empty($value) && strlen($value) > $max) {
            $this->errors[$field] = ($label ?? $field) . " must not exceed {$max} characters";
        }
        return $this;
    }

    public function passwordMatch(string $field, $value, ?string $label = null): self
    {
        if ($value[0] !== $value[1]) {
            $this->errors[$field] = "Passwords do not match";
        }
        return $this;
    }

    /**
     * Sanitiza string (proteção XSS)
     */
    public static function sanitize(string $data): string
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Verifica se há erros
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Retorna erros
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function token(string $field, mixed $value, string $label): self
    {
        if ($this->fails()) {
            $this->errors[$field] = $value;
        }
        return $this;
    }
}
