<?php

namespace Support;

use Random\RandomException;

class Token
{
    /**
     * @throws RandomException
     */
    public static function genToken($length = 64): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}