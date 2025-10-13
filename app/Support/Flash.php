<?php

namespace Support;

class Flash
{
    public static function set(string $index, string $value): void
    {
        if (!isset($_SESSION['__flash'][$index])) {
            $_SESSION['__flash'][$index] = $value;
        }
    }

    public static function get(string $index): string
    {
        $value = '';

        if (isset($_SESSION['__flash'][$index])) {
            $value = $_SESSION['__flash'][$index];
            unset($_SESSION['__flash'][$index]);
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}