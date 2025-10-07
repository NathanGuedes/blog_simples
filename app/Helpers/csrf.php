<?php

use Support\Csrf;
use Random\RandomException;

/**
 * @throws RandomException
 */
function getToken(): string
{
    return Csrf::getToken();
}