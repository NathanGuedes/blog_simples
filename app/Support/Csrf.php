<?php

namespace Support;

use Random\RandomException;

class Csrf
{
    /**
     * @throws RandomException
     */
    public static function getToken(): string
    {
        if (isset($_SESSION['__temp']['csrf_token'])) {
            unset($_SESSION['__temp']['csrf_token']);
        }

        $_SESSION['__temp']['csrf_token'] = bin2hex(random_bytes(32));

        return "<input type='hidden' id='csrf_token' name='csrf_token' value='{$_SESSION['__temp']['csrf_token']}'>";
    }

    public static function validateToken(): string|null
    {
        if (!isset($_SESSION['__temp']['csrf_token'])) {
            return "Não foi possível concluir a solicitação. Por favor, tente novamente.";
        }

        $token = $_POST['csrf_token'];

        if ($_SESSION['__temp']['csrf_token'] !== $token) {
            return "Não foi possível concluir a solicitação. Por favor, tente novamente.";
        }

        unset($_SESSION['__temp']['csrf_token']);

        return null;
    }
}